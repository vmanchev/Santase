<?php

namespace Toxic\Games\Santase;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Engine implements MessageComponentInterface {

    protected $connections = [];

    public function onOpen(ConnectionInterface $conn) {

        $this->connections[$conn->resourceId] = $conn;

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {

        
        
        $msg = json_decode($msg);

        $this->connections[$from->resourceId]->send("Hi there!");
        
        return;
        
//        $modelSegments = explode('.', $msg->action);
//        
//        $modelName = "Toxic\Santase\Models\\" . ucfirst(strtolower($modelSegments[0]));
//
//        $callable = array(
//            new $modelName(),
//            strtolower($modelSegments[1])
//        );
//
//        $result = call_user_func_array($callable, [$msg->data]);

    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        unset($this->connections[$conn->resourceId]);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }

}
