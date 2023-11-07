<?php

namespace Btw\Core\Config;

use CodeIgniter\Config\BaseConfig;

class Notification extends BaseConfig
{
    /**
     * Type Notification
     */
    public $typesNotify = [
        1                     => [
            'svg'            => 'notify-success.svg',
        ],
        2                     => [
            'svg'            => 'notify-info.svg',
        ],
        3                     => [
            'svg'            => 'notify-warning.svg',
        ],
        4                     => [
            'svg'            => 'notify-error.svg',
        ],
    ];
}
