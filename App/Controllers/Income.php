<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Incomes;
use \App\Flash;
use \App\Auth;

class Income extends \Core\Controller   // rozszerza klase podstwawowa wiec dziedziczy te funckjonalnośc
{
      
    public function newAction()
    {        
      $args = [
        'income_categories' => \App\Models\Incomes::loadIncomeCategoriesData()
    ];
    
# wysietl categorie na ekranie 
        View::renderTemplate('Income/new.html', $args);    
    }

    public function saveAction()
    {
        if (Incomes::saveNewData()== true){
            Flash::addMessage('Hurra! Dodano nowy wydatek', Flash::SUCCESS);
            $this->redirect('/income');

            }
            else {
               $this->redirect('/income'); 
            }
            
        //View::renderTemplate('Income/new.html');
    }
}