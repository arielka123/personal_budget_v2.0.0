<?php

namespace App\Models;

use PDO;
use \App\Auth;
use \App\Models\Validation;
/**
 * Expense model
  *
 * PHP version 7.0
 */     

class Incomes extends \Core\Model 
{
    static $ADD_STATUS_NEW = 1;
    static $ADD_STATUS_ACTIVATED = 2;
    static $ADD_STATUS_ALLREADY_EXIST = 3;
    static $ADD_STATUS_ERROR = -1;

    public static function  loadIncomeCategoriesData()
    {
   
        if(isset($_SESSION['user_id']))
        {
        
        $user_id= Auth::getUserId();

        $sql_query_category_income = 'SELECT * FROM incomes_category_assigned_to_users
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
        return false;
    }
              
    public static function saveNewData ()
    {
        $sql = 'INSERT INTO incomes (user_id, income_category_assigned_to_user_id, amount, date_of_income, income_comment)
                VALUES (:user_id, :id_income_category, :amount, :date_of_income, :income_comment) ';

        $user_id=Auth::getUserId();

        $date = $_POST['date'];

        if(isset($_POST['income'])==false || ($_POST['income']==null)){
            return false;
        }
        $id_income_category =$_POST['income'];

        if(Validation::validate_amount()==true)
        {
            $amount = Validation::validate_amount();
        }
        else return false;

        $comment = Validation::validate_comment();

        $db = static::getDB();

        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':id_income_category', $id_income_category, PDO::PARAM_INT);
        $stmt->bindValue(':amount', $amount, PDO::PARAM_STR);
        $stmt->bindValue(':date_of_income', $date, PDO::PARAM_STR);
        $stmt->bindValue(':income_comment', $comment, PDO::PARAM_STR);

        $stmt->execute();

        return true;
    }

    
    public static function loadUserIncomes()
    {
        $user_id=Auth::getUserId();   

        $sql = 'SELECT amount, date_of_income, income_comment, c.name as name FROM incomes as i
                                   JOIN incomes_category_assigned_to_users as c ON i.income_category_assigned_to_user_id=c.id
                                   WHERE i.user_id = :user_id
                                   ORDER BY date_of_income desc';
                                   
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $result=  $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function deleteIncomeCategory()
    {
        $user_id=Auth::getUserId();
        $id = $_POST['incomeCategoryItem']; 

        // $sql = 'DELETE FROM incomes_category_assigned_to_users 
        //        WHERE user_id=:user_id 
        //        AND id=:id';

        $sql = 'UPDATE incomes_category_assigned_to_users  
                SET is_active = "N"
                WHERE user_id=:user_id 
                AND id=:id';
    
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        if($stmt->execute()!= true){
            return false;
        }
        return true;
    }

    public static function addIncomeCategory()
    {
        $user_id=Auth::getUserId();
        $is_active  = 'Y';
        $is_not_active = 'N';

        $name = $_POST['inputIncomeCategory'];
        $name = ltrim($name, ' ');
        $name = rtrim($name, ' ');
        
        // $sql = 'INSERT INTO incomes_category_assigned_to_users (user_id, name)
        //         VALUES (:user_id, :name) ';

        $sql1 = 'INSERT INTO incomes_category_assigned_to_users (user_id, name)
        SELECT :user_id, :name
        WHERE NOT EXISTS (
            SELECT *
            FROM incomes_category_assigned_to_users src
            WHERE UPPER(src.name) = UPPER(:name)
            AND src.user_id = :user_id
        )';

        $sql2 = 'UPDATE incomes_category_assigned_to_users
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
                return Incomes::$ADD_STATUS_NEW; 
            }

            if ($stmt2->execute() == true) {
                $rows_count2 = $stmt2->rowCount();
                if($rows_count2 == 1){
                    return Incomes::$ADD_STATUS_ACTIVATED; 
                }
                else {
                    return Incomes::$ADD_STATUS_ALLREADY_EXIST;
                }
            }
            else {
                return Incomes::$ADD_STATUS_ERROR;
            }
        }
        
        return Incomes::$ADD_STATUS_ERROR;
    }

    public static function editIncomeCategory()
    {
        $name = $_POST['editIncCategory'];
        $id = $_POST['editIncCategory2'];

        $name = ltrim($name, ' ');
        $name = rtrim($name, ' ');

        $sql = 'UPDATE incomes_category_assigned_to_users
                SET name = :name
                WHERE id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
       
        if($stmt->execute()!= true){
            return Incomes::$ADD_STATUS_ERROR; 
        }

        $rows_count = $stmt->rowCount();

        if($rows_count == 1){
            return Incomes::$ADD_STATUS_ACTIVATED; 
        }
        elseif($rows_count == 0) {
            return Incomes::$ADD_STATUS_ALLREADY_EXIST; 
        }
        else  return Incomes::$ADD_STATUS_ERROR; 
    }

    public static function  getIncomeName($category_id)
    {
        $user_id=Auth::getUserId();

        $sql = 'SELECT name FROM incomes_category_assigned_to_users
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
}
