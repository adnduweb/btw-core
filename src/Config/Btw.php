<?php

namespace Btw\Core\Config;

use CodeIgniter\Config\BaseConfig;

class Btw extends BaseConfig
{
    public $views = [
        'filter_list' => 'Btw\Views\_filter_list',
    ];

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
}
