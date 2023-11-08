<?php

/**
 * This file is part of Doudou.
 *
 * (c) Fabrice Loru <fabrice@adnduweb.com>
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
            'fontIconSvg'     => theme()->getSVG('admin/images/icons/user.svg', 'svg-icon flex-shrink-0 h-6 w-6 dark:text-gray-200 text-gray-800 svg-white', true),
            'permission'      => 'users.view',
        ]);
        $sidebar->menu('sidebar')->collection('access')->addItem($item);


        $item    = new MenuItem([
            'title'           => 'Groups',
            'namedRoute'      => 'groups-list',
            'fontIconSvg'     => theme()->getSVG('admin/images/icons/group.svg', 'svg-icon flex-shrink-0 h-6 w-6 dark:text-gray-200 text-gray-800 svg-white', true),
            'permission'      => 'groups.view',
        ]);
        $sidebar->menu('sidebar')->collection('access')->addItem($item);

        $item    = new MenuItem([
            'title'           => 'Permissions',
            'namedRoute'      => 'permissions-list',
            'fontIconSvg'     => theme()->getSVG('admin/images/icons/permissions.svg', 'svg-icon flex-shrink-0 h-6 w-6 dark:text-gray-200 text-gray-800 svg-white', true),
            'permission'      => 'admin.view',
        ]);
        $sidebar->menu('sidebar')->collection('access')->addItem($item);

        $item    = new MenuItem([
            'title'           => lang('Btw.Settings'),
            'namedRoute'      => 'settings-general',
            'fontIconSvg'     => theme()->getSVG('admin/images/icons/settings.svg', 'svg-icon flex-shrink-0 h-6 w-6 dark:text-gray-200 text-gray-800 svg-white', true),
            'permission'      => 'admin.view',
            'weight' => 3
        ]);
        $sidebar->menu('sidebar')->collection('system')->addItem($item);

        $item    = new MenuItem([
            'title'           => lang('Btw.Logs'),
            'namedRoute'      => 'logs-file',
            'fontIconSvg'     => theme()->getSVG('admin/images/icons/logs.svg', 'svg-icon flex-shrink-0 h-6 w-6 dark:text-gray-200 text-gray-800 svg-white', true),
            'permission'      => 'admin.view',
            'weight' => 1
        ]);
        $sidebar->menu('sidebar')->collection('system')->addItem($item);

        $item    = new MenuItem([
            'title'           => lang('Btw.systemLogs'),
            'namedRoute'      => 'logs-system',
            'fontIconSvg'     => theme()->getSVG('admin/images/icons/logs.svg', 'svg-icon flex-shrink-0 h-6 w-6 dark:text-gray-200 text-gray-800 svg-white', true),
            'permission'      => 'admin.view',
            'weight' => 2
        ]);
        $sidebar->menu('sidebar')->collection('system')->addItem($item);

        $item    = new MenuItem([
            'title'           => lang('Btw.notes'),
            'namedRoute'      => 'notes-list',
            'fontIconSvg'     => theme()->getSVG('admin/images/icons/note.svg', 'svg-icon flex-shrink-0 h-6 w-6 dark:text-gray-200 text-gray-800 svg-white', true),
            'permission'      => 'admin.view',
            'weight' => 3
        ]);
        $sidebar->menu('sidebar')->collection('system')->addItem($item);

        $item    = new MenuItem([
            'title'           => lang('Btw.systemInfos'),
            'namedRoute'      => 'sys-info',
            'fontIconSvg'     => theme()->getSVG('admin/images/icons/code.svg', 'svg-icon flex-shrink-0 h-6 w-6 dark:text-gray-200 text-gray-800 svg-white', true),
            'permission'      => 'admin.view',
            'weight' => 1
        ]);
        $sidebar->menu('sidebar')->collection('tools')->addItem($item);

        $item    = new MenuItem([
            'title'           => lang('Btw.tokens'),
            'namedRoute'      => 'tokens-manage',
            'fontIconSvg'     => theme()->getSVG('admin/images/icons/tokens.svg', 'svg-icon flex-shrink-0 h-6 w-6 dark:text-gray-200 text-gray-800 svg-white', true),
            'permission'      => 'admin.view',
            'weight' => 2
        ]);
        $sidebar->menu('sidebar')->collection('tools')->addItem($item);

        $item    = new MenuItem([
            'title'           => lang('Btw.notices'),
            'namedRoute'      => 'notices-manage',
            'fontIconSvg'     => theme()->getSVG('admin/images/icons/tokens.svg', 'svg-icon flex-shrink-0 h-6 w-6 dark:text-gray-200 text-gray-800 svg-white', true),
            'permission'      => 'me.view',
            'weight' => 2
        ]);
        $sidebar->menu('sidebar')->collection('system')->addItem($item);
    }
}
