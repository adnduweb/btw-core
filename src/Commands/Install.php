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

class Install extends BaseCommand
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
    protected $name = 'btw:install';

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
    protected $usage = 'btw:install';

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

    private array $supportedFrameworks = ['none', 'react', 'vue', 'svelte'];

    private $path;

    private array $configFiles = [
        // 'Btw\Core\Assets\Config\Assets',
        //'Btw\Core\Config\Auth',
        //'Btw\Core\Config\AuthGroups',
        'Btw\Core\Config\Btw',
        //'Btw\Core\Config\Site',
        //'Btw\Core\Config\Themes',
        //'Btw\Core\Consent\Config\Consent',
        //'Btw\Core\Dashboard\Config\Dashboard',
        //'Btw\Core\Recycler\Config\Recycler',
        //'Btw\Core\Users\Config\Users',
    ];

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
            $this->publishConfigFiles();
            $this->framework = 'none';
            $this->publishThemes();
            $this->updateEnvFileVite();

            CLI::newLine();
            CLI::write('If you need to create your database, you may run:', 'yellow');
            CLI::write("\tphp spark db:create <database name>", 'green');
            CLI::write('If you chose SQLite3 as your database driver, the database will be created automatically on the next step (migration).', 'yellow');
            CLI::newLine();
            CLI::write('To migrate and create the initial user, please run: ', 'yellow');
            CLI::write("\tphp spark btw:install --continue", 'green');
        } else {
            $this->migrate();
            $this->createUser();
            CLI::newLine();
            CLI::write('run: npm install && npm run dev');
            CLI::write('Suivre le processus d\'installation du package');
            CLI::write('run: npm install && npm run dev');
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
        $name   = CLI::prompt('Database name:', 'bonfire');
        if ($driver !== 'SQLite3') {
            $host = CLI::prompt('Database host:', '127.0.0.1');
            $user = CLI::prompt('Database username:', 'root');
            $pass = CLI::prompt('Database password:', 'root');
            $port = CLI::prompt('Database port:', '3306');
        }
        $prefix = CLI::prompt('Table prefix, if any (like bf_)');

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
        $this->updateEnvFile("# session.sessionDriver = 'CodeIgniter\Session\Handlers\FileHandler'", "session.sessionDriver = 'Btw\Core\Session\Handlers\DatabaseHandler'");
        $this->updateEnvFile("# session.sessionCookieName = 'ci_session'", "session.sessionCookieName = 'adn_" . rand() . "'");
        $this->updateEnvFile("# session.sessionExpiration = 7200", "session.sessionExpiration = 86400");
        $this->updateEnvFile("# session.sessionSavePath = null", "session.sessionSavePath = 'sessions'");
        $this->updateEnvFile("# session.sessionMatchIP = false", "session.sessionMatchIP = true");
        $this->updateEnvFile("# session.sessionTimeToUpdate = 300", "session.sessionTimeToUpdate = 100");
        $this->updateEnvFile("# session.sessionRegenerateDestroy = false", "session.sessionRegenerateDestroy = true");
        CLI::write('Session saved to .env file', 'green');
        CLI::newLine();
    }

    private function setCookie()
    {
        CLI::write('Generating Cookie', 'yellow');
        $this->updateEnvFile("# security.csrfProtection = 'cookie'", "security.csrfProtection = 'session'");
        $this->updateEnvFile("# security.tokenRandomize = false", "security.tokenRandomize = true");
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


    private function publishConfigFiles()
    {
        $publisher = new Publisher();
        $publisher->setDestination(APPPATH . 'Config/');

        CLI::newLine();
        CLI::write('Publishing config files', 'yellow');

        foreach ($this->configFiles as $className) {
            $publisher->publishClass($className);
        }
    }

    private function publishThemes()
    {
        $source      = BTPATH . 'configurations/themes';
        $destination = APPPATH . '../themes';

        $sourcePublic      = BTPATH . 'configurations/public';
        $destinationPublic = APPPATH . '../public';

        $admin = ROOTPATH . 'public' . DIRECTORY_SEPARATOR . 'admin';
        if (!is_dir($admin) && !@mkdir($admin, 0775, true)) {
            throw new \Exception('impossible de créer le dossier admin');
        }

        // $admin_img = ROOTPATH . 'public' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'img';
        // if (!is_dir($admin_img) && !@mkdir($admin_img, 0775, true)) {
        //     throw new \Exception('impossible de créer le dossier admin/img');
        // }

        $front = ROOTPATH . 'public' . DIRECTORY_SEPARATOR . 'front';
        if (!is_dir($front) && !@mkdir($front, 0775, true)) {
            throw new \Exception('impossible de créer le dossier front');
        }

        $front_img = ROOTPATH . 'public' . DIRECTORY_SEPARATOR . 'front' . DIRECTORY_SEPARATOR . 'img';
        if (!is_dir($front_img) && !@mkdir($front_img, 0775, true)) {
            throw new \Exception('impossible de créer le dossier front/img');
        }

        $publisher = new Publisher();
        $publisher->copyDirectory($source, $destination);
        $publisher->copyDirectory(BTPATH . 'configurations/package.json', APPPATH . '../package.json');
        $publisher->copyDirectory(BTPATH . 'configurations/vite.admin.config.js', APPPATH . '../vite.admin.config.js');
        $publisher->copyDirectory(BTPATH . 'configurations/vite.front.config.js', APPPATH . '../vite.front.config.js');
        $publisher->copyDirectory(BTPATH . 'configurations/tailwind.admin.config.js', APPPATH . '../tailwind.admin.config.js');
        $publisher->copyDirectory(BTPATH . 'configurations/tailwind.front.config.js', APPPATH . '../tailwind.front.config.js');

        //Dir Public
        $publisher->copyDirectory($sourcePublic, $destinationPublic);
        // $publisher->copyDirectory(BTPATH . 'configurations/themes/Admin/img/logo-adn.png', APPPATH . '../public/admin/img/logo-adn.png');
        // $publisher->copyDirectory(BTPATH . 'configurations/themes/Admin/img/logo-adn-grey.png', APPPATH . '../public/admin/img/logo-adn-grey.png');
        // $publisher->copyDirectory(BTPATH . 'configurations/themes/Admin/img/logo-adn-white.png', APPPATH . '../public/admin/img/logo-adn-white.png');
        // $publisher->copyDirectory(BTPATH . 'configurations/themes/Admin/img/logo-adn-small.png', APPPATH . '../public/admin/img/logo-adn-small.png');
        // $publisher->copyDirectory(BTPATH . 'configurations/themes/Admin/img/flags.png', APPPATH . '../public/admin/img/flags.png');
        // $publisher->copyDirectory(BTPATH . 'configurations/themes/Admin/img/flags@2x.png', APPPATH . '../public/admin/img/flags@2x.png');
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

    private function createUser()
    {
        CLI::write('Create initial user', 'yellow');

        $email     = CLI::prompt('Email?');
        $firstName = CLI::prompt('First name?');
        $lastName  = CLI::prompt('Last name?');
        $username  = CLI::prompt('Username?');
        $password  = CLI::prompt('Password?');
        $company_id  = CLI::prompt('Id de la company');
        $main_account  = CLI::prompt('Compte principal?', ['0', '1']);

        $users = model(UserModel::class);

        $user = new User([
            'first_name' => $firstName,
            'last_name'  => $lastName,
            'username'   => $username,
            'company_id'   => $company_id,
            'main_account'   => $main_account,
        ]);
        $users->save($user);

        /** @var \Bonfire\Users\User $user */
        $user = $users->where('username', $username)->first();
        $user->createEmailIdentity([
            'email'    => $email,
            'password' => $password,
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
}
