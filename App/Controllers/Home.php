<?php

namespace App\Controllers;

use \Core\View;

class Home extends \Core\Controller 
{

    public function indexAction()
    {
      //\App\Mail::send('arleta.madej@gmail.com', 'Czas troche pooszczedzać', '<h2>This is a test2</h2></br><h4>Czesc co słychac ?</h4>');//'arleta.madej@gmail.com', 'Test', 'This is a test','<h1>This is a test</h1>'

        if (isset($_SESSION['user_id'])) { 
            
            $args = [
                'balance' => \App\Models\BalanceSheet::getBalance()[0]['amount']
                ];

                View::renderTemplate('Home/index.html', $args);    
        }
        
        else {

                View::renderTemplate('Home/index.html');

        }
    }

}
