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
use InvalidArgumentException;
use Btw\Core\TableHelper;
use CodeIgniter\Shield\Authorization\Groups;

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
    protected $viewPrefix = 'Btw\Core\Views\admin\groups\\';

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
            return view('Michalsn\CodeIgniterHtmxDemo\Views\books\table', $data);
        }


        echo $this->render($this->viewPrefix . 'index', $data);
    }

    /**
     * Allows the user to choose the permissions for a group.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     */
    public function show(string $alias)
    {

        if (!auth()->user()->can('groups.edit')) {
            alert('error', lang('Core.notAuthorized'));
            return redirect()->back();
        }

        $data['alias'] = $alias;
        $data['group'] = setting('AuthGroups.groups')[$alias];
        $data['pageTitleDefault'] = ucfirst(lang('Core.EditGroupsAndPermission') . ' : ' . ucfirst($alias));

        if (empty($data['group'])) {
            return redirect()->back()->with('error', lang('Bonfire.resourceNotFound', ['user group']));
        }

        $this->permissions($alias);

        return $this->render($this->viewPrefix . 'form', $data);
    }


    /**
     * Save the group settings
     *
     * @return \CodeIgniter\HTTP\RedirectResponse|void
     */
    public function saveGroup()
    {

        $post = $this->request->getVar(['title', 'description', 'alias']);

        $validation = service('validation');

        $group = setting('AuthGroups.groups')[$post['alias']];

        $validation->setRules([
            'title'  => ['required', 'string', 'min_length[2]', 'max_length[100]'],
            'description' => ['required'],
        ]);

        if (!$validation->run($post)) {
            return view('Btw\Core\Views\admin\groups\form_cell', [
                'group' => $group, 'validation' => $validation
            ]) . alert('danger', 'Form validation failed.');;
        }

        // Save the settings
        $groupConfig         = setting('AuthGroups.groups');
        $groupConfig[$post['alias']] = [
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
        ];

        setting('AuthGroups.groups', $groupConfig);



        return view('Btw\Core\Views\admin\groups\form_cell', [
            'group' => $group
        ]) . alert('success', lang('Btw.resourcesSaved', ['groups']));
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
}
