<?php

namespace App;

//uniqe random tokens

class Token
{

    protected $token;

    //class contructor. create a new random or assign an existing one if passed in

    public function __construct($token_value = null)
    {
        if($token_value){
            
            $this->token = $token_value;
        }
        else
        {
            $this->token = bin2hex(random_bytes(16));  //16 bytes = 128 bits = 32 hex charaters

        }
    }

    //get the token
    public function getValue()
    {
        return $this->token;
    }

    //get the hashed token value

    public function getHash()
    {
        return hash_hmac('sha256', $this->token, \App\Config::SECRET_KEY); //sha256 = 64 chars
    }
}