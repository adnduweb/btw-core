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
use Btw\Core\Menus\MenuItem;
use Btw\Core\Entities\User;
use Btw\Core\Models\UserModel;


class UserSettingsController extends AdminController
{
    protected $theme      = 'Admin';
    protected $viewPrefix = 'Btw\Core\Views\Admin\users\\';

    public function __construct()
    {
        self::setupMenus();
        $this->addMenuSidebar();
    }


    /**
     * Display the Email settings page.
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

                $requestJson = $this->request->getJSON(true);
                $validation = service('validation');

                $validation->setRules([
                    'email'      => 'required|valid_email|unique_email[' . auth()->id() . ']',
                    'first_name' => 'permit_empty|string|min_length[3]',
                    'last_name'  => 'permit_empty|string|min_length[3]',
                ]);

                if (!$validation->run($requestJson)) {
                    return view('Btw\Core\Views\Admin\users\cells\form_cell_information', [
                        'userCurrent' => $user,
                        'validation' => $validation
                    ]) . alert('danger', 'Form validation failed.');;
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


                $this->response->triggerClientEvent('updateUserCurrent');

                return view('Btw\Core\Views\Admin\users\cells\form_cell_information', [
                    'userCurrent' => $user,
                    'menu' => service('menus')->menu('sidebar_user_current'),
                    'currentUrl' => (string)current_url(true)->setHost('')->setScheme('')->stripQuery('token')
                ]) . alert('success', lang('Btw.resourcesSaved', ['settings']));

                break;
            case 'groups':

                $requestJson = $this->request->getJSON(true);
                $validation = service('validation');

                $validation->setRules([
                    'currentGroup[]'      => 'required'
                ]);

                if (!$validation->run($requestJson)) {
                    return view('Btw\Core\Views\Admin\users\cells\cell_groups', [
                        'userCurrent' => auth()->user(),
                        'currentGroup'    => array_flip(auth()->user()->getGroups()),
                        'groups'          => setting('AuthGroups.groups'),
                        'validation' => $validation
                    ]) . alert('danger', 'Form validation failed.');;
                }


                if (!is_array($requestJson['currentGroup[]']))
                    $requestJson['currentGroup[]']  = [$requestJson['currentGroup[]']];

                // Save the user's groups
                $user->syncGroups(...($requestJson['currentGroup[]'] ?? []));

                $this->response->triggerClientEvent('updateGroupUserCurrent');

                return view('Btw\Core\Views\Admin\users\cells\cell_groups', [
                    'userCurrent' => auth()->user(),
                    'currentGroup'    => array_flip( $user->getGroups()),
                    'groups'          => setting('AuthGroups.groups'),
                ]) . alert('success', lang('Btw.resourcesSaved', ['settings']));

                break;
            default:
                alert('danger', lang('Btw.erreor', ['settings']));
        }
    }

    public function update()
    {
        return view('Themes\Admin\partials\headers\renderAvatar', [
            'auth' => auth()
        ]);
    }

    public function updateGroup(){
        return view('Btw\Core\Views\Admin\users\cells\line_group', [
            'userCurrent' => auth()->user()
        ]);
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
            'namedRoute'      => 'settings-registration',
            'fontIconSvg'     => theme()->getSVG('duotune/general/gen047.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
            'permission'      => 'admin.view',
            'weight' => 2
        ]);
        $sidebar->menu('sidebar_user_current')->collection('content')->addItem($item);

        $item    = new MenuItem([
            'title'           => 'Change password',
            'namedRoute'      => 'settings-passwords',
            'fontIconSvg'     => theme()->getSVG('duotune/technology/teh004.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
            'permission'      => 'admin.view',
            'weight' => 3
        ]);
        $sidebar->menu('sidebar_user_current')->collection('content')->addItem($item);

        $item    = new MenuItem([
            'title'           => 'History',
            'namedRoute'      => 'settings-avatar',
            'fontIconSvg'     => theme()->getSVG('duotune/general/gen013.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
            'permission'      => 'admin.view',
            'weight' => 4
        ]);
        $sidebar->menu('sidebar_user_current')->collection('content')->addItem($item);

        $item    = new MenuItem([
            'title'           => 'Delete',
            'namedRoute'      => 'settings-email',
            'fontIconSvg'     => theme()->getSVG('duotune/general/gen016.svg', 'svg-icon group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
            'permission'      => 'admin.view',
            'weight' => 5
        ]);
        $sidebar->menu('sidebar_user_current')->collection('content')->addItem($item);
    }
}
