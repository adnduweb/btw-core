<?php

namespace Btw\Core\Config;

use CodeIgniter\Config\BaseConfig;

class Btw extends BaseConfig
{
    public $views = [
        'filter_list' => 'Btw\Views\_filter_list',
    ];

    /**
     * --------------------------------------------------------------------------
     * App Module locations
     * --------------------------------------------------------------------------
     *
     * Any folders that contain modules can be configured here.
     * When Btw boots up it will automatitcally load any modules in these
     * folders. The entries MUST be the namespace as the key, and the location
     * as the value.
     *
     *   'MyStuff' => 'app/Modules',
     *
     *  You may leave the array empty if you do not wish to use module discovery.
     */
    public $appModules = [
        'App\Modules' => APPPATH . 'Modules',
    ];
}
