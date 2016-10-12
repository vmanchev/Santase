<?php

namespace Toxic\Lib;

class Status {

    /**
     * Status code
     * 
     * The status code value follows the HTTP specifications, e.g.
     * 200 - OK
     * 409 - Conflict (default value)
     * 
     * @var int 
     */
    public $code = 409;

    /**
     * Status message
     * 
     * Pre-defined message keys instead of free text. 
     * 
     * @var string
     */
    public $message = '';

    /**
     * Status class constructor
     * 
     * @param int $code
     * @param string $message
     */
    public function __construct(int $code, $message) {
        $this->code = $code;
        $this->message = $message;
    }

}
