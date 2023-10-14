<?php

namespace Btw\Core\Config;

use CodeIgniter\Config\BaseConfig;

class Btw extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * List Views
     * --------------------------------------------------------------------------
     *
     */
    public $views = [
        'filter_list' => 'Btw\Views\_filter_list',
    ];

    /**
     * --------------------------------------------------------------------------
     * Menu ordering
     * --------------------------------------------------------------------------
     *
     * $menuWeights property is an array of named routes as keys with weight
     * asigned to each named route as a value. If the module's named route
     * is not represented in this array, it's weight will default to 0 (highest
     * in the menu).
     *
     *   // Main content:
     *   'user-list'     => 1,
     *   'custom-list'    => 2,
     *
     *   // Settings submenu:
     *   'user-group-settings' => 0,
     *   // ... other items here
     *
     *   // Tools submenu:
     *   'recycler'      => 1,
     *   'sys-info'      => 2,
     *   'sys-logs'      => 3,
     *
     * It is used by MenuItem class to assign non-default weight to a menu.
     *
     * Menu Users and the menus belonging to custom modules can be arranged
     * this way, as well as the submenus of Tools and Settings. The placement
     * of menus Tools and Settings will not be affected by this setting.
     *
     */
    public $menuWeights = [];


    /**
     * --------------------------------------------------------------------------
     * Supported Locales
     * --------------------------------------------------------------------------
     *
     */
    public $supportedLocales = [
        'fr' => [
            'name' => 'Btw.french',
            'iso_code' => 'fr',
            'flag' => '/flags/FR.svg',
        ],
        'en' => [
            'name' => 'Btw.english',
            'iso_code' => 'en',
            'flag' => 'flags/EN.svg',
        ]
    ];

    /**
     * --------------------------------------------------------------------------
     * Sidebar Expanded
     * --------------------------------------------------------------------------
     *
     * If true, Sidebar collapse.
     */
    public $isSidebarExpanded = true;

    public $themebo = 'Admin';

    public array $cellsDashboard = [
        'Btw\Core\Controllers\Admin\WidgetsController::chart_view_hx'

    ];

    public array $cellsearch = [];

    public $debugTwig = true;

    public $functionsTwig = [
        'dd',
        'form_open',
        'form_close',
        'form_error',
        'form_hidden',
        'set_value',
        'csrf_field',
        'asset_link',
        'theme_link',
        'setting',
        'form',
        'vite_tags',
        'csrf_meta',
        'current_url'
    ];
}
