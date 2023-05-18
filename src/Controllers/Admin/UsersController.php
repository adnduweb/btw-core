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
use Btw\Core\Models\UserModel;
use Btw\Core\Entities\User;
use CodeIgniter\Shield\Models\LoginModel;
use Btw\Core\Models\SessionModel;
use CodeIgniter\Shield\Models\UserIdentityModel;
use Btw\Core\Libraries\DataTable\DataTable;
use CodeIgniter\I18n\Time;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Exceptions\PageNotFoundException;
use InvalidArgumentException;


/**
 * Class Devis
 *
 * The primary entry-point to the Bonfire admin area.
 */
class UsersController extends AdminController
{

    use ResponseTrait;
    /**
     * Base URL.
     */
    protected string $baseURL = 'admin/users';
    protected $viewPrefix = 'Btw\Core\Views\Admin\users\only\\';
    public static $actions = [
        'edit',
        'delete',
        'activate',
        'desactivate'
    ];

    public function __construct()
    {
        self::setupMenus();
        $this->addMenuSidebar();
    }

    /**
     * Displays the site's initial page.
     */
    public function index()
    {

        $model = model(UserModel::class);
        $data['columns'] = $model->getColumn();
        $data['actions'] = self::$actions;

        return $this->render($this->viewPrefix . 'index', $data);
    }

    /**
     * Function datatable.
     *
     */
    public function ajaxDatatable()
    {

        $model = model(UserModel::class);
        $model->select('users.id, username, last_name, first_name, secret, active, users.created_at')->join('auth_identities', 'auth_identities.user_id = users.id')->where(['type' => 'email_password', 'deleted_at' => null]);

        return DataTable::of($model)
            ->add('select', function ($row) {
                $row = new User((array) $row);
                return view('Themes\Admin\Datatabase\select', ['row' => $row]);
            }, 'first')
            // ->hide('id')
            ->edit('username', function ($row) {
                $row = new User((array) $row);
                return view('Themes\Admin\Datatabase\username', ['row' => $row]);
            })
            ->hide('last_name')
            ->hide('first_name')
            ->edit('secret', function ($row) {
                return view('Themes\Admin\Datatabase\email', ['row' => $row]);
            })
            ->edit('active', function ($row) {
                $row = new User((array) $row);
                return view('Themes\Admin\Datatabase\switch', [
                    'row' => $row,
                    'type' => 'user',
                    'hxGet' => route_to('user-active-table', $row->id),
                    'hxSwap' => "none"
                ]);
            })
            ->add('type', function ($row) {
                $userCurrent = model(UserModel::class)->getAuthGroupsUsers($row->id);
                return ucfirst(implode(', ', $userCurrent));
            }, 'last')
            ->add('2fa', function ($row) {
                $actions = setting()->get('Auth.actions', 'user:' . $row->id);
                return (!empty($actions['login'])) ? '<span class="inline-flex items-center rounded-full bg-green-200 px-2 py-1 text-xs font-medium text-green-800">' . lang('Btw.yes') . '</span>' : '<span class="inline-flex items-center rounded-full bg-red-200 px-2 py-1 text-xs font-medium text-red-800">' . lang('Btw.no') . '</span>';
            }, 'last')
            ->format('created_at', function ($value) {
                return Time::parse($value, setting('App.appTimezone'))->format(setting('App.dateFormat') . ' à ' . setting('App.timeFormat'));
            })
            ->add('action', function ($row) {
                $row = new User((array) $row);
                return view('Themes\Admin\Datatabase\action', ['row' => $row, 'actions' => DataTable::actions(self::$actions, $row)]);
            }, 'last')
            ->toJson(true);
    }


