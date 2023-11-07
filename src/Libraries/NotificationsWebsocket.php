<?php

//https://github.com/takielias/codeigniter4-websocket/tree/master

namespace Btw\Core\Libraries;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Btw\Core\Models\ConnectionsModel;
use Btw\Core\Libraries\Authorization;

class NotificationsWebsocket implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage();
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg, true);
        $numRecv = count($this->clients) - 1;
        $data ['token']= json_encode(array("type" => "token", "token" => Authorization::generateToken($from->resourceId)));
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n", $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        foreach ($this->clients as $client) {
            if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }

     /**
     * Function to send the message
     * @method send_message
     * @param array $user User to send
     * @param array $message Message
     * @param array $client Sender
     * @return string
     */
    protected function send_message($user = array(), $message = array(), $client = array())
    {
        // Send the message
        $user->send($message);

        // We have to check if event callback must be called
        if (!empty($this->callback['event'])) {

            // At this moment we have to check if we have authent callback defined
            call_user_func_array($this->callback['event'],
                array((valid_json($message) ? json_decode($message) : $message)));

            // Output
            if ($this->config->debug) {
                output('info', 'Callback event "' . $this->callback['event'][1] . '" called');
            }
        }

        // Output
        if ($this->config->debug) {
            output('info',
                'Client (' . $client->resourceId . ') send \'' . $message . '\' to (' . $user->resourceId . ')');
        }
    }
}
