<?php

namespace Toxic\Lib;

/**
 * Operation status
 * 
 * This class represents the operation result status. There are two properties - 
 * code and message, which indicates the status and provides one of the pre-defined 
 * success or error codes.
 */
class Status implements \JsonSerializable {

    /**
     * Status code
     * 
     * The status code value follows the HTTP specifications, e.g.
     * 200 - OK
     * 409 - Conflict (default value)
     * 
     * @var int 
     */
    protected $code = 409;

    /**
     * Status message
     * 
     * Pre-defined message keys instead of free text. 
     * 
     * @var string
     */
    protected $message = '';

    /**
     * Status class constructor
     * 
     * @param int $code
     * @param string $message
     */
    public function __construct(int $code, string $message) {
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * Helper for serializing the object to JSON
     * 
     * @return array
     */
    public function jsonSerialize() {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }

}
