<?php

namespace Btw\Core\Config;

use Btw\Core\Btw;
use Btw\Core\Libraries\Menus\Manager as MenuManager;
use Btw\Core\View\Theme as Theme;
use Btw\Core\View\Metadata;
use Btw\Core\View\Javascriptdata;
use Btw\Core\Libraries\Oauth\Basic\ShieldOAuth;
use Btw\Core\Libraries\Activitys;
use Btw\Core\Config\Activitys as ActivitysConfig;
use Btw\Core\Libraries\Storage\FileSystem;
use Btw\Core\Libraries\Storage\StorageFactory;
use Btw\Core\Libraries\Cron\Scheduler;
use Btw\Core\Libraries\Notifications;
use Btw\Core\Libraries\Notice\Notices;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\UserAgent;
use Config\App;
use Config\Services as AppServices;
use Config\Toolbar as ToolbarConfig;
use Config\View as ViewConfig;
use Btw\Core\Debug\Toolbar;
use Btw\Core\HTTP\IncomingRequest;
use Btw\Core\HTTP\RedirectResponse;
use Btw\Core\HTTP\Response;

use Btw\Core\View\View;

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
     * The Renderer class is the class that actually displays a file to the user.
     * The default View class within CodeIgniter is intentionally simple, but this
     * service could easily be replaced by a template engine if the user needed to.
     *
     * @return View
     */
    public static function renderer(?string $viewPath = null, ?ViewConfig $config = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('renderer', $viewPath, $config);
        }

        $viewPath = $viewPath ?: config('Paths')->viewDirectory;
        $config ??= config('View');

        return new View($config, $viewPath, AppServices::locator(), CI_DEBUG, AppServices::logger());
    }

    /**
     * Returns the current Request object.
     *
     * createRequest() injects IncomingRequest or CLIRequest.
     *
     * @deprecated The parameter $config and $getShared are deprecated.
     */
    public static function request(?App $config = null, bool $getShared = true): CLIRequest|IncomingRequest
    {
        if ($getShared) {
            return static::getSharedInstance('request', $config);
        }

        // @TODO remove the following code for backward compatibility
        return static::incomingrequest($config, $getShared);
    }

    /**
     * The IncomingRequest class models an HTTP request.
     *
     * @return IncomingRequest
     *
     * @internal
     */
    public static function incomingrequest(?App $config = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('request', $config);
        }

        $config ??= config('App');

        return new IncomingRequest(
            $config,
            AppServices::uri(),
            'php://input',
            new UserAgent()
        );
    }

    /**
     * The Redirect class provides nice way of working with redirects.
     *
     * @return RedirectResponse
     */
    public static function redirectresponse(?App $config = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('redirectresponse', $config);
        }

        $config ??= config('App');
        $response = new RedirectResponse($config);
        $response->setProtocolVersion(AppServices::request()->getProtocolVersion());

        return $response;
    }

    /**
     * The Response class models an HTTP response.
     *
     * @return ResponseInterface
     */
    public static function response(?App $config = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('response', $config);
        }

        $config ??= config('App');

        return new Response($config);
    }

    /**
     * Return the debug toolbar.
     *
     * @return Toolbar
     */
    public static function toolbar(?ToolbarConfig $config = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('toolbar', $config);
        }

        $config ??= config('Toolbar');

        return new Toolbar($config);
    }

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
     * @return Btw\Core\Libraries\Menus\Manager|mixed
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

    public static function ShieldOAuth($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('ShieldOAuth');
        }

        return new ShieldOAuth(new ShieldOAuthConfig());
    }

    public static function Activitys(?ActivitysConfig $config = null, bool $getShared = true): Activitys
    {
        if ($getShared) {
            return static::getSharedInstance('Activitys', $config);
        }

        // If no config was injected then load one
        if (empty($config)) {
            $config = config('Activitys');
        }

        return new Activitys($config);
    }


    /**
    * The storage class provides a simple way to store and retrieve
    * complex file to local or external service.
    *
    * @param null $disk
    * @param Storage|null $config
    * @param boolean $getShared
    *
    * @return FileSystem
    */
    public static function storage($disk = null, Storage $config = null, bool $getShared = true)
    {
        $config = $config ?? new Storage();

        if ($getShared) {
            return static::getSharedInstance('storage', $disk, $config);
        }

        return StorageFactory::getDisk($config, $disk);
    }

    /**
     * Returns the Task Scheduler
     *
     * @param boolean $getShared
     *
     * @return \Daycry\CronJob\Scheduler
     */
    public static function scheduler(bool $getShared = true): Scheduler
    {
        if ($getShared) {
            return static::getSharedInstance('scheduler');
        }

        return new Scheduler();
    }

    /**
    * Returns the Task Scheduler
    *
    * @param boolean $getShared
    *
    * @return \Daycry\CronJob\Scheduler
    */
    public static function notifications(bool $getShared = true): Notifications
    {
        if ($getShared) {
            return static::getSharedInstance('notifications');
        }

        return new Notifications();
    }

     /**
    * Returns the Task Scheduler
    *
    * @param boolean $getShared
    *
    * @return \Daycry\CronJob\Scheduler
    */
    public static function notices(bool $getShared = true): Notices
    {
        if ($getShared) {
            return static::getSharedInstance('notices');
        }

        return new Notices();
    }

    


}
