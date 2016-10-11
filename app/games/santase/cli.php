<?php

include realpath(__DIR__ . "/../../../vendor/autoload.php");

$config = include realpath(__DIR__ . "/../../config/config.php");

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Toxic\Games\Santase\Engine as SantaseEngine;

$server = IoServer::factory(
                new HttpServer(
                new WsServer(
                new SantaseEngine()
                )
                ), 8081
);

$server->run();

//Toxic\Games\Santase\Models\BaseModel::getInstance($config['db']);
//
//Toxic\Games\Santase\Models\Users::save(["name" => "venelin", "experience" => [["employer" => "orange dot"], ["employer" => "prodio"]]]);
