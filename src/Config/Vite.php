<?php

namespace Btw\Core\Config;

use CodeIgniter\Config\BaseConfig;

class Vite extends BaseConfig
{
    public $entryPoints = [
        'front' => 'themes/App/js/app.js',
        'admin' => 'themes/Admin/js/app.js',
    ];
}
