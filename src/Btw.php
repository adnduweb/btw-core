<?php

/**
 * This file is part of Btw.
 *
 * (c) Lonnie Ezell <lonnieje@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Btw;

use Btw\Core\Menus\MenuItem;


include_once __DIR__ . '/Common.php';

/**
 * Class Btw
 *
 * Provides basic utility functions used throughout the
 * lifecycle of a request in the admin area.
 */
class Btw
{
    /**
     * Holds cached instances of all Module classes
     *
     * @var array
     */
    private $moduleConfigs = [];

    /**
     * Are we currently in the admin area?
     *
     * @var bool
     */
    public $inAdmin = false;

    /**
     * @var array
     */
    public $menus = [];



    /**
     * Sets up admin menus, initializes modules.
     */
    public function boot()
    {
        helper('filesystem');

        $this->saveInAdmin();

        if ($this->inAdmin) {
            $this->setupMenus();
        }

        $this->discoverCoreModules();
        $this->discoverAppModules();
        $this->initModules();
    }

    /*
    * Setup our admin area needs.
    */
    public function initAdmin()
    {
        // Add to the Content menu
        $sidebar = service('menus');
        $item    = new MenuItem([
            'title'           => 'Users',
            'namedRoute'      => 'user-list',
            'fontAwesomeIcon' => 'fas fa-users',
            'permission'      => 'users.view',
        ]);
        $sidebar->menu('sidebar')->collection('content')->addItem($item);

        // Add Users Settings
        $item = new MenuItem([
            'title'           => 'Users',
            'namedRoute'      => 'user-settings',
            'fontAwesomeIcon' => 'fas fa-user-cog',
            'permission'      => 'users.settings',
        ]);
        $sidebar->menu('sidebar')->collection('settings')->addItem($item);

        print_r($sidebar);
        exit;
    }

    /**
     * Checks to see if we're in the admin area
     * by analyzing the current url and the ADMIN_AREA constant.
     */
    private function saveInAdmin()
    {
        $url = current_url();

        $path = parse_url($url, PHP_URL_PATH);

        $this->inAdmin = strpos($path, ADMIN_AREA) !== false;
    }

    /**
     * Creates any admin-required menus so they're
     * available to use by any modules.
     */
    private function setupMenus()
    {
        $menus = service('menus');

        // Sidebar menu
        $menus->createMenu('sidebar');
        $menus->menu('sidebar')
            ->createCollection('content', 'Content');
        $menus->menu('sidebar')
            ->createCollection('settings', 'Settings')
            ->setFontAwesomeIcon('fas fa-cog')
            ->setCollapsible();
        $menus->menu('sidebar')
            ->createCollection('tools', 'Tools')
            ->setFontAwesomeIcon('fas fa-toolbox')
            ->setCollapsible();

        // Top "icon" menu for notifications, account, etc.
        $menus->createMenu('iconbar');

        // print_r($menus); exit;
    }



    /**
     * Adds any directories within Btw/Modules
     * into routes as a new namespace so that discover
     * features will automatically work for core modules.
     */
    private function discoverCoreModules()
    {
        if (!$modules = cache('bf-modules-search')) {
            $modules  = [];
            $excluded = ['Config', 'Language', 'Views'];

            $map = directory_map(__DIR__, 1);

            foreach ($map as $row) {
                if (substr($row, -1) !== DIRECTORY_SEPARATOR) {
                    continue;
                }

                $name = trim($row, DIRECTORY_SEPARATOR);
                if (in_array($name, $excluded, true)) {
                    continue;
                }

                // $modules["Btw\\{$name}"] = __DIR__ . "/{$name}";
                $key = str_replace('btw-', '' , $name);
                if($key == 'core')
                    $modules["btw\Core"] = APPPATH . "Modules/{$name}/src";
                else
                    $modules["btw\\" . ucfirst($key)] = APPPATH . "Modules/{$name}/src";

            }

            cache()->save('bf-modules-search', $modules);
        }

        // print_r($modules); exit;

        // save instances of our module configs
        foreach ($modules as $namespace => $dir) {
            if (!is_file($dir . '/Module.php')) {
                continue;
            }

            include_once $dir . '/Module.php';
            $className                       = $namespace . '\Module';
            $this->moduleConfigs[$namespace] = new $className();
        }
    }

    private function discoverAppModules()
    {
        if (!$modules = cache('app-modules-search')) {
            $modules  = [];
            $excluded = ['Config', 'Language', 'Views'];

            $paths = config('Btw')->appModules;

            if (!is_array($paths) || empty($paths)) {
                log_message('debug', 'No app modules directories specified. Skipping.');

                return;
            }

            foreach ($paths as $namespace => $dir) {
                if (!is_dir($dir)) {
                    continue;
                }

                $dir = rtrim($dir, DIRECTORY_SEPARATOR);
                $map = directory_map($dir, 1);

                foreach ($map as $row) {
                    if (substr($row, -1) !== DIRECTORY_SEPARATOR) {
                        continue;
                    }

                    $name = trim($row, DIRECTORY_SEPARATOR);
                    if (in_array($name, $excluded, true)) {
                        continue;
                    }

                    // $modules["{$namespace}\\{$name}"] = "{$dir}/{$name}";

                    $key = str_replace('btw-', '' , $name);
                    if($key == 'core')
                        $modules["btw\Core"] = APPPATH . "Modules/{$name}/src";
                    else
                        $modules["btw\\" . ucfirst($key)] = APPPATH . "Modules/{$name}/src";                }
            }

            // cache()->save('app-modules-search', $modules);
        }

        // save instances of our module configs
        foreach ($modules as $namespace => $dir) {
            if (!is_file($dir . '/Module.php')) {
                continue;
            }

            include_once $dir . '/Module.php';
            $className                       = $namespace . '\Module';
            $this->moduleConfigs[$namespace] = new $className();
        }
    }

    /**
     * Performs any initialization needed for our modules.
     */
    private function initModules()
    {
        $method = $this->inAdmin ? 'initAdmin' : 'initFront';

        foreach ($this->moduleConfigs as $config) {
            $config->{$method}($this);
        }
    }
}
