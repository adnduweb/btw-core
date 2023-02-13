<?php

/**
 * This file is part of Bonfire.
 *
 * (c) Lonnie Ezell <lonnieje@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Btw\Core;

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
            'fontIconSvg'     => theme()->getSVG('duotune/communication/com006.svg', 'svg-icon svg-white group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300 fill-white', true),
            'permission'      => 'users.view',
        ]);
        $sidebar->menu('sidebar')->collection('content')->addItem($item);

        // Add Users Settings
        $item = new MenuItem([
            'title'           => 'Users',
            'namedRoute'      => 'user-settings',
            'fontIconSvg'     => theme()->getSVG('duotune/communication/com006.svg', 'svg-icon svg-white group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
            'permission'      => 'users.settings',
        ]);
        $sidebar->menu('sidebar')->collection('settings')->addItem($item);

        // print_r($sidebar);exit;
    }
}
