<?php

namespace App\Models;

use PDO;
use \App\Auth;
use App\Controllers\Expense;
use \App\Models\Validation;

      
/* Expense model
 *
 * PHP version 7.0
 */

class Expenses extends \Core\Model
{   

    static $ADD_STATUS_NEW = 1;
    static $ADD_STATUS_ACTIVATED = 2;
    static $ADD_STATUS_ALLREADY_EXIST = 3;
    static $ADD_STATUS_ERROR = -1;

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
        
        if(isset($_POST['expense'])==false || ($_POST['expense']==null)){
            return false;
        }

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

        if($stmt->execute()!= true){
            return false;
        }
        return true;
    }

    public static function loadUserExpenses()
    {
        $user_id=Auth::getUserId();   

        $sql_expenses = 'SELECT c.name as name, e.id, amount, date_of_expense, expense_comment, p.name as paymentMethods FROM expenses as e
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

        if($stmt->execute()== true){
            return true;
        }

        return false;
    }

    public static function addExpenseCategory()
    {
        $name = $_POST['inputExpenseCategory'];
        $name = ltrim($name, ' ');
        $name = rtrim($name, ' ');
         
        $user_id=Auth::getUserId();
        $is_active  = 'Y';
        $is_not_active = 'N';

        if (isset($_POST['amountLimitAdd'])){
             $limitCategory = $_POST['amountLimitAdd'];
         }
        else  $limitCategory ="0";
        
        $sql1 = 'INSERT INTO expenses_category_assigned_to_users (user_id, name, limitCategory)
                SELECT :user_id, :name, :limitCategory
                WHERE NOT EXISTS (
                    SELECT *
                    FROM expenses_category_assigned_to_users src
                    WHERE UPPER(src.name) = UPPER(:name)
                    AND src.user_id = :user_id
                )';

        $sql2 = 'UPDATE expenses_category_assigned_to_users
                    SET is_active = :is_active, limitCategory = :limitCategory
                    WHERE user_id = :user_id
                    AND  UPPER(name) = UPPER(:name)
                    AND is_active = :is_not_active';

        $db = static::getDB();

        $stmt1 = $db->prepare($sql1);
        $stmt2 = $db->prepare($sql2);

        $stmt1->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt1->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt1->bindValue(':limitCategory', $limitCategory, PDO::PARAM_STR);

        $stmt2->bindValue(':limitCategory', $limitCategory, PDO::PARAM_STR);
        $stmt2->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt2->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt2->bindValue(':is_active', $is_active, PDO::PARAM_STR);
        $stmt2->bindValue(':is_not_active', $is_not_active, PDO::PARAM_STR);

        if($stmt1->execute()== true){
            $rows_count1 = $stmt1->rowCount();

            if($rows_count1 == 1){
                return Expenses::$ADD_STATUS_NEW; 
            }

            if ($stmt2->execute() == true) {
                $rows_count2 = $stmt2->rowCount();
                if($rows_count2 == 1){
                    return Expenses::$ADD_STATUS_ACTIVATED; 
                }
                else {
                    return Expenses::$ADD_STATUS_ALLREADY_EXIST;
                }
            }
            else {
                return Expenses::$ADD_STATUS_ERROR;
            }
            
        }
        
        return Expenses::$ADD_STATUS_ERROR;
    }

    public static function addPaymentsCategory()
    {
        $user_id=Auth::getUserId();
        $is_active  = 'Y';
        $is_not_active = 'N';

        $name = $_POST['inputPaymentsCategory'];
        $name = ltrim($name, ' ');
        $name = rtrim($name, ' ');
        
        // $sql = 'INSERT INTO payment_methods_assigned_to_users (user_id, name)
        //         VALUES (:user_id, :name) ';

        $sql1 = 'INSERT INTO payment_methods_assigned_to_users (user_id, name)
        SELECT :user_id, :name
        WHERE NOT EXISTS (
            SELECT *
            FROM payment_methods_assigned_to_users src
            WHERE UPPER(src.name) = UPPER(:name)
            AND src.user_id = :user_id
        )';

        $sql2 = 'UPDATE payment_methods_assigned_to_users
                    SET is_active = :is_active
                    WHERE user_id = :user_id
                    AND  UPPER(name) = UPPER(:name)
                    AND is_active = :is_not_active';

        $db = static::getDB();

        $stmt1 = $db->prepare($sql1);
        $stmt2 = $db->prepare($sql2);

        $stmt1->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt1->bindValue(':name', $name, PDO::PARAM_STR);

        $stmt2->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt2->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt2->bindValue(':is_active', $is_active, PDO::PARAM_STR);
        $stmt2->bindValue(':is_not_active', $is_not_active, PDO::PARAM_STR);

        if($stmt1->execute()== true){
            $rows_count1 = $stmt1->rowCount();

            if($rows_count1 == 1){
                return Expenses::$ADD_STATUS_NEW; 
            }

            if ($stmt2->execute() == true) {
                $rows_count2 = $stmt2->rowCount();
                if($rows_count2 == 1){
                    return Expenses::$ADD_STATUS_ACTIVATED; 
                }
                else {
                    return Expenses::$ADD_STATUS_ALLREADY_EXIST;
                }
            }
            else {
                return Expenses::$ADD_STATUS_ERROR;
            }
            
        }
        
        return Expenses::$ADD_STATUS_ERROR;
    }

    public static function editExpenseCategory() 
    {
         if (isset($_POST['editExpenseCategory'])){

            $name = $_POST['editExpenseCategory'];
            $name = ltrim($name, ' ');
            $name = rtrim($name, ' ');
            $id = $_POST['editExpenseCategory2'];
         }

        $sql = 'UPDATE expenses_category_assigned_to_users
                SET ';
        $set_values = [];
         
        if($name !=''){
            array_push($set_values, 'name = :name');
        }

        if (isset($_POST['amountLimitEdit'])){
            $limitCategory = $_POST['amountLimitEdit'];
            
            if($_POST['amountLimitEdit'] !='' ){
                array_push($set_values, 'limitCategory = :limitCategory');
            }
         }
        
         if(empty($set_values)){
            return true;
         }
        $sql .= implode(', ', $set_values);
        
        $sql .=" \nWHERE id=:id";
               
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        if ($_POST['editExpenseCategory'] !=''){
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        }

        if (isset($_POST['amountLimitEdit'])){
            $stmt->bindValue(':limitCategory', $limitCategory, PDO::PARAM_STR);
        }

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        // print_r($sql);
        if($stmt->execute()!= true){
            return Expenses::$ADD_STATUS_ERROR; 
        }

        $rows_count = $stmt->rowCount();

        if($rows_count == 1){
            return Expenses::$ADD_STATUS_ACTIVATED; 
        }
        elseif($rows_count == 0) {
            return Expenses::$ADD_STATUS_ALLREADY_EXIST; 
        }
        else  return Expenses::$ADD_STATUS_ERROR; 
    }


    public static function editPaymentsCategory()
    {
        $name = $_POST['editPaymentsCategory'];
        $id = $_POST['editPaymentsCategory2'];

        $name = ltrim($name, ' ');
        $name = rtrim($name, ' ');

        $sql = 'UPDATE payment_methods_assigned_to_users
                SET name = :name
                WHERE id = :id ';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
       
        if($stmt->execute()!= true){
            return Expenses::$ADD_STATUS_ERROR; 
        }

        $rows_count = $stmt->rowCount();

        if($rows_count == 1){
            return Expenses::$ADD_STATUS_ACTIVATED; 
        }
        elseif($rows_count == 0) {
            return Expenses::$ADD_STATUS_ALLREADY_EXIST; 
        }
        else  return Expenses::$ADD_STATUS_ERROR; 
    }

    public static function getLimit($category_id){

        $user_id=Auth::getUserId();

        $sql = 'SELECT limitCategory FROM expenses_category_assigned_to_users
                WHERE user_id = :user_id
                AND id = :category_id;
                AND is_active ="Y" 
                LIMIT 1';
                                                                                              
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);

        $stmt->execute();

        $result=  $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result[0]['limitCategory'];
    }

    public static function expenseAmount($category_id){
        
        $year=date('Y');          
        $month=date('m');
        $today= date('Y-m-d');
        $first_day="01";   //#TODO powinien byc dzień wybrany przez uzytkownika
    
        $date1=$year."-".$month."-".$first_day;
        $date2=$today;   

        $user_id=Auth::getUserId();

        $sql = 'SELECT SUM(amount) as sum FROM expenses
                WHERE user_id = :user_id
                AND expense_category_assigned_to_user_id = :category_id;
                AND date_of_expense BETWEEN :date1 AND :date2';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindValue(':date1', $date1, PDO::PARAM_STR);
        $stmt->bindValue(':date2', $date2, PDO::PARAM_STR);

        $stmt->execute();
        $result=  $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result[0]['sum'];
    }

    public static function  getExpenseName($category_id)
    {
        $user_id=Auth::getUserId();

        $sql = 'SELECT name FROM expenses_category_assigned_to_users
                WHERE user_id = :user_id
                AND id = :category_id;';
                                                                    
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->execute();

        $result=  $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result[0]['name'];
    }

    public static function  getPaymentName($category_id)
    {
        $user_id=Auth::getUserId();

        $sql = 'SELECT name FROM payment_methods_assigned_to_users
                WHERE user_id = :user_id
                AND id = :category_id;';
                                                                    
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->execute();

        $result=  $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result[0]['name'];
    }

    public static function deleteExpenseRecord()
    {
        $user_id=Auth::getUserId();

        if(isset($_POST['expenseRecod'])){
            $id = $_POST['expenseRecod']; 
        }
        else return false;

        $sql = 'DELETE FROM expenses 
               WHERE user_id=:user_id 
               AND id=:id';
    
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        if($stmt->execute()== true){
            return true;
        }

        return false;
    }  
}