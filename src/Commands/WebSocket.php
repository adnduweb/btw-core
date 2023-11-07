<?php

declare(strict_types=1);

namespace Btw\Core\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Btw\Core\Libraries\NotificationsWebsocket;

class WebSocket extends BaseCommand
{
    private array $valid_actions = [];

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
    protected $name = 'btw:websocket';

    /**
     * Command's short description
     *
     * @var string
     */
    protected $description = 'Manage Btw websocket';

    /**
     * Command's usage
     *
     * @var string
     */
    protected $usage = 'btw:websocket <action>';

    /**
     * Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];


    /**
     * Displays the help for the spark cli script itself.
     */
    public function run(array $params): void
    {

        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new NotificationsWebsocket()
                )
            ),
            8282
        );
        $server->run();

        CLI::write('Start Websocket', 'green');
    }

}
