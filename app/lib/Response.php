<?php

namespace Toxic\Lib;

use Toxic\Lib\Status;

class Response {
    
    public $status;
    
    public $data;
    
    public function __construct(Status $status, $data) {
        $this->status = $status;
        $this->data = $data;
    }
}