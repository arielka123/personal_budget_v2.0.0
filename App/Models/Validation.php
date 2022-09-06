<?php

namespace App\Models;

use PDO;
use \App\Flash;

class Validation extends \Core\Model
{   

    public static function validate_comment ()
    {
        $comment = $_POST['comment'];
        $comment= htmlentities($comment, ENT_QUOTES, "UTF-8");

        return $comment;
    }

    public static function validate_amount ()
    {

        $amount = $_POST['amount'];
        $amount =trim($amount);
		$amount = str_replace(",",".",$amount);

		// weryfikuje podaną kwotę
		if ($amount ==0)
        {
            Flash::addMessage('Nie wprowadzono kwoty!',
            Flash::WARNING);
        
			return false;
        }
		
		if (is_numeric($amount)!=1)
		{
            Flash::addMessage('Niepoprawny format kwoty. Usuń wszystkie litery i znaki!',
            Flash::WARNING);
        
			return false;
		}     

		if($amount<=0)
		{
            Flash::addMessage('Wprowadź kwotę większą od zera!', Flash::WARNING);
			return false;
		}

        return $amount;
		
    }


}
