<?php
/**
 * Created by PhpStorm.
 * User: Kaephas
 * Date: 5/18/2019
 * Time: 10:02
 */

//Turn on error reporting
ini_set('display_errors' ,1);
ini_set('file_uploads', 1);
error_reporting(E_ALL);

//require autoload file
require_once 'vendor/autoload.php';
require_once 'model/validate.php';

session_start();

//create an instance of the Base class
$f3 = Base::instance();

$f3->set('DEBUG', 3);

//Define a default route (dating splash page)
$f3->route('GET /', function()
{
    $view = new Template();
    echo $view->render('views/home.html');
});