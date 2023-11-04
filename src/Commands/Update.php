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
                    $this->publishThemes('admin');
                    break;

                case 'theme-app':
                    $this->publishThemes('app');
                    break;

                case 'theme-auth':
                    $this->publishThemes('auth');
                    break;
            }
        } else {
            CLI::write('Specify a valid action : ' . implode(',', $this->valid_actions), 'red');
        }
    }

    private function publishThemes(string $resource)
    {
        $source = BTPATH . 'configurations/themes/' . $resource;
        $destination = APPPATH . '../themes/' . $resource;

        $sourcePublic = BTPATH . 'configurations/public/' . $resource;
        $destinationPublic = APPPATH . '../public/' . $resource;

        $publisher = new Publisher();
        $publisher->copyDirectory($source, $destination);
        $publisher->copyDirectory($sourcePublic, $destinationPublic);
    }
}
