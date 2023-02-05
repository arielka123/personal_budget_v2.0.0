<?php

namespace App\Models;

use App\Mail;
use PDO;
use \App\Token;
use \Core\View;
use \App\Auth;
use \App\Flash;


/**
 * User model
 *
 * PHP version 7.0
 */  
class User extends \Core\Model
{
    protected $password;
    protected $name;
    protected $email;
    protected $id;
    protected $activation_token;
    protected $password_reset_token;
    protected $expiry_timestamp;
    protected $remember_token;


    /**
     * Error messages
     *
     * @var array
     */
    public $errors = [];

    /**
     * Class constructor
     *
     * @param array $data  Initial property values (optional)
     *
     * @return void
     */
    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }

    /**
     * Save the user model with the current property values
     *
     * @return boolean  True if the user was saved, false otherwise
     */
    public function save()
    {
        $this->validate();    

        if (empty($this->errors)) {

            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

            $token = new Token();                 /////weryfikacja emailu przy zapisuwaniu
            $hashed_token = $token->getHash();
            $this->activation_token = $token->getValue();


            $sql_user = 'INSERT INTO users (name), email, password_hash, activation_hash)
                    VALUES (:name, :email, :password_hash, :activation_hash)';

            $db = static::getDB();
            $stmt = $db->prepare($sql_user);

            $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
            $stmt->bindValue(':activation_hash', $hashed_token, PDO::PARAM_STR);

            return $stmt->execute();
        }

        return false;
    }


    /**
     *  create data assigned to user , the select options can be modified by user
    **/


    public static function payment_methods_asigned_to_user($user_id)
    {
        $sql_income = 'INSERT INTO payment_methods_assigned_to_users (id, name, user_id)
        SELECT null, def.name, u.id
        FROM payment_methods_default as def
            JOIN users as u on u.id = :user_id
        where not exists (
            select *
            from payment_methods_assigned_to_users t2
            where t2.user_id = u.id
            and t2.name = def.name
        )';

        $db = static::getDB();
        $stmt = $db->prepare($sql_income);

        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);

        $stmt->execute();
    }

    public static function expenses_category_asigned_to_user($user_id)
    {

        $sql_income = 'INSERT INTO expenses_category_assigned_to_users (id, name, user_id)
        SELECT null, def.name, u.id
        FROM expenses_category_default as def
            JOIN users as u on u.id = :user_id
        where not exists (
            select *
            from expenses_category_assigned_to_users t2
            where t2.user_id = u.id
            and t2.name = def.name
        )';

        $db = static::getDB();
        $stmt = $db->prepare($sql_income);

        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);

        $stmt->execute();
    }    

    public static function incomes_category_asigned_to_user($user_id)
    {
        $sql_income = 'INSERT INTO incomes_category_assigned_to_users (name, user_id)
        	            SELECT def.name, u.id
        			    FROM incomes_category_default as def
         				JOIN users as u on u.id = :user_id
                        where not exists (
                            select *
                            from incomes_category_assigned_to_users t2
                            where t2.user_id = u.id
                            and t2.name = def.name
                        )';

         $db = static::getDB();
         $stmt = $db->prepare($sql_income);

         $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
         $stmt->bindValue(':active', 'Y', PDO::PARAM_INT);

     $stmt->execute();

    }

    public static function save_items_asigned_to_user($user_id)
    {
        User::incomes_category_asigned_to_user($user_id);
        User::expenses_category_asigned_to_user($user_id);
        User::payment_methods_asigned_to_user($user_id);
    }

    /**
     * Validate current property values, adding valiation error messages to the errors array property
     *
     * @return void
     */


    public function validate()     
    {
        /** Name */
        if ($this->name == '') {
           $this->errors[] = 'Wprowadź proszę swoje imie';
           Flash::addMessage('Wprowadź proszę swoje imie',
            Flash::WARNING);
        }
        
         /** email address  */
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
            $this->errors[] = 'Niepoprawny mail';
            Flash::addMessage('Niepoprawny mail !',
            Flash::WARNING);
        }
        if (static::emailExists($this->email, $this->id ?? null)) {  //The Null coalescing operator returns its first operand if it exists and is not NULL; otherwise it returns its second operand.
            $this->errors[] = 'Podany mail jest już zajęty';
            Flash::addMessage('Podany mail jest już zajęty',
            Flash::WARNING);
        }

        /** Password is saved if a value provided */

        if(isset($this->password)){
            if (strlen($this->password) < 6) {
               $this->errors[] = 'Wprowadź proszę hasło zawierające przynajmniej 6 znaków';
               Flash::addMessage('Wprowadź proszę hasło zawierające przynajmniej 6 znaków',
               Flash::WARNING);
            }

            if (preg_match('/.*[a-z]+.*/i', $this->password) == 0) {
                $this->errors[] = 'Hasło musi zawierać przynajmniej 1 literę';
                Flash::addMessage('Hasło musi zawierać przynajmniej 1 literę',
               Flash::WARNING);
            }

            if (preg_match('/.*\d+.*/i', $this->password) == 0) {
               $this->errors[] = 'Hasło musi zawierać przynajmniej 1 cyfrę';
               Flash::addMessage('Hasło musi zawierać przynajmniej 1 cyfrę',
               Flash::WARNING);
            }
        }
            
    }

    /**
     * See if a user record already exists with the specified email
     *
     * @param string $email email address to search for
     *
     * @return boolean  True if a record already exists with the specified email, false otherwise
     */
    public static function emailExists($email, $ignore_id = null)
    {
        $user = static::findByEmail($email);

        if($user){
            if ($user->id != $ignore_id){
            return true;
            }
        }

        return false;
    }

    /**
     * Find a user model by email address
     *
     * @param string $email email address to search for
     *
     * @return mixed User object if found, false otherwise
     */
    public static function findByEmail($email)
    {
        $sql = 'SELECT * FROM users WHERE email = :email';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     * Authenticate a user by email and password.
     *
     * @param string $email email address
     * @param string $password password
     *
     * @return mixed  The user object or false if authentication fails
     */
    public static function authenticate($email, $password)
    {
        $user = static::findByEmail($email);

        if ($user && $user->is_active) {
            if (password_verify($password, $user->password_hash)) {
                return $user;
            }
        }

        return false;
    }

    /**
     * Find a user model by ID
     *
     * @param string $id The user ID
     *
     * @return mixed User object if found, false otherwise
     */
    public static function findByID($id)
    {
        $sql = 'SELECT * FROM users WHERE id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     * Remember the login by inserting a new unique token into the remembered_logins table
     * for this user record
     *
     * @return boolean  True if the login was remembered successfully, false otherwise
     */
    public function rememberLogin()
    {
        $token = new Token();
        $hashed_token = $token->getHash();
        $this->remember_token = $token->getValue();

        $this->expiry_timestamp = time() + 60 * 60 * 24 * 30;  /**  30 days from now*/

        $sql = 'INSERT INTO remembered_logins (token_hash, user_id, expires_at)
                VALUES (:token_hash, :user_id, :expires_at)';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':expires_at', date('Y-m-d H:i:s', $this->expiry_timestamp), PDO::PARAM_STR);

        return $stmt->execute();
    }   

    public static function sendPasswordReset($email)
    {
        $user = static::findByEmail($email);

        if($user){
            if ($user->startPasswordReset())
            {
                $user->sendPasswordResetEmail();
            }
        }
    }


    protected function startPasswordReset()  /** protected function */
    {
        $token = new Token();
        $hashed_token = $token->getHash();
        $this->password_reset_token = $token->getValue();

        $expiry_timestamp = time() + 60 * 60 * 2; /**  2 hour from now*/

        $sql = 'UPDATE users
                SET password_reset_hash = :token_hash,
                    password_reset_expires_at = :expires_at
                WHERE id= :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt-> bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);
        $stmt->bindValue(':expires_at', date('Y-m-d H:i:s', $expiry_timestamp), PDO::PARAM_STR);
        $stmt-> bindValue(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();

    }

    /** send password reset instructions in an email to the user */

    protected function sendPasswordResetEmail()
    {
        $url = 'https://'.$_SERVER['HTTP_HOST'].'/password/reset/'.$this->password_reset_token;
      
        $text = View::getTemplate('Password/reset_email.html', ['url'=>$url]);

        Mail::send($this->email,'Ustaw nowe hasło', $text);
    }

    public static function findByPasswordReset($token)
    {
        $token = new Token($token);

        $hashed_token = $token->getHash();

        $sql = 'SELECT * FROM users
                WHERE password_reset_hash =:token_hash';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);

        $stmt-> setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        $user=  $stmt->fetch();

        if($user){
            /* check password reset token hasnt expired */

            if(strtotime($user->password_reset_expires_at)>time()){
                return $user;
            }
        }

    }

    public function resetPassword($password)
    {
        $this->password = $password;
        $this-> validate();     
        
        /**  verify if its empty or not*/
        if (empty($this->errors)){

            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

            $sql = 'UPDATE users
                    SET password_hash = :password_hash,
                        password_reset_hash = NULL,
                        password_reset_expires_at = NULL
                    WHERE id = :id';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
            $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);

            return $stmt->execute();
        }
        
        return false;
    }

    
    /** send an email to the user containing  the activation link */

    public function sendActivationEmail()
    {
        $url = 'https://'.$_SERVER['HTTP_HOST'].'/signup/activate/'.$this->activation_token;
      
        $text = View::getTemplate('Signup/activation_email.html', ['url'=>$url]);

        Mail::send($this->email,'Aktywacja konta użytkownika', $text);

    }


    /** 
    *skrypty automatyczne uruchamiane zaraz po utworzeniu nowego usera 
    *   User::save_items_asigned_to_user($user_id) po kliknieciu linka w mailu przez Usera
    **/
    public static function activate($value)
    {
        $token = new Token($value);
        $hashed_token = $token->getHash();
    /**  pobierz id nowego usera */
    $sql1 = 'SELECT id FROM users WHERE activation_hash = :hashed_token';

    $db = static::getDB();
    $stmt1 = $db->prepare($sql1);
    $stmt1->bindValue(':hashed_token', $hashed_token, PDO::PARAM_STR);

    $stmt1-> setFetchMode(PDO::FETCH_CLASS, get_called_class());

    $stmt1->execute();
    $user=  $stmt1->fetch();

    if (!isset($user->id))
    {
        return false;
    }

    $user_id = $user->id;

    User::save_items_asigned_to_user($user_id);


    $sql = 'UPDATE users
            SET is_active = 1, 
            activation_hash = null
            WHERE activation_hash = :hashed_token';
                
    $db = static::getDB();
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':hashed_token', $hashed_token, PDO::PARAM_STR);
    $stmt->execute();
    }

    public function updateProfile($data)
    {
        $this->name = $data['name'];
        $this->email = $data['email'];
       
       //only validate and update the password if a  value provided
       if($data['password']!=''){
        $this->password = $data['password'];
       }

        $this->validate();

        if(empty($this->errors)){
            $sql = 'UPDATE users
                    SET name =:name,
                        email=:email';
        
        /** Add password if it is set */
        if(isset($this->password)){
            $sql.=', password_hash=:password_hash';
        }

        $sql .="\nWHERE id=:id";

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_STR);

        if(isset($this->password)){
            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);
            $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);        
        }
        

        return $stmt->execute();

        }

        return false;

    }
}
