<?php

namespace App\Controllers;
use \Core\View;
use \App\Models\Expenses;    
use \App\Flash;

class Expense extends Authenticated 
{
    protected function before()
    {
       parent::before();
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
            Flash::addMessage('Ups.. coś poszło nie tak. Sprawdź czy wszystkie dane zostały wybrane', Flash::WARNING);
            $this->redirect('/expense'); 
            }
    }

    public function limitAction(){
        $category_id= $this->route_params['category'];

        echo json_encode(Expenses::getLimit($category_id), JSON_UNESCAPED_UNICODE);
    }
 
    public function expenseAmountAction(){
        $category_id= $this->route_params['category'];
        echo json_encode(Expenses::expenseAmount($category_id), JSON_UNESCAPED_UNICODE);
    }
}