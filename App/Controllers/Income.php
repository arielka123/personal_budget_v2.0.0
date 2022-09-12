<?php

namespace App\Controllers;
use \Core\View;
use \App\Models\Incomes;
use \App\Flash;
use \App\Auth;

   
class Income extends Authenticated   // rozszerza klase podstwawowa wiec dziedziczy te funckjonalnośc
{

    protected function before()
    {
      //  parent::before();
    }
    
    public function newAction()
    {        
      $args = [
        'income_categories' => \App\Models\Incomes::loadIncomeCategoriesData()
    ];
       
# wysietl categorie na ekranie 
        if( $this->user = Auth::getUser())
        {
            View::renderTemplate('Income/new.html', $args);    
        }
        else View::renderTemplate('Login/new.html');
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