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
	
	//  const DB_HOST ="budget.arleta-madej.profesjonalnyprogramista.pl.mysql.dhosting.pl";
	//  const DB_NAME = "iso7ne_budgetar";
  //  const DB_USER = "rae4ah_budgetar";
  //  const DB_PASSWORD ="oQua5wohJaiv";
  
	 
    const DB_HOST = 'localhost';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = 'mvclogin';

    /**
     * Database user
     * @var string
     */
   const DB_USER = 'root';

    /**
     * Database password
     * @var string
     */
   const DB_PASSWORD = 'mysql';


	//const DB_PORT =90;

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = false;

    //secret key for hashing 

    const SECRET_KEY = 'D0yhwvV2bESiOy1RGfeLJGYEU6wMPJ92';

    const SMTP = 'smtp.gmail.com';
    const mailPassword = 'ilozkhhjzurpblyn';

    //const mailPassword = 'Personalbudget1234';
    const adminMail ='personalbudget.money@gmail.com';

   const adminMailName ='Twój Osobisty Budżet Domowy';

    // const mailPassword = '2ffefc09dd925d';
    // const adminUsername = '505cf6c25acf51';
}
