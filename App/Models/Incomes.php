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
                                    WHERE user_id = :user_id';

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
}