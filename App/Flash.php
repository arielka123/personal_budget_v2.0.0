<?php

namespace App;

//flash notofocations messages: messages for one-time display using the session
//for storage between requested

class Flash
{
    const SUCCESS = 'success';
    const INFO = 'info';
    const WARNING = 'warning';

    //add a message  
    //message content

    //string $message  The message content
    //string $type  The optional message type, fefaultss to success

    public static function addMessage($message, $type='success')
    {
        //create array in the session if it doesn't exist

        if(! isset($_SESSION['flash_notifications'])){
            $_SESSION['flash_notifications'] = [];
        }

        $_SESSION['flash_notifications'][] = [
            'body'=>$message,
            'type'=>$type
        ];
    }

    public static function getMessages()
    {
        if(isset($_SESSION['flash_notifications'])){
            $message = $_SESSION['flash_notifications'];
            unset($_SESSION['flash_notifications']);

            return $message;
        }

    }



}