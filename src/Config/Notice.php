<?php

namespace Btw\Core\Config;

use CodeIgniter\Config\BaseConfig;

class Notice extends BaseConfig
{
    public $typeId = [
        1 => 'success',
        2 => 'primary',
        3 => 'danger',
    ];

}