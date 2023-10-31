<?php

namespace Btw\Core\Config;

use CodeIgniter\Config\BaseConfig;
use Btw\Core\Interfaces\Transformer;

class Visits extends BaseConfig
{
    /**
     * Database field for tracking a unique visitor
     *
     * @var 'ip_address'|'session_id'|'user_id'
     */
    public string $trackingMethod = 'ip_address';

    /**
     * Number of seconds before a visit counts as new
     * instead of incrementing a previous view count.
     * Set to zero to record each page view as unique (not recommended).
     */
    public int $resetAfter = HOUR;

    /**
     * Transformers to apply (in order) before
     * recording the visit data.
     *
     * @see VisitModel::applyTransformations()
     *
     * @var class-string<Transformer>[]
     */
    public array $transformers = [];

    /**
     * Whether to ignore AJAX requests when recording.
     * See framework User Guide for caveats.
     *
     * @see https://www.codeigniter.com/user_guide/general/ajax.html
     */
    public bool $ignoreAjax = true;

    /**
     * Whether to ignore requests that result in a redirect response.
     * Note: requires using the "after" filter method.
     */
    public bool $ignoreRedirects = true;

    /**
     * Whether to ignore requests that result in an empty body.
     * Note: requires using the "after" filter method.
     */
    public bool $requireBody = false;

    /**
     * Whether to ignore requests with Content Types other than HTML.
     * Note: requires using the "after" filter method.
     */
    public bool $requireHtml = false;

    public array $browsers = [
        'safari' => [
            'icon' => 'admin/images/icons/safari.svg',
            'from' => 'a71d31',
            'to' => '3f0d12',
        ],
        'chrome' => [
            'icon' => 'admin/images/icons/chrome.svg',
            'from' => '009ffd',
            'to' => '2a2a72',
        ],
        'firefox' => [
            'icon' => 'admin/images/icons/firefox.svg',
            'from' => '009ffd',
            'to' => '2a2a72',
        ],
        'others' => [
            'icon' => 'admin/images/icons/others.svg',
            'from' => 'fe5f75',
            'to' => 'fc9842',
        ]
        ];
}
