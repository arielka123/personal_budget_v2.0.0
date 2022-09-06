<?php

namespace App;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

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

     public static function send($to, $subject, $text)//$to, $subject, $text, $html
     {

        $mail = new PHPMailer();
        $mail->CharSet = "UTF-8";
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Mailer = 'smtp';


        //mailtrap 

       // $mail->Host = 'smtp.mailtrap.io';
        // $mail->SMTPAuth = true;                               // Enable SMTP authentication
      //  $mail->Port = 2525;
        // $mail->Username = '505cf6c25acf51';
        // $mail->Password = '2ffefc09dd925d';
        // $mail->IsHTML(true);

        //gmail

        $mail->SMTPDebug  = 1;         
        $mail->Host = Config::SMTP;
        $mail->SMTPAuth   = true;
        $mail->Username = Config::adminMail;   // SMTP username
        $mail->Password = Config::mailPassword;
        $mail->SMTPSecure = 'tls';                            // Enable encryption, only 'tls' is accepted
        $mail->Port =587; //465; // or 587

        $mail->SetFrom(Config::adminMail,'Mailer');
        $mail->addAddress($to);                 // Add a recipient

        $mail->IsHTML(true);
        //$mail->SetFrom(Config::adminMail,Config::adminMailName, 0);
        

        //onet
                
        // $mail->SMTPDebug  = 1;  
        // $mail->SMTPAuth   = TRUE;
        // $mail->SMTPSecure = 'ssl';                            // Enable encryption, only 'tls' is accepted
        // $mail->Port =465; //465; // or 587
        // $mail->Host = 'smtp.poczta.onet.pl';
        // $mail->Username = Config::adminMail;   // SMTP username
        // $mail->Password = Config::mailPassword;                           // SMTP password
        // $mail->IsHTML(true);
        // $mail->SetFrom(Config::adminMail,Config::adminMailName, 0);
        

        /**
         * konfiguracja wiadomości
         */
        $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
        $mail->Subject = $subject;     
        $img = '<img alt="PHPMailer" src="cid:my-attach">';
        $mail->Body    = $img.$text;
        $mail->AddEmbeddedImage("img/logo_personal_budget.png", "my-attach", "img/logo_personal_budget.png");

        if(!$mail->send()) {

          //Flash::addMessage('Upss.. Wiadomość nie została wysłana. Przepraszamy za utrudnienia!', Flash::WARNING);
          echo 'Wiadmość nie została wysłana.';
         // echo 'Mailer Error: ' . $mail->ErrorInfo;
        } 
      }
}


// mailPassword = '2ffefc09dd925d';
// const adminUsername = '505cf6c25acf51'
// }