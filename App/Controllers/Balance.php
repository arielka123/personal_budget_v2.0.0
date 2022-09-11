<?php

namespace App\Controllers;

use \Core\View;
use \App\Flash;
use \App\Auth;


class Balance extends Authenticated  // rozszerza klase podstwawowa wiec dziedziczy te funckjonalnośc
{

	protected function before()
    {
        parent::before();
        $this->user = Auth::getUser();
    }

    public function newAction() {

			$data = array(
				array('y' => 79.45, 'label' => "Google"),
				array('y' => 7.31, 'label' => "Bing"),
				array('y' => 7.06, 'label' => "Baidu"),
				array('y' => 4.91, 'label' => "Yahoo"),
				array('y' => 1.26, 'label' => "Others")
			);

			$zmienna1 = 'Ala ma kota';
            $args = [
                'result_income' => \App\Models\BalanceSheet::loadIncomeResults(),
                'result_expense' => \App\Models\BalanceSheet::loadExpenseResults(),
				'mypiechart' => $data,
				'zmienna1' => $zmienna1
            ];

            if (\App\Models\BalanceSheet::period()==false){
                Flash::addMessage('Ups.. coś poszło nie tak. Sprawdź czy zostały wybrane daty!', Flash::WARNING);
            }

            View::renderTemplate('Balance/new.html',  $args);     

        }

    

}