<?php

include realpath(__DIR__ . "/../../../vendor/autoload.php");

$config = include realpath(__DIR__ . "/../../config/config.php");

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Toxic\Games\Santase\Engine as SantaseEngine;

Toxic\Games\Santase\Models\BaseModel::getInstance($config['db']);

$server = IoServer::factory(
                new HttpServer(
                new WsServer(
                new SantaseEngine()
                )
                ), $config['ws_port']
);

$server->run();
