<?php
/**
 * Created by PhpStorm.
 * User: Kaephas
 * Date: 5/18/2019
 * Time: 10:10
 */

//TODO: Validation functions
function validInfo()
{
    global $f3;
    $isValid = true;
//    if(!validQty($f3->get('qty'))) {
//        $isValid = false;
//        $f3->set('errors["email"]', "Please enter a valid email.");
//    }
    echo '<br><h2>Pre validation functions.</h2>';
    echo '<br>var dump: ';
    var_dump($isValid);

    if(!validName($f3->get('name'))) {
        $isValid = false;
        $f3->set('errors["name"]', 'Required');
    } else {
        $f3->get('drink')->setName($f3->get('name'));
    }
    echo '<br>var dump: ';
    var_dump($isValid);
    $qtyErrors = validQty($f3->get('qtys'));
    if(sizeof($qtyErrors) > 0) {
        $isValid = false;
        $f3->set('errors["qty"]', $qtyErrors);
    } // drink qty updated in function
    echo '<br>var dump: ';
    var_dump($isValid);
    $ingErrors = validIng($f3->get('ings'));
    if(sizeof($ingErrors) > 0) {
        $isValid = false;
        $f3->set('errors["ing"]', $ingErrors);
    }   // drink ing updated in function
    echo '<br>var dump: ';
    var_dump($isValid);
    $typeErrors = validType($f3->get('types'));
    if(sizeof($typeErrors) > 0) {
        $isValid = false;
        $f3->set('errors["type"]', $typeErrors);
    }   // drink types updated in function
    echo '<br>var dump: ';
    var_dump($isValid);
    // check if drink type conversion necessary and do so
    convertDrink();
    echo '<br>var dump: ';
    var_dump($isValid);
    $shotsError = validShots($f3->get('shots'));
    if(strlen($shotsError) > 0) {
        $isValid = false;
        $f3->set('errors["shots"]', $shotsError);
    } else {
        if(get_class($f3->get('drink')) == 'AlcoholDrink') {
            $f3->get('drink')->setShots($f3->get('shots'));
        }
    }
    echo '<br>var dump: ';
    var_dump($isValid);
    $recError = validRecipe($f3->get('recipe'));
    if(strlen($recError) > 0) {
        $isValid = false;
        $f3->set('errors["recipe"]', $recError);
    } else {
        $f3->get('drink')->setRecipe($f3->get('recipe'));
    }
    echo '<br>var dump: ';
    var_dump($isValid);
    echo '<br><h2>Post validation functions.';
    return $isValid;
}



function validRecipe($dir) {
    global $f3;
    $error = '';
    if(empty($dir) || $dir == '') {
        $error = 'Required';
    }
    return $error;
}

function validName($name)
{
    // required field
    return isset($name) && $name != "";

}

/**
 * @param array $qtys    all qty options
 * @return array $errors    errors from each qty box
 */
function validQty($qtys) {
    global $f3;
    $errors = array();

    foreach($qtys as $index => $qty) {
        if($qty == "" || empty($qty)) {
            $errors[$index] = "Required";
        } else {
            $newQty = $f3->get('drink')->getQty();
            $newQty[$index] = $qty;
            $f3->get('drink')->setQty($newQty);
        }
    }
    return $errors;
}

function validIng($ings) {
    global $f3;
    $errors = array();

    foreach($ings as $index => $ing) {
        if($ing == "" || empty($ing)) {
            $errors[$index] = "Required";
        } else {
            $newIng = $f3->get('drink')->getIngredients();
            $newIng[$index] = $ing;
            $f3->get('drink')->setIngredients($newIng);
        }
    }
    return $errors;
}

function validType($types) {
    global $f3;
    $errors = array();
    $validTypes = $f3->get('typeList');
    echo '<br>Valid types: ';
    var_dump($validTypes);
    echo '<br>Drink types: ';
    var_dump($types);
    foreach($types as $index => $type) {
        if(!in_array($type, $validTypes)) {
            echo '<br>Error with: ' . $type;
            $errors[$index] = "Required";
        } else {
            $newType = $f3->get('drink')->getType();
            $newType[$index] = $type;
            $f3->get('drink')->setType($newType);
        }
    }
    return $errors;
}

function validShots($shots) {
    global $f3;
    $error = '';

    if($shots == 0 || $shots == '' || empty($shots)) {
        if(get_class($f3->get('drink')) == 'AlcoholDrink') {
            $error = 'Required';
        }
    } elseif (!is_numeric($shots)) {
        $error = "Invalid";
    } elseif (is_numeric($shots) && $shots > 0 && get_class($f3->get('drink')) == 'Drink') {
        $error = 'Impossible';
    }
    return $error;
}


/**
 * Checks if an age is valid
 *
 * must be numeric and between 19 and 118 inclusive
 *
 * @param int $age  the age to be checked
 * @return bool     if the age is valid
 */
function validAge($age)
{
    // required field
    return is_numeric($age) && $age >= 9 && $age <= 118;

}


/**
 * Checks if an image is valid for upload
 *
 * @param array $image      File info for profile image
 * @param string $path      the path of the image to be checked
 * @return bool             if the image is valid
 */
function validImage($image, $path)
{
    global $f3;
    // $image = $_FILES['image']
    //$path = 'uploads/' . $image["name"];
    $upload = true;
    $type = strtolower(pathinfo($path,PATHINFO_EXTENSION));
    $check = getimagesize($image['tmp_name']);
    if($check !== false) {
        // is an image
        // if filepath already exists
        if(file_exists($path)) {
//            $f3->set("errors['image']", "File already exists.");
            // if already exists, set Drink image to the file
            $upload = false;
            $f3->get('drink')->setImage($path);
            // if not correct file type
        } elseif (!($type == 'jpg' || $type == 'png' || $type == 'jpeg')) {
            $f3->set("errors['image']", "Please choose a png, jpg, or jpeg.");
            $upload = false;
        }
    } else {
        $f3->set("errors['image']", "That file isn't an image.");
        $upload = false;
    }
    return $upload;
}

function convertDrink() {
    global $f3;
    $alcohol = false;

    foreach($f3->get('drink')->getType() as $type) {
        if(in_array($type, $f3->get('alcohols'))) {
            $alcohol = true;
        }
    }
    // if alcohol added, convert to alcoholic drink and vise versa
    if(get_class($f3->get('drink')) == 'Drink' && $alcohol) {
        $oldDrink = $f3->get('drink');

        $newName = $oldDrink->getName();
        $newGlass = $oldDrink->getGlass();
        $newQty = $oldDrink->getQty();
        $newIng = $oldDrink->getIngredients();
        $newType = $oldDrink->getType();
        $newRec = $oldDrink->getRecipe();
        $newImg = $oldDrink->getImage();

        $newDrink = new AlcoholDrink($newName, $newGlass, $newQty, $newIng, $newType, $newRec, $newImg);
        $newDrink->setShots($f3->get('shots'));
        // replace drink in hive
        $f3->set('drink', $newDrink);
    } elseif(get_class($f3->get('drink')) == 'AlcoholDrink' && !$alcohol) {
        $oldDrink = $f3->get('drink');

        $newName = $oldDrink->getName();
        $newGlass = $oldDrink->getGlass();
        $newQty = $oldDrink->getQty();
        $newIng = $oldDrink->getIngredients();
        $newType = $oldDrink->getType();
        $newRec = $oldDrink->getRecipe();
        $newImg = $oldDrink->getImage();

        $newDrink = new Drink($newName, $newGlass, $newQty, $newIng, $newType, $newRec, $newImg);
        // replace drink in hive
        $f3->set('drink', $newDrink);
    }
}