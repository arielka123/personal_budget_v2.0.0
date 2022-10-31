<?php

namespace App\Models;

use PDO;
use \App\Auth;
use App\Controllers\Balance;
use App\Models\User;


/**
 * Expense model
 *
 * PHP version 7.0
 */

class BalanceSheet  extends \Core\Model
{   
    public static function period()
    {
        unset($_SESSION['present_month']);
        unset($_SESSION['previous_month']);
        unset($_SESSION['non_standard']);
        unset($_SESSION['present_year']);
        unset($_SESSION['date1']);
        unset($_SESSION['date2']);
        
        $date = new BalanceSheet();
  
        if(!isset($_POST['wybor']))
        {
            $x=2;
        }
        else
        {
            $x =$_POST['wybor'];
        }
  

		$year=date('Y');          
		$month=date('m');
        $day=date('d');  
        $today= date('Y-m-d');
		$first_day="01"; 
    
        if($x=='1')
        {
            $_SESSION['previous_month']=true;
            if($month=='01')
            {
                $year=$year-1;
                $month='12';  
                
                $date1=$year."-".$month."-".$first_day;
                $last_day_month=date("Y-m-t", strtotime($date1));

                $date2=$last_day_month;
            }
    
            else if($month<=10)
            {
                $month=$month-1;
                $date1=$year."-0".$month."-".$first_day;
                $last_day_month=date("Y-m-t", strtotime($date1));

                $date2=$last_day_month;
            }
            else{

                $month=$month-1;
                $date1=$year."-".$month."-".$first_day;
                $last_day_month=date("Y-m-t", strtotime($date1));

                $date2=$last_day_month;
            }
        }
        else if($x=='2')
        {
            $date1=$year."-".$month."-".$first_day;
            $date2=$today;
            $_SESSION['present_month']=true;
        }   
        else if($x=='3')
        {
            $_SESSION['present_year']=true;

            $date1 = $year."-"."01-".$first_day;
            $date2=$today;
        }
        /** non-standard */
        else if($x=='4')
        {
            $_SESSION['non_standard']=true;

            if(isset($_POST['date1']) || isset($_POST['date2']))
            {
                $date1=$_POST['date1'];
                $date2=$_POST['date2'];

                if ($date1 >= $today)
                {
                    $date1=$today;
                }
                if ($date2 >= $today)
                {
                    $date2=$today;
                }

                if($date1>$date2)
                {
                    $temp = $date1;
                    $date1= $date2;
                    $date2 = $temp;
                }

               
            }
        }

        if (empty($date1) && empty($date2)) 
                {
                $pusty="";
                return false;
                }
      
        $date->date1 = $date1;
        $date->date2 = $date2;

        $_SESSION['date1']= $date1;
        $_SESSION['date2'] = $date2;

        return array($date1, $date2);
    }

   public static function loadIncomeResults()
   {

        list($date1, $date2) = BalanceSheet::period();    
       
        $user_id=Auth::getUserId();
       
	    $year=date('Y');  

        $sql = 'SELECT name, SUM(amount) as amount FROM incomes as i
            Join incomes_category_assigned_to_users as x ON i.income_category_assigned_to_user_id=x.id
            WHERE i.user_id=:user_id AND 
            i.date_of_income BETWEEN :date1 AND :date2
            GROUP BY name 
            ORDER BY amount DESC;';
        
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':date1', $date1, PDO::PARAM_STR);
        $stmt->bindValue(':date2', $date2, PDO::PARAM_STR);

        $stmt->execute();

        $result=  $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    

   public static function loadExpenseResults()
   {
        $user_id=Auth::getUserId();
        list($date1, $date2) = BalanceSheet::period();    

        $year=date('Y');  

        $sql = 'SELECT name, SUM(amount) as amount FROM expenses as e
            Join expenses_category_assigned_to_users as x ON e.expense_category_assigned_to_user_id=x.id
            WHERE e.user_id=:user_id AND 
            e.date_of_expense BETWEEN :date1 AND :date2
            GROUP BY name 
            ORDER BY amount DESC;';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':date1', $date1, PDO::PARAM_STR);
        $stmt->bindValue(':date2', $date2, PDO::PARAM_STR);

        $stmt->execute();

        $result=  $stmt->fetchAll(PDO::FETCH_ASSOC);

                //print_r($result);
        return $result;   
   }


   public static function getBalance()
   {

    $year=date('Y');          
    $month=date('m');
    $today= date('Y-m-d');
    $first_day="01"; 

    $date1=$year."-".$month."-".$first_day;
    $date2=$today;

    $user=Auth::getUser();
    $user_id= $user->id;

    $sql = 'SELECT SUM(amount) as amount FROM (
        SELECT -amount as amount
        FROM expenses as e
        WHERE e.user_id=:user_id AND 
        e.date_of_expense BETWEEN :date1 AND :date2
        UNION ALL
        SELECT amount 
        FROM incomes as i
        WHERE i.user_id=:user_id AND 
        i.date_of_income BETWEEN :date1 AND :date2 
        ) as w;' ; 

    $db = static::getDB();
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':date1', $date1, PDO::PARAM_STR);
    $stmt->bindValue(':date2', $date2, PDO::PARAM_STR);

    $stmt->execute();

    $result=  $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
        
   }
    
}
