<?php

declare(strict_types=1);

namespace Btw\Core\Authentication\Actions;

use Btw\Core\Authentication\Actions\ActionInterface;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Entities\UserIdentity;
use CodeIgniter\Shield\Exceptions\RuntimeException;
use CodeIgniter\Shield\Models\UserIdentityModel;
use Btw\Core\View\Theme;

/**
 * Class Email2FA
 *
 * Sends an email to the user with a code to verify their account.
 */
class Email2FA implements ActionInterface
{
    private string $type = Session::ID_TYPE_EMAIL_2FA;

    /**
     * Displays the "Hey we're going to send you a number to your email"
     * message to the user with a prompt to continue.
     */
    public function show(): string
    {
        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        $user = $authenticator->getPendingUser();
        if ($user === null) {
            throw new RuntimeException('Cannot get the pending login User.');
        }

        $this->createIdentity($user);

        return render('Auth', setting('Auth.views')['action_email_2fa'], ['user' => $user]);
    }

    /**
     * Generates the random number, saves it as a temp identity
     * with the user, and fires off an email to the user with the code,
     * then displays the form to accept the 6 digits
     *
     * @return RedirectResponse|string
     */
    public function handle(IncomingRequest $request)
    {
        $email = $request->getPost('email');

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        $user = $authenticator->getPendingUser();
        if ($user === null) {
            throw new RuntimeException('Cannot get the pending login User.');
        }

        if (empty($email) || $email !== $user->email) {
            return redirect()->route('auth-action-show')->with('error', lang('Auth.invalidEmail'));
        }

        /** @var UserIdentityModel $identityModel */
        $identityModel = model(UserIdentityModel::class);

        $identity = $identityModel->getIdentityByType($user, $this->type);

        if (empty($identity)) {
            return redirect()->route('auth-action-show')->with('error', lang('Auth.need2FA'));
        }

        // Send the user an email with the code
        $email = emailer()->setFrom(setting('Email.fromEmail'), setting('Email.fromName') ?? '');
        $email->setTo($user->email);
        $email->setSubject(lang('Auth.email2FASubject'));
        $email->setMessage(view(setting('Auth.views')['action_email_2fa_email'], ['code' => $identity->secret]));

        if ($email->send(false) === false) {
            throw new RuntimeException('Cannot send email for user: ' . $user->email . "\n" . $email->printDebugger(['headers']));
        }

        // Clear the email
        $email->clear();

        return  render('Auth', setting('Auth.views')['action_email_2fa_verify']);
    }

    /**
     * Generates the random number, saves it as a temp identity
     * with the user, and fires off an email to the user with the code,
     * then displays the form to accept the 6 digits
     *
     * @return RedirectResponse|string
     */
    public function handleHtmx(IncomingRequest $request)
    {
        $email = $request->getPost('email');

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        $user = $authenticator->getPendingUser();
        if ($user === null) {
            response()->triggerClientEvent('showMessage', ['type' => 'error', 'content' => 'Cannot get the pending login User']);
            throw new RuntimeException('Cannot get the pending login User.');
        }

        if (empty($email) || $email !== $user->email) {
            response()->triggerClientEvent('showMessage', ['type' => 'error', 'content' => lang('Auth.invalidEmail')]);
            //return redirect()->route('auth-action-show')->with('error', lang('Auth.invalidEmail'));
        }

        /** @var UserIdentityModel $identityModel */
        $identityModel = model(UserIdentityModel::class);

        $identity = $identityModel->getIdentityByType($user, $this->type);

        if (empty($identity)) {
            response()->triggerClientEvent('showMessage', ['type' => 'error', 'content' => lang('Auth.need2FA')]);
            //return redirect()->route('auth-action-show')->with('error', lang('Auth.need2FA'));
        }

        // Send the user an email with the code
        $email = emailer()->setFrom(setting('Email.fromEmail'), setting('Email.fromName') ?? '');
        $email->setTo($user->email);
        $email->setSubject(lang('Auth.email2FASubject'));
        $email->setMessage(view(setting('Auth.views')['action_email_2fa_email'], ['code' => $identity->secret]));

        if ($email->send(false) === false) {
            response()->triggerClientEvent('showMessage', ['type' => 'error', 'content' => 'Cannot send email for user: ' . $user->email . "\n" . $email->printDebugger(['headers'])]);
            // throw new RuntimeException('Cannot send email for user: ' . $user->email . "\n" . $email->printDebugger(['headers']));
        }

        // Clear the email
        $email->clear();

        return redirect()->hxLocation(str_replace(config('App')->baseURL, '', route_to('auth-action-verify')));
    }

    /**
     * Attempts to verify the code the user entered.
     *
     * @return RedirectResponse|string
     */
    public function verifyGet(IncomingRequest $request)
    {
        return render('Auth', setting('Auth.views')['action_email_2fa_verify']);
    }

    /**
     * Attempts to verify the code the user entered.
     *
     * @return RedirectResponse|string
     */
    public function verify(IncomingRequest $request)
    {
        if (request()->is('post')) {
            /** @var Session $authenticator */
            $authenticator = auth('session')->getAuthenticator();

            $postedToken = $request->getPost('token');

            $user = $authenticator->getPendingUser();
            if ($user === null) {
                // throw new RuntimeException('Cannot get the pending login User.');
                response()->triggerClientEvent('showMessage', ['type' => 'error', 'content' => 'Cannot get the pending login User.']);
            }

            $identity = $this->getIdentity($user);

            // Token mismatch? Let them try again...
            if (!$authenticator->checkAction($identity, $postedToken)) {
                response()->triggerClientEvent('showMessage', ['type' => 'error', 'content' => lang('Auth.invalid2FAToken')]);
                return render('Auth', setting('Auth.views')['action_email_2fa_verify']);
            }

            // Get our login redirect url
            // return redirect()->to(config('Auth')->loginRedirect());
            Theme::set_message_htmx('success', lang('Btw.welcomeUser', ['user']));
            return redirect()->hxLocation(str_replace(config('App')->baseURL, '', config('Auth')->loginRedirect()));
        }
    }

    /**
     * Attempts to verify the code the user entered.
     *
     * @return RedirectResponse|string
     */
    public function verifyHtmx(IncomingRequest $request)
    {
        if (request()->is('post')) {
            /** @var Session $authenticator */
            $authenticator = auth('session')->getAuthenticator();

            $postedToken = $request->getPost('token');

            $user = $authenticator->getPendingUser();
            if ($user === null) {
                // throw new RuntimeException('Cannot get the pending login User.');
                response()->triggerClientEvent('showMessage', ['type' => 'error', 'content' => 'Cannot get the pending login User.']);
            }

            $identity = $this->getIdentity($user);

            // Token mismatch? Let them try again...
            if (!$authenticator->checkAction($identity, $postedToken)) {
                response()->triggerClientEvent('showMessage', ['type' => 'error', 'content' => lang('Auth.invalid2FAToken')]);
                return render('Auth', setting('Auth.views')['action_email_2fa_verify']);
            }

            // Get our login redirect url
            // return redirect()->to(config('Auth')->loginRedirect());
            Theme::set_message_htmx('success', lang('Btw.welcomeUser', ['user']));
            return redirect()->hxLocation(str_replace(config('App')->baseURL, '', config('Auth')->loginRedirect()));
        }
    }


    /**
     * Creates an identity for the action of the user.
     *
     * @return string secret
     */
    public function createIdentity(User $user): string
    {
        /** @var UserIdentityModel $identityModel */
        $identityModel = model(UserIdentityModel::class);

        // Delete any previous identities for action
        $identityModel->deleteIdentitiesByType($user, $this->type);

        $generator = static fn (): string => random_string('nozero', 6);

        return $identityModel->createCodeIdentity(
            $user,
            [
                'type'  => $this->type,
                'name'  => 'login',
                'extra' => lang('Auth.need2FA'),
            ],
            $generator
        );
    }

    /**
     * Returns an identity for the action of the user.
     */
    private function getIdentity(User $user): ?UserIdentity
    {
        /** @var UserIdentityModel $identityModel */
        $identityModel = model(UserIdentityModel::class);

        return $identityModel->getIdentityByType(
            $user,
            $this->type
        );
    }

    /**
     * Returns the string type of the action class.
     */
    public function getType(): string
    {
        return $this->type;
    }
}
