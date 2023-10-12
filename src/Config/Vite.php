<?php

namespace Btw\Core\Config;

use CodeIgniter\Config\BaseConfig;

class Vite extends BaseConfig
{
    public $entryPoints = [
        'front' => 'themes/app/js/app.js',
        'admin' => 'themes/admin/js/app.js',
    ];
}
