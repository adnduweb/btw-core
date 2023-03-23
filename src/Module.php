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
use Btw\Core\Libraries\Menus\MenuItem;

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
            'fontIconSvg'     => theme()->getSVG('duotune/communication/com014.svg', 'svg-icon mr-3 flex-shrink-0 h-6 w-6 dark:text-gray-200 text-gray-800', true),
            'permission'      => 'users.view',
        ]);
        $sidebar->menu('sidebar')->collection('access')->addItem($item);


        // Add to the Content menu
        $sidebar = service('menus');
        $item    = new MenuItem([
            'title'           => 'Groups',
            'namedRoute'      => 'groups-list',
            'fontIconSvg'     => theme()->getSVG('duotune/general/gen049.svg', 'svg-icon mr-3 flex-shrink-0 h-6 w-6 dark:text-gray-200 text-gray-800 ', true),
            'permission'      => 'groups.view',
        ]);
        $sidebar->menu('sidebar')->collection('access')->addItem($item);

        // Add to the Content menu
        $sidebar = service('menus');
        $item    = new MenuItem([
            'title'           => 'Permissions',
            'namedRoute'      => 'permissions-list',
            'fontIconSvg'     => theme()->getSVG('duotune/general/gen051.svg', 'svg-icon  mr-3 flex-shrink-0 h-6 w-6 dark:text-gray-200 text-gray-800 ', true),
            'permission'      => 'admin.view',
        ]);
        $sidebar->menu('sidebar')->collection('access')->addItem($item);

         // Add to the Content menu
         $sidebar = service('menus');
         $item    = new MenuItem([
             'title'           => lang('Btw.Settings'),
             'namedRoute'      => 'settings-general',
             'fontIconSvg'     => theme()->getSVG('duotone/Code/Settings4.svg', 'svg-icon  mr-3 flex-shrink-0 h-6 w-6 dark:text-gray-200 text-gray-800 ', true),
             'permission'      => 'admin.view',
             'weight' => 3
         ]);
         $sidebar->menu('sidebar')->collection('system')->addItem($item);

          // Add to the Content menu
          $sidebar = service('menus');
          $item    = new MenuItem([
              'title'           => lang('Btw.Logs'),
              'namedRoute'      => 'logs-file',
              'fontIconSvg'     => theme()->getSVG('duotune/text/txt012.svg', 'svg-icon mr-3 flex-shrink-0 h-4 w-6 ml-5 dark:text-gray-200 text-gray-800 ', true),
              'permission'      => 'admin.view',
              'weight' => 1
          ]);
          $sidebar->menu('sidebar')->collection('system')->addItem($item);

           // Add to the Content menu
           $sidebar = service('menus');
           $item    = new MenuItem([
               'title'           => lang('Btw.systemLogs'),
               'namedRoute'      => 'logs-system',
               'fontIconSvg'     => theme()->getSVG('duotune/text/txt012.svg', 'svg-icon mr-3 flex-shrink-0 h-4 w-6 ml-5 dark:text-gray-200 text-gray-800 ', true),
               'permission'      => 'admin.view',
               'weight' => 2
           ]);
           $sidebar->menu('sidebar')->collection('system')->addItem($item);

          
    }
}
