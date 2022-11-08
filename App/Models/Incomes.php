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

    public static function  loadIncomeCategoriesData()
    {
   
        if(isset($_SESSION['user_id']))
        {
        
        $user_id= Auth::getUserId();

        $sql_query_category_income = 'SELECT * FROM incomes_category_assigned_to_users
                                    WHERE user_id = :user_id
                                    AND is_active ="Y"';

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

    public static function loadIncomeCategories()
    {
        $user_id=Auth::getUserId();   

        $sql = 'SELECT * FROM incomes_category_assigned_to_users
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
        $name = $_POST['inputIncomeCategory'];
        
        $sql = 'INSERT INTO incomes_category_assigned_to_users (user_id, name)
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

    public static function editIncomeCategory()
    {
        $user_id=Auth::getUserId();
        $name = $_POST['editIncCategory'];
        $id = $_POST['editIncCategory2'];

        $sql = 'UPDATE incomes_category_assigned_to_users
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