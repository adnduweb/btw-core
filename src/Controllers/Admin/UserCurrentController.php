<?php

/**
 * This file is part of Doudou.
 *
 * (c) Fabrice Loru <fabrice@adnduweb.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Btw\Core\Controllers\Admin;

use Btw\Core\Controllers\AdminController;
use Btw\Core\Libraries\Menus\MenuItem;
use Btw\Core\Entities\User;
use Btw\Core\Models\UserModel;
use CodeIgniter\Shield\Models\LoginModel;
use Btw\Core\Models\SessionModel;
use CodeIgniter\Shield\Models\UserIdentityModel;
use ReflectionException;


class UserCurrentController extends AdminController
{
    protected $theme      = 'Admin';
    protected $viewPrefix = 'Btw\Core\Views\Admin\users\\current\\';

    public function __construct()
    {
        self::setupMenus();
        $this->addMenuSidebar();
    }


    /**
     * Display the Email settings user.
     *
     * @return string
     */
    public function editUserCurrent()
    {
        $groups = setting('AuthGroups.groups');
        asort($groups);

        if (!$this->request->is('post')) {

            return $this->render($this->viewPrefix . 'settings_user', [
                'userCurrent' => auth()->user(),
                'currentGroup'    => array_flip(auth()->user()->getGroups()),
                'groups'          => setting('AuthGroups.groups'),
                'menu' => service('menus')->menu('sidebar_user_current'),
                'currentUrl' => (string)current_url(true)->setHost('')->setScheme('')->stripQuery('token')
            ]);
        }

        $users = new UserModel();

        /**
         * @var User
         */
        $user = $users->find(auth()->id());


        switch ($this->request->getVar('section')) {
            case 'general':

                if (!auth()->user()->can('users.edit')) {
                    $this->response->triggerClientEvent('showMessage', ['type' => 'error', 'content' => lang('Btw.notAuthorized')]);
                    return view($this->viewPrefix . 'cells\form_cell_information', [
                        'userCurrent' => $user,
                    ]);
                }

                $requestJson = $this->request->getJSON(true);
                $validation = service('validation');

                $validation->setRules([
                    'email'      => 'required|valid_email|unique_email[' . auth()->id() . ']',
                    'first_name' => 'permit_empty|string|min_length[3]',
                    'last_name'  => 'permit_empty|string|min_length[3]',
                ]);

                if (!$validation->run($requestJson)) {
                    $this->response->triggerClientEvent('showMessage', ['type' => 'success', 'content' => lang('Btw.errorField', ['user'])]);
                    return view($this->viewPrefix . 'cells\form_cell_information', [
                        'userCurrent' => $user,
                        'validation' => $validation
                    ]);
                }

                $user->fill($requestJson);
                $user->username = generateUsername($requestJson['last_name'] . ' ' .  $requestJson['first_name']);

                // Try saving basic details
                try {
                    if (!$users->save($user)) {
                        log_message('error', 'User errors', $users->errors());
                        $this->response->triggerClientEvent('showMessage', ['type' => 'error', 'content' => lang('Btw.unknownSaveError', ['user'])]);
                    }
                } catch (DataException $e) {
                    // Just log the message for now since it's
                    // likely saying the user's data is all the same
                    log_message('debug', 'SAVING USER: ' . $e->getMessage());
                }


                $this->response->triggerClientEvent('updateUserCurrent');
                $this->response->triggerClientEvent('showMessage', ['type' => 'success', 'content' => lang('Btw.saveData', ['user'])]);

                return view($this->viewPrefix . 'cells\form_cell_information', [
                    'userCurrent' => $user,
                    'menu' => service('menus')->menu('sidebar_user_current'),
                    'currentUrl' => (string)current_url(true)->setHost('')->setScheme('')->stripQuery('token')
                ]);

                break;
            case 'groups':

                $requestJson = $this->request->getJSON(true);
                $validation = service('validation');

                $validation->setRules([
                    'currentGroup[]'      => 'required'
                ]);

                if (!$validation->run($requestJson)) {
                    return view($this->viewPrefix . 'cells\cell_groups', [
                        'userCurrent' => auth()->user(),
                        'currentGroup'    => array_flip(auth()->user()->getGroups()),
                        'groups'          => setting('AuthGroups.groups'),
                        'validation' => $validation
                    ]) . alertHtmx('danger', 'Form validation failed.');;
                }


                if (!is_array($requestJson['currentGroup[]']))
                    $requestJson['currentGroup[]']  = [$requestJson['currentGroup[]']];

                // Save the user's groups
                $user->syncGroups(...($requestJson['currentGroup[]'] ?? []));

                $this->response->triggerClientEvent('updateGroupUserCurrent');

                return view($this->viewPrefix . 'cells\cell_groups', [
                    'userCurrent' => auth()->user(),
                    'currentGroup'    => array_flip($user->getGroups()),
                    'groups'          => setting('AuthGroups.groups'),
                ]) . alertHtmx('success', lang('Btw.resourcesSaved', ['settings']));

                break;
            default:
                alertHtmx('danger', lang('Btw.erreor', ['settings']));
        }
    }

    public function updateAvatar()
    {
        return view('Themes\Admin\partials\headers\renderAvatar', [
            'auth' => auth()
        ]);
    }

    public function updateGroup(int $id)
    {
        if (!$user = (model(UserModel::class)->find($id))) {
            throw new userNotFoundException('Incorrect book id.');
        }
        return view($this->viewPrefix . 'cells\line_group', [
            'userCurrent' => $user
        ]);
    }

    public function history()
    {
        $users = model(UserModel::class);
        /** @var User|null $user */
        $user = $users->find(auth()->id());
        if ($user === null) {
            return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', ['user']));
        }

        /** @var LoginModel $loginModel */
        $loginModel = model(LoginModel::class);
        $logins     = $loginModel->where('identifier', $user->email)->orderBy('date', 'desc')->limit(20)->findAll();

        if (!$this->request->is('post')) {

            return $this->render($this->viewPrefix . 'settings_user_history', [
                'user'   => $user,
                'logins' => $logins,
                'menu' => service('menus')->menu('sidebar_user_current'),
                'currentUrl' => (string)current_url(true)->setHost('')->setScheme('')->stripQuery('token')
            ]);
        }
    }

    public function sessionBrowser()
    {
        $users = model(UserModel::class);
        /** @var User|null $user */
        $user = $users->find(auth()->id());
        if ($user === null) {
            return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', ['user']));
        }

        /** @var SessionModel $sessionModel */
        $sessionModel = model(SessionModel::class);
        $sessions = $sessionModel->where('user_id', Auth()->user()->id)->orderBy('timestamp', 'desc')->limit(10)->find();


        if (!$this->request->is('post')) {

            return $this->render($this->viewPrefix . 'settings_user_browser', [
                'user'   => $user,
                'sessions' => $sessions,
                'menu' => service('menus')->menu('sidebar_user_current'),
                'currentUrl' => (string)current_url(true)->setHost('')->setScheme('')->stripQuery('token')
            ]);
        }
    }

    public function capabilities()
    {
        $users = model(UserModel::class);
        /** @var User|null $user */
        $user = $users->find(auth()->id());
        if ($user === null) {
            return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', ['user']));
        }

        $permissions = setting('AuthGroups.permissions');
        if (is_array($permissions)) {
            ksort($permissions);
        }

        if (!$this->request->is('post')) {

            return $this->render($this->viewPrefix . 'settings_user_capabilities', [
                'permissions'   => $permissions,
                'user'   => $user,
                'menu' => service('menus')->menu('sidebar_user_current'),
                'currentUrl' => (string)current_url(true)->setHost('')->setScheme('')->stripQuery('token')
            ]);
        }
    }

    /**
     * Toggle capability.
     */
    public function toggle(string $perm)
    {
        $users = model(UserModel::class);
        /** @var User|null $user */
        $user = $users->find(auth()->id());

        $requestJson = $this->request->getJSON(true);

        if (isset($requestJson['permissions']) && !is_array($requestJson['permissions']))
            $requestJson['permissions'] = [$requestJson['permissions']];

        $user->syncPermissions(...($requestJson['permissions'] ?? []));

        $permissions = setting('AuthGroups.permissions');
        if (is_array($permissions)) {
            ksort($permissions);
        }

        return view($this->viewPrefix . 'cells\form_cell_capabilities_row', [
            'rowPermission'   => [$perm, $permissions[$perm]],
            'user'   => $user,
            'menu' => service('menus')->menu('sidebar_user_current'),
            'currentUrl' => (string)current_url(true)->setHost('')->setScheme('')->stripQuery('token')
        ]) . alertHtmx('success', lang('Btw.resourcesSaved', ['settings']));
    }

    /**
     * Toggle all capabilities.
     */
    public function toggleAll()
    {

        $users = model(UserModel::class);
        /** @var User|null $user */
        $user = $users->find(auth()->id());

        // print_r($this->request->getJSON(true)); exit;
        $requestJson = $this->request->getJSON(true);

        $user->syncPermissions(...($requestJson['permissions'] ?? []));

        $permissions = setting('AuthGroups.permissions');
        if (is_array($permissions)) {
            ksort($permissions);
        }

        return view($this->viewPrefix . 'cells\form_cell_capabilities_tr', [
            'permissions'   => $permissions,
            'user'   => $user,
            'menu' => service('menus')->menu('sidebar_user_current'),
            'currentUrl' => (string)current_url(true)->setHost('')->setScheme('')->stripQuery('token')
        ]) . alertHtmx('success', lang('Btw.resourcesSaved', ['settings']));
    }

    /**
     * Change user's password.
     *
     */
    public function changePassword()
    {
        $users = model(UserModel::class);
        /** @var User|null $user */
        $user = $users->find(auth()->id());
        if ($user === null) {
            return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', ['user']));
        }

        if (!$this->request->is('post')) {

            return $this->render($this->viewPrefix . 'settings_user_change_password', [
                'userCurrent' => auth()->user(),
                'menu' => service('menus')->menu('sidebar_user_current'),
                'currentUrl' => (string)current_url(true)->setHost('')->setScheme('')->stripQuery('token')
            ]);
        }

        $requestJson = $this->request->getJSON(true);
        $validation = service('validation');

        $validation->setRules([
            'current_password'      => 'required|strong_password',
            'new_password'      => 'required|strong_password',
            'pass_confirm' => 'required|matches[new_password]',
        ]);

        if (!$validation->run($requestJson)) {
            return view($this->viewPrefix . 'cells\form_cell_changepassword', [
                'userCurrent' => $user,
                'validation' => $validation
            ]) . alertHtmx('danger', 'Form validation failed.');;
        }

        //On vérifie que le mote d epasse en cours est connu 
        $validCreds = auth()->check(['password' => $requestJson['current_password'], 'email' => $user->email]);
        if (!$validCreds->isOK()) {
            return view($this->viewPrefix . 'cells\form_cell_changepassword', [
                'userCurrent' => $user,
                'validation' => $validation
            ]) . alertHtmx('danger', 'Erreur de mot de passe en cours.');;
        }


        // Save the new user's email/password
        $identity = $user->getEmailIdentity();

        if ($requestJson['new_password'] !== null) {
            $identity->secret2 = service('passwords')->hash($requestJson['new_password']);
        }

        if ($identity->hasChanged()) {
            model(UserIdentityModel::class)->save($identity);
        }

        return view($this->viewPrefix . 'cells\form_cell_changepassword', [
            'userCurrent' => auth()->user()
        ]) . alertHtmx('success', lang('Btw.resourcesSaved', ['settings']));
    }


    public function twoFactor()
    {
        $users = model(UserModel::class);
        /** @var User|null $user */
        $user = $users->find(auth()->id());
        if ($user === null) {
            return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', ['user']));
        }

        if (!$this->request->is('post')) {

            return $this->render($this->viewPrefix . 'settings_user_two_factor', [
                'user'   => $user,
                'menu' => service('menus')->menu('sidebar_user_current'),
                'currentUrl' => (string)current_url(true)->setHost('')->setScheme('')->stripQuery('token')
            ]);
        }

        $requestJson = $this->request->getJSON(true);

        // Actions
        $actions             = setting('Auth.actions');
        $actions['login']    = $requestJson['email2FA'] ?? null;
        $context = 'user:' . user_id();
        service('settings')->set('Auth.actions', $actions, $context);

        return view($this->viewPrefix . 'cells\form_cell_two_factor', [
            'user'   => $user,
        ]) . alertHtmx('success', lang('Btw.resourcesSaved', ['settings']));
    }


    public function changeLangue()
    {
        $context = 'user:' . user_id();
        service('settings')->set('Btw.language_bo', $this->request->getGet('changeLanguageBO'), $context);
        return redirect()->back();
    }

    public function changeSidebarExpanded(){

        $context = 'user:' . user_id();
        $isSidebarExpanded = service('settings')->get('Btw.isSidebarExpanded', $context);
       
        if($isSidebarExpanded == false){
            service('settings')->set('Btw.isSidebarExpanded', 1, $context);
        }else{
            service('settings')->set('Btw.isSidebarExpanded', 0, $context);
        }        
       
        $this->response->triggerClientEvent('updateSidebarExpanded');
    }



    /**
     * Creates any admin-required menus so they're
     * available to use by any modules.
     */
    private function setupMenus()
    {
        $menus = service('menus');

        // Sidebar menu
        $menus->createMenu('sidebar_user_current');
        $menus->menu('sidebar_user_current')
            ->createCollection('content', 'Content');
    }
    public function addMenuSidebar()
    {
        $sidebar = service('menus');
        $item    = new MenuItem([
            'title'           => 'Information',
            'namedRoute'      => 'user-current-settings',
            'fontIconSvg'     => theme()->getSVG('duotune/communication/com006.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
            'permission'      => 'admin.view',
            'weight' => 1
        ]);
        $sidebar->menu('sidebar_user_current')->collection('content')->addItem($item);

        $item    = new MenuItem([
            'title'           => 'Capabilities',
            'namedRoute'      => 'user-capabilities',
            'fontIconSvg'     => theme()->getSVG('duotune/general/gen047.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
            'permission'      => 'admin.view',
            'weight' => 2
        ]);
        $sidebar->menu('sidebar_user_current')->collection('content')->addItem($item);

        $item    = new MenuItem([
            'title'           => 'Change password',
            'namedRoute'      => 'user-change-password',
            'fontIconSvg'     => theme()->getSVG('duotune/technology/teh004.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
            'permission'      => 'admin.view',
            'weight' => 3
        ]);
        $sidebar->menu('sidebar_user_current')->collection('content')->addItem($item);

        $item    = new MenuItem([
            'title'           => 'Two Factor',
            'namedRoute'      => 'user-two-factor',
            'fontIconSvg'     => theme()->getSVG('duotune/technology/teh004.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
            'permission'      => 'admin.view',
            'weight' => 3
        ]);
        $sidebar->menu('sidebar_user_current')->collection('content')->addItem($item);

        $item    = new MenuItem([
            'title'           => 'History',
            'namedRoute'      => 'user-history',
            'fontIconSvg'     => theme()->getSVG('duotune/general/gen013.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
            'permission'      => 'admin.view',
            'weight' => 4
        ]);
        $sidebar->menu('sidebar_user_current')->collection('content')->addItem($item);

        $item    = new MenuItem([
            'title'           => 'Browser',
            'namedRoute'      => 'user-session-browser',
            'fontIconSvg'     => theme()->getSVG('duotune/general/gen013.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
            'permission'      => 'admin.view',
            'weight' => 4
        ]);
        $sidebar->menu('sidebar_user_current')->collection('content')->addItem($item);

        $item    = new MenuItem([
            'title'           => 'Delete',
            'namedRoute'      => 'settings-email',
            'fontIconSvg'     => theme()->getSVG('duotune/general/gen016.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300 text-red-800', true),
            'permission'      => 'admin.view',
            'color'           => 'text-red-800',
            'weight' => 5
        ]);
        $sidebar->menu('sidebar_user_current')->collection('content')->addItem($item);
    }
}