    public function activeTable(int $userId)
    {
        $users = model(UserModel::class);
        if (!$user = $users->find($userId)) {
            throw new userNotFoundException('Incorrect user id.');
        }

        if (user_id() == $userId) {
            $this->response->triggerClientEvent('showMessage', ['type' => 'error', 'content' => lang('Btw.general.notAuthorized', ['user'])]);
            return $this;
        }

        $user->active = $user->active == true ? false : true;
        $user->updated_at = date('Y-m-d H:i:s');

        // Try saving basic details
        try {
            if (!$users->save($user, true)) {
                log_message('error', 'user errors', $users->errors());
                alertHtmx('danger', lang('Btw.unknownSaveError', ['user']));
            }
            $this->response->triggerClientEvent('showMessage', ['type' => 'success', 'content' => lang('Btw.message.resourcesSaved', [lang('Btw.general.user')])]);
            //$this->response->triggerClientEvent('reloadTable');
        } catch (\Exception $e) {
            log_message('debug', 'SAVING USER: ' . $e->getMessage());
        }

        $this->response->setStatusCode(204, 'No Content');
    }


    /**
     * Edit row.
     */
    public function edit(int $id): string
    {
        $users = model(UserModel::class);

        if (!$user = $users->find($id)) {
            if ($this->request->isHtmx() && !$this->request->isBoosted()) {
                $this->response->triggerClientEvent('showMessage', ['type' => 'danger', 'content' => lang('Btw.noRessourdeExistId', ['user'])]);
            } else
                throw new PageNotFoundException(lang('Btw.noRessourdeExistId', ['user']));
        }

        $groups = setting('AuthGroups.groups');
        asort($groups);

        if (!$this->request->is('post')) {

            return $this->render($this->viewPrefix . 'user_information', [
                'userCurrent' => $user,
                'currentGroup' => array_flip($user->getGroups()),
                'groups' => setting('AuthGroups.groups'),
                'menu' => service('menus')->menu('sidebar_user'),
                'currentUrl' => (string) current_url(true)->setHost('')->setScheme('')->stripQuery('token')
            ]);
        }

        switch ($this->request->getVar('section')) {
            case 'general':

                $requestJson = $this->request->getJSON(true);
                $validation = service('validation');

                $validation->setRules([
                    'email' => 'required|valid_email|unique_email[' . $user->id . ']',
                    'first_name' => 'permit_empty|string|min_length[3]',
                    'last_name' => 'permit_empty|string|min_length[3]',
                ]);

                if (!$validation->run($requestJson)) {
                    if ($this->request->isHtmx() && !$this->request->isBoosted()) {
                        $this->response->triggerClientEvent('showMessage', ['type' => 'error', 'content' => lang('Btw.message.formValidationFailed', [lang('Btw.general.users')])]);
                    } else
                        alertHtmx('danger', 'Form validation failed.');


                    return view($this->viewPrefix . 'cells\form_cell_information', [
                        'userCurrent' => $user,
                        'validation' => $validation
                    ]);
                    ;
                }

                $user->fill($requestJson);
                $user->username = generateUsername($requestJson['last_name'] . ' ' . $requestJson['first_name']);

                // Try saving basic details
                try {
                    if (!$users->save($user)) {
                        log_message('error', 'User errors', $users->errors());

                        $response = ['errors' => lang('Bonfire.unknownSaveError', ['user'])];
                        return $this->respond($response, ResponseInterface::HTTP_FORBIDDEN);
                    }
                } catch (InvalidArgumentException $e) {
                    // Just log the message for now since it's
                    // likely saying the user's data is all the same
                    log_message('debug', 'SAVING USER: ' . $e->getMessage());
                }

                if ($this->request->isHtmx() && !$this->request->isBoosted()) {
                    $this->response->triggerClientEvent('showMessage', ['type' => 'success', 'content' => lang('Btw.message.resourcesSaved', [lang('Btw.general.user')])]);
                    $this->response->triggerClientEvent('updateUser');
                }

                return view($this->viewPrefix . 'cells\form_cell_information', [
                    'userCurrent' => $user,
                    'menu' => service('menus')->menu('sidebar_user'),
                    'currentUrl' => (string) current_url(true)->setHost('')->setScheme('')->stripQuery('token')
                ]);

                break;
            case 'groups':

                $requestJson = $this->request->getJSON(true);
                $validation = service('validation');

                $validation->setRules([
                    'currentGroup[]' => 'required'
                ]);

                if (!$validation->run($requestJson)) {
                    return view($this->viewPrefix . 'cells\cell_groups', [
                        'userCurrent' => auth()->user(),
                        'currentGroup' => array_flip(auth()->user()->getGroups()),
                        'groups' => setting('AuthGroups.groups'),
                        'validation' => $validation
                    ]) . alertHtmx('danger', 'Form validation failed.');
                    ;
                }


                if (!is_array($requestJson['currentGroup[]']))
                    $requestJson['currentGroup[]'] = [$requestJson['currentGroup[]']];

                // Save the user's groups
                $user->syncGroups(...($requestJson['currentGroup[]'] ?? []));


                if ($this->request->isHtmx()) {
                    $this->response->triggerClientEvent('showMessage', ['type' => 'success', 'content' => lang('Btw.message.resourcesSaved', [lang('Btw.general.user')])]);
                    $this->response->triggerClientEvent('updateGroupUserCurrent');
                } else
                    alertHtmx('success', lang('Btw.resourcesSaved', ['settings']));

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

    public function create()
    {
        if (!$this->request->is('post')) {

            return $this->render($this->viewPrefix . 'create', [
                'groups' => setting('AuthGroups.groups')
            ]);
        }

        $requestJson = $this->request->getJSON(true);
        $validation = service('validation');

        $users = new UserModel();
        $user = new User();

        $rules = config('Users')->validation;
        $rules['currentGroup[]'] = 'required';
        $rules['new_password'] = 'required|strong_password';
        $rules['pass_confirm'] = 'required|matches[new_password]';
        $rules = array_merge($rules, $user->validationRules('meta'));

        if (!$this->validate($rules)) {


            // if (!$validation->run($requestJson)) {
            $this->response->triggerClientEvent('showMessage', ['type' => 'error', 'content' => lang('Btw.message.formValidationFailed', [lang('Btw.general.users')])]);
            return view($this->viewPrefix . 'cells\form_cell_create', [
                'validation' => $validation,
                'groups' => setting('AuthGroups.groups')
            ]);
        }

        $user->fill($requestJson);

        // Try saving basic details
        try {
            if (!$users->save($user)) {
                log_message('error', 'User errors', $users->errors());
                $this->response->triggerClientEvent('showMessage', ['type' => 'error', 'content' => lang('Btw.message.unknownSaveError', [lang('Btw.general.user')])]);
            }
        } catch (InvalidArgumentException $e) {
            // Just log the message for now since it's
            // likely saying the user's data is all the same
            log_message('debug', 'SAVING USER: ' . $e->getMessage());
        }

        // We need an ID to on the entity to save groups.
        if ($user->id === null) {
            $user->id = $users->getInsertID();
        }

        // Save the new user's email/password
        $password = $requestJson['new_password'];
        $identity = $user->getEmailIdentity();
        if ($identity === null) {
            helper('text');
            $user->createEmailIdentity([
                'email' => $requestJson['email'],
                'password' => !empty($password) ? $password : random_string('alnum', 12),
            ]);
        }
        // Update existing user's email identity
        else {
            $identity->secret = $requestJson['email'];
            if ($password !== null) {
                $identity->secret2 = service('passwords')->hash($password);
            }
            if ($identity->hasChanged()) {
                model(UserIdentityModel::class)->save($identity);
            }
        }

        if (!is_array($requestJson['currentGroup[]']))
            $requestJson['currentGroup[]'] = [$requestJson['currentGroup[]']];

        // Save the user's groups if the user has right permissions
        if (auth()->user()->can('users.edit')) {
            $user->syncGroups(...($requestJson['currentGroup[]'] ?? []));
        }

        Events::trigger('userCreated', $user); 

        $this->response->triggerClientEvent('showMessage', ['type' => 'success', 'content' => lang('Btw.message.resourcesSaved', [lang('Btw.general.user')])]);
        return redirect()->hxLocation('/' . ADMIN_AREA . '/users/edit/' . $user->id . '/information');

    }


    public function capabilities(int $id)
    {
        $users = model(UserModel::class);
        /** @var User|null $user */
        $user = $users->find($id);
        if ($user === null) {
            theme()->set_message_htmx('success', lang('Btw.resourceNotFound', ['user']));
            return redirect()->back();
        }

        $permissions = setting('AuthGroups.permissions');
        if (is_array($permissions)) {
            ksort($permissions);
        }

        $group = $user->getGroups();
        $matrix = setting('AuthGroups.matrix');


        $permissionsMatrix = [];
        foreach (array_flip($group) as $key => $val):
            if (isset($matrix[$key])):
                foreach ($matrix[$key] as $key => $val):
                    $permissionsMatrix[$val] = $val;
                endforeach;
            endif;
        endforeach;

        if (!$this->request->is('post')) {

            return $this->render($this->viewPrefix . 'user_capabilities', [
                'permissions' => $permissions,
                'permissionsMatrix' => $permissionsMatrix,
                'user' => $user,
                'menu' => service('menus')->menu('sidebar_user'),
                'currentUrl' => (string) current_url(true)->setHost('')->setScheme('')->stripQuery('token')
            ]);
        }
    }

    /**
     * Toggle capability.
     */
    public function toggle(int $id, string $perm)
    {
        $users = model(UserModel::class);
        /** @var User|null $user */
        $user = $users->find($id);

        $requestJson = $this->request->getJSON(true);

        if (isset($requestJson['permissions']) && !is_array($requestJson['permissions']))
            $requestJson['permissions'] = [$requestJson['permissions']];

        $user->syncPermissions(...($requestJson['permissions'] ?? []));

        $permissions = setting('AuthGroups.permissions');
        if (is_array($permissions)) {
            ksort($permissions);
        }

        $this->response->triggerClientEvent('showMessage', ['type' => 'success', 'content' => lang('Btw.message.resourcesSaved', [lang('Btw.general.user')])]);
        return view($this->viewPrefix . 'cells\form_cell_capabilities_row', [
            'rowPermission' => [$perm, $permissions[$perm]],
            'user' => $user,
            'menu' => service('menus')->menu('sidebar_user'),
            'currentUrl' => (string) current_url(true)->setHost('')->setScheme('')->stripQuery('token')
        ]);
    }

    /**
     * Toggle all capabilities.
     */
    public function toggleAll(int $id)
    {

        $users = model(UserModel::class);
        /** @var User|null $user */
        $user = $users->find($id);

        // print_r($this->request->getJSON(true)); exit;
        $requestJson = $this->request->getJSON(true);

        $user->syncPermissions(...($requestJson['permissions'] ?? []));

        $permissions = setting('AuthGroups.permissions');
        if (is_array($permissions)) {
            ksort($permissions);
        }

        return view($this->viewPrefix . 'cells\form_cell_capabilities_tr', [
            'permissions' => $permissions,
            'user' => $user,
            'menu' => service('menus')->menu('sidebar_user'),
            'currentUrl' => (string) current_url(true)->setHost('')->setScheme('')->stripQuery('token')
        ]) . alertHtmx('success', lang('Btw.resourcesSaved', ['settings']));
    }


    /**
     * Change user's password.
     *
     */
    public function changePassword(int $id)
    {
        $users = model(UserModel::class);
        /** @var User|null $user */
        $user = $users->find($id);
        if ($user === null) {
            theme()->set_message_htmx('success', lang('Btw.resourceNotFound', ['user']));
            return redirect()->back();
        }

        if (!$this->request->is('post')) {

            return $this->render($this->viewPrefix . 'user_change_password', [
                'user' => $user,
                'menu' => service('menus')->menu('sidebar_user'),
                'currentUrl' => (string) current_url(true)->setHost('')->setScheme('')->stripQuery('token')
            ]);
        }

        $requestJson = $this->request->getJSON(true);
        $validation = service('validation');

        $validation->setRules([
            'current_password' => 'required|strong_password',
            'new_password' => 'required|strong_password',
            'pass_confirm' => 'required|matches[new_password]',
        ]);

        if (!$validation->run($requestJson)) {
            return view($this->viewPrefix . 'cells\form_cell_changepassword', [
                'userCurrent' => $user,
                'validation' => $validation
            ]) . alertHtmx('danger', 'Form validation failed.');
            ;
        }

        //On vérifie que le mote d epasse en cours est connu 
        $validCreds = auth()->check(['password' => $requestJson['current_password'], 'email' => $user->email]);
        if (!$validCreds->isOK()) {
            return view($this->viewPrefix . 'cells\form_cell_changepassword', [
                'userCurrent' => $user,
                'validation' => $validation
            ]) . alertHtmx('danger', 'Erreur de mot de passe en cours.');
            ;
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
            'user' => $user
        ]) . alertHtmx('success', lang('Btw.resourcesSaved', ['settings']));
    }


    public function twoFactor(int $id)
    {
        $users = model(UserModel::class);
        /** @var User|null $user */
        $user = $users->find($id);
        if ($user === null) {
            theme()->set_message_htmx('success', lang('Btw.resourceNotFound', ['user']));
            return redirect()->back();
        }

        if (!$this->request->is('post')) {

            return $this->render($this->viewPrefix . 'user_two_factor', [
                'user' => $user,
                'menu' => service('menus')->menu('sidebar_user'),
                'currentUrl' => (string) current_url(true)->setHost('')->setScheme('')->stripQuery('token')
            ]);
        }

        $requestJson = $this->request->getJSON(true);

        // Actions
        $actions = setting('Auth.actions');
        $actions['login'] = $requestJson['email2FA'] ?? null;
        $context = 'user:' . $id;
        service('settings')->set('Auth.actions', $actions, $context);

        return view($this->viewPrefix . 'cells\form_cell_two_factor', [
            'user' => $user,
        ]) . alertHtmx('success', lang('Btw.resourcesSaved', ['settings']));
    }

    public function history(int $id)
    {
        $users = model(UserModel::class);
        /** @var User|null $user */
        $user = $users->find($id);
        if ($user === null) {
            theme()->set_message_htmx('success', lang('Btw.resourceNotFound', ['user']));
            return redirect()->back();
        }

        /** @var LoginModel $loginModel */
        $loginModel = model(LoginModel::class);
        $logins = $loginModel->where('identifier', $user->email)->orderBy('date', 'desc')->limit(20)->findAll();

        if (!$this->request->is('post')) {

            return $this->render($this->viewPrefix . 'user_history', [
                'user' => $user,
                'logins' => $logins,
                'menu' => service('menus')->menu('sidebar_user'),
                'currentUrl' => (string) current_url(true)->setHost('')->setScheme('')->stripQuery('token')
            ]);
        }
    }

    public function sessionBrowser(int $id)
    {
        $users = model(UserModel::class);
        /** @var User|null $user */
        $user = $users->find($id);
        if ($user === null) {
            theme()->set_message_htmx('success', lang('Btw.resourceNotFound', ['user']));
            return redirect()->back();
        }

        /** @var SessionModel $sessionModel */
        $sessionModel = model(SessionModel::class);
        $sessions = $sessionModel->where('user_id', $user->id)->orderBy('timestamp', 'desc')->limit(10)->find();


        if (!$this->request->is('post')) {

            return $this->render($this->viewPrefix . 'user_browser', [
                'user' => $user,
                'sessions' => $sessions,
                'menu' => service('menus')->menu('sidebar_user'),
                'currentUrl' => (string) current_url(true)->setHost('')->setScheme('')->stripQuery('token')
            ]);
        }
    }


    /**
     * Delete the item (soft).
     *
     * @param string $itemId
     *
     */
    public function deleteUser()
    {

        if ($this->request->is('delete')) {

            $response = json_decode($this->request->getBody());
            // print_r($response); exit;
            if (!is_array($response->id))
                return false;

            $model = model(UserModel::class);


            //print_r($rawInput['id']); exit;
            $isNatif = false;
            foreach ($response->id as $key => $id) {

                if ($id == Auth()->user()->id) {
                    // print_r($response); exit;
                    $this->response->triggerClientEvent('Messages', ['level' => 'info', 'message' => 'Here Is A Message']);
                    $this->response->triggerClientEvent('reloadTable');
                    alertHtmx('success', lang('Btw.resourcesSaved', ['users']));
                    return $this->respond(['messagehtml' => alertHtmx('error', lang('Btw.resourcesNotSaved', ['users']))], 200);

                    // return $this->response->triggerClientEvent('showMessage', ['level' => 'info', 'message' => 'Here Is A Message']);

                }
                $model->delete(['id' => $id]);
            }
            alertHtmx('success', lang('Btw.resourcesSaved', ['users']));
            return $this->respond(['messagehtml' => alertHtmx('error', lang('Btw.resourcesSaved', ['users']))], 200);
        }
        return $this->respondNoContent();
    }


    /**
     * Creates any admin-required menus so they're
     * available to use by any modules.
     */
    private function setupMenus()
    {
        $menus = service('menus');

        // Sidebar menu
        $menus->createMenu('sidebar_user');
        $menus->menu('sidebar_user')
            ->createCollection('content', 'Content');
    }

    public function addMenuSidebar()
    {
        $segments = request()->getUri()->getSegments();

        if (isset($segments[2]) && $segments[2] == 'edit') {

            $sidebar = service('menus');
            $item = new MenuItem([
                'title' => 'Information',
                'namedRoute' => ['user-only-information', (isset($segments[3])) ? $segments[3] : null],
                'fontIconSvg' => theme()->getSVG('duotune/communication/com006.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
                'permission' => 'admin.view',
                'weight' => 1
            ]);
            $sidebar->menu('sidebar_user')->collection('content')->addItem($item);

            $item = new MenuItem([
                'title' => 'Capabilities',
                'namedRoute' => ['user-only-capabilities', (isset($segments[3])) ? $segments[3] : null],
                'fontIconSvg' => theme()->getSVG('duotune/general/gen047.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
                'permission' => 'admin.view',
                'weight' => 2
            ]);
            $sidebar->menu('sidebar_user')->collection('content')->addItem($item);

            $item = new MenuItem([
                'title' => 'Change password',
                'namedRoute' => ['user-only-change-password', (isset($segments[3])) ? $segments[3] : null],
                'fontIconSvg' => theme()->getSVG('duotune/technology/teh004.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
                'permission' => 'admin.view',
                'weight' => 3
            ]);
            $sidebar->menu('sidebar_user')->collection('content')->addItem($item);

            $item = new MenuItem([
                'title' => 'Two Factor',
                'namedRoute' => ['user-only-two-factor', (isset($segments[3])) ? $segments[3] : null],
                'fontIconSvg' => theme()->getSVG('duotune/technology/teh004.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
                'permission' => 'admin.view',
                'weight' => 3
            ]);
            $sidebar->menu('sidebar_user')->collection('content')->addItem($item);

            $item = new MenuItem([
                'title' => 'History',
                'namedRoute' => ['user-only-history', (isset($segments[3])) ? $segments[3] : null],
                'fontIconSvg' => theme()->getSVG('duotune/general/gen013.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
                'permission' => 'admin.view',
                'weight' => 4
            ]);
            $sidebar->menu('sidebar_user')->collection('content')->addItem($item);

            $item = new MenuItem([
                'title' => 'Browser',
                'namedRoute' => ['user-only-browser', (isset($segments[3])) ? $segments[3] : null],
                'fontIconSvg' => theme()->getSVG('duotune/general/gen013.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
                'permission' => 'admin.view',
                'weight' => 4
            ]);
            $sidebar->menu('sidebar_user')->collection('content')->addItem($item);

            $item = new MenuItem([
                'title' => 'Delete',
                'namedRoute' => ['settings-email', (isset($segments[3])) ? $segments[3] : null],
                'fontIconSvg' => theme()->getSVG('duotune/general/gen016.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300 text-red-800', true),
                'permission' => 'admin.view',
                'weight' => 5
            ]);
            $sidebar->menu('sidebar_user')->collection('content')->addItem($item);
        }
    }
}