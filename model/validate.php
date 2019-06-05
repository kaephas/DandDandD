<?php
/**
 * Created by PhpStorm.
 * User: Kaephas
 * Date: 5/18/2019
 */

//TODO: Validation functions
function validInfo()
{
    global $f3;
    $isValid = true;

    if(!validName($f3->get('name'))) {
        $isValid = false;
        $f3->set('errors["name"]', 'Required');
    } else {
        if($f3->get('drink') instanceof Drink || $f3->get('drink') instanceof AlcoholDrink) {
            $f3->get('drink')->setName($f3->get('name'));
        }
    }

    $qtyErrors = validQty($f3->get('qtys'));
    if(sizeof($qtyErrors) > 0) {
        $isValid = false;
        $f3->set('errors["qty"]', $qtyErrors);
    } // drink qty updated in function

    $ingErrors = validIng($f3->get('ings'));
    if(sizeof($ingErrors) > 0) {
        $isValid = false;
        $f3->set('errors["ing"]', $ingErrors);
    }   // drink ing updated in function

    $typeErrors = validType($f3->get('types'));
    if(sizeof($typeErrors) > 0) {
        $isValid = false;
        $f3->set('errors["type"]', $typeErrors);
    }   // drink types updated in function

    // check if drink type conversion necessary and do so
    if($f3->get('drink') instanceof Drink || $f3->get('drink') instanceof AlcoholDrink) {
        convertDrink();
    }

    $shotsError = validShots($f3->get('shots'), $f3->get('types'));
    if(strlen($shotsError) > 0) {
        $isValid = false;
        $f3->set('errors["shots"]', $shotsError);
    } else {
        if($f3->get('drink')instanceof AlcoholDrink) {
            $f3->get('drink')->setShots($f3->get('shots'));
        }
    }

    $recError = validRecipe($f3->get('recipe'));
    if(strlen($recError) > 0) {
        $isValid = false;
        $f3->set('errors["recipe"]', $recError);
    } else {
        if($f3->get('drink') instanceof Drink || $f3->get('drink') instanceof AlcoholDrink) {
            $f3->get('drink')->setRecipe($f3->get('recipe'));
        }
    }

    return $isValid;
}

function validCharacter() {
    global $f3;
    $isValid = true;
    // valid name
    if(!validName($f3->get('name'))) {
        $f3->set("errors['name']", "Please type a name.");
        $isValid = false;
    }
    // valid class
    if(!validClass($f3->get('class'))) {
        $f3->set('errors["class"]', "Please choose a class.");
        $isValid = false;
    }
    // valid subclass
    if(!validSubclass($f3->get('sub'))) {
        $f3->set('errors["sub"]', "Please choose a subclass.");
        $isValid = false;
    }
    // valid alignment
    if(!validAlign($f3->get('alignment'))) {
        $f3->set('errors["alignment"]', "Please choose an alignment.");
        $isValid = false;
    }
    // valid background
    if(!validBack($f3->get('background'))) {
        $f3->set('errors["background"]', "Please choose a background");
        $isValid = false;
    }
    // valid age/alcoholic
    if(!validAge($f3->get('age'), $f3->get('alcoholic'))) {
        $isValid = false;
    }
    // valid stats
    if(!validStats($f3->get('stats'))) {
        $isValid = false;
    }
    return $isValid;

}

/**
 * Validates stat values chosen
 *
 * @param string[] $stats   list of stats values
 * @return bool $valid      if stats are valid
 */
function validStats($stats) {
    global $f3;
    $valid = true;
    $regex = "/^\d{1,2}$/";
    for($i = 0; $i < count($stats); $i++) {
        $val = $stats[$i];
        if(!preg_match($regex, $val)) {
            $f3->set("errors['stats'][$i]", "Invalid #");
            $valid = false;
        } elseif($val < 1 || $val > 30) {
            $f3->set("errors['stats'][$i]", "Invalid #");
            $valid = false;
        }
    }
    return $valid;
}

function validAge($age, $alc) {
    global $f3;
    $valid = true;
    if(!is_numeric($age)) {
        $f3->set("errors['age']", "Invalid age.");
        $valid = false;
    }
    if(is_numeric($age) && $age < 21) {
        if($alc == 'yes') {
            $until = 21 - $age;
            if($until == 1) {
                $f3->set("errors['alcoholic']", "Can't for 1 more year!");
            } else {
                $f3->set("errors['alcoholic']", "Wait $until more years.");
            }
            $valid = false;
        }
    }
    if($alc != 'no' && $alc != 'yes') {
        $f3->set("errors['alcoholic']", "Select one.");
        $valid = false;
    }
    return $valid;
}

function validBack($back) {
    $backs = generateBackgrounds();
    if(in_array($back, $backs)) {
        return true;
    } else {
        return false;
    }
}

function validAlign($align) {
    $aligns = generateAlignments();
    if(in_array($align, $aligns)) {
        return true;
    } else {
        return false;
    }
}

function validClass($class) {
    $classList = generateClasses();
    if(in_array($class, $classList)) {
        return true;
    } else {
        return false;
    }
}

function validSubclass($sub) {
    global $f3;
    $valid = true;
    $classSubs = generateSubClasses();
    $subclassList = $classSubs[$f3->get('class')];

    if(!in_array($sub, $subclassList)) {
        $valid = false;
    }
    return $valid;
}


function validRecipe($dir) {
    $error = '';
    if(empty($dir) || $dir == '') {
        $error = 'Required';
    }
    return $error;
}

function validName($name)
{
    // required field -- non-alpha ok since D&D people make weird names sometimes
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
            if($f3->get('drink') instanceof Drink || $f3->get('drink') instanceof AlcoholDrink) {
                $newQty = $f3->get('drink')->getQty();
                $newQty[$index] = $qty;
                $f3->get('drink')->setQty($newQty);
            }
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
            if($f3->get('drink') instanceof Drink || $f3->get('drink') instanceof AlcoholDrink) {
                $newIng = $f3->get('drink')->getIngredients();
                $newIng[$index] = $ing;
                $f3->get('drink')->setIngredients($newIng);
            }
        }
    }
    return $errors;
}

function validType($types) {
    global $f3;
    $errors = array();
    $validTypes = $f3->get('typeList');

    foreach($types as $index => $type) {
        if(!in_array($type, $validTypes)) {
            $errors[$index] = "Required";
        } else {
            if($f3->get('drink') instanceof Drink || $f3->get('drink') instanceof AlcoholDrink) {
                $newType = $f3->get('drink')->getType();
                $newType[$index] = $type;
                $f3->get('drink')->setType($newType);
            }
        }
    }
    return $errors;
}

function validShots($shots, $types) {
    global $f3;
    $error = '';
    $alcoholic = false;
    foreach ($types as $type) {
        if(in_array($type, $f3->get('alcohols'))) {
            $alcoholic = true;
        }
    }
    if($shots == 0 || $shots == '' || empty($shots)) {
        if($f3->get('drink') instanceof AlcoholDrink || $alcoholic) {
            $error = 'Required';
        }
    } elseif (!is_numeric($shots)) {
        $error = "Invalid";
    } elseif (is_numeric($shots) && $shots > 0 && !$alcoholic) {
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
//function validAge($age)
//{
//    // required field
//    return is_numeric($age) && $age >= 9 && $age <= 118;
//
//}


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
    global $newDrink;
    // $image = $_FILES['image']
    //$path = 'uploads/' . $image["name"];
    $upload = true;
    $type = strtolower(pathinfo($path,PATHINFO_EXTENSION));
    $check = getimagesize($image['tmp_name']);
    if($check !== false) {
        // is an image
        // if filepath already exists
        if(file_exists($path)) {
//            $f3->set("errors['image']", "Using existing file.");
            // if already exists, set Drink image to the file
            //$upload = false;
            //if($f3->get('drink') instanceof Drink) {
            if($newDrink instanceof Drink) {
               //TODO check add drink: $f3->get('drink')->setImage($path);
            } else {
                //TODO check add drink: $f3->set('drinkImg', $path);
            }
            // for add drink page
            $_SESSION['image'] = $path;
            // not uploaded, but can re-use path without uploading
            $f3->set('imgSource', $path);

            // for edit drink page
            $f3->set('newImage', 1);
            $_SESSION['imageAlready'] = $path;
//            unset($_SESSION['newImage']);

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