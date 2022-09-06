<?php

namespace App\Controllers;

abstract class Authenticated extends \Core\Controller
{
    //require the uset to be a authenticated begore giving access to all methods in the controller
    protected function before()
    {
        $this->requireLogin();

    }
}
