<?php

namespace Toxic\Games\Santase\Models;

use Toxic\Lib\Status;
use Toxic\Lib\Response;
use Toxic\Games\Santase\Models\BaseModel;

class Players extends BaseModel 
{
    const ERROR_USERNAME_EMPTY = "player.register.error.username.empty";
    const ERROR_USERNAME_DUPLICATE = "player.register.error.username.duplicate";
    const SUCCESS_USER_REGISTRATION = "player.register.success";
    
    public static function register(\stdClass $data){
        
        $validation = self::isValid($data);
        
        if($validation !== true){
            return $validation;
        }
        
        try{
            
            $result = parent::save($data);

            return new Response(
                    new Status(200, self::SUCCESS_USER_REGISTRATION),
                    ["id" => $result->getInsertedId()->__toString()]
            );
            
            
        }catch(\Exception $e){
            
            $error = $e->getMessage();
            
            if(strstr($error, "duplicate key") !== false){
                $error = self::ERROR_USERNAME_DUPLICATE;
            }
            
            return new Response(new Status(409, $error));
        }
        
    }
    
    private static function isValid(\stdClass $data){
                
        $data->username = filter_var(trim($data->username), FILTER_SANITIZE_STRING);
        $data->password = trim($data->password);
        
        if(empty($data->username)){
            return new Response(new Status(409, self::ERROR_USERNAME_EMPTY));
        }
        
        return true;        
    }
}