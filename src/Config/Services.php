<?php

namespace Btw\Core\Config;

use Btw\Core\Btw;
use Btw\Core\Menus\Manager as MenuManager;
use Btw\Core\View\Theme as Theme;
use Btw\Core\View\Metadata;
use Btw\Core\View\Javascriptdata;

use CodeIgniter\Config\BaseService;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
    /**
     * Core utility class for Btw's system.
     *
     * @return Btw|mixed
     */
    public static function Btw(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('Btw');
        }

        return new Btw();
    }

    /**
     * Returns the system menu manager
     *
     * @return Bonfire\Menus\Manager|mixed
     */
    public static function menus(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('menus');
        }

        return new MenuManager();
    }


    /**
     * Returns the view metadata manager.
     *
     * @return Metadata
     */
    public static function viewMeta(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('viewMeta');
        }

        return new Metadata();
    }

    /**
     * Returns the view metadata manager.
     *
     * @return Javascriptdata
     */
    public static function viewJavascript(bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('viewJavascript');
        }

        return new Javascriptdata();
    }

    

    /**
     * Return List AdminTheme.
     *
     * @param Theme|null $config
     * @param bool      $getShared
     *

     */
    public static function theme(bool $getShared = true)
    {
        if ($getShared) {
            return self::getSharedInstance('theme');
        }

        return new Theme();
    }
}
