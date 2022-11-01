<?php

namespace App\Controllers;
use \Core\View;

class Settings extends Authenticated 
{
    protected function before()
    {
       // parent::before();
    }
    
    public static function newAction()      
    {         
        //   $args = [
        //     'expenses' => Expenses::loadUserExpenses(),
        //     'incomes' => Incomes::loadUserIncomes(),
        // ];              
        //print_r (Expenses::loadUserExpenses());
         //  View::renderTemplate('Register/new.html', $args);   

         View::renderTemplate('Settings/new.html');
    } 
    
}