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

// enable debuffing
$f3->set('DEBUG', 3);

// arrays of option lists to be used in validation
$f3->set('glasses', generateGlasses());
$f3->set('typeList', generateIngTypes());
$f3->set('alcohols', array('cognac', 'gin', 'pisco', 'rum', 'tequila', 'vermouth', 'vodka', 'whiskey', 'liquor'));

// instantiate database connection object
$db = new Database();

//Define a default route (home page)
$f3->route('GET /', function($f3)
{
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
    // subclasses populated via ajax
    // TODO: is hive subclasses still used anywhere?
    $f3->set('subclasses', generateSubClasses());
    $f3->set('statsList', generateStats());
    $f3->set('alignments', generateAlignments());
    $f3->set('backgrounds', generateBackgrounds());

    // set class to artificer if no class chosen
    $class = $f3->get('class');
    if(!isset($class)) {
        $f3->set('class', 'Artificer');
    }

    // if posting form
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

            $f3->reroute('/result');    // views/result.html
        }
    }

    $view = new Template();
    echo $view->render('views/character.html');
});

// add a new drink to DB route
$f3->route('GET|POST /add_drink', function($f3)
{
    // only accessible by admins
    if(!isset($_SESSION['admin'])) {
        $f3->reroute('/');
    }

    global $db;
    $pageTitle = "Add a Drink";
    $f3->set('pageTitle', $pageTitle);

    // initial image is the default => overwritten after post if Session image is created
    $f3->set('imgSource', 'images/default.jpg');

    // after form posted
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
            // => allows use of same validation functions during edit drink
        $f3->set('drink', 'Not Drink');
        $validate = validInfo();

        $validateImg = true;
        // if a file has been selected to attempt image upload
        if(!empty($_FILES['drinkImg']['name'])) {
            $image = $_FILES['drinkImg'];

            // get storage path to attempt
            $path = 'images/' . basename($image["name"]);

            $f3->set('newImage', 2);
            $validateImg = validImage($image, $path);
            // if uploaded update Drink object
            if($validateImg) {
                // new image is set to 1 if image not uploaded but image choice was already on server
                if($f3->get('newImage') != 1) {
                    // $_SESSION['newImage'] = $path;
                    unset($_SESSION['image']);
                }
            } else {
                // image wasn't validated => change 2 to 0
                $f3->set('newImage', 0);
            }
        }

        // only time it should be set is if image was previously uploaded (duplicate file name)
        if(isset($_SESSION['image'])) {
            $f3->set('imgSource', $_SESSION['image']);
        }

        $validate = $validate && $validateImg;
        // image was validated but was a new image => have to re-attempt (no stickiness for security reasons)
        if($validateImg && !$validate && $f3->get('newImage') == 2){
            $f3->set('errors["image"]', 'Form error. Re-select image.');
        }

        // valid form and valid image
        if($validate) {
            // attempt to upload
            $upload = true;
            if(!empty($_FILES['drinkImg']['name'])) {
                if (move_uploaded_file($image['tmp_name'], $path)) {
                    $imageUpload = $path;
                    $_SESSION['image'] = $path;
                } else {
                    $upload = false;
                    $f3->set('errors["image"]', 'Error. Upload failed. Please try a different file.');
                }
            } elseif(isset($_SESSION['image'])) {
                // if no file to upload, but file was a previously stored image
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
                // if non-default image was chosen
                if (isset($imageUpload)) {
                    $drink->setImage($imageUpload);
                }
                // update database
                $updated = $db->addDrink($drink);
                if($updated) {
                    // reroute to drink summary => acknowledge success
                    $_SESSION['addition'] = "Success! You added " . $name . "!";

                    $f3->reroute('/drinks');
                } else {
                    // database connection failed either due to mismatched ingredient=>type or other reason
                    $f3->set('errors["db"]', 'Database error: check ingredient matches type, or try again later.');
                }
            }
        }
    }

    $view = new Template();
    echo $view->render('views/add_drink.html');
});

