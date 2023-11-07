<?php

namespace Btw\Core\Config;

use CodeIgniter\Config\BaseConfig;

class Btw extends BaseConfig
{

    public $dateCreated = "2023-11-01";
    public $codeApp = "";
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


    public $getExpirated = [
        '5 minutes' => 5 * MINUTE,
        '10 minutes' => 10 * MINUTE,
        '1 hour' => 1 * HOUR,
        '1 days' => 1 * DAY,
        '1 week' => 1 * WEEK,
        '1 month' => 1 * MONTH,
        '1 year' => 12 * MONTH,
    ];


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
        'Btw\Core\Cells\StatsDashboardCells::render'
    ];

    public array $cellsearch = [];

    public $debugTwig = true;

    public $functionsTwig = [
        'dd',
        'service',
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

    public string $titleNameAdmin = 'Btw le meilleur';

    public $seuilMEArtisans = '36800';

    public $seuilMECommercants = '91900';

    /**
    * --------------------------------------------------------------------------
    * Additional User Fields
    * --------------------------------------------------------------------------
    * Validation rules used when saving a user.
    */
    public $typesInfos = [
        1                     => [
            'name'            => 'attrGeneral',
            'class'           => ' bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300'
        ],
    ];

    /**
     * Time expired data Sensive
     */
    public $dataAskAuthExpiration = 3600;

    public $activeWebsocket = false;
}
