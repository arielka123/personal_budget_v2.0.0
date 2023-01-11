<?php

namespace App\Controllers;
use \Core\View;
use \App\Models\Incomes;
use \App\Flash;

class Income extends Authenticated   
{
    protected function before()
    {
       parent::before();
    }
    
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
        if (Incomes::saveNewData()== true)
        {
            Flash::addMessage('Hurra! Dodano nowy wydatek', Flash::SUCCESS);
            $this->redirect('/income');

        }
            else {
               $this->redirect('/income'); 
            }          
    }
    
}