<?php

namespace Toxic\Games\Santase\Models;

class BaseModel {

    protected static $instance = null;
    protected static $database = null;

    protected function __construct() {
        //Thou shalt not construct that which is unconstructable!
    }

    protected function __clone() {
        //Me not like clones! Me smash clones!
    }

    public static function getInstance($db_config) {
        if (!isset(static::$instance)) {
            /**
             * @var \MongoDB\Client
             */
            static::$instance = new \MongoDB\Client($db_config['host']);
            static::$database = $db_config['name'];
        }
        return static::$instance;
    }

    public static function getCollectionName() {
       return strtolower(array_pop(explode("\\", get_called_class())));
    }
    
    public static function before()
    {
        return static::$instance->{static::$database}->{static::getCollectionName()};
    }

    public function save($data) {
        
        static::before();
        
        return static::before()->insertOne($data);       
        
    }

}
