<?php

namespace Toxic\Games\Santase\Models;

/**
 * Base model
 * 
 * The base model is responsible to initialize a single database connection during 
 * the call and to perform all general operations, which are not model-specific.
 * 
 * Implementation of the Singleton design pattern
 */
class BaseModel {

    /**
     * Container for the client instance
     * @var \MongoDB\Client
     */
    protected static $instance = null;

    /**
     * Database name
     * @var string
     */
    protected static $database = null;

    protected function __construct() {
        
    }

    protected function __clone() {
        
    }

    /**
     * Get db connection instance
     * 
     * This is the entry point before using a model for the first time. Should be 
     * called only once during a backend call.
     * 
     * @param array $db_config
     * @return \MongoDB\Client
     */
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

    /**
     * Determinate the collection name from model namespace 
     * 
     * Collection name is expected to be a snake-case version of the model name. 
     * For example "Toxic\Games\Santase\Models\Players" will be served by "players" 
     * collection and "Toxic\Games\Santase\Models\SomeOtherModel" will be served 
     * by "some_other_model" collection
     * 
     * @return string
     */
    protected static function getCollectionName() {

        $nsSegments = explode("\\", get_called_class());

        return strtolower(preg_replace('/\B([A-Z])/', '_$1', array_pop($nsSegments)));
    }

    /**
     * Get collection reference
     * 
     * Should be used before any collection-related operation. This is the way 
     * to ensure we have a reference to the desired collection and we can perform 
     * the required action. 
     * 
     * @return MongoDB\Collection
     */
    protected static function before() {
        return static::$instance->{static::$database}->{static::getCollectionName()};
    }

    /**
     * Insert one new document in the current collection
     * 
     * As this method will be called by the child classes, we are using their name 
     * to identify the collection name. 
     * 
     * @param \stdClass $data
     * @return \MongoDB\InsertOneResult To find the new document id, use the 
     * getInsertedId() method, which returns ObjectId instance, so a call to 
     * its __toString() method may be required, as well.
     */
    public function insertOne(\stdClass $data) {

        static::before();

        return static::before()->insertOne($data);
    }

}
