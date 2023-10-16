<?php

namespace Btw\Core\Controllers\Auth;

use Btw\Core\View\Themeable;
use Btw\Core\View\Theme;
use CodeIgniter\Events\Events;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\I18n\Time;
use Btw\Core\Entities\User;
use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\Shield\Controllers\MagicLinkController as ShieldMagicLinkController;
use CodeIgniter\Shield\Models\UserIdentityModel;

class MagicLinkController extends ShieldMagicLinkController
{
    use Themeable;

    protected $viewPrefix = 'Btw\Core\Views\Auth\\';

    public function __construct()
    {
        parent::__construct();
        
        service('viewMeta')->addMeta(['name' => 'robots', 'content' => 'nofollow, noindex' ]);
        $this->theme = 'auth';
        helper(['auth', 'form', 'alertHtmx']);
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
        if (!$this->validate($rules)) {
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
        helper('email');
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
     * Receives the email from the user, creates the hash
     * to a user identity, and sends an email to the given
     * email address.
     *
     * @return RedirectResponse|string
     */
    public function loginActionHtmx() 
    {
        // Validate email format
        $rules = $this->getValidationRules();
        if (!$this->validate($rules)) {
           $this->response->triggerClientEvent('showMessage', ['type' => 'error', 'content' => $this->validator->getErrors()]);
           return view($this->viewPrefix . 'cells\form_cell_email_2fa_show', [
               'validation' => $this->validator->getErrors()
           ]);
        }

        // Check if the user exists
        $email = $this->request->getPost('email');
        $user  = $this->provider->findByCredentials(['email' => $email]);

        if ($user === null) {
            $this->response->triggerClientEvent('showMessage', ['type' => 'error', 'content' =>  lang('Auth.invalidEmail')]);
            return view($this->viewPrefix . 'cells\form_cell_email_2fa_show', [
                'validation' => lang('Auth.invalidEmail')
            ]);
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
        helper('email');
        $email = emailer()->setFrom(setting('Email.fromEmail'), setting('Email.fromName') ?? '');
        $email->setTo($user->email);
        $email->setSubject(lang('Auth.magicLinkSubject'));
        $email->setMessage($this->view(setting('Auth.views')['magic-link-email'], ['token' => $token, 'ipAddress' => $ipAddress, 'userAgent' => $userAgent, 'date' => $date]));
        $email->setMailType('html');

        if ($email->send(false) === false) {
            log_message('error', $email->printDebugger(['headers']));

            // return redirect()->route('magic-link')->with('error', lang('Auth.unableSendEmailToUser', [$user->email]));
            $this->response->triggerClientEvent('showMessage', ['type' => 'error', 'content' =>  lang('Auth.unableSendEmailToUser', [$user->email])]);
            return view($this->viewPrefix . 'cells\form_cell_email_2fa_show', [
                'validation' =>  lang('Auth.unableSendEmailToUser', [$user->email])
            ]);
        }

        // Clear the email
        $email->clear();

        // return $this->displayMessage();
        // echo str_replace(config('App')->baseURL, '', setting('Auth.views')['magic-link-message'])
        // echo str_replace(config('App')->baseURL, '', route_to('magic-link-message'));exit;
        return redirect()->hxLocation(str_replace(config('App')->baseURL, '', route_to('magic-link-message')));
    }

    /**
     * Display the "What's happening/next" message to the user.
     */
    protected function displayMessage(): string
    {
        return $this->render(setting('Auth.views')['magic-link-message']);
    }

    public function magicLinkMesage(){

        return $this->render(setting('Auth.views')['magic-link-message']);
       
    }
}
