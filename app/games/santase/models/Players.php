<?php

namespace Toxic\Games\Santase\Models;

use Toxic\Lib\Status;
use Toxic\Lib\Response;
use Toxic\Games\Santase\Models\BaseModel;

/**
 * Players model
 * 
 * This model provides all the functionalities to manage the players, such as 
 * registration, authentication, etc. All the related response status messages 
 * are also within this class as class constants.
 */
class Players extends BaseModel {

    /**
     * Error message when the username is empty
     */
    const ERROR_USERNAME_EMPTY = "player.register.error.username.empty";

    /**
     * Error message when the password is empty
     */
    const ERROR_PASSWORD_EMPTY = "player.register.error.password.empty";

    /**
     * Error message when the username is duplicated
     */
    const ERROR_USERNAME_DUPLICATE = "player.register.error.username.duplicate";

    /**
     * Message for successful new payer registration
     */
    const SUCCESS_PLAYER_REGISTRATION = "player.register.success";

    /**
     * Register a new player
     * 
     * Username and password must be provided in order to register a new player. 
     * Username must be unique.
     * 
     * @param \stdClass $data Object with two properties - username and password
     * @return Response
     */
    public static function register(\stdClass $data): Response {

        //filter and validate
        $validation = self::isValid($data);

        //if input data is invalid, return the response
        if ($validation !== true) {
            return $validation;
        }

        try {
            return new Response(
                    new Status(200, self::SUCCESS_PLAYER_REGISTRATION), 
                    ["id" => parent::insertOne($data)->getInsertedId()->__toString()]
            );
        } catch (\Exception $e) {

            $error = $e->getMessage();

            if (strstr($error, "duplicate key") !== false) {
                $error = self::ERROR_USERNAME_DUPLICATE;
            }

            return new Response(new Status(409, $error));
        }
    }

    /**
     * Validate the input data for new user registration
     * 
     * @param \stdClass $data
     * @return Response|boolean In case of error, prepare and return the proper 
     * Response object. In case of success, return boolean TRUE.
     */
    private static function isValid(\stdClass $data) {

        $data->username = filter_var(trim($data->username), FILTER_SANITIZE_STRING);
        $data->password = filter_var(trim($data->password), FILTER_SANITIZE_STRING);

        if (empty($data->username)) {
            return new Response(new Status(409, self::ERROR_USERNAME_EMPTY));
        }

        if (empty($data->password)) {
            return new Response(new Status(409, self::ERROR_PASSWORD_EMPTY));
        }

        return true;
    }

}
