<?php

namespace Toxic\Lib;

use Toxic\Lib\Status;

/**
 * Operation response 
 * 
 * This class represents the response, which the backend sends to the client. 
 * There are two properties - status and data, which provides the necessary 
 * information. 
 */
class Response implements \JsonSerializable {

    /**
     * Operation status
     * @var Toxic\Lib\Status 
     */
    protected $status;
    
    /**
     * Response data
     * 
     * Optional parameter, which serves as data container in case the backend 
     * should send back any data to the client. 
     * 
     * @var string|array|object 
     */
    protected $data;

    /**
     * Class constructor 
     * 
     * @param Status $status
     * @param string|array|object $data
     */
    public function __construct(Status $status, $data = '') {
        $this->status = $status;
        $this->data = $data;
    }

    /**
     * Helper for serializing the object to JSON
     * 
     * @return array
     */
    public function jsonSerialize() {
        return array_filter([
            'status' => $this->status,
            'data' => $this->data
        ]);
    }

}
