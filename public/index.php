<?php 

include "../vendor/autoload.php";

$config = include "../app/config/config.php";

Toxic\Games\Santase\Models\BaseModel::getInstance($config['db']);

Toxic\Games\Santase\Models\Users::save(["name" => "venelin", "experience" => [ ["employer" => "orange dot"], ["employer" => "prodio"] ]]);