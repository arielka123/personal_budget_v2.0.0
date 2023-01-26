<?php

namespace App;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/PHPMailer-master/src/PHPMailer.php';
require 'vendor/PHPMailer-master/src/SMTP.php';
require 'vendor/PHPMailer-master/src/Exception.php';

use App\Config;
use App\Flash;

class Mail
{   
    /**
     * send a message
     * @param string $to Recipient
     * @param string $subject Subject
     * @param string $text text-only content af the message
     * @param string $html Html content af the message
     * 
     * @return mixed
     */

     public static function send($to, $subject, $text)
     {

        $mail = new PHPMailer();
        $mail->CharSet = "UTF-8";
        $mail->isSMTP();                                     
        $mail->Mailer = 'smtp';

        $mail->SMTPDebug  = 1;         
        $mail->Host = Config::SMTP;
        $mail->SMTPAuth   = true;
        $mail->Username = Config::adminMail;   /**  SMTP username*/
        $mail->Password = Config::mailPassword;
        $mail->SMTPSecure = 'tls';                         
        $mail->Port =587; /* 465;  or 587 */

        $mail->SetFrom(Config::adminMail,'Mailer');
        $mail->addAddress($to);               

        $mail->IsHTML(true);        

        /**
         * konfiguracja wiadomości
         */
        $mail->WordWrap = 50;                               
        $mail->Subject = $subject;     
        $img = '<img alt="PHPMailer" src="cid:my-attach">';
        $mail->Body    = $img.$text;
        $mail->AddEmbeddedImage("img/logo_personal_budget.png", "my-attach", "img/logo_personal_budget.png");

        if(!$mail->send()) {

          Flash::addMessage('Upss.. Wiadomość nie została wysłana. Przepraszamy za utrudnienia!', Flash::WARNING);
    
        } 
      }
}
