<?php

declare(strict_types=1);

namespace Btw\Core\Commands;

use Btw\Core\Commands\Install\Publisher;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Services;

class Update extends BaseCommand
{
    private array $valid_actions = ['theme-admin', 'theme-app', 'theme-auth', 'package-json'];

    /**
     * The group the command is lumped under
     * when listing commands.
     *
     * @var string
     */
    protected $group = 'Btw';

    /**
     * Command's name
     *
     * @var string
     */
    protected $name = 'btw:update';

    /**
     * Command's short description
     *
     * @var string
     */
    protected $description = 'Manage Btw update';

    /**
     * Command's usage
     *
     * @var string
     */
    protected $usage = 'btw:update <action>';

    /**
     * Command's Arguments
     *
     * @var array
     */
    protected $arguments = [
        'action' => 'Valid actions : theme-admin, theme-app, theme-auth, package-json',
    ];


    /**
     * Displays the help for the spark cli script itself.
     */
    public function run(array $params): void
    {
        $action = CLI::getSegment(2);
        if ($action && in_array($action, $this->valid_actions, true)) {
          

            switch ($action) {
                case 'theme-admin':
                    $this->publishThemes('Admin');
                    break;

                case 'theme-app':
                    $this->publishThemes('App');
                    break;

                case 'theme-auth':
                    $this->publishThemes('Auth');
                    break;
            }
        } else {
            CLI::write('Specify a valid action : ' . implode(',', $this->valid_actions), 'red');
        }
    }

    private function publishThemes(string $resource)
    {
        $source      = BTPATH . '../themes/' . $resource;
        $destination = APPPATH . '../themes/' . $resource;

        $publisher = new Publisher();
        $publisher->copyDirectory($source, $destination);

        if( $resource == 'Admin'){
        //logo
        $publisher->copyDirectory(BTPATH . '../themes/Admin/img/logo-adn.png', APPPATH . '../public/logo-adn.png');
        $publisher->copyDirectory(BTPATH . '../themes/Admin/img/logo-adn-grey.png', APPPATH . '../public/logo-adn-grey.png');
        $publisher->copyDirectory(BTPATH . '../themes/Admin/img/logo-adn-blanc.png', APPPATH . '../public/logo-adn-blanc.png');
        }
    }
}