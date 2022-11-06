<?php

//front controller    


//ini_set('session_cookie_lifetime', '864000'); //ten days in sek

//composer
require_once '../vendor/autoload.php';



error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

session_start();

$router = new Core\Router();

/** add the routes */

/** Add the routes */
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('login',['controller' => 'Login', 'action' => 'new']);
$router->add('create',['controller' => 'Login', 'action' => 'create']);

$router->add('logout',['controller' => 'Login', 'action' => 'destroy']);

$router->add('password/reset/{token:[\da-f]+}',['controller' => 'Password', 'action' => 'reset']);
$router->add('password/forgot',['controller' => 'Password', 'action' => 'forgot']);
$router->add('request-reset',['controller' => 'Password', 'action' => 'request-reset']);

$router->add('signup/activate/{token:[\da-f]+}',['controller' => 'Signup', 'action' => 'activate']);
$router->add('signup',['controller' => 'Signup', 'action' => 'new']);
$router->add('signup/create',['controller' => 'Signup', 'action' => 'create']);

$router->add('income',['controller' => 'Income', 'action' => 'new']);
$router->add('income/save',['controller' => 'Income', 'action' => 'save']);

$router->add('expense',['controller' => 'Expense', 'action' => 'new']);
$router->add('expense/save',['controller' => 'Expense', 'action' => 'save']);


$router->add('balance',['controller' => 'Balance', 'action' => 'new']);

$router->add('profile-show',['controller' => 'Profile', 'action' => 'show']);
$router->add('profile-edit',['controller' => 'Profile', 'action' => 'edit']);    
$router->add('profile-update',['controller' => 'Profile', 'action' => 'update']);

$router->add('register',['controller' => 'Register', 'action' => 'new']);

$router->add('settings',['controller' => 'Settings', 'action' => 'new']);
$router->add('settings/deleteExpenseCategory',['controller' => 'Settings', 'action' => 'deleteExpCategory']);
$router->add('settings/deleteIncomeCategory',['controller' => 'Settings', 'action' => 'deleteIncCategory']);
$router->add('settings/deletePaymentCategory',['controller' => 'Settings', 'action' => 'deletePayCategory']);
$router->add('settings/addIncomeCategory',['controller' => 'Settings', 'action' => 'addIncomeCategory']);

$router->add('api/expenses', ['controller' => 'Register', 'action' => 'expenses']);
$router->add('api/incomes', ['controller' => 'Register', 'action' => 'incomes']);

$router->add('api/expenseCategories', ['controller' => 'Settings', 'action' => 'expenseCategories']);
$router->add('api/incomeCategories', ['controller' => 'Settings', 'action' => 'incomeCategories']);
$router->add('api/payments', ['controller' => 'Settings', 'action' => 'payments']);

$router->add('{controller}/{action}');
   
$router->dispatch($_SERVER['QUERY_STRING']);

?>