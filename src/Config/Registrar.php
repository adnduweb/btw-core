<?php

declare(strict_types=1);

namespace Btw\Core\Config;

use Btw\Core\Filters\Admin;
// use Btw\Core\Filters\Protect;
use Btw\Core\Filters\OnlineCheckFilter;
use Btw\Core\Filters\VisitsFilter;
// use Btw\Core\Filters\BlockIpFilter;
use Btw\Core\View\ShieldOAuth;
use Btw\Core\View\Decorator;
use Btw\Core\View\ErrorModalDecorator;
use Btw\Core\Validation\UserRules;
use Btw\Core\Validation\ExpressRules;
use CodeIgniter\Shield\Authentication\Passwords\ValidationRules as PasswordRules;
use CodeIgniter\Shield\Filters\ChainAuth;
use Btw\Core\Filters\SessionAuthOverride;
use CodeIgniter\Shield\Filters\TokenAuth;
use ReflectionClass;
use ReflectionProperty;

include_once __DIR__ . '/Constants.php';
include_once __DIR__ . '/../Common.php';

class Registrar
{
    /**
     * Registers the Shield filters.
     */
    public static function Filters()
    {
        // CodeIgniter currently doesn't support merging
        // nested arrays within the registrars....
        $ref   = new ReflectionClass('Config\Filters');
        $props = $ref->getDefaultProperties();

        return [
            'aliases' => [
                'session' => SessionAuthOverride::class,
                'tokens'  => TokenAuth::class,
                'chain'   => ChainAuth::class,
                'admin'   => Admin::class,
                // 'protect'   => Protect::class,
                'online'   => OnlineCheckFilter::class,
                'visits' => VisitsFilter::class,
                // 'blockIP' => BlockIpFilter::class, 
            ],
            'globals' => [
                // 'before' => [
                //     'csrf' => ['except' => ['api/record/[0-9]+']],
                // ],
                'before' => [
                    'online' => ['except' => ['site-offline', ADMIN_AREA . '*', 'login*']],
                    'csrf' => ['except' => ['api/record/[0-9]+']],
                    // 'session' => ['except' => ['login*', 'register', 'auth/a/*', 'oauth*']],
                ],
                'after' => array_merge($props['globals']['after'], [
                    'visits'
                ]),
            ],
            'filters' => [
                // 'protect' => [
                //     'before' => ['*'],
                // ],
                'session' => [
                    'before' => [ADMIN_AREA . '*'],
                ],
                'admin' => [
                    'before' => [ADMIN_AREA . '*'],
                    'after' => [ADMIN_AREA . '*'],
                ],
            ],
        ];
    }

    public static function Validation()
    {
        return [
            'ruleSets' => [
                PasswordRules::class,
                UserRules::class,
                ExpressRules::class,
            ],
            'users' => [
                'email'      => 'required|valid_email|unique_email[{id}]',
                'username'   => 'required|string|is_unique[users.username,id,{id}]',
                'first_name' => 'permit_empty|string|min_length[3]',
                'last_name'  => 'permit_empty|string|min_length[3]',
            ],
        ];
    }

    public static function View()
    {
        return [
            'decorators' => [
                ShieldOAuth::class,
                Decorator::class,
                ErrorModalDecorator::class,
            ],
        ];
    }

    public static function Pager(): array
    {
        return [
            'templates' => [
                'default_htmx_full' => 'Btw\Core\Views\Pager\default_htmx_full',
                'btw_full' => 'Btw\Core\Views\Pager\btw_full',
            ],
        ];
    }

    /**
     * Registers all Module namespaces
     */
    public static function registerNamespaces(): void
    {
        helper('filesystem');
        $map = directory_map(__DIR__ . '/../', 1);
        /** @var \CodeIgniter\Autoloader\Autoloader $autoloader */
        $autoloader = service('autoloader');

        $namespaces = [];
        $namespaces["Themes"] = [ROOTPATH . 'themes'];
        $namespaces["Btw\\Core"] = [realpath(__DIR__ . "/../")];

        foreach ([APPPATH . 'Modules'] as $namespace => $dir) {
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
                // $modules["{$namespace}\\{$name}"] = "{$dir}/{$name}";
                $key = str_replace('btw-', '', $name);
                $namespaces["Btw\\" . ucfirst($key)] = [APPPATH . "Modules/{$name}/src"];
            }
        }

        // Insert the namespaces into the psr4 array in the autoloader
        // to ensure that Btw's files get loader prior to vendor files
        $rp = new ReflectionProperty($autoloader, 'prefixes');
        $rp->setAccessible(true);
        $prefixes = $rp->getValue($autoloader);
        $keys     = array_keys($prefixes);

        $prefixesStart = array_slice($prefixes, 0, array_search('Tests\\Support', $keys, true) + 1);
        $prefixesEnd   = array_slice($prefixes, array_search('Tests\\Support', $keys, true) + 1);
        $prefixes      = array_merge($prefixesStart, $namespaces, $prefixesEnd);

        $rp->setValue($autoloader, $prefixes);
    }
}


// This is hacky but will ensure all
// BTW namespaces have been registered
// with the system and are found automatically.
Registrar::registerNamespaces();
