<?php

namespace App\Controllers;
use \Core\View;
use \App\Models\Expenses;    
use \App\Flash;
use \App\Auth;


class Expense extends Authenticated 
{
    protected function before()
    {
       // parent::before();
    }
    
   
    public function newAction()      
    {        
      $args = [
        'expense_categories' => \App\Models\Expenses::loadExpenseCategoriesData(),
        'payment_methods' => \App\Models\Expenses::loadPaymentMethodData()
    ];
    
# wysietl categorie na ekranie 
        View::renderTemplate('Expense/new.html', $args);    
    } 
       
      
    public function saveAction()
    {
        if (Expenses::saveNewData()== true)
        {
            Flash::addMessage('Hurra! Dodano nowy wydatek', Flash::SUCCESS);
            $this->redirect('/expense');

        }
        else {
        // Flash::addMessage('Ups.. coś poszło nie tak.', Flash::WARNING);
            $this->redirect('/expense'); 
            }
            
    }
}