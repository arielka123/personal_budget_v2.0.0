<?php

namespace App\Controllers;
use \Core\View;
use \App\Models\Expenses;   
use \App\Models\Incomes;
use \App\Flash;


class Register extends Authenticated 
{
    protected function before()
    {
       parent::before();
    }  
    
    public static function newAction()      
    {         
          $args = [
            'expenses' => Expenses::loadUserExpenses(),
            'incomes' => Incomes::loadUserIncomes(),
        ];              
        //print_r (Expenses::loadUserExpenses());
           View::renderTemplate('Register/new.html', $args);   
    } 
    
    public function expensesAction(){
        echo json_encode(Expenses::loadUserExpenses(), JSON_UNESCAPED_UNICODE);
    }

    public function incomesAction(){
        echo json_encode(Incomes::loadUserIncomes(), JSON_UNESCAPED_UNICODE);
    }

    public function deleteExpenseRecordAction(){

        if (Expenses::deleteExpenseRecord()==true) {
            Flash::addMessage('Wybrany wpis został usunięty', Flash::SUCCESS);
            $this->redirect('/register');
        }
        else {
            Flash::addMessage('ups... spróbuj ponownie później', Flash::WARNING);
            $this->redirect('/register');
        }
    }

    public function deleteIncomeRecordAction(){
        if (Incomes::deleteIncomeRecord()==true) {
            Flash::addMessage('Wybrany wpis został usunięt', Flash::SUCCESS);
            $this->redirect('/register');
        }
        else {
            Flash::addMessage('ups... spróbuj ponownie później', Flash::WARNING);
            $this->redirect('/register');
        };
    }

}