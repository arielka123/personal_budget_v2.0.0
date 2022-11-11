<?php

namespace App\Controllers;
use \Core\View;
use \App\Models\Expenses;   
use \App\Models\Incomes;
use \App\Auth;
use \App\Flash;


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
            'expenseCategories' => Expenses::loadExpenseCategoriesData(),
            'payments' => Expenses::loadPaymentMethodData(),
            'incomeCategories' => Incomes::loadIncomeCategoriesData(),
            'user' => $user,
        ];              
        //print_r (Expenses::loadUserExpenses());
            View::renderTemplate('Settings/new.html', $args);   
    } 

    public function expenseCategoriesAction(){ 
        echo json_encode(Expenses::loadExpenseCategoriesData(), JSON_UNESCAPED_UNICODE);
    }

    public function paymentsAction(){
        echo json_encode(Expenses::loadPaymentMethodData(), JSON_UNESCAPED_UNICODE);
    }

    public function incomeCategoriesAction(){
        echo json_encode(Incomes::loadIncomeCategoriesData(), JSON_UNESCAPED_UNICODE);
    }

    public function deleteExpCategoryAction(){


        if (Expenses::deleteExpenseCategory()==true) {
            Flash::addMessage('Wybranan kategoria została usunięta', Flash::SUCCESS);
    
            $this->redirect('/settings');
        }
        else {
            $this->redirect('/settings');

        }
    }

    public function deleteIncCategoryAction(){
 
         if (Incomes::deleteIncomeCategory()==true) {
             Flash::addMessage('Wybranan kategoria została usunięta', Flash::SUCCESS);
     
             $this->redirect('/settings');
         }
         else {
             $this->redirect('/settings');
 
         }
     }
     public function deletePayCategoryAction(){
 
        if (Expenses::deletePaymentCategory()==true) {
            Flash::addMessage('Wybranan kategoria została usunięta', Flash::SUCCESS);
    
            $this->redirect('/settings');
        }
        else {
            $this->redirect('/settings');
        }
    }

    public function addIncomeCategoryAction(){

        if (Incomes::addIncomeCategory()==true) {
            Flash::addMessage('Nowa kategoria została dodana', Flash::SUCCESS);
    
            $this->redirect('/settings');
        }
        else {
            $this->redirect('/settings');
        }
    }

    public function addExpenseCategoryAction(){

        if (Expenses::addExpenseCategory()==true) {
            Flash::addMessage('Nowa kategoria została dodana', Flash::SUCCESS);
    
            $this->redirect('/settings');
        }
        else {
            $this->redirect('/settings');
        }
    }

    public function addPaymentsCategoryAction(){

        if (Expenses::addPaymentsCategory()==true) {
            Flash::addMessage('Nowa kategoria została dodana', Flash::SUCCESS);
    
            $this->redirect('/settings');
        }
        else {
            $this->redirect('/settings');
        }
    }
    
    public function editIncomeCategoryAction(){

        if (Incomes::editIncomeCategory()==true) {
            Flash::addMessage('Zapisano zmiany', Flash::SUCCESS);
            $this->redirect('/settings');
        }
        else {
            $this->redirect('/settings');
        }
    }

    public function editExpenseCategoryAction(){

        if (Expenses::editExpenseCategory()==true) {
            Flash::addMessage('Zapisano zmiany', Flash::SUCCESS);
            $this->redirect('/settings');
        }
        else {
            $this->redirect('/settings');
        }
    }

    public function editPaymentsCategoryAction(){

        if (Expenses::editPaymentsCategory()==true) {
            Flash::addMessage('Zapisano zmiany', Flash::SUCCESS);
            $this->redirect('/settings');
        }
        else {
            $this->redirect('/settings');
        }
    }
    
}