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


class ProfileController extends AdminController
{
    protected $theme = 'Admin';
    protected $viewPrefix = 'Btw\Core\Views\Admin\users\\profile\\';

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

            return $this->render($this->viewPrefix . 'profile', [
                'userCurrent' => auth()->user(),
                'currentGroup' => array_flip(auth()->user()->getGroups()),
                'groups' => setting('AuthGroups.groups'),
                'menu' => service('menus')->menu('sidebar_user_profile'),
                'currentUrl' => (string) current_url(true)->setHost('')->setScheme('')->stripQuery('token')
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

                $validation = service('validation');
                $file = $this->request->getFile('photo') ?? null;
                if ($file) {

                    $validationRule = [
                        'photo' => [
                            'label' => 'Image File',
                            'rules' => [
                                'uploaded[photo]',
                                'is_image[photo]',
                                'mime_in[photo,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
                                'max_size[photo,1000]',
                                'max_dims[photo,1024,768]',
                            ],
                        ],
                    ];
                    if (!$this->validate($validationRule)) {
                        $this->response->triggerClientEvent('showMessage', ['type' => 'error', 'content' => $this->validator->getErrors()]);
                        $this->response->setReswap('innerHTML show:#general:top');
                        return view($this->viewPrefix . 'cells\form_cell_information', [
                            'userCurrent' => $user,
                            'validation' => $this->validator->getErrors()
                        ]);
                    }


                    $storage = service('storage');
                    $result = $storage->store($file, 'attachments/' . date('Y/m'));
                    $context = 'user:' . user_id();
                    service('settings')->set('Users.photoProfile', $result, $context);
                }



                $data = $this->request->getPost();


                $validation->setRules([
                    'email' => 'required|valid_email|unique_email[' . auth()->id() . ']',
                    'first_name' => 'permit_empty|string|min_length[3]',
                    'last_name' => 'permit_empty|string|min_length[3]',
                ]);

                if (!$validation->run($data)) {
                    $this->response->triggerClientEvent('showMessage', ['type' => 'error', 'content' => lang('Btw.message.formValidationFailed', [lang('Btw.general.users')])]);
                    $this->response->setReswap('innerHTML show:#general:top');
                    return view($this->viewPrefix . 'cells\form_cell_information', [
                        'userCurrent' => $user,
                        'validation' => $validation
                    ]);
                }

                $user->fill($data);
                $user->username = generateUsername($data['last_name'] . ' ' . $data['first_name']);

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
                $this->response->triggerClientEvent('showMessage', ['type' => 'success', 'content' => lang('Btw.message.resourcesSaved', [lang('Btw.general.users')])]);
                $this->response->setReswap('innerHTML show:#general:top');

                return view($this->viewPrefix . 'cells\form_cell_information', [
                    'userCurrent' => $user,
                    'menu' => service('menus')->menu('sidebar_user_profile'),
                    'currentUrl' => (string) current_url(true)->setHost('')->setScheme('')->stripQuery('token')
                ]);

                break;
            case 'groups':

                $data = $this->request->getPost();
                $validation = service('validation');

                $validation->setRules([
                    'currentGroup' => 'required'
                ]);

                if (!$validation->run($data)) {
                    $this->response->triggerClientEvent('showMessage', ['type' => 'error', 'content' => lang('Btw.message.formValidationFailed', [lang('Btw.general.users')])]);
                    return view($this->viewPrefix . 'cells\cell_groups', [
                        'userCurrent' => auth()->user(),
                        'currentGroup' => array_flip(auth()->user()->getGroups()),
                        'groups' => setting('AuthGroups.groups'),
                        'validation' => $validation
                    ]);
                }


                if (!is_array($data['currentGroup']))
                    $data['currentGroup'] = [$data['currentGroup']];

                // Save the user's groups
                $user->syncGroups(...($data['currentGroup'] ?? []));

                $this->response->triggerClientEvent('updateGroupUserCurrent');
                $this->response->triggerClientEvent('showMessage', ['type' => 'success', 'content' => lang('Btw.message.resourcesSaved', [lang('Btw.general.users')])]);
                return view($this->viewPrefix . 'cells\cell_groups', [
                    'userCurrent' => auth()->user(),
                    'currentGroup' => array_flip($user->getGroups()),
                    'groups' => setting('AuthGroups.groups'),
                ]);

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
        $logins = $loginModel->where('identifier', $user->email)->orderBy('date', 'desc')->limit(20)->findAll();

        if (!$this->request->is('post')) {

            return $this->render($this->viewPrefix . 'profile_history', [
                'user' => $user,
                'logins' => $logins,
                'menu' => service('menus')->menu('sidebar_user_profile'),
                'currentUrl' => (string) current_url(true)->setHost('')->setScheme('')->stripQuery('token')
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

            return $this->render($this->viewPrefix . 'profile_browser', [
                'user' => $user,
                'sessions' => $sessions,
                'menu' => service('menus')->menu('sidebar_user_profile'),
                'currentUrl' => (string) current_url(true)->setHost('')->setScheme('')->stripQuery('token')
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

            return $this->render($this->viewPrefix . 'profile_capabilities', [
                'permissions' => $permissions,
                'user' => $user,
                'menu' => service('menus')->menu('sidebar_user_profile'),
                'currentUrl' => (string) current_url(true)->setHost('')->setScheme('')->stripQuery('token')
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

        $data = $this->request->getPost();

        if (isset($data['permissions']) && !is_array($data['permissions']))
            $data['permissions'] = [$data['permissions']];

        $user->syncPermissions(...($data['permissions'] ?? []));

        $permissions = setting('AuthGroups.permissions');
        if (is_array($permissions)) {
            ksort($permissions);
        }
        $this->response->triggerClientEvent('showMessage', ['type' => 'success', 'content' => lang('Btw.message.resourcesSaved', [lang('Btw.general.users')])]);
        return view($this->viewPrefix . 'cells\form_cell_capabilities_row', [
            'rowPermission' => [$perm, $permissions[$perm]],
            'user' => $user,
            'menu' => service('menus')->menu('sidebar_user_profile'),
            'currentUrl' => (string) current_url(true)->setHost('')->setScheme('')->stripQuery('token')
        ]);
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
        $data = $this->request->getPost();

        $user->syncPermissions(...($data['permissions'] ?? []));

        $permissions = setting('AuthGroups.permissions');
        if (is_array($permissions)) {
            ksort($permissions);
        }
        $this->response->triggerClientEvent('showMessage', ['type' => 'success', 'content' => lang('Btw.message.resourcesSaved', [lang('Btw.general.users')])]);
        return view($this->viewPrefix . 'cells\form_cell_capabilities_tr', [
            'permissions' => $permissions,
            'user' => $user,
            'menu' => service('menus')->menu('sidebar_user_profile'),
            'currentUrl' => (string) current_url(true)->setHost('')->setScheme('')->stripQuery('token')
        ]);
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

            return $this->render($this->viewPrefix . 'profile_change_password', [
                'userCurrent' => auth()->user(),
                'menu' => service('menus')->menu('sidebar_user_profile'),
                'currentUrl' => (string) current_url(true)->setHost('')->setScheme('')->stripQuery('token')
            ]);
        }

        $data = $this->request->getPost();
        $validation = service('validation');

        $validation->setRules([
            'current_password' => 'required|strong_password',
            'new_password' => 'required|strong_password',
            'pass_confirm' => 'required|matches[new_password]',
        ]);

        if (!$validation->run($data)) {
            $this->response->triggerClientEvent('showMessage', ['type' => 'error', 'content' => lang('Btw.message.formValidationFailed', [lang('Btw.general.settings')])]);
            return view($this->viewPrefix . 'cells\form_cell_changepassword', [
                'userCurrent' => $user,
                'validation' => $validation
            ]);
        }

        //On vérifie que le mote d epasse en cours est connu 
        $validCreds = auth()->check(['password' => $data['current_password'], 'email' => $user->email]);
        if (!$validCreds->isOK()) {
            return view($this->viewPrefix . 'cells\form_cell_changepassword', [
                'userCurrent' => $user,
                'validation' => $validation
            ]) . alertHtmx('danger', 'Erreur de mot de passe en cours.');
            ;
        }


        // Save the new user's email/password
        $identity = $user->getEmailIdentity();

        if ($data['new_password'] !== null) {
            $identity->secret2 = service('passwords')->hash($data['new_password']);
        }

        if ($identity->hasChanged()) {
            model(UserIdentityModel::class)->save($identity);
        }

        $this->response->triggerClientEvent('showMessage', ['type' => 'success', 'content' => lang('Btw.message.resourcesSaved', [lang('Btw.general.users')])]);
        return view($this->viewPrefix . 'cells\form_cell_changepassword', [
            'userCurrent' => auth()->user()
        ]);
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

            return $this->render($this->viewPrefix . 'profile_two_factor', [
                'user' => $user,
                'menu' => service('menus')->menu('sidebar_user_profile'),
                'currentUrl' => (string) current_url(true)->setHost('')->setScheme('')->stripQuery('token')
            ]);
        }

        $data = $this->request->getPost();

        // Actions
        $actions = setting('Auth.actions');
        $actions['login'] = $data['email2FA'] ?? null;
        $context = 'user:' . user_id();
        service('settings')->set('Auth.actions', $actions, $context);

        $this->response->triggerClientEvent('showMessage', ['type' => 'success', 'content' => lang('Btw.message.resourcesSaved', [lang('Btw.general.users')])]);
        return view($this->viewPrefix . 'cells\form_cell_two_factor', [
            'user' => $user,
        ]);
    }


    public function changeLangue()
    {
        $context = 'user:' . user_id(); 
        service('settings')->set('Btw.language_bo', $this->request->getGet('changeLanguageBO'), $context);
        return redirect()->hxLocation(str_replace(base_url(), '', $this->request->getCurrentUrl()));
    }

    public function changeSidebarExpanded()
    {

        $context = 'user:' . user_id();
        $isSidebarExpanded = service('settings')->get('Btw.isSidebarExpanded', $context);

        if ($isSidebarExpanded == false) {
            service('settings')->set('Btw.isSidebarExpanded', 1, $context);
        } else {
            service('settings')->set('Btw.isSidebarExpanded', 0, $context);
        }

        $this->response->triggerClientEvent('updateSidebarExpanded');
    }


    /**
     * Déscative les informations sensible par le mot de passe
     */
    public function authPassModal(...$params){

        $validCreds = auth()->check(['password' => request()->getPost('password'), 'email' => Auth()->user()->email]);
        if (!$validCreds->isOK()) {
            $this->response->triggerClientEvent('showMessage', ['type' => 'error', 'content' => lang('Btw.Erreur de mot de passe en cours')]);
            $this->response->setReswap('none');
            return;
        }

        session()->set(request()->getPost('module') . '_' . request()->getPost('identifier'), time());        
        $this->response->triggerClientEvent(request()->getPost('actionHtmx'), time(), 'receive');
        $this->response->setReswap('innerHTML show:#general:top');
        $this->response->triggerClientEvent('closemodal');
    }



    /**
     * Creates any admin-required menus so they're
     * available to use by any modules.
     */
    private function setupMenus()
    {
        $menus = service('menus');

        // Sidebar menu
        $menus->createMenu('sidebar_user_profile');
        $menus->menu('sidebar_user_profile')
            ->createCollection('content', 'Content');
    }
    public function addMenuSidebar()
    {
        $sidebar = service('menus');
        $item = new MenuItem([
            'title' => 'Information',
            'namedRoute' => 'user-profile-settings',
            'fontIconSvg' => theme()->getSVG('duotune/communication/com006.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
            'permission' => 'admin.view.profile',
            'weight' => 1
        ]);
        $sidebar->menu('sidebar_user_profile')->collection('content')->addItem($item);

        $item = new MenuItem([
            'title' => lang('Btw.sidebar.capabilities'),
            'namedRoute' => 'user-capabilities',
            'fontIconSvg' => theme()->getSVG('duotune/general/gen047.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
            'permission' => 'admin.view.profile',
            'weight' => 2
        ]);
        $sidebar->menu('sidebar_user_profile')->collection('content')->addItem($item);

        $item = new MenuItem([
            'title' => lang('Btw.sidebar.changePassword'),
            'namedRoute' => 'user-change-password',
            'fontIconSvg' => theme()->getSVG('duotune/technology/teh004.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
            'permission' => 'admin.view.profile',
            'weight' => 3
        ]);
        $sidebar->menu('sidebar_user_profile')->collection('content')->addItem($item);

        $item = new MenuItem([
            'title' => lang('Btw.sidebar.TwoFactoAuthentification'),
            'namedRoute' => 'user-two-factor',
            'fontIconSvg' => theme()->getSVG('duotune/technology/teh004.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
            'permission' => 'admin.view.profile',
            'weight' => 3
        ]);
        $sidebar->menu('sidebar_user_profile')->collection('content')->addItem($item);

        $item = new MenuItem([
            'title' => lang('Btw.sidebar.historyLogin'),
            'namedRoute' => 'user-history',
            'fontIconSvg' => theme()->getSVG('duotune/general/gen013.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
            'permission' => 'admin.view.profile',
            'weight' => 4
        ]);
        $sidebar->menu('sidebar_user_profile')->collection('content')->addItem($item);

        $item = new MenuItem([
            'title' => lang('Btw.sidebar.historyBrowser'),
            'namedRoute' => 'user-session-browser',
            'fontIconSvg' => theme()->getSVG('duotune/general/gen013.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
            'permission' => 'admin.view.profile',
            'weight' => 4
        ]);
        $sidebar->menu('sidebar_user_profile')->collection('content')->addItem($item);

        $item = new MenuItem([
            'title' => 'Delete',
            'namedRoute' => 'settings-email',
            'fontIconSvg' => theme()->getSVG('duotune/general/gen016.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300 text-red-800', true),
            'permission' => 'admin.view.profile',
            'color' => 'text-red-800',
            'weight' => 5
        ]);
        $sidebar->menu('sidebar_user_profile')->collection('content')->addItem($item);
    }
}