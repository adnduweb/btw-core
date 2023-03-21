<?php

/**
 * This file is part of Bonfire.
 *
 * (c) Lonnie Ezell <lonnieje@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Btw\Core\Controllers\Admin;

use Btw\Core\Controllers\AdminController;
use Btw\Core\Libraries\Menus\MenuItem;
use Btw\Core\Models\UserModel;
use Btw\Core\Libraries\DataTable\DataTable;
use CodeIgniter\I18n\Time;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Exceptions\PageNotFoundException;
use InvalidArgumentException;
use ReflectionException;


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


    protected $viewPrefix = 'Btw\Core\Views\admin\users\only\\';

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

        $data = [
            'limit'         => $this->request->getGet('limit') ?? 5,
            'page'          => $this->request->getGet('page') ?? 1,
            'query'         => $this->request->getGet('query') ?? '',
            'sortColumn'    => $this->request->getGet('sortColumn') ?? 'id',
            'sortDirection' => $this->request->getGet('sortDirection') ?? 'asc',
        ];

        $model = model(UserModel::class);
        $data['columns'] = $model->getColumn();

        return $this->render($this->viewPrefix . 'index',  $data);
    }

    /**
     * Function datatable.
     *
     */
    public function ajaxDatatable()
    {

        $model = model(UserModel::class);
        $model->select('users.id, username, last_name, first_name, secret, active, users.created_at')->join('auth_identities', 'auth_identities.user_id = users.id')->where(['type' => 'email_password']);

        return DataTable::of($model)
            ->add('select', function ($row) {
                return view('Btw\Core\Views\admin\_datatabase\select', ['row' => $row]);
            }, 'first')
            ->hide('id')
            ->edit('username', function ($row) {
                return view('Btw\Core\Views\admin\_datatabase\username', ['row' => $row]);
            })
            ->hide('last_name')
            ->hide('first_name')
            ->edit('secret', function ($row) {
                return view('Btw\Core\Views\admin\_datatabase\email', ['row' => $row]);
            })
            ->edit('active', function ($row) {
                $active = ($row->active == '1') ? '<span class="inline-flex items-center rounded-full bg-green-200 px-2 py-1 text-xs font-medium text-green-800">' . lang('Btw.yes') . '</span>' :  '<span class="inline-flex items-center rounded-full bg-red-200 px-2 py-1 text-xs font-medium text-red-800">' . lang('Btw.no') . '</span>';
                return $active;
            })
            ->add('type', function ($row) {
                $userCurrent = model(UserModel::class)->getAuthGroupsUsers($row->id);
                return ucfirst(implode(', ', $userCurrent));
            }, 'last')
            ->add('2fa', function ($row) {
                $actions = setting()->get('Auth.actions', 'user:' . $row->id);
                return (!empty($actions['login'])) ? '<span class="inline-flex items-center rounded-full bg-green-200 px-2 py-1 text-xs font-medium text-green-800">' . lang('Btw.yes') . '</span>' :  '<span class="inline-flex items-center rounded-full bg-red-200 px-2 py-1 text-xs font-medium text-red-800">' . lang('Btw.no') . '</span>';
            }, 'last')
            ->format('created_at', function ($value) {
                return Time::parse($value, setting('App.appTimezone'))->format(setting('App.dateFormat') . ' ' . setting('App.timeFormat'));
            })
            ->add('action', function ($row) {
                return view('Btw\Core\Views\admin\_datatabase\action', ['row' => $row]);
            }, 'last')
            ->toJson();
    }

    public function bulkaction()
    {
        print_r($_POST);
        exit;
    }


    /**
     * Edit row.
     */
    public function edit(int $id): string
    {
        $users = model(UserModel::class);

        if (!$user = $users->find($id)) {
            throw new PageNotFoundException('Incorrect book id.');
        }

        $groups = setting('AuthGroups.groups');
        asort($groups);

        if (!$this->request->is('post')) {

            return $this->render($this->viewPrefix . 'user_information', [
                'userCurrent' => $user,
                'currentGroup'    => array_flip($user->getGroups()),
                'groups'          => setting('AuthGroups.groups'),
                'menu' => service('menus')->menu('sidebar_user'),
                'currentUrl' => (string)current_url(true)->setHost('')->setScheme('')->stripQuery('token')
            ]);
        }

        switch ($this->request->getVar('section')) {
            case 'general':

                $requestJson = $this->request->getJSON(true);
                $validation = service('validation');

                $validation->setRules([
                    'email'      => 'required|valid_email|unique_email[' . $user->id . ']',
                    'first_name' => 'permit_empty|string|min_length[3]',
                    'last_name'  => 'permit_empty|string|min_length[3]',
                ]);

                if (!$validation->run($requestJson)) {
                    return view($this->viewPrefix . 'cells\form_cell_information', [
                        'userCurrent' => $user,
                        'validation' => $validation
                    ]) . alertHtmx('danger', 'Form validation failed.');;
                }

                $user->fill($requestJson);
                $user->username = generateUsername($requestJson['last_name'] . ' ' .  $requestJson['first_name']);

                // Try saving basic details
                try {
                    if (!$users->save($user)) {
                        log_message('error', 'User errors', $users->errors());

                        $response = ['errors' => lang('Bonfire.unknownSaveError', ['user'])];
                        return $this->respond($response, ResponseInterface::HTTP_FORBIDDEN);
                    }
                } catch (DataException $e) {
                    // Just log the message for now since it's
                    // likely saying the user's data is all the same
                    log_message('debug', 'SAVING USER: ' . $e->getMessage());
                }


                $this->response->triggerClientEvent('updateUser');

                return view($this->viewPrefix . 'cells\form_cell_information', [
                    'userCurrent' => $user,
                    'menu' => service('menus')->menu('sidebar_user_current'),
                    'currentUrl' => (string)current_url(true)->setHost('')->setScheme('')->stripQuery('token')
                ]) . alertHtmx('success', lang('Btw.resourcesSaved sur ? ', ['settings']));

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


    public function capabilities(int $id)
    {
        $users = model(UserModel::class);
        /** @var User|null $user */
        $user = $users->find($id);
        if ($user === null) {
            return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', ['user']));
        }

        $permissions = setting('AuthGroups.permissions');
        if (is_array($permissions)) {
            ksort($permissions);
        }

        if (!$this->request->is('post')) {

            return $this->render($this->viewPrefix . 'user_capabilities', [
                'permissions'   => $permissions,
                'user'   => $user,
                'menu' => service('menus')->menu('sidebar_user'),
                'currentUrl' => (string)current_url(true)->setHost('')->setScheme('')->stripQuery('token')
            ]);
        }
    }

    /**
     * Delete the item (soft).
     *
     * @param string $itemId
     *
     */
    public function delete()
    {

        if ($this->request->is('delete')) {

            $response = json_decode($this->request->getBody());
            // print_r($response); exit;
            if (!is_array($response->id))
                return false;

            $model = model(DevisModel::class);


            //print_r($rawInput['id']); exit;
            $isNatif = false;
            foreach ($response->id as $key => $id) {

                $model->delete(['id' => $id]);
            }
            alertHtmx('success', lang('Btw.resourcesSaved', ['settings']));
            return $this->respond(['success' => lang('Core.your_selected_records_have_been_deleted'), 'messagehtml' => alertHtmx('success', lang('Btw.resourcesSaved', ['users']))], 200);
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
            $item    = new MenuItem([
                'title'           => 'Information',
                'namedRoute'      => ['user-only-information', (isset($segments[3])) ? $segments[3] : null],
                'fontIconSvg'     => theme()->getSVG('duotune/communication/com006.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
                'permission'      => 'admin.view',
                'weight' => 1
            ]);
            $sidebar->menu('sidebar_user')->collection('content')->addItem($item);

            $item    = new MenuItem([
                'title'           => 'Capabilities',
                'namedRoute'      => ['user-only-capabilities', (isset($segments[3])) ? $segments[3] : null],
                'fontIconSvg'     => theme()->getSVG('duotune/general/gen047.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
                'permission'      => 'admin.view',
                'weight' => 2
            ]);
            $sidebar->menu('sidebar_user')->collection('content')->addItem($item);

            $item    = new MenuItem([
                'title'           => 'Change password',
                'namedRoute'      => ['user-change-password', (isset($segments[3])) ? $segments[3] : null],
                'fontIconSvg'     => theme()->getSVG('duotune/technology/teh004.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
                'permission'      => 'admin.view',
                'weight' => 3
            ]);
            $sidebar->menu('sidebar_user')->collection('content')->addItem($item);

            $item    = new MenuItem([
                'title'           => 'Two Factor',
                'namedRoute'      => ['user-two-factor', (isset($segments[3])) ? $segments[3] : null],
                'fontIconSvg'     => theme()->getSVG('duotune/technology/teh004.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
                'permission'      => 'admin.view',
                'weight' => 3
            ]);
            $sidebar->menu('sidebar_user')->collection('content')->addItem($item);

            $item    = new MenuItem([
                'title'           => 'History',
                'namedRoute'      => ['user-history', (isset($segments[3])) ? $segments[3] : null],
                'fontIconSvg'     => theme()->getSVG('duotune/general/gen013.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
                'permission'      => 'admin.view',
                'weight' => 4
            ]);
            $sidebar->menu('sidebar_user')->collection('content')->addItem($item);

            $item    = new MenuItem([
                'title'           => 'Browser',
                'namedRoute'      => ['user-session-browser', (isset($segments[3])) ? $segments[3] : null],
                'fontIconSvg'     => theme()->getSVG('duotune/general/gen013.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
                'permission'      => 'admin.view',
                'weight' => 4
            ]);
            $sidebar->menu('sidebar_user')->collection('content')->addItem($item);

            $item    = new MenuItem([
                'title'           => 'Delete',
                'namedRoute'      => ['settings-email', (isset($segments[3])) ? $segments[3] : null],
                'fontIconSvg'     => theme()->getSVG('duotune/general/gen016.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
                'permission'      => 'admin.view',
                'weight' => 5
            ]);
            $sidebar->menu('sidebar_user')->collection('content')->addItem($item);
        }
    }
}
