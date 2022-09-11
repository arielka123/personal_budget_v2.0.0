<?php

namespace App;

/**
 * Application configuration
 *
 * PHP version 5.4
 */
class Config
{


    /**
     * Database host
     * @var string
     */
  
	 
    const DB_HOST = TWOJ_HOST;

    /**
     * Database name
     * @var string
     */
    const DB_NAME = TWOJA_BAZA;

    /**
     * Database user
     * @var string
     */
   const DB_USER = TWOJ_USER;

    /**
     * Database password
     * @var string
     */
   const DB_PASSWORD = TWOJE_HASŁO;

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = false;

    //secret key for hashing 

    const SECRET_KEY = TWOJ_KLUCZ;

    const SMTP = TWOJ_SMTP;
	
    const mailPassword =  TWOJE_HASŁO2;

    const adminMail =  TWOJ_MAIL;

   const adminMailName = TWOJ_ADRESAT;

}
