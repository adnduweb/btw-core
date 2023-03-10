<?php

namespace Btw\Core\Config;

use Btw\Core\Filters\Admin;
use Btw\Core\View\Decorator;
use Btw\Core\Validation\UserRules;
use CodeIgniter\Shield\Authentication\Passwords\ValidationRules as PasswordRules;
use CodeIgniter\Shield\Filters\ChainAuth;
use CodeIgniter\Shield\Filters\SessionAuth;
use CodeIgniter\Shield\Filters\TokenAuth;
use ReflectionClass;
use ReflectionProperty;

include_once __DIR__ . '/Constants.php';
include_once __DIR__ . '/../Common.php';

class Registrar
{
    private static $nonModuleFolders = [
        'Config',
    ];

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
                'session' => SessionAuth::class,
                'tokens'  => TokenAuth::class,
                'chain'   => ChainAuth::class,
                'admin'   => Admin::class,
            ],
            'filters' => [
                'session' => [
                    'before' => [ADMIN_AREA . '*'],
                ],
                'admin' => [
                    'before' => [ADMIN_AREA . '*'],
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
                Decorator::class,
            ],
        ];
    }

    /**
     * Registers all Bonfire Module namespaces
     */
    public static function registerNamespaces(): void
    {
        helper('filesystem');
        $map = directory_map(__DIR__ . '/../', 1);
        /** @var \CodeIgniter\Autoloader\Autoloader $autoloader */
        $autoloader = service('autoloader');

        $namespaces = [];

        foreach ($map as $row) {
            if (substr($row, -1) !== DIRECTORY_SEPARATOR || in_array(trim($row, '/ '), self::$nonModuleFolders, true)) {
                continue;
            }

            $name = trim($row, DIRECTORY_SEPARATOR);

            $namespaces["Btw\\{{$name}}"] = [realpath(__DIR__ . "/../{$name}")];
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
// Bonfire namespaces have been registered
// with the system and are found automatically.
Registrar::registerNamespaces();
echo 'fgfdgqsdfg'; exit;