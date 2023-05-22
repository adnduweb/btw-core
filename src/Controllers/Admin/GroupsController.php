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
use Btw\Core\Libraries\TableHelper;
use CodeIgniter\Shield\Authorization\Groups;
use InvalidArgumentException;


/**
 * Class Dashboard
 *
 * The primary entry-point to the Bonfire admin area.
 */
class GroupsController extends AdminController
{

    /**
     * Base URL.
     */
    protected string $baseURL = 'admin/groups-list';

    /**
     * Base Views.
     */
    protected $viewPrefix = 'Btw\Core\Views\Admin\groups\\';

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
            'search'        => $this->request->getGet('search') ?? '',
            'sortColumn'    => $this->request->getGet('sortColumn') ?? 'title',
            'sortDirection' => $this->request->getGet('sortDirection') ?? 'asc',
            'collapse'      => true
        ];

        $rules = [
            'limit'         => ['is_natural_no_zero', 'less_than_equal_to[10]'],
            // 'page'          => ['is_natural', 'greater_than_equal_to[1]'],
            'search'        => ['string'],
            'sortColumn'    => ['in_list[title,description,alias,user_count]'],
            'sortDirection' => ['in_list[asc,desc]'],
        ];

        if (!$this->validateData($data, $rules)) {
            throw new InvalidArgumentException(implode(PHP_EOL, $this->validator->getErrors()));
        }

        $groups = setting('AuthGroups.groups');
        asort($groups);

        // Find the number of users in this group
        $data['groups'] = [];
        $i = 0;
        foreach ($groups as $alias => &$group) {
            $data['groups'][$i] = $group;
            $data['groups'][$i]['alias'] = $alias;
            $data['groups'][$i]['user_count'] = db_connect()
                ->table('auth_groups_users')
                ->where('group', $alias)
                ->countAllResults(true);
            $i++;
        }

        $data['table'] = new TableHelper($this->baseURL, $data['sortColumn'], $data['sortDirection']);


        if ($this->request->isHtmx() && !$this->request->isBoosted()) {
            return view('Btw\Core\Views\Admin\groups\table', $data);
        }

        echo $this->render($this->viewPrefix . 'index', $data);
    }

    /**
     * Creates a item from the new form data.
     *
     */
    public function create()
    {

        if (!$this->request->is('post')) {

            return $this->render($this->viewPrefix . 'group_information_add', [
                'alias' => 'new',
                'group' => 'new'
            ]);
        }

        $post = $this->request->getVar(['title', 'description']);
        $validation = service('validation');
        // validate
        $validation->setRules([
            'title'  => ['required', 'string', 'min_length[2]', 'max_length[100]'],
            'description' => ['required'],
        ]);

        if (!$validation->run($post)) {
            return view('Btw\Core\Views\Admin\groups\cells\form_cell_information', [
                'alias' => 'new',
                'validation' => $validation
            ]) . alertHtmx('danger', 'Form validation failed.');;
        }

        // Save the settings
        $alias = uniforme($post['title']);
        $groupConfig         = setting('AuthGroups.groups');
        $groupConfig[$alias] = [
            'title'       => $post['title'],
            'description' => $post['description'],
        ];

        setting('AuthGroups.groups', $groupConfig);

        theme()->set_message_htmx('success', lang('Btw.resourcesCreatead', ['groups']));
        $this->response->triggerClientEvent('createGroup');
        return redirect()->hxRedirect('/' .ADMIN_AREA. '/groups');
    }

    /**
     * Allows the user to choose the permissions for a group.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     */
    public function show(string $alias)
    {

        if (!auth()->user()->can('groups.edit')) {
            alertHtmx('error', lang('Core.notAuthorized'));
            return redirect()->back();
        }

        $this->permissions($alias);

        if (!$this->request->is('post')) {

            return $this->render($this->viewPrefix . 'group_information', [
                'alias' => $alias,
                'group' => setting('AuthGroups.groups')[$alias],
                'pageTitleDefault' => ucfirst(lang('Core.EditGroupsAndPermission') . ' : ' . ucfirst($alias)),
                'menu' => service('menus')->menu('sidebar_group'),
                'currentUrl' => (string)current_url(true)->setHost('')->setScheme('')->stripQuery('token')
            ]);
        }

        $post = $this->request->getVar(['title', 'description', 'alias']);
        $validation = service('validation');
        $group = setting('AuthGroups.groups')[$post['alias']];

        $validation->setRules([
            'title'  => ['required', 'string', 'min_length[2]', 'max_length[100]'],
            'description' => ['required'],
        ]);

        if (!$validation->run($post)) {
            return view('Btw\Core\Views\Admin\groups\cells\form_cell_information', [
                'group' => $group, 'validation' => $validation
            ]) . alertHtmx('danger', 'Form validation failed.');;
        }

        // Save the settings
        $groupConfig         = setting('AuthGroups.groups');
        $groupConfig[$post['alias']] = [
            'title'       => $post['title'],
            'description' => $post['description'],
        ];

        $groupNew = setting('AuthGroups.groups', $groupConfig);

        return view('Btw\Core\Views\Admin\groups\cells\form_cell_information', [
            'alias' => $alias,
            'group' => $groupConfig[$post['alias']],
            'pageTitleDefault' => ucfirst(lang('Core.EditGroupsAndPermission') . ' : ' . ucfirst($alias)),
            'menu' => service('menus')->menu('sidebar_group'),
            'currentUrl' => (string)current_url(true)->setHost('')->setScheme('')->stripQuery('token')
        ]) . alertHtmx('success', lang('Btw.resourcesSaved', ['groups']));
    }



    /**
     * Display the user to choose the permissions for a group.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     */
    public function capabilities(string $alias)
    {

        if (!auth()->user()->can('groups.edit')) {
            alertHtmx('error', lang('Core.notAuthorized'));
            return redirect()->back();
        }

        $permissions = setting('AuthGroups.permissions');
        if (is_array($permissions)) {
            ksort($permissions);
        }

        $matrix = setting('AuthGroups.matrix');

        if (!$this->request->is('post')) {

            return $this->render($this->viewPrefix . 'group_capabilities', [
                'alias' => $alias,
                'permissions'   => $permissions,
                'matrix' => (isset($matrix[$alias])) ? array_flip($matrix[$alias]) : false,
                'menu' => service('menus')->menu('sidebar_group'),
                'currentUrl' => (string)current_url(true)->setHost('')->setScheme('')->stripQuery('token')
            ]);
        }
    }

    /**
     * Toggle capability.
     */
    public function toggle(string $perm)
    {

        $data = $this->request->getPost();

        $groups = new Groups();
        $group  = $groups->info($data['alias']);
        if ($group === null) {
            return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', ['user group']));
        }

        if (isset($data['permissions']) && !is_array($data['permissions']))
            $data['permissions'] = [$data['permissions']];

        $group->setPermissions($data['permissions'] ?? []);


        $permissions = setting('AuthGroups.permissions');
        if (is_array($permissions)) {
            ksort($permissions);
        }

        $matrix = setting('AuthGroups.matrix');

        return view($this->viewPrefix . 'cells\form_cell_capabilities_row', [
            'alias' => $data['alias'],
            'permission'   => $perm,
            'description'   => $permissions[$perm],
            'matrix' => array_flip($matrix[$data['alias']]),
            'menu' => service('menus')->menu('sidebar_user_current'),
            'currentUrl' => (string)current_url(true)->setHost('')->setScheme('')->stripQuery('token')
        ]) . alertHtmx('success', lang('Btw.resourcesSaved', ['groups']));
    }

    /**
     * Toggle all capabilities.
     */
    public function toggleAll()
    {

        $data = $this->request->getPost();

        $groups = new Groups();
        $group  = $groups->info($data['alias']);
        if ($group === null) {
            return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', ['user group']));
        }

        if (isset($data['permissions']) && !is_array($data['permissions']))
            $data['permissions'] = [$data['permissions']];

        $group->setPermissions($data['permissions'] ?? []);


        $permissions = setting('AuthGroups.permissions');
        if (is_array($permissions)) {
            ksort($permissions);
        }

        $matrix = setting('AuthGroups.matrix');

        return view($this->viewPrefix . 'cells\form_cell_capabilities_tr', [
            'permissions'   => $permissions,
            'alias'   => $data['alias'],
            'matrix' => array_flip($matrix[$data['alias']]),
            'menu' => service('menus')->menu('sidebar_user_current'),
            'currentUrl' => (string)current_url(true)->setHost('')->setScheme('')->stripQuery('token')
        ]) . alertHtmx('success', lang('Btw.resourcesSaved', ['settings']));
    }

    /**
     * Delete the item (soft).
     *
     * @param string $alias
     *
     */
    public function delete(string $alias)
    {

        if ($this->request->is('delete')) {

            // Save the settings
            $groupConfig         = setting('AuthGroups.groups');
            unset($groupConfig[$alias]);

            $groupNew = setting('AuthGroups.groups', $groupConfig);

            $this->response->triggerClientEvent('deleteViaModal', true);
            alertHtmx('success', lang('Btw.resourcesDeleted', ['groups']));
            $this->response->triggerClientEvent('showMessage', ['level' => 'info', 'message' => 'Here Is A Message']);
            return $this->response->setJSON(['test' => 'cool']);
        }
    }


    /**
     * Displays a list of all Permissions for a single group
     *
     * @return RedirectResponse|string
     */
    public function permissions(string $groupName)
    {
        $groups = new Groups();
        $group  = $groups->info($groupName);
        if ($group === null) {
            $response = ['errors' => lang('Core.resourceNotFound', ['user group'])];
            return $this->respond($response, ResponseInterface::HTTP_FORBIDDEN);
        }

        $permissions = setting('AuthGroups.permissions');
        if (is_array($permissions)) {
            ksort($permissions);
        }

        $this->viewData['groupPermission'] = $group;
        $this->viewData['permissions'] = $permissions;
    }

    /**
     * Creates any admin-required menus so they're
     * available to use by any modules.
     */
    private function setupMenus()
    {
        $menus = service('menus');

        // Sidebar menu
        $menus->createMenu('sidebar_group');
        $menus->menu('sidebar_group')
            ->createCollection('content', 'Content');
    }

    public function addMenuSidebar()
    {

        $segments = request()->getUri()->getSegments();

        if (isset($segments[2]) && $segments[2] == 'show') {

            $sidebar = service('menus');
            $item    = new MenuItem([
                'title'           => 'Information',
                'namedRoute'      => ['group-show', (isset($segments[3])) ? $segments[3] : null],
                'fontIconSvg'     => theme()->getSVG('duotune/communication/com006.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
                'permission'      => 'admin.view',
                'weight' => 1
            ]);
            $sidebar->menu('sidebar_group')->collection('content')->addItem($item);

            $item    = new MenuItem([
                'title'           => 'Capabilities',
                'namedRoute'      => ['group-capabilities', (isset($segments[3])) ? $segments[3] : null],
                'fontIconSvg'     => theme()->getSVG('duotune/general/gen047.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
                'permission'      => 'admin.view',
                'weight' => 2
            ]);
            $sidebar->menu('sidebar_group')->collection('content')->addItem($item);
        }
    }
}
