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
     * Supported Locales
     * --------------------------------------------------------------------------
     *
     */   
    public $supportedLocales = [
        'fr' => [
            'name' => 'Btw.french',
            'iso_code' => 'fr',
            'flag' => '/flags/france.svg',
        ],
        'en' => [
            'name' => 'Btw.english',
            'iso_code' => 'en',
            'flag' => 'flags/united-states.svg',
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
}
