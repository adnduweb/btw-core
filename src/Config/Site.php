<?php

namespace Btw\Core\Config;

use CodeIgniter\Config\BaseConfig;

class Site extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Items Per Page
     * --------------------------------------------------------------------------
     *
     * The number of items that should be displayed in content lists.
     */
    public $perPage = 15;

    /**
     * --------------------------------------------------------------------------
     * Base Site URL
     * --------------------------------------------------------------------------
     *
     * The name that should be displayed for the site.
     */
    public $siteName = 'Btw';

    /**
     * --------------------------------------------------------------------------
     * Site Online?
     * --------------------------------------------------------------------------
     *
     * When false, only superadmins and user groups with permission will be
     * able to view the site. All others will see the "System Offline" page.
     */
    public $siteOnline = true;

    /**
     * --------------------------------------------------------------------------
     * Site Offline View
     * --------------------------------------------------------------------------
     *
     * The view file that is displayed when the site is offline.
     */
    public $siteOfflineView = 'Themes\App\site_offline';
}
