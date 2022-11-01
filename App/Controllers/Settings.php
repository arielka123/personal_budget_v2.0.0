<?php

namespace App\Controllers;
use \Core\View;
use \App\Models\Expenses;   
use \App\Models\Incomes;
use \App\Auth;

class Settings extends Authenticated 
{
    protected function before()
    {
        parent::before();

    }

    public static function newAction()      
    {         
            $user = Auth::getUser();

            $args = [
            'expenseCategories' => Expenses::loadExpenseCategories(),
            'payments' => Expenses::loadUserpayments(),
            'incomeCategories' => Incomes::loadIncomeCategories(),
            'user' => $user,
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