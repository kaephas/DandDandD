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
require_once 'model/option_functions.php';

session_start();

//create an instance of the Base class
$f3 = Base::instance();

$f3->set('DEBUG', 3);

$f3->set('glasses', generateGlasses());
$f3->set('types', generateIngTypes());


$db = new Database();

//Define a default route (dating splash page)
$f3->route('GET /', function()
{
    $view = new Template();
    echo $view->render('views/home.html');
});

$f3->route('GET|POST /find_drink', function()
{
   $view = new Template();
   echo $view->render('views/character.html');
});

$f3->route('GET|POST /add_drink', function()
{
    $view = new Template();
    echo $view->render('views/add_drink.html');
});

$f3->route('GET /drinks', function($f3) {
    global $db;
    $drinks = $db->getAllDrinks();

    $f3->set('drinks', $drinks);

    $view = new Template();
    echo $view->render('views/view_drinks.html');
});

// edit drinks
$f3->route('GET|POST /drinks/@drink', function($f3, $params) {
    $drink = $params['drink'];
    global $db;
    $info = $db->editDrink($drink);
    $f3->set('drink', $info);
//    $f3->set('drink', 'hello');
    $f3->set('ingTypes', $info->getType());
    $view = new Template();
    echo $view->render('views/edit_drink.html');
});

$f3->run();