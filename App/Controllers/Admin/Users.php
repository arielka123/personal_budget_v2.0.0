<?php

namespace App\Controllers\Admin;

class Users extends \Core\Controller
{

    /**
     *filter before
     */
    protected function before()
    {
       //echo "(before) ";
       // return false;
    }

    public function indexAction()
    {
        echo 'User admin index';
        //echo '<p>Query string parameters: <pre>'.htmlspecialchars(print_r($_GET, true)) . '</pre></p>';
       
    }

}
