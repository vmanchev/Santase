<?php

namespace Toxic\Games\Santase;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

/**
 * Game engine
 * 
 * This class serves as a glue or dispatcher between the client requests and the 
 * models, related to that particular game.
 */
class Engine implements MessageComponentInterface {

    /**
     * Container for all active connection (clients)
     * @var array 
     */
    protected $connections = [];

    /**
     * New connection
     * 
     * Someone has visited the website and their browser initialize a socket 
     * connection. At this moment this is a user, not a player.
     * 
     * @param ConnectionInterface $conn
     */
    public function onOpen(ConnectionInterface $conn) {
        $this->connections[$conn->resourceId] = $conn;
    }

    /**
     * New message
     * 
     * This method will be called, when a client/connection sends us a new 
     * socket message. The message is expected to be a JSON-encoded object with 
     * two properties - action and data. Further down, the "action" property consists 
     * of the model name and model method, responsible to the requested operation.
     * 
     * For example:
     * 
     * {
     *     "action" : "players.register",
     *     "data" : {
     *         "username" : "",
     *         "password" : ""
     *     }
     * }
     * 
     * @param ConnectionInterface $from
     * @param string $msg JSON-encoded object
     * @todo To handle snake_case model names
     * @todo To send message to the related connections, if needed.
     */
    public function onMessage(ConnectionInterface $from, $msg) {

        //decode the message
        $msg = json_decode($msg);

        //workout the model name and method
        $modelSegments = explode('.', $msg->action);
        
        //build the model name
        $modelName = "Toxic\Games\Santase\Models\\" . ucfirst(strtolower($modelSegments[0]));

        $callable = array(
            $modelName,
            strtolower($modelSegments[1])
        );

        //call the model/method passing the parameters and get the result
        $result = call_user_func_array($callable, [$msg->data]);

        //send the response back to the calling user
        $this->connections[$from->resourceId]->send(json_encode($result));
    }

    /**
     * The user has closed the connection or browser
     * 
     * Remove the connection reference from the connections container.
     * 
     * @param ConnectionInterface $conn
     */
    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        unset($this->connections[$conn->resourceId]);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }

}
