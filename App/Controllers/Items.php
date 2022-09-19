<?php

namespace App\Controllers;
use \Core\View;

class Items extends Authenticated
{
   
#TODO dlaczego zakomentowane

    public function indexAction()
    {
        //  $this->requireLogin();

        View::renderTemplate('Items/index.html');
    }

    public function newAction()
    {
      //  $this->requireLogin();

        echo "new action";
    }

    public function showAction()
    {
       // $this->requireLogin();

        echo "show action";
    }

}