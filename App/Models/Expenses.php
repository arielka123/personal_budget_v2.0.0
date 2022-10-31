<?php

namespace App\Models;

use PDO;
use \App\Auth;
use \App\Models\Validation;

      
/* Expense model
 *
 * PHP version 7.0
 */

class Expenses extends \Core\Model
{   

/**
 * get array of results
 */
    public static function  loadExpenseCategoriesData()
    {

    $user_id=Auth::getUserId();

    $sql_query_category_income = 'SELECT * FROM expenses_category_assigned_to_users
                                   WHERE user_id = :user_id';

    $db = static::getDB();
    $stmt = $db->prepare($sql_query_category_income);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    $result=  $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;

    }

    /**
     * get array of results 
     */

    public static function  loadPaymentMethodData()
    {

    $user_id=Auth::getUserId();   

    $sql_query_category_income = 'SELECT * FROM payment_methods_assigned_to_users
                                   WHERE user_id = :user_id';

    $db = static::getDB();
    $stmt = $db->prepare($sql_query_category_income);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    $result=  $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;

    }

    public static function saveNewData ()
    {
        $sql = 'INSERT INTO expenses (user_id, expense_category_assigned_to_user_id,
        payment_method_assigned_to_user_id, amount, date_of_expense, expense_comment)
                VALUES (:user_id, :id_expense_category, :id_payment_method, :amount, :date_of_expense, :expense_comment) ';


        $date = $_POST['date'];        
        $id_expense_category =$_POST['expense'];

        if(Validation::validate_amount()==true)
        {
            $amount = Validation::validate_amount();
        }
        else return false;


        $comment = Validation::validate_comment();

        $id_payment_method = $_POST['payment'];

        $user_id=Auth::getUserId();

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':id_expense_category', $id_expense_category, PDO::PARAM_INT);
        $stmt->bindValue(':amount', $amount, PDO::PARAM_STR);
        $stmt->bindValue(':date_of_expense', $date, PDO::PARAM_STR);
        $stmt->bindValue(':expense_comment', $comment, PDO::PARAM_STR);
        $stmt->bindValue(':id_payment_method', $id_payment_method, PDO::PARAM_INT);

        $stmt->execute();

        return true;
    }

    public static function loadUserExpenses(){
        $user_id=Auth::getUserId();   

        // $sql_expenses = 'SELECT * FROM expenses
        //                            WHERE user_id = :user_id
        //                            order by date_of_expense desc';

        $sql_expenses = 'SELECT c.name as name, amount, date_of_expense, expense_comment, p.name as paymentMethods FROM expenses as e
                                   JOIN expenses_category_assigned_to_users as c ON e.expense_category_assigned_to_user_id=c.id
                                   JOIN payment_methods_assigned_to_users as p ON e.payment_method_assigned_to_user_id=p.id
                                   WHERE e.user_id = :user_id
                                   ORDER BY date_of_expense desc';
                                   
        $db = static::getDB();
        $stmt = $db->prepare($sql_expenses);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

    $result=  $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
    }

}