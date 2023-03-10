<?php

/**
 * This file is part of Bonfire.
 *
 * (c) Lonnie Ezell <lonnieje@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Btw\Core\Users;

use Btw\Core\Controllers\BaseModuleController;
use Btw\Core\Menus\MenuItem;

class Module extends BaseModuleController
{
    /**
     * Setup our admin area needs.
     */
    public function initAdmin()
    {
        // Add to the Content menu
        $sidebar = service('menus');
        $item    = new MenuItem([
            'title'           => 'Users',
            'namedRoute'      => 'user-list',
            'fontAwesomeIcon' => 'fas fa-users',
            'permission'      => 'users.view',
        ]);
        $sidebar->menu('sidebar')->collection('content')->addItem($item);

        // Add Users Settings
        $item = new MenuItem([
            'title'           => 'Users',
            'namedRoute'      => 'user-settings',
            'fontAwesomeIcon' => 'fas fa-user-cog',
            'permission'      => 'users.settings',
        ]);
        $sidebar->menu('sidebar')->collection('settings')->addItem($item);

        print_r($sidebar);exit;
    }
}
