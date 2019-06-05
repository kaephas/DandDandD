<?php
/**
 * Created by PhpStorm.
 * User: Kaephas, Zane
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
    session_destroy();
    $pageTitle = "D&D&D";
    $f3->set('pageTitle', $pageTitle);

    $view = new Template();
    echo $view->render('views/home.html');
});

// fill out character data route
$f3->route('GET|POST /find_drink', function($f3)
{
    global $db;

    $pageTitle = "Find My Drink";
    $f3->set('pageTitle', $pageTitle);

    $f3->set('classes', generateClasses());
    // html generated by js, but validation from f3
    $f3->set('subclasses', generateSubClasses());
    $f3->set('statsList', generateStats());
    $f3->set('alignments', generateAlignments());
    $f3->set('backgrounds', generateBackgrounds());

    //TODO is this section needed?
    $hello = $f3->get('class');
    if(!isset($hello)) {
        $f3->set('class', 'Artificer');
    }
    // end TODO

    if(!empty($_POST)) {
        $f3->set('name', $_POST['name']);
        $f3->set('class', $_POST['class']);
        $f3->set('sub', $_POST['sub']);
        $f3->set('alignment', $_POST['alignment']);
        $f3->set('background', $_POST['background']);
        $f3->set('age', $_POST['age']);
        $f3->set('stats', $_POST['stats']);
        $f3->set('alcoholic', $_POST['alcoholic']);

        // for getClassInfo.php
        $_SESSION['sub'] = $_POST['sub'];

        $validate = validCharacter();

        if($validate) {
            // create character object and store in session
            $image = strtolower($f3->get('class'));
            $image = "images/$image.jpg";
            $_SESSION['character'] = new Character(
                $f3->get('name'), $f3->get('class'), $f3->get('sub'),
                $f3->get('alignment'), $f3->get('background'), $f3->get('age'),
                $f3->get('stats'), $f3->get('alcoholic'), $image
            );
            // find matches
            $_SESSION['drinkMatch'] = $db->getDrinkMatch($_SESSION['character']);
            // choose one drink and store in session

            $f3->reroute('/result');
        }
    }

    $view = new Template();
//    echo $view->render('views/character.html');
    echo $view->render('views/character.html');
});

// add a new drink to DB route
$f3->route('GET|POST /add_drink', function($f3)
{
    global $db;
    $pageTitle = "Add a Drink";
    $f3->set('pageTitle', $pageTitle);
    $f3->set('imgSource', 'images/default.jpg');

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

            $f3->set('newImage', 0);
            $validateImg = validImage($image, $path);
            // if uploaded update Drink object
            if($validateImg) {
                //$f3->get('drink')->setImage($path);
                if($f3->get('newImage') != 1) {
                    // $_SESSION['newImage'] = $path;
                    unset($_SESSION['image']);
                }
            }
        }

        // only time it should be set is if image was previously uploaded (duplicate file name)
        if(isset($_SESSION['image'])) {
            $f3->set('imgSource', $_SESSION['image']);
        }

        $validate = $validate && $validateImg;
        if($validateImg && !$validate && !isset($_SESSION['image'])){
            $f3->set('errors["image"]', 'Form error. Re-select image.');
        }

        if($validate) {
            // check for file upload success
            $upload = true;
            if(!empty($_FILES['drinkImg']['name'])) {
                if (move_uploaded_file($image['tmp_name'], $path)) {
                    $imageUpload = $path;
                } else {
                    $upload = false;
                    $f3->set('errors["image"]', 'Error. Upload failed. Please try a different file.');
                }
            } elseif(isset($_SESSION['image'])) {
                $imageUpload = $_SESSION['image'];
            }

            if($upload) {
                // create drink object
                if ($shots == 0) {
                    $drink = new Drink($name, $glass, $qtys, $ings, $types, $recipe);
                } else {
                    $drink = new AlcoholDrink($name, $glass, $qtys, $ings, $types, $recipe);
                    $drink->setShots($shots);
                }
//                $image = $f3->get('drinkImg');
                if (isset($imageUpload)) {
                    $drink->setImage($imageUpload);
                }
                // update database
                $updated = $db->addDrink($drink);
                if($updated) {
                    // TODO: check if this session variable is still used
                    unset($_SESSION['drink']);
                    // reroute to drink summary? acknowledge success?
                    $_SESSION['addition'] = "Success! You added " . $name . "!";

                    $f3->reroute('/drinks');
                } else {
                    $f3->set('errors["db"]', 'Database error: check ingredient matches type, or try again later.');
                }
                //$_SESSION['drink'] = $drink;
                //$f3->reroute('/test2');
//                echo 'Ingredients: ';
//                print_r($f3->get('ings'));
//                echo '<br>Types: ';
//                print_r($f3->get('types'));
//                echo '<br>All Drink info: ';
//                print_r($drink);

            }
        }
    }

    $view = new Template();
    echo $view->render('views/add_drink.html');
});

// view all drinks in datatable
$f3->route('GET /drinks', function($f3) {
    global $db;
    $drinks = $db->getAllDrinks();

    $pageTitle = "Drink List";
    $f3->set('pageTitle', $pageTitle);

    $f3->set('drinks', $drinks);

    $view = new Template();
    echo $view->render('views/view_drinks.html');

    // remove session data to prevent loading incorrect data
//    unset($_SESSION['deletion']);
//    unset($_SESSION['addition']);
//    unset($_SESSION['image']);
//    unset($_SESSION['editSuccess']);
//    unset($_SESSION['newImage']);
//    unset($_SESSION['old']);
//    unset($_SESSION['new']);
//    unset($_SESSION['drink']);
//    unset($_SESSION['imageAlready']);
    //TODO swap to commented if adding user logon
    session_destroy();
});

// edit drinks route
$f3->route('GET|POST /drinks/@drink', function($f3, $params) {
    $drink = $params['drink'];
    global $db;
    $info = $db->getDrink($drink);

    $f3->set('drink', $info);
    $f3->set('oldName', $params['drink']);

    // set all initial value if first load
    if(empty($_POST)) {

        $f3->set('name', $info->getName());
        $f3->set('drinkGlass', $info->getGlass());
        $f3->set('qtys', $info->getQty());
        $f3->set('ings', $info->getIngredients());
        $f3->set('types', $info->getType());
        $f3->set('recipe', $info->getRecipe());

        if(get_class($info) == 'AlcoholDrink') {
            $f3->set('shots', $info->getShots());
        } else {
            $f3->set('shots', 0);
        }

        $f3->set('drinkImg', $info->getImage());

    }

    if(!empty($_POST)) {
        if(isset($_SESSION['imageAlready'])) {
            $f3->set('drinkImg', $_SESSION['imageAlready']);
        } else {
            $f3->set('drinkImg', $info->getImage());
        }

        // validate
        $name = $_POST['name'];
        $glass = $_POST['glass'];
        $shots = $_POST['shots'];
        $qtys = $_POST['qtys'];
        $ings = $_POST['ings'];
        $types = $_POST['types'];
        $recipe = $_POST['recipe'];

//        // check if row was removed
//        if(count($ings) != count($info->getIngredients())) {
//            $_SESSION['newIngs'] = $ings;
//        }

        $f3->set('name', $name);
        $f3->set('drinkGlass', $glass);
        $f3->set('shots', $shots);
        $f3->set('qtys', $qtys);
        $f3->set('ings', $ings);
        $f3->set('types', $types);
        $f3->set('recipe', $recipe);

        //$f3->get('drink')->setName($name);
        $newDrink = $f3->get('drink');
        $newDrink->setName($name);
        $newDrink->setGlass($glass);
        $newDrink->setShots($shots);
        $newDrink->setQty($qtys);
        $newDrink->setIngredients($ings);
        $newDrink->setType($types);
        $newDrink->setRecipe($recipe);
        $newDrink->setImage($info->getImage());

        $validate = validInfo();

        $validateImg = true;
        if(!empty($_FILES['drinkImg']['name'])) {
            $image = $_FILES['drinkImg'];
//            var_dump($f3->get('drinkImg'));
            // get storage path to attempt
            $path = 'images/' . basename($image["name"]);
            $f3->set('newImage', 0);
            $validateImg = validImage($image, $path);
            // if uploaded update Drink object
            if($validateImg) {
                //$f3->get('drink')->setImage($path);
                if($f3->get('newImage') != 1) {
                    // $_SESSION['newImage'] = $path;

                    unset($_SESSION['imageAlready']);
                }
            }
        }

        $validate = $validate && $validateImg;
        if(!$validate && $validateImg && !isset($_SESSION['imageAlready'])) {
            $f3->set('errors["image"]', 'Form error. Re-select image.');
        }

        if($validate) {
            // check for file upload success
            $upload = true;
            if(!empty($_FILES['drinkImg']['name'])) {
                if (move_uploaded_file($image['tmp_name'], $path)) {
                    $newDrink->setImage($path);
                } else {
                    $upload = false;
                    $f3->set('errors["image"]', 'Error. Upload failed. Please try a different file.');
                }
                // assigning image to a file already on server
            } elseif(isset($_SESSION['imageAlready'])) {
                $newDrink->setImage($_SESSION['imageAlready']);
            }

            if($upload) {
                // drink has been updated during validation
                // update database
                $updated = $db->updateDrink($newDrink, $f3->get('oldName'));

                if($updated) {

                    $_SESSION['old'] = $f3->get('oldName');
                    $_SESSION['new'] = $newDrink->getName();
                    $_SESSION['drink'] = $newDrink;
                    // reroute to all drinks? Back to self with notice of success?
                    $_SESSION['editSuccess'] = "Success! You edited " . $_SESSION['new'] . "!";
//            $f3->reroute('/test');

//                    echo $newDrink->prettify();
//                    echo '<br>Post ingredients: ';
//                    print_r($_POST['ings']);

                    $f3->reroute('/drinks');
                } else {
                    $f3->set("errors['db']", 'Database error: check ingredient and type matches and
                     redo image choice if necessary, or try again later.');
                    // TODO: TEST -> set ing=>type wrong and change image to both already existing and new
                    $_SESSION['imageAlready'] = $newDrink->getImage();
                    // TODO does this fix?
                    $f3->set('drinkImg', $_SESSION['imageAlready']);

                    // TODO: Remove when done testing
                    echo $newDrink->prettify();
                    echo '<br>Post ingredients: ';
                    print_r($_POST['ings']);
                }
            }
        } else {
            if(isset($_SESSION['imageAlready'])) {
                // if validation failed and imageAlready changed or was newly set
                $f3->set('drinkImg', $_SESSION['imageAlready']);
            }// else {
//                $f3->set('drinkImg', $info->getImage());
//            }
            // TODO: Remove when done testing
            echo $newDrink->prettify();
            echo '<br>Post ingredients: ';
            print_r($_POST['ings']);
        }

    }
    //$f3->set('ingTypes', $info->getType());
    $view = new Template();
    echo $view->render('views/edit_drink.html');
});


$f3->route('GET|POST /delete/@drink', function($f3, $params) {
    global $db;
    $drinkName = $params['drink'];
    $info = $db->getDrink($drinkName);
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

$f3->route('GET /result', function($f3) {
    if(!isset($_SESSION['drinkMatch']) || !isset($_SESSION['character'])) {
        $f3->reroute('/');
    }

    $f3->set('drink', $_SESSION['drinkMatch']);
    $f3->set('character', $_SESSION['character']);
//    $drinkname = $_SESSION['drinkMatch']->getName();
//    echo $drinkname;
    $f3->set('pageTitle', $_SESSION['drinkMatch']->getName());

    $view = new Template();
    echo $view->render('views/result.html');
//    session_destroy();


});

$f3->route('GET|POST /login', function ($f3){
    global $f3;
    global $db;

    $username = $_POST['username'];
    $password = $_POST['password'];

    $f3->set('username', $username);
    $f3->set('password', $password);

    if ($db->validAdmin($username, $password)) {
        $_SESSION['admin'] = $username;

        $f3->reroute('/');
    } else {
        echo '<div class="alert alert-danger">No Admin rights.</div>';
    }

    $view = new Template();
    echo $view->render('views/login.html');
});


//TODO: REMOVE test ajax view
$f3->route('GET /testAjax', function($f3) {
    $f3->set('pageTitle', 'Test Ajax');
    $view = new Template();
    echo $view->render('views/testAjax.html');
});

// TODO: DELETE when done testing
$f3->route('GET /test', function($f3) {
    $f3->set('old', $_SESSION['old']);
    $f3->set('new', $_SESSION['new']);
    $f3->set('drink', $_SESSION['drink']);

    $view = new Template();
    echo $view->render('views/test.html');

    session_destroy();
});

// TODO: Delete when done testing
$f3->route('GET /test2', function($f3) {

    $view = new Template();
    echo $view->render('views/test2.html');
    session_destroy();
});


$f3->run();
