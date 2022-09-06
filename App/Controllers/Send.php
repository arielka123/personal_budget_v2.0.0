<?php

namespace App\Controllers;

use \Core\View;

class Send extends \Core\Controller   // rozszerza klase podstwawowa wiec dziedziczy te funckjonalnośc
{

    public function indexAction()
    {        
        echo "probuję wysłać maila";

        \App\Mail::send('arleta.madej@gmail.com', 'testowanie', '<h2>This is a test2</h2></br><h4>Czesc co słychac ?</h4>');//'arleta.madej@gmail.com', 'Test', 'This is a test','<h1>This is a test</h1>'
       
        echo '<br>'."sprawdz czy przyszło coś";

    }

}