<?php

namespace Btw\Core\Controllers\Auth;

use Btw\Core\View\Themeable;
use CodeIgniter\Events\Events;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\I18n\Time;
use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\Shield\Controllers\MagicLinkController as ShieldMagicLinkController;

class MagicLinkController extends ShieldMagicLinkController
{
    use Themeable;

    public function __construct()
    {
        parent::__construct();

        $this->theme = 'Auth';
    }

    /**
     * Displays the view to enter their email address
     * so an email can be sent to them.
     */
    public function loginView(): string
    {
        return $this->render(setting('Auth.views')['magic-link-login']);
    }

     /**
     * Receives the email from the user, creates the hash
     * to a user identity, and sends an email to the given
     * email address.
     *
     * @return RedirectResponse|string
     */
    public function loginAction()
    {
        // Validate email format
        $rules = $this->getValidationRules();
        if (! $this->validate($rules)) {
            return redirect()->route('magic-link')->with('errors', $this->validator->getErrors());
        }

        // Check if the user exists
        $email = $this->request->getPost('email');
        $user  = $this->provider->findByCredentials(['email' => $email]);

        if ($user === null) {
            return redirect()->route('magic-link')->with('error', lang('Auth.invalidEmail'));
        }

        /** @var UserIdentityModel $identityModel */
        $identityModel = model(UserIdentityModel::class);

        // Delete any previous magic-link identities
        $identityModel->deleteIdentitiesByType($user, Session::ID_TYPE_MAGIC_LINK);

        // Generate the code and save it as an identity
        helper('text');
        $token = random_string('crypto', 20);

        $identityModel->insert([
            'user_id' => $user->id,
            'type'    => Session::ID_TYPE_MAGIC_LINK,
            'secret'  => $token,
            'expires' => Time::now()->addSeconds(setting('Auth.magicLinkLifetime'))->format('Y-m-d H:i:s'),
        ]);

        /** @var IncomingRequest $request */
        $request = service('request');

        $ipAddress = $request->getIPAddress();
        $userAgent = (string) $request->getUserAgent();
        $date      = Time::now()->toDateTimeString();

        // Send the user an email with the code
        $email = emailer()->setFrom(setting('Email.fromEmail'), setting('Email.fromName') ?? '');
        $email->setTo($user->email);
        $email->setSubject(lang('Auth.magicLinkSubject'));
        $email->setMessage($this->view(setting('Auth.views')['magic-link-email'], ['token' => $token, 'ipAddress' => $ipAddress, 'userAgent' => $userAgent, 'date' => $date]));
        $email->setMailType('html');

        if ($email->send(false) === false) {
            log_message('error', $email->printDebugger(['headers']));

            return redirect()->route('magic-link')->with('error', lang('Auth.unableSendEmailToUser', [$user->email]));
        }

        // Clear the email
        $email->clear();

        return $this->displayMessage();
    }

    /**
     * Display the "What's happening/next" message to the user.
     */
    protected function displayMessage(): string
    {
        return $this->render(setting('Auth.views')['magic-link-message']);
    }
}
