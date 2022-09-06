<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;

class Signup extends \Core\Controller   // rozszerza klase podstwawowa wiec dziedziczy te funckjonalnośc
{

   public function newAction()
   {
    View::renderTemplate('Signup/new.html');
   }


   //sign up a new user 

   public function createAction()
   {
      // var_dump($_POST);

     $user = new User($_POST);

     if($user->save()){
         
        //  View::renderTemplate('Signup/success.html');
        //header('Location: http://'.$_SERVER['HTTP_HOST'].'/signup/success', true, 303);
        $user->sendActivationEmail();

        $this->redirect('/signup/success');////////////////////////////////

     }else{

        // var_dump($user->errors);

        View::renderTemplate('Signup/new.html', [
            'user'=>$user
        ]);
    }

   }

   public function successAction()
   {
        View::renderTemplate('Signup/success.html');
   }

   public function activateAction()
   {
     $this->route_params['token'];
     User::activate($this->route_params['token']);
     $this->redirect('/signup/activated');
   }


/**
 * show the activation success page 
 * @return void
  */ 

   public function activatedAction()
   {
      /**
       * after activation the default data can be assigned to user    /////////////////////////////////////////
       */
         View::renderTemplate('Signup/activated.html');
         header("Refresh:5; url=/login");
   }
   

}
