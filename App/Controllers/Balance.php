<?php

namespace App\Controllers;
use \Core\View;
use \App\Flash;

class Balance extends  Authenticated 
{
    protected function before()
    {
       parent::before();
    }

    public function newAction() {

            $args = [
                'result_income' => \App\Models\BalanceSheet::loadIncomeResults(),
                'result_expense' => \App\Models\BalanceSheet::loadExpenseResults(),
            ];

            if (\App\Models\BalanceSheet::period()==false){
                Flash::addMessage('Ups.. coś poszło nie tak. Sprawdź czy zostały wybrane daty!', Flash::WARNING);
            }

            View::renderTemplate('Balance/new.html',  $args);     

        } 

}