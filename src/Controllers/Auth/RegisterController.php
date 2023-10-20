<?php

namespace Btw\Core\Controllers\Auth;

use Btw\Core\View\Themeable;
use Btw\Core\View\Theme;
use CodeIgniter\Shield\Controllers\RegisterController as ShieldRegister;
use CodeIgniter\Shield\Authentication\Passwords;
use CodeIgniter\Shield\Exceptions\ValidationException;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Events\Events;
use Psr\Log\LoggerInterface;

class RegisterController extends ShieldRegister
{
    use Themeable;

    protected $viewPrefix = 'Btw\Core\Views\Auth\\';

    /**
     * Auth Table names
     */
    private array $tables;

    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ): void {
        parent::initController(
            $request,
            $response,
            $logger
        );

        /** @var Auth $authConfig */
        $authConfig   = config('Auth');
        $this->tables = $authConfig->tables;
    }

    public function __construct()
    {
        service('viewMeta')->addMeta(['name' => 'robots', 'content' => 'nofollow, noindex' ]);
        $this->theme = 'auth';
        helper(['auth', 'form', 'alertHtmx']);
    }

    /**
     * Displays the registration form.
     */
    public function registerView()
    {
        if (auth()->loggedIn()) {
            return redirect()->to('/login');
        }

        // Check if registration is allowed
        if (!setting('Auth.allowRegistration')) {
            return redirect()->back()->withInput()->with('error', lang('Auth.registerDisabled'));
        }

        return $this->render(setting('Auth.views')['register']);
    }


    /**
     * Attempts to register the user.
     */
    public function registerActionHtmx()
    {
        if (auth()->loggedIn()) {
            return redirect()->to(config('Auth')->registerRedirect());
        }

        // Check if registration is allowed
        if (!setting('Auth.allowRegistration')) {
            return redirect()->back()->withInput()
                ->with('error', lang('Auth.registerDisabled'));
        }

        $users = $this->getUserProvider();

        // Validate here first, since some things,
        // like the password, can only be validated properly here.
        $rules = $this->getValidationRules();

        if (!$this->validateData($this->request->getPost(), $rules)) {
            $this->response->triggerClientEvent('showMessage', ['type' => 'error', 'content' => $this->validator->getErrors()]);
            return view($this->viewPrefix . 'cells\form_cell_register', [
                'validation' => $this->validator->getErrors()
            ]);
        }

        // Save the user
        $allowedPostFields = array_keys($rules);
        $user              = $this->getUserEntity();
        $user->fill($this->request->getPost($allowedPostFields));

        // Workaround for email only registration/login
        if ($user->username === null) {
            $user->username = null;
        }

        try {
            $users->save($user);
        } catch (ValidationException $e) {

            $this->response->triggerClientEvent('showMessage', ['type' => 'error', 'content' => $users->errors()]);
            return view($this->viewPrefix . 'cells\form_cell_register', [
                'validation' => $users->errors()
            ]);
        }

        // To get the complete user object with ID, we need to get from the database
        $user = $users->findById($users->getInsertID());

        // Add to default group
        $users->addToDefaultGroup($user);

        Events::trigger('register', $user);

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        $authenticator->startLogin($user);

        // If an action has been defined for register, start it up.
        $hasAction = $authenticator->startUpAction('register', $user);
        if ($hasAction) {
            return redirect()->hxLocation(str_replace(config('App')->baseURL, '/', route_to('auth-action-show')));
        }

        // Set the user active
        $user->activate();

        $authenticator->completeLogin($user);

        // Success!
        Theme::set_message_htmx('success', lang('Auth.registerSuccess'));
        return redirect()->hxLocation("/login");
    }

    /**
     * Returns the URL the user should be redirected to
     * after a successful registration.
     */
    protected function getRedirectURL(): string
    {
        $url = setting('Auth.redirects')['register'];

        return strpos($url, 'http') === 0
            ? $url
            : rtrim(site_url($url), '/ ');
    }
}
