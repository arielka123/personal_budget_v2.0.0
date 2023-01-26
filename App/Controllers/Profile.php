<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
use \App\Flash;


/**
 * profile controller
 */

class Profile extends Authenticated    //najpierw sprawdza czy zalogowany jest zalogowany
{

    protected function before()
    {
        parent::before();
    }
    /**
     * Update the profile
     */

     public function updateUserProfileAction()
     {
        $user = Auth::getUser();
            if($user->updateProfile($_POST)){
                Flash::addMessage('Twoje zmiany zostały zapisane');
                $this->redirect('/settings');
            }
            else {
                $this->redirect('/settings');
            }
     }
}
