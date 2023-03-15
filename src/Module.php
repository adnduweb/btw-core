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
            'fontIconSvg'     => theme()->getSVG('duotune/communication/com014.svg', 'svg-icon svg-white group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300 fill-white', true),
            'permission'      => 'users.view',
        ]);
        $sidebar->menu('sidebar')->collection('access')->addItem($item);

        // // Add Users Settings
        // $item = new MenuItem([
        //     'title'           => 'Users',
        //     'namedRoute'      => 'user-settings',
        //     'fontIconSvg'     => theme()->getSVG('duotune/communication/com006.svg', 'svg-icon svg-white group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300', true),
        //     'permission'      => 'users.settings',
        // ]);
        // $sidebar->menu('sidebar')->collection('access')->addItem($item);

        // print_r($sidebar);exit;

        // Add to the Content menu
        $sidebar = service('menus');
        $item    = new MenuItem([
            'title'           => 'Groups',
            'namedRoute'      => 'groups-list',
            'fontIconSvg'     => theme()->getSVG('duotune/general/gen049.svg', 'svg-icon svg-white group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300 fill-white', true),
            'permission'      => 'groups.view',
        ]);
        $sidebar->menu('sidebar')->collection('access')->addItem($item);

        // Add to the Content menu
        $sidebar = service('menus');
        $item    = new MenuItem([
            'title'           => 'Permissions',
            'namedRoute'      => 'permissions-list',
            'fontIconSvg'     => theme()->getSVG('duotune/general/gen051.svg', 'svg-icon svg-white group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300 fill-white', true),
            'permission'      => 'permissions.view',
        ]);
        $sidebar->menu('sidebar')->collection('access')->addItem($item);

         // Add to the Content menu
         $sidebar = service('menus');
         $item    = new MenuItem([
             'title'           => lang('Btw.Settings'),
             'namedRoute'      => 'settings-general',
             'fontIconSvg'     => theme()->getSVG('duotone/Code/Settings4.svg', 'svg-icon svg-white group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300 fill-white', true),
             'permission'      => 'admin.view',
         ]);
         $sidebar->menu('sidebar')->collection('system')->addItem($item);

          // Add to the Content menu
          $sidebar = service('menus');
          $item    = new MenuItem([
              'title'           => lang('Btw.Logs'),
              'namedRoute'      => 'logs-file',
              'fontIconSvg'     => theme()->getSVG('duotone/Code/Settings4.svg', 'svg-icon svg-white group-hover:text-slate-300 mr-3 flex-shrink-0 h-6 w-6 text-slate-400 group-hover:text-slate-300 fill-white', true),
              'permission'      => 'admin.view',
          ]);
          $sidebar->menu('sidebar')->collection('system')->addItem($item);
    }
}