// view all drinks in datatable
$f3->route('GET /drinks', function($f3)
{
    // only viewable by admin
    if(!isset($_SESSION['admin'])) {
        $f3->reroute('/');
    }

    global $db;

    $pageTitle = "Drink List";
    $f3->set('pageTitle', $pageTitle);

    // get complete list of drinks from database
    $drinks = $db->getAllDrinks();
    $f3->set('drinks', $drinks);

    $view = new Template();
    echo $view->render('views/view_drinks.html');

    // remove session data to prevent loading incorrect data
    unset($_SESSION['deletion']);
    unset($_SESSION['addition']);
    unset($_SESSION['image']);
    unset($_SESSION['editSuccess']);
    unset($_SESSION['newImage']);
    unset($_SESSION['old']);
    unset($_SESSION['new']);
    unset($_SESSION['drink']);
    unset($_SESSION['imageAlready']);
});

// edit drinks route
$f3->route('GET|POST /drinks/@drink', function($f3, $params)
{
    // cannot edit drinks unless admin
    if(!isset($_SESSION['admin'])) {
        $f3->reroute('/');
    }

    $drink = $params['drink'];

    global $db;
    // get all drink info matching drink name
    $info = $db->getDrink($drink);

    $f3->set('drink', $info);
    // store old name in case name changes to still have access to database values
    $f3->set('oldName', $params['drink']);

    // set all initial hive values if first load
    if(empty($_POST)) {

        $f3->set('name', $info->getName());
        $f3->set('drinkGlass', $info->getGlass());
        $f3->set('qtys', $info->getQty());
        $f3->set('ings', $info->getIngredients());
        $f3->set('types', $info->getType());
        $f3->set('recipe', $info->getRecipe());

        if($info instanceof AlcoholDrink) {
            $f3->set('shots', $info->getShots());
        } else {
            $f3->set('shots', 0);
        }

        $f3->set('drinkImg', $info->getImage());

    }

    // after form posts
    if(!empty($_POST)) {
        // check session for stored image change (was set to previously existing image)
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

        $f3->set('name', $name);
        $f3->set('drinkGlass', $glass);
        $f3->set('shots', $shots);
        $f3->set('qtys', $qtys);
        $f3->set('ings', $ings);
        $f3->set('types', $types);
        $f3->set('recipe', $recipe);

        // overwrite old drink values with new (whether changed or not)
        $newDrink = $f3->get('drink');
        $newDrink->setName($name);
        $newDrink->setGlass($glass);
        $newDrink->setQty($qtys);
        $newDrink->setIngredients($ings);
        $newDrink->setType($types);
        $newDrink->setRecipe($recipe);
        $newDrink->setImage($info->getImage());
        if($newDrink instanceof AlcoholDrink) {
            $newDrink->setShots($shots);
        }

        $validate = validInfo();

        $validateImg = true;
        // if attempt to upload image
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

                    unset($_SESSION['imageAlready']);
                }
            }
        }

        $validate = $validate && $validateImg;
        // if form didn't validate but image did and wasn't an image previously on the server
        if(!$validate && $validateImg && !isset($_SESSION['imageAlready'])) {
            $f3->set('errors["image"]', 'Form error. Re-select image.');
        }

        if($validate) {
            // check for file upload success
            $upload = true;
            if(!empty($_FILES['drinkImg']['name'])) {
                if (move_uploaded_file($image['tmp_name'], $path)) {
                    // if file uploaded, update imageAlready in case db update fails for some reason
                    $_SESSION['imageAlready'] = $path;
                    $newDrink->setImage($path);
                } else {
                    $upload = false;
                    $f3->set('errors["image"]', 'Error. Upload failed. Please try a different file.');
                }
                // assigning image to a file already on server
            } elseif(isset($_SESSION['imageAlready'])) {
                $newDrink->setImage($_SESSION['imageAlready']);
            }
            // form validated, image uploaded
            if($upload) {
                // drink has been updated during validation
                // update database
                $updated = $db->updateDrink($newDrink, $f3->get('oldName'));
                // updating database was successful
                if($updated) {
                    $_SESSION['old'] = $f3->get('oldName');
                    $_SESSION['new'] = $newDrink->getName();
                    $_SESSION['drink'] = $newDrink;

                    // reroute to all drinks with notice of success
                    $_SESSION['editSuccess'] = "Success! You edited " . $_SESSION['new'] . "!";
                    $f3->reroute('/drinks');
                } else {
                    // database didn't update, possibly due to bad ingredient => type, could be server down
                    $f3->set("errors['db']", 'Database error: check ingredient and type matches, or try again later.');

                    $_SESSION['imageAlready'] = $newDrink->getImage();

                    $f3->set('drinkImg', $_SESSION['imageAlready']);

                }
            }
        } else {
            // form didn't validate
            if(isset($_SESSION['imageAlready'])) {
                // if validation failed and imageAlready changed or was newly set
                $f3->set('drinkImg', $_SESSION['imageAlready']);
            }
        }

    }

    $view = new Template();
    echo $view->render('views/edit_drink.html');
});

