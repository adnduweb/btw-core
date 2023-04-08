<?php

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

 namespace Btw\Core\Commands;

use CodeIgniter\Cache\CacheFactory;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

/**
 * Clears current cache.
 */
class ClearCache extends BaseCommand
{
    /**
     * Command grouping.
     *
     * @var string
     */
    protected $group = 'Btw';

    /**
     * The Command's name
     *
     * @var string
     */
    protected $name = 'Btwcache:clear';

    /**
     * the Command's short description
     *
     * @var string
     */
    protected $description = 'Clears the current system caches.';

    /**
     * the Command's usage
     *
     * @var string
     */
    protected $usage = 'Btwcache:clear [driver]';

    /**
     * the Command's Arguments
     *
     * @var array
     */
    protected $arguments = [
        'driver' => 'The cache driver to use',
    ];

    /**
     * Clears the cache
     */
    public function run(array $params)
    {
        $config  = config('Cache');
        $handler = $params[0] ?? $config->handler;

        if (! array_key_exists($handler, $config->validHandlers)) {
            CLI::error($handler . ' is not a valid cache handler.');

            return;
        }

        $config->handler = $handler;
        $cache           = CacheFactory::getHandler($config);

        // var_dump(delete_files(WRITEPATH . '/cache/twig/')); exit;

        if (! $cache->clean() || !delete_files(WRITEPATH . '/cache/twig/', true)) {
            // @codeCoverageIgnoreStart
            CLI::error('Error while clearing the cache.');

            return;
            // @codeCoverageIgnoreEnd
        }

        CLI::write(CLI::color('Cache cleared.', 'green'));
    }
}
