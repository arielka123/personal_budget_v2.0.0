<?php

namespace App\Controllers;
use \Core\View;
use \App\Models\Expenses;   
use \App\Models\Incomes;

class Register extends Authenticated 
{
    protected function before()
    {
       // parent::before();
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
    
}