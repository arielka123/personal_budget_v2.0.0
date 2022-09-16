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
        // parent::before();
        // $this->user = Auth::getUser();
    }
    /**
     * show profile
     */
    public function showAction()
    {     
        if( $this->user = Auth::getUser())
        {
            View::renderTemplate('Profile/show.html',[
                'user' => $this->user
            ]);        
        }
        else View::renderTemplate('Login/new.html');
    }

    

/**
 * show the form for the editing action
 */

    public function editAction()
    {
        View::renderTemplate('Profile/edit.html',[
            'user' => $this->user
        ]);
    }

    /**
     * Update the profile
     */

     public function updateAction()
     {

         if($this->user->updateProfile($_POST)){
             Flash::addMessage('Twoje zmiany zostały zapisane');
            //  $this->redirect('/profile/show');
            $this->showAction();
         }
         else {
             View::renderTemplate('Profile/edit.html',[
                 'user' => $this->user
             ]);
         }
     }

}