// drink deletion confirmation route
$f3->route('GET|POST /delete/@drink', function($f3, $params)
{
    // only admins
    if(!isset($_SESSION['admin'])) {
        $f3->reroute('/');
    }

    global $db;

    $drinkName = $params['drink'];
    // create a new Drink object from db info
    $info = $db->getDrink($drinkName);
    $f3->set('drink', $info);

    $f3->set('name', $info->getName());
    $f3->set('drinkGlass', $info->getGlass());
    $f3->set('qtys', $info->getQty());
    $f3->set('ings', $info->getIngredients());
    $f3->set('types', $info->getType());
    $f3->set('recipe', $info->getRecipe());
    $f3->set('drinkImg', $info->getImage());
    // set shots value accordingly
    if($info instanceof AlcoholDrink) {
        $f3->set('shots', $info->getShots());
    } else {
        $f3->set('shots', 0);
    }

    if(!empty($_POST['confirm'])) {
        $success = $db->deleteDrink($info->getName());
        // delete drink returns both if both drink and drink_ing junction data were removed
        if($success == 'both') {
            $_SESSION['deletion'] = 'Deletion successful.';
            $f3->reroute('/drinks');
        } else if($success = 'first'){
            // this really shouldn't happen, but a notice to manually delete from DB
            $f3->set("errors['delete']", 'Deletion error. Ingredients for ' . $drinkName . ' not deleted.');
        } else {
            $f3->set("errors['delete']", 'Deletion error. ' . $drinkName . ' not deleted.');
        }

    }

    $view = new Template();
    echo $view->render('views/delete_drink.html');
});

// matched drink route
$f3->route('GET /result', function($f3)
{
    // if somehow here without visiting character page
    if(!isset($_SESSION['drinkMatch']) || !isset($_SESSION['character'])) {
        $f3->reroute('/');
    }

    $f3->set('drink', $_SESSION['drinkMatch']);
    $f3->set('character', $_SESSION['character']);
    $f3->set('pageTitle', $_SESSION['drinkMatch']->getName());

    $view = new Template();
    echo $view->render('views/result.html');
});

// login page
$f3->route('GET|POST /login', function ($f3)
{
    global $db;

    if (isset($_POST['username'])) {

        $username = $_POST['username'];
        $password = $_POST['password'];

        $f3->set('username', $username);

        if ($db->validAdmin($username, $password)) {

            $_SESSION['admin'] = $username;

            $f3->reroute('/');
        }
    }
    // else load page with any error messages

    $view = new Template();
    echo $view->render('views/login.html');
});

// TODO: ONLY TO BE USED WITH INITIALIZING USER PASSWORDS
$f3->route('GET /setPW', function($f3)
{
    // should only be run intentionally and definitely only by an admin
    if(!isset($_SESSION['admin'])) {
        $f3->reroute('/');
    }
    global $db;
    $db->runOnce();

});

// unsets admin session then re-reroutes back home
$f3->route('GET /logout', function ($f3)
{

    unset($_SESSION['admin']);

   $f3->reroute('/');
});

$f3->run();