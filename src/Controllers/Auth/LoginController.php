<?php

namespace Btw\Core\Controllers\Auth;

use Btw\Core\View\Themeable;
use Btw\Core\View\Theme;
use CodeIgniter\Shield\Controllers\LoginController as ShieldLogin;
use CodeIgniter\HTTP\RedirectResponse;

class LoginController extends ShieldLogin
{
    use Themeable;

    protected $viewPrefix = 'Btw\Core\Views\Auth\\';

    public function __construct()
    {
        $this->addMeta();
        $this->theme = 'auth';
        helper(['auth', 'form', 'alertHtmx']);
    }

    /**
     * Display the login view
     */
    public function loginView(): string
    {
        return $this->render(config('Auth')->views['login'], [
            'allowRemember' => setting('Auth.sessionConfig')['allowRemembering'],
        ]);
    }

    /**
     * Attempts to log the user in.
     */
    public function loginAction(): RedirectResponse
    {
        // Validate here first, since some things,
        // like the password, can only be validated properly here.
        $rules = $this->getValidationRules();

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $credentials             = $this->request->getPost(setting('Auth.validFields'));
        $credentials             = array_filter($credentials);
        $credentials['password'] = $this->request->getPost('password');
        $remember                = (bool) $this->request->getPost('remember');

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        // Attempt to login
        $result = $authenticator->remember($remember)->attempt($credentials);
        if (!$result->isOK()) {
            return redirect()->route('login')->withInput()->with('error', $result->reason());
        }

        // If an action has been defined for login, start it up.
        if ($authenticator->hasAction()) {
            return redirect()->route('auth-action-show')->withCookies();
        }

        if (session()->get('redirect_url')) {
            $redirect = session()->get('redirect_url');
            session()->remove('redirect_url');
        } else {
            $redirect = config('Auth')->loginRedirect();
        }

        return redirect()->to($redirect)->withCookies();
    }

    /**
     * Attempts to log the user in.
     */
    public function loginActionHtmx()
    {
        // Validate here first, since some things,
        // like the password, can only be validated properly here.
        $rules = $this->getValidationRules();

        if (!$this->validate($rules)) {
            $this->response->triggerClientEvent('showMessage', ['type' => 'error', 'content' => $this->validator->getErrors()]);
            return view($this->viewPrefix . 'cells\form_cell_login', [
                'validation' => $this->validator->getErrors()
            ]);
        }

        $credentials             = $this->request->getPost(setting('Auth.validFields'));
        $credentials             = array_filter($credentials);
        $credentials['password'] = $this->request->getPost('password');
        $remember                = (bool) $this->request->getPost('remember');

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        // Attempt to login
        $result = $authenticator->remember($remember)->attempt($credentials);
        if (!$result->isOK()) {
            $this->response->triggerClientEvent('showMessage', ['type' => 'error', 'content' => $result->reason()]);
            return view($this->viewPrefix . 'cells\form_cell_login', [
                'validation' => $result->reason()
            ]);
        }

        // If an action has been defined for login, start it up.
        if ($authenticator->hasAction()) {
            return redirect()->hxLocation(str_replace(config('App')->baseURL, '/', route_to('auth-action-show')));
        }

        if (session()->get('redirect_url')) {
            $redirect = session()->get('redirect_url');
            session()->remove('redirect_url');
        } else {
            $redirect = config('Auth')->loginRedirect();
        }

        Theme::set_message_htmx('success', lang('Btw.welcomeUser', ['user']));
        // return redirect()->hxLocation(str_replace(config('App')->baseURL, '', $redirect));
        return redirect()->hxRefresh();
    }

    /**
     * Logs the current user out.
     */
    public function logoutAction(): RedirectResponse
    {
        // Capture logout redirect URL before auth logout,
        // otherwise you cannot check the user in `logoutRedirect()`.
        $url = config('Auth')->logoutRedirect();

        auth()->logout();

        theme()->set_message_not_htmx('success', lang('Auth.successLogout', ['Logs']));
        return redirect()->to($url);
    }

    /**
    * Logs the current user out.
    */
    public function logoutActionHtmx()
    {
        // Capture logout redirect URL before auth logout,
        // otherwise you cannot check the user in `logoutRedirect()`.
        $url = config('Auth')->logoutRedirect();

        auth()->logout();

        theme()->set_message_not_htmx('success', lang('Auth.successLogout', ['Logs']));
        return redirect()->hxRefresh();
    }

    private function addMeta()
    {
        $viewMeta =  service('viewMeta');
        $viewMeta->addMeta(['name' => 'robots', 'content' => 'nofollow, noindex' ]);
        $viewMeta->addFavicon('admin');

    }
}
