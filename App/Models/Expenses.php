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

    $sql = 'SELECT * FROM expenses_category_assigned_to_users
                                   WHERE user_id = :user_id
                                   AND is_active ="Y"
                                   ORDER BY name asc';
                                                                   

    $db = static::getDB();
    $stmt = $db->prepare($sql);
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
                                   WHERE user_id = :user_id
                                   AND is_active ="Y"
                                   ORDER BY name asc';

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

    public static function loadUserExpenses()
    {
        $user_id=Auth::getUserId();   

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
   
    public static function deletePaymentCategory()
    {
        $user_id=Auth::getUserId();
        $id = $_POST['paymentCategoryItem']; 

        // $sql = 'DELETE FROM payment_methods_assigned_to_users 
        //        WHERE user_id=:user_id 
        //        AND id=:id';

        $sql = 'UPDATE payment_methods_assigned_to_users 
                SET is_active = "N"
                WHERE user_id=:user_id 
                AND id=:id';
    
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        if($stmt->execute()!= true){
            return false;
        }

        return true;
    }

    public static function deleteExpenseCategory()
    {
        $user_id=Auth::getUserId();
        $id = $_POST['expenseCategoryItem']; 

        // $sql = 'DELETE FROM expenses_category_assigned_to_users 
        //        WHERE user_id=:user_id 
        //        AND id=:id';

        $sql = 'UPDATE expenses_category_assigned_to_users 
                SET is_active = "N"
                WHERE user_id=:user_id 
                AND id=:id';
    
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        if($stmt->execute()!= true){
            return false;
        }

        return true;
    }

    public static function addExpenseCategory()
    {
        #TODO zapisac wprowadzoną kwote limitu do bazy 
        $user_id=Auth::getUserId();
        $name = $_POST['inputExpenseCategory'];
        $limitCategory = $_POST['amountLimitAdd'];
        
        $sql = 'INSERT INTO expenses_category_assigned_to_users (user_id, name, limitCategory)
                VALUES (:user_id, :name, :limitCategory) ';

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':limitCategory', $limitCategory, PDO::PARAM_STR);

        if($stmt->execute()!= true){
            return false;
        }
        return true;
    }

    public static function addPaymentsCategory()
    {
        $user_id=Auth::getUserId();
        $name = $_POST['inputPaymentsCategory'];
        
        $sql = 'INSERT INTO payment_methods_assigned_to_users (user_id, name)
                VALUES (:user_id, :name) ';

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
       
        if($stmt->execute()!= true){
            return false;
        }
        return true;
    }

    public static function editExpenseCategory() 
    {
         #TODO zapisac wprowadzoną kwote limitu do bazy 

        $name = $_POST['editExpenseCategory'];
        $id = $_POST['editExpenseCategory2'];
        $limitCategory = $_POST['amountLimitEdit'];

        $sql = 'UPDATE expenses_category_assigned_to_users
                SET name = :name, limitCategory = :limitCategory
                WHERE id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':limitCategory', $limitCategory, PDO::PARAM_STR);

        if($stmt->execute()!= true){
            return false;
        }
        return true;
    }

    public static function editPaymentsCategory()
    {
        $user_id=Auth::getUserId();
        $name = $_POST['editPaymentsCategory'];
        $id = $_POST['editPaymentsCategory2'];

        $sql = 'UPDATE payment_methods_assigned_to_users
                SET name = :name
                WHERE id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
       
        if($stmt->execute()!= true){
            return false;
        }
        return true;
    }
}