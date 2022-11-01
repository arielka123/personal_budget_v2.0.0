<?php

namespace App\Controllers;
use \Core\View;
use \App\Models\Expenses;   
use \App\Models\Incomes;

class Settings extends Authenticated 
{
    protected function before()
    {
        parent::before();
    }

    public static function newAction()      
    {         
            $args = [
            'expenseCategories' => Expenses::loadExpenseCategories(),
            'payments' => Expenses::loadUserpayments(),
            'IncomeCategories' => Incomes::loadIncomeCategories()
        ];              
        //print_r (Expenses::loadUserExpenses());
            View::renderTemplate('Settings/new.html', $args);   
    } 

    public function expenseCategoriesAction(){ 
        echo json_encode(Expenses::loadExpenseCategories(), JSON_UNESCAPED_UNICODE);
    }

    public function paymentsAction(){
        echo json_encode(Expenses::loadUserpayments(), JSON_UNESCAPED_UNICODE);
    }

    public function incomeCategoriesAction(){
        echo json_encode(Incomes::loadIncomeCategories(), JSON_UNESCAPED_UNICODE);
    }


}