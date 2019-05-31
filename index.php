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
$f3->set('typeList', generateIngTypes());
$f3->set('alcohols', array('cognac', 'gin', 'pisco', 'rum', 'tequila', 'vermouth', 'vodka', 'whiskey', 'liquor'));
$db = new Database();
//Define a default route (dating splash page)
$f3->route('GET /', function($f3)
{
    $pageTitle = "D&D&D";
    $f3->set('pageTitle', $pageTitle);
    $view = new Template();
    echo $view->render('views/home.html');
});
$f3->route('GET|POST /find_drink', function($f3)
{
    $pageTitle = "Find My Drink";
    $f3->set('pageTitle', $pageTitle);
    $f3->set('classes', generateClasses());
    // html generated by js, but validation from f3
    $f3->set('subclasses', generateSubClasses());
    $f3->set('stats', generateStats());
    $f3->set('alignments', generateAlignments());
    $f3->set('backgrounds', generateBackgrounds());
    if(!empty($_POST)) {
        $f3->set('name', $_POST['name']);
        $f3->set('class', $_POST['class']);
        $f3->set('sub', $_POST['sub']);
        $f3->set('alignment', $_POST['alignment']);
        $f3->set('background', $_POST['background']);
        $f3->set('age', $_POST['age']);
        $f3->set('stats', $_POST['stats']);
        $f3->set('alcoholic', $_POST['alcoholic']);
        $validate = validChar();
        if($validate) {
            // create character object and store in session
            // find matches
            // choose one drink and store in session
            $f3->reroute('result');
        }
    }
    $view = new Template();
    echo $view->render('views/character.html');
});
$f3->route('GET|POST /add_drink', function($f3)
{
    global $db;
    $pageTitle = "Add a Drink";
    $f3->set('pageTitle', $pageTitle);
    if(!empty($_POST)) {
        // validate
        $name = $_POST['name'];
        $glass = $_POST['glass'];
        $shots = $_POST['shots'];
        $qtys = $_POST['qtys'];
        $ings = $_POST['ings'];
        $types = $_POST['types'];
        $recipe = $_POST['recipe'];
        $f3->set('name', $name);
        $f3->set('drinkGlass', $glass);
        $f3->set('shots', $shots);
        $f3->set('qtys', $qtys);
        $f3->set('ings', $ings);
        $f3->set('types', $types);
        $f3->set('recipe', $recipe);
        // set drink to make sure not indicated as a Drink object during validation functions
        $f3->set('drink', 'Not Drink');
        $validate = validInfo();
        $validateImg = true;
        if(!empty($_FILES['drinkImg']['name'])) {
            $image = $_FILES['drinkImg'];
            // get storage path to attempt
            $path = 'images/' . basename($image["name"]);
            $validateImg = validImage($image, $path);
            // if uploaded update Drink object
            if($validateImg) {
                $f3->set('drinkImg', $path);
                $_SESSION['image'] = $path;
            }
        } else {
            $f3->set('drinkImg', $_SESSION['image']);
        }
        $validate = $validate && $validateImg;
        if($validate) {
            // create drink object
            if($shots == 0) {
                $drink = new Drink($name, $glass, $qtys, $ings, $types, $recipe);
            } else {
                $drink = new AlcoholDrink($name, $glass, $qtys, $ings, $types, $recipe);
                $drink->setShots($shots);
            }
            $image = $f3->get('drinkImg');
            if(isset($image)) {
                $drink->setImage($f3->get('drinkImg'));
            }
            // update database
            $db->addDrink($drink);
            // reroute to drink summary? acknowledge success?
            $_SESSION['drink'] = $drink;
            $f3->reroute('/test2');
        }
    }
    $view = new Template();
    echo $view->render('views/add_drink.html');
});
$f3->route('GET /drinks', function($f3) {
    global $db;
    $drinks = $db->getAllDrinks();
    $pageTitle = "Drink List";
    $f3->set('pageTitle', $pageTitle);
    $f3->set('drinks', $drinks);
    $view = new Template();
    echo $view->render('views/view_drinks.html');
    unset($_SESSION['deletion']);
});
// edit drinks
$f3->route('GET|POST /drinks/@drink', function($f3, $params) {
    $drink = $params['drink'];
    global $db;
    $info = $db->editDrink($drink);
    //TODO: store drink in session to be used to delete?
    $_SESSION['origDrink'] = $info;
    $f3->set('oldName', $info->getName());
    $f3->set('drink', $info);
    $f3->set('name', $info->getName());
    $f3->set('drinkGlass', $info->getGlass());
    $f3->set('qtys', $info->getQty());
    $f3->set('ings', $info->getIngredients());
    $f3->set('types', $info->getType());
    $f3->set('recipe', $info->getRecipe());
    $f3->set('drinkImg', $info->getImage());
    if(get_class($info) == 'AlcoholDrink') {
        $f3->set('shots', $info->getShots());
    } else {
        $f3->set('shots', 0);
    }
    if(!empty($_POST)) {
        // validate
        $name = $_POST['name'];
        $glass = $_POST['glass'];
        $shots = $_POST['shots'];
        $qtys = $_POST['qtys'];
        $ings = $_POST['ings'];
        $types = $_POST['types'];
        $recipe = $_POST['recipe'];
        $f3->set('name', $name);
        $f3->set('drinkGlass', $glass);
        $f3->set('shots', $shots);
        $f3->set('qtys', $qtys);
        $f3->set('ings', $ings);
        $f3->set('types', $types);
        $f3->set('recipe', $recipe);
        $validate = validInfo();
        $validateImg = true;
        if(!empty($_FILES['drinkImg']['name'])) {
            $image = $_FILES['drinkImg'];
            var_dump($f3->get('drinkImg'));
            // get storage path to attempt
            $path = 'images/' . basename($image["name"]);
            $validateImg = validImage($image, $path);
            // if uploaded update Drink object
            if($validateImg) {
                $f3->set('drinkImg', $path);
                $f3->get('drink')->setImage($path);
            }
        }else {
            $f3->set('drinkImg', $_SESSION['image']);
        }
        echo 'after valid: ';
        var_dump($f3->get('drinkImg'));
        echo '<br> drink value: ';
        print_r($f3->get('drink')->getImage());
        $f3->set('drinkImg', $f3->get('drink')->getImage());
        $validate = $validate && $validateImg;
        echo '<br>Drink info: ';
        var_dump($f3->get('drink'));
        if($validate) {
            $_SESSION['old'] = $f3->get('oldName');
            $_SESSION['new'] = $f3->get('drink')->getName();
            $_SESSION['drink'] = $f3->get('drink');
            // drink has been updated during validation
            // update database
            $db->updateDrink($f3->get('drink'), $f3->get('oldName'));
            // reroute to all drinks? Back to self with notice of success?
            $f3->reroute('/test');
        }
    }
    //$f3->set('ingTypes', $info->getType());
    $view = new Template();
    echo $view->render('views/edit_drink.html');
});
$f3->route('GET /test', function($f3) {
    $f3->set('old', $_SESSION['old']);
    $f3->set('new', $_SESSION['new']);
    $f3->set('drink', $_SESSION['drink']);
    $view = new Template();
    echo $view->render('views/test.html');
    session_destroy();
});
$f3->route('GET /test2', function($f3) {
    $view = new Template();
    echo $view->render('views/test2.html');
});
$f3->route('GET|POST /delete/@drink', function($f3, $params) {
    global $db;
    $drinkName = $params['drink'];
    $info = $db->editDrink($drinkName);
    $f3->set('drink', $info);
    $f3->set('name', $info->getName());
    $f3->set('drinkGlass', $info->getGlass());
    $f3->set('qtys', $info->getQty());
    $f3->set('ings', $info->getIngredients());
    $f3->set('types', $info->getType());
    $f3->set('recipe', $info->getRecipe());
    $f3->set('drinkImg', $info->getImage());
    if(get_class($info) == 'AlcoholDrink') {
        $f3->set('shots', $info->getShots());
    } else {
        $f3->set('shots', 0);
    }
    if(!empty($_POST['confirm'])) {
        $success = $db->deleteDrink($info->getName());
        if($success == 'both') {
            $_SESSION['deletion'] = 'Deletion successful.';
            $f3->reroute('/drinks');
        } else if($success = 'first'){
            echo 'Deletion error. Ingredients for ' . $drinkName . ' not deleted.';
        } else {
            echo 'Deletion error. Drink not deleted.';
        }
    }
    $view = new Template();
    echo $view->render('views/delete_drink.html');
});
$f3->run();