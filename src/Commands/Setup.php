<?php

/**
 * This file is part of Doudou.
 *
 * (c) Fabrice Loru <fabrice@adnduweb.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Btw\Core\Commands;

use Btw\Core\Commands\Install\Publisher;
use Btw\Core\Models\UserModel;
use Btw\Core\Entities\User;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class Setup extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'Btw';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'btw:setup';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Handles initial installation of Btw.';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'btw:setup';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [
        '--continue' => 'Execute the second install step.',
    ];

    private string $framework;

    private $path;

    public function __construct()
    {
        $this->path = service('autoloader')->getNamespace('Btw\\Core')[0];
    }

    /**
     * Actually execute a command.
     */
    public function run(array $params)
    {
        helper('filesystem');

        if (!CLI::getOption('continue')) {
            $this->ensureEnvFile();
            $this->setAppUrl();
            $this->setSession();
            $this->setCookie();
            $this->setEncryptionKey();
            $this->setDatabase();
            $this->framework = 'none';
            $this->publishThemes();
            $this->updateEnvFileVite();
            $this->checkApp();
            CLI::newLine();
            CLI::write('Suivre le processus d\'installation du package en ajoutant', 'green');
            CLI::write('php spark btw:setup --continue', 'green');
        } else {
            $this->migrate();
            $this->createUserDemo();
            $seeder = \Config\Database::seeder();
            $seeder->call('Btw\Core\Database\Seeds\BtwSeeder');
            $seeder->call('Btw\Core\Database\Seeds\MediaSeeder');
        }


        CLI::newLine();
    }

    /**
     * Copies the env file, if .env does not exist
     */
    private function ensureEnvFile()
    {
        CLI::print('Creating .env file...', 'yellow');

        if (file_exists(ROOTPATH . '.env')) {
            CLI::print('Exists', 'green');

            return;
        }

        if (!file_exists(ROOTPATH . 'env')) {
            CLI::error('The original `env` file is not found.');

            exit();
        }

        // Create the .env file
        if (!copy(ROOTPATH . 'env', ROOTPATH . '.env')) {
            CLI::error('Error copying the env file');
        }

        CLI::print('Done', 'green');

        CLI::write('Setting initial environment', 'yellow');

        // Set to development environment
        $this->updateEnvFile('# CI_ENVIRONMENT = production', 'CI_ENVIRONMENT = development');
    }

    private function setAppUrl()
    {
        CLI::newLine();
        $url = CLI::prompt('What URL are you running Bonfire under locally?');

        if (strpos($url, 'http://') === false && strpos($url, 'https://') === false) {
            $url = 'http://' . $url;
        }

        $this->updateEnvFile("# app.baseURL = ''", "app.baseURL = '{$url}'");
    }

    private function setDatabase()
    {
        $driver = CLI::prompt('Database driver:', ['MySQLi', 'Postgre', 'SQLite3', 'SQLSRV']);
        $name = CLI::prompt('Database name:', 'bonfire');
        if ($driver !== 'SQLite3') {
            $host = CLI::prompt('Database host:', '127.0.0.1');
            $user = CLI::prompt('Database username:', 'root');
            $pass = CLI::prompt('Database password:', 'root');
            $port = CLI::prompt('Database port:', '8889');
        }
        $prefix = CLI::prompt('Table prefix, if any (like bf_)', 'bf_');

        $this->updateEnvFile('# database.default.DBDriver = MySQLi', "database.default.DBDriver = {$driver}");
        $this->updateEnvFile('# database.default.database = ci4', "database.default.database = {$name}");
        if ($driver !== 'SQLite3') {
            $this->updateEnvFile('# database.default.hostname = localhost', "database.default.hostname = {$host}");
            $this->updateEnvFile('# database.default.username = root', "database.default.username = {$user}");
            $this->updateEnvFile('# database.default.password = root', "database.default.password = {$pass}");
        }
        $this->updateEnvFile('# database.default.DBPrefix =', "database.default.DBPrefix = {$prefix}");
        if ($port !== '3306') {
            $this->updateEnvFile('# database.default.port = 3306', "database.default.port = {$port}");
        }

    }

    private function setSession()
    {

        CLI::write('Generating session', 'yellow');
        $this->updateEnvFile("# session.driver = 'CodeIgniter\Session\Handlers\FileHandler'", "session.driver = 'Btw\Core\Session\Handlers\DatabaseHandler'");
        $this->updateEnvFile("# session.cookieName = 'ci_session'", "session.cookieName = 'adn_" . rand() . "'");
        $this->updateEnvFile("# session.expiration = 7200", "session.expiration = 86400");
        $this->updateEnvFile("# session.savePath = null", "session.savePath = 'sessions'");
        $this->updateEnvFile("# session.matchIP = false", "session.matchIP = true");
        $this->updateEnvFile("# session.timeToUpdate = 300", "session.timeToUpdate = 300");
        $this->updateEnvFile("# session.regenerateDestroy = false", "session.regenerateDestroy = true");
        CLI::write('Session saved to .env file', 'green');
        CLI::newLine();
    }

    private function setCookie()
    {
        CLI::write('Generating Cookie', 'yellow');
        $this->updateEnvFile("# security.csrfProtection = 'cookie'", "security.csrfProtection = 'session'");
        $this->updateEnvFile("# security.tokenRandomize = false", "security.tokenRandomize = false");
        $this->updateEnvFile("# security.tokenName = 'csrf_token_name'", "security.tokenName = 'x-csrfToken'");
        $this->updateEnvFile("# security.headerName = 'X-CSRF-TOKEN'", "security.headerName = 'X-CSRF-TOKEN'");
        $this->updateEnvFile("# security.cookieName = 'csrf_cookie_name'", "security.cookieName = 'adn_" . rand() . "'");
        $this->updateEnvFile("# security.expires = 7200", "security.expires = 7200");
        $this->updateEnvFile("# security.regenerate = true", "security.regenerate = false");
        $this->updateEnvFile("# security.redirect = true", "security.redirect = true");
        $this->updateEnvFile("# security.samesite = 'Lax'", "security.samesite = 'Lax'");
        CLI::write('Cookie saved to .env file', 'green');
        CLI::newLine();

    }

    private function publishThemes()
    {
        $source = BTPATH . '../themes';
        $destination = APPPATH . '../themes';

        $publisher = new Publisher();
        $publisher->copyDirectory($source, $destination);
        $publisher->copyDirectory(BTPATH . '../package.json', APPPATH . '../package.json');
        $publisher->copyDirectory(BTPATH . '../vite.config.js', APPPATH . '../vite.config.js');
        $publisher->copyDirectory(BTPATH . '../tailwind.config.js', APPPATH . '../tailwind.config.js');

        //logo
        $publisher->copyDirectory(BTPATH . '../themes/Admin/img/logo-adn.png', APPPATH . '../public/logo-adn.png');
        $publisher->copyDirectory(BTPATH . '../themes/Admin/img/logo-adn-grey.png', APPPATH . '../public/logo-adn-grey.png');
        $publisher->copyDirectory(BTPATH . '../themes/Admin/img/logo-adn-blanc.png', APPPATH . '../public/logo-adn-blanc.png');

        //Build
        $publisher->copyDirectory(BTPATH . '../manifest.json', APPPATH . '../public/manifest.json');
        $publisher->copyDirectory(BTPATH . '../build', APPPATH . '../public/build');

    }

    private function setEncryptionKey()
    {
        // generate a key using the out-of-the-box defaults for the Encryption library
        CLI::newLine();
        CLI::write('Generating encryption key', 'yellow');
        $key = bin2hex(\CodeIgniter\Encryption\Encryption::createKey());
        $this->updateEnvFile('# encryption.key =', "encryption.key = hex2bin:{$key}");
        CLI::write('Encryption key saved to .env file', 'green');
        CLI::newLine();
    }

    private function migrate()
    {
        command('migrate --all');
        CLI::newLine();
    }

    private function createUserDemo()
    {
        $users = model(UserModel::class);
        $user = new User([
            'first_name' => "Fabrice",
            'last_name' => 'Loru',
            'username' => 'ElFafa',
            'active' => 1
        ]);
        $users->save($user);

        /** @var \Bonfire\Users\User $user */
        $user = $users->where('username', $user->username)->first();
        $user->createEmailIdentity([
            'email' => "fabrice@adnduweb.com",
            'password' => "Fabrice56!",
        ]);

        $user->addGroup('superadmin');

        CLI::write('Done. You can now login as a superadmin.', 'green');
    }

    /**
     * Replaces text within the .env file.
     */
    private function updateEnvFile(string $find, string $replace)
    {
        $env = file_get_contents(ROOTPATH . '.env');
        $env = str_replace($find, $replace, $env);
        write_file(ROOTPATH . '.env', $env);
    }

    /**
     * Set vite configs in .env file
     * 
     * @return void
     */
    private function updateEnvFileVite()
    {
        CLI::write('Updating .env file...', 'yellow');

        # Get the env file.
        $envFile = ROOTPATH . '.env';

        # For backup.
        $backupFile = is_file($envFile) ? 'env-BACKUP-' . time() : null;

        # Does exist? if not, generate it =)
        if (is_file($envFile)) {
            # But first, let's take a backup.
            copy($envFile, ROOTPATH . $backupFile);

            # Get .env.default content
            $content = file_get_contents($this->path . 'Config/env.default');

            # Append it.
            file_put_contents($envFile, "\n\n$content", FILE_APPEND);
        } else {
            # As we said before, generate it.
            copy($this->path . 'Config/env.default', ROOTPATH . '.env');
        }

        # set the backup name in the current one.
        if ($backupFile) {
            $envContent = file_get_contents(ROOTPATH . '.env');
            $backupUpdate = str_replace('VITE_BACKUP_FILE=', "VITE_BACKUP_FILE='$backupFile'", $envContent);
            file_put_contents($envFile, $backupUpdate);
        }

        # Define framework.
        if ($this->framework !== 'none') {
            # Get .env content.
            $envContent = file_get_contents($envFile);
            # Set framework.
            $updates = str_replace("VITE_FRAMEWORK='none'", "VITE_FRAMEWORK='$this->framework'", $envContent);

            file_put_contents($envFile, $updates);

            # React entry file (main.jsx).
            if ($this->framework === 'react') {
                $envContent = file_get_contents($envFile);
                $updates = str_replace("VITE_ENTRY_FILE='main.js'", "VITE_ENTRY_FILE='main.jsx'", $envContent);
                file_put_contents($envFile, $updates);
            }
        }

        # env updated.
        CLI::newLine();
        CLI::write('.env file updated ✅', 'green');
        CLI::newLine();
    }

    public function checkApp()
    {
        CLI::write('PHP Version: ' . CLI::color(phpversion(), 'yellow'));
        CLI::write('CI Version: ' . CLI::color(\CodeIgniter\CodeIgniter::CI_VERSION, 'yellow'));
        CLI::write('APPPATH: ' . CLI::color(APPPATH, 'yellow'));
        CLI::write('SYSTEMPATH: ' . CLI::color(SYSTEMPATH, 'yellow'));
        CLI::write('ROOTPATH: ' . CLI::color(ROOTPATH, 'yellow'));
        CLI::write('Included files: ' . CLI::color(count(get_included_files()), 'yellow'));

        if (!is_writable(ROOTPATH . 'writable/cache/'))
            CLI::write(CLI::color('cache not writable: ', 'red') . ROOTPATH . 'writable/cache/');
        else
            CLI::write(CLI::color('cache writable: ', 'yellow') . ROOTPATH . 'writable/cache/');

        if (!is_writable(ROOTPATH . 'writable/logs/'))
            CLI::write(CLI::color('Logs not writable: ', 'red') . ROOTPATH . 'writable/logs/');
        else
            CLI::write(CLI::color('Logs writable: ', 'yellow') . ROOTPATH . 'writable/logs/');

        if (!is_writable(ROOTPATH . 'writable/uploads/'))
            CLI::write(CLI::color('Uploads not writable: ', 'red') . ROOTPATH . 'writable/uploads/');
        else
            CLI::write(CLI::color('Uploads writable: ', 'yellow') . ROOTPATH . 'writable/uploads/');

        try {
            if (
                phpversion() >= '7.2' &&
                extension_loaded('intl') &&
                extension_loaded('curl') &&
                extension_loaded('json') &&
                extension_loaded('mbstring') &&
                extension_loaded('mysqlnd') &&
                extension_loaded('xml')
            ) {
                //silent
            }
        } catch (\Exception $e) {
            CLI::write('Erreur avec une extension php : ' . CLI::color($e->getMessage(), 'red'));
            exit;
        }

        $continue = CLI::prompt('Voulez vous continuer?', ['y', 'n']);
        if ($continue == 'n') {
            CLI::error('Au revoir');
            exit;
        }
    }

}