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

class UserSettingsController extends AdminController
{
    protected $theme      = 'Admin';
    protected $viewPrefix = 'Btw\Core\Views\Admin\users\\';

    protected $rememberOptions = [
        '1 hour'   => 1 * HOUR,
        '4 hours'  => 4 * HOUR,
        '8 hours'  => 8 * HOUR,
        '25 hours' => 24 * HOUR,
        '1 week'   => 1 * WEEK,
        '2 weeks'  => 2 * WEEK,
        '3 weeks'  => 3 * WEEK,
        '1 month'  => 1 * MONTH,
        '2 months' => 2 * MONTH,
        '6 months' => 6 * MONTH,
        '1 year'   => 12 * MONTH,
    ];

    /**
     * Display the Email settings page.
     *
     * @return string
     */
    public function index()
    {
       

        return $this->render($this->viewPrefix . 'user_settings', [
            'rememberOptions' => $this->rememberOptions,
            'defaultGroup'    => setting('AuthGroups.defaultGroup'),
            'groups'          => setting('AuthGroups.groups'),
        ]);
    }

    /**
     * Saves the email settings to the config file, where it
     * is automatically saved by our dynamic configuration system.
     */
    public function save()
    {

        switch ($this->request->getVar('section')) {
            case 'registration':

                $requestJson = $this->request->getJSON(true);

                $validation = service('validation');

                $validation->setRules([
                    'defaultGroup'          => 'required|string',
                ]);

                if (!$validation->run($requestJson)) {
                    return view('Btw\Core\Views\Admin\users\form_cell_registration', [
                        'validation' => $validation
                    ]) . alert('danger', 'Form validation failed.');;
                }

                setting('Auth.allowRegistration', $requestJson['allowRegistration'] ?? false );
                Setting('AuthGroups.defaultGroup', $requestJson['defaultGroup']);

                // Actions
                $actions             = setting('Auth.actions');
                $actions['register'] = $requestJson['emailActivation'] ?? null;
                setting('Auth.actions', $actions);

                return view('Btw\Core\Views\Admin\users\form_cell_registration', [
                    'groups' => setting('AuthGroups.groups'),
                    'defaultGroup'    => setting('AuthGroups.defaultGroup'),
                ]) . alert('success', lang('Btw.resourcesSaved', ['users']));

                break;
            case 'login':

                $requestJson = $this->request->getJSON(true);

                // Remember Me
                $sessionConfig                     = setting('Auth.sessionConfig');
                $sessionConfig['allowRemembering'] = $requestJson['allowRemember'] ?? false;
                $sessionConfig['rememberLength']   = $requestJson['rememberLength'];
                setting('Auth.sessionConfig', $sessionConfig);

                // Actions
                $actions             = setting('Auth.actions');
                $actions['login']    = $requestJson['email2FA'] ?? null;
                setting('Auth.actions', $actions);

                return view('Btw\Core\Views\Admin\users\form_cell_login', [
                    'rememberOptions' => $this->rememberOptions,
                    'groups' => setting('AuthGroups.groups'),
                    'defaultGroup'    => setting('AuthGroups.defaultGroup'),
                ]) . alert('success', lang('Btw.resourcesSaved', ['users']));

                break;
            case 'password':

                $requestJson = $this->request->getJSON(true);

                $validation = service('validation');

                $validation->setRules([
                    'minimumPasswordLength' => 'required|integer|greater_than[6]'
                ]);

                if (!$validation->run($requestJson)) {
                    return view('Btw\Core\Views\Admin\users\form_cell_password', [
                        'validation' => $validation
                    ]) . alert('danger', 'Form validation failed.');;
                }

                setting('Auth.minimumPasswordLength', (int)$requestJson['minimumPasswordLength']);
                setting('Auth.passwordValidators',$requestJson['validators[]']);

                return view('Btw\Core\Views\Admin\users\form_cell_password', [
                    'groups' => setting('AuthGroups.groups'),
                    'defaultGroup'    => setting('AuthGroups.defaultGroup'),
                ]) . alert('success', lang('Btw.resourcesSaved', ['users']));

                break;

            case 'avatar':

                $requestJson = $this->request->getJSON(true);

                // Avatars
                setting('Users.useGravatar', $requestJson['useGravatar'] ?? false);
                setting('Users.gravatarDefault', $requestJson['gravatarDefault']);
                setting('Users.avatarNameBasis', $requestJson['avatarNameBasis']);

                $this->response->triggerClientEvent('updateAvatar', time(), 'receive');
                return view('Btw\Core\Views\Admin\users\form_cell_avatar', [
                    'groups' => setting('AuthGroups.groups'),
                    'defaultGroup'    => setting('AuthGroups.defaultGroup'),
                ]) . alert('success', lang('Btw.resourcesSaved', ['users']));

                break;
            default:
                alert('danger', lang('Btw.erreor', ['settings']));
        }
    }

    public function update(){

        return view('Themes\Admin\partials\headers\renderAvatar', [
            'auth' => auth()
        ]); 
        
    }
}
