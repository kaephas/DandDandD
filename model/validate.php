<?php
/**
 * Contains a set of validation functions for all forms on the d&d&d site
 *
 * @author Kaephas & Zane
 * @version 1.0
 *
 */

/**
 * Validates all drink info and sets errors messages as needed
 * @return bool $isValid    if all info is valid
 */
function validInfo()
{
    global $f3;
    $isValid = true;

    // validate name
    if(!validName($f3->get('name'))) {
        $isValid = false;
        $f3->set('errors["name"]', 'Required');
    } else {
        if($f3->get('drink') instanceof Drink || $f3->get('drink') instanceof AlcoholDrink) {
            $f3->get('drink')->setName($f3->get('name'));
        }
    }

    // validate quantities -- drink qty updated in function
    $qtyErrors = validQty($f3->get('qtys'));
    if(sizeof($qtyErrors) > 0) {
        $isValid = false;
        $f3->set('errors["qty"]', $qtyErrors);
    }

    // validate ingredients -- drink ing updated in function
    $ingErrors = validIng($f3->get('ings'));
    if(sizeof($ingErrors) > 0) {
        $isValid = false;
        $f3->set('errors["ing"]', $ingErrors);
    }

    // validate types -- drink types updated in function
    $typeErrors = validType($f3->get('types'));
    if(sizeof($typeErrors) > 0) {
        $isValid = false;
        $f3->set('errors["type"]', $typeErrors);
    }

    // check if drink type conversion necessary and do so (if occurring in edit drink page)
    if($f3->get('drink') instanceof Drink || $f3->get('drink') instanceof AlcoholDrink) {
        convertDrink();
    }

    // validate shots
    $shotsError = validShots($f3->get('shots'), $f3->get('types'));
    if(strlen($shotsError) > 0) {
        $isValid = false;
        $f3->set('errors["shots"]', $shotsError);
    } else {
        if($f3->get('drink')instanceof AlcoholDrink) {
            $f3->get('drink')->setShots($f3->get('shots'));
        }
    }

    // validate recipe
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

/**
 * Validates all character form values and sets error messages as needed
 * @return bool $isValid    if all data is valid
 */
function validCharacter()
{
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
    // valid age/alcoholic (errors set in function)
    if(!validAge($f3->get('age'), $f3->get('alcoholic'))) {
        $isValid = false;
    }
    // valid stats (errors set in function)
    if(!validStats($f3->get('stats'))) {
        $isValid = false;
    }
    return $isValid;

}

/**
 * Validates stat values chosen and sets errors as needed
 *
 * @param string[] $stats   list of stats values
 * @return bool $valid      if stats are valid
 */
function validStats($stats)
{
    global $f3;
    $valid = true;
    // allows numeric between 1-30 (incl)
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

/**
 * Validates age, requiring >= 21 to choose alcoholic drink and sets errors as needed
 * @param int $age  the age of the character
 * @param string $alc   if the drink requested has alcohol
 * @return bool $valid  if age validates
 */
function validAge($age, $alc)
{
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
    // validate radio button
    if($alc != 'no' && $alc != 'yes') {
        $f3->set("errors['alcoholic']", "Select one.");
        $valid = false;
    }
    return $valid;
}

/**
 * Confirms that background chosen is in list of valid backgrounds
 * @param string $back  background chosen
 * @return bool $backs  if valid
 */
function validBack($back)
{
    $backs = generateBackgrounds();
    if(in_array($back, $backs)) {
        return true;
    } else {
        return false;
    }
}

/**
 * Confirms that alignment chosen is in list of valid alignments
 * @param string $align     the alignment chosen
 * @return bool $aligns     if valid
 */
function validAlign($align)
{
    $aligns = generateAlignments();
    if(in_array($align, $aligns)) {
        return true;
    } else {
        return false;
    }
}

/**
 * Confirms that class chosen is in the list of valid classes
 * @param string $class     the class chosen
 * @return bool             if valid
 */
function validClass($class)
{
    $classList = generateClasses();
    if(in_array($class, $classList)) {
        return true;
    } else {
        return false;
    }
}

/**
 * Confirms that the subclass chosen is in the list of valid subclasses
 * @param $sub
 * @return bool
 */
function validSubclass($sub)
{
    global $f3;
    $valid = true;
    $classSubs = generateSubClasses();
    $subclassList = $classSubs[$f3->get('class')];

    if(!in_array($sub, $subclassList)) {
        $valid = false;
    }
    return $valid;
}


/**
 * Confirms that the recipe is set
 * @param string $dir   the recipe
 * @return string   the error message
 */
function validRecipe($dir)
{
    $error = '';
    if(empty($dir) || $dir == '') {
        $error = 'Required';
    }
    return $error;
}


/**
 * Confirms that name is set, alpha not required since robots often have numbers or symbols in name
 * Also used for drinks, which can contain numerals--symbol acceptable
 * @param string $name  the character's name
 * @return bool     if set
 */
function validName($name)
{
    // required field -- non-alpha ok since D&D people make weird names sometimes
    return isset($name) && $name != "";
}

/**
 * Confirms that all quantities are set for all ingredients
 * @param string[] $qtys    all qty options
 * @return string[] $errors    errors for each qty box
 */
function validQty($qtys)
{
    global $f3;
    $errors = array();

    foreach($qtys as $index => $qty) {
        if($qty == "" || empty($qty)) {
            $errors[$index] = "Required";
        } else {
            // redundant condition but i'm scared to remove 2nd part...
            if($f3->get('drink') instanceof Drink || $f3->get('drink') instanceof AlcoholDrink) {
                // if editing a drink and quantity is valid, set drinks quantity to new value (stickiness)
                $newQty = $f3->get('drink')->getQty();
                $newQty[$index] = $qty;
                $f3->get('drink')->setQty($newQty);
            }
        }
    }
    return $errors;
}

/**
 * Confirms each ingredient field is set
 * @param string[] $ings    ingredients list
 * @return string[] $errors errors for each ingredient
 */
function validIng($ings)
{
    global $f3;
    $errors = array();

    foreach($ings as $index => $ing) {
        if($ing == "" || empty($ing)) {
            $errors[$index] = "Required";
        } else {
            // updates drink object for stickiness on edit drink page
            if($f3->get('drink') instanceof Drink || $f3->get('drink') instanceof AlcoholDrink) {
                $newIng = $f3->get('drink')->getIngredients();
                $newIng[$index] = $ing;
                $f3->get('drink')->setIngredients($newIng);
            }
        }
    }
    return $errors;
}

/**
 * Confirms each type is in valid list of types
 * @param string[] $types   the list of types
 * @return string[] $errors     errors for each type
 */
function validType($types)
{
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

/**
 * Confirms that shots is set and numeric if alcoholic beverage (contains alcohol types)
 * @param int $shots    the number of shots
 * @param string[] $types   the list of types
 * @return string $error    the error message
 */
function validShots($shots, $types)
{
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

/**
 * Converts a drink to alcoholic or back if gaining or losing alcohol based types
 * @return void
 */
function convertDrink()
{
    global $f3;
    $alcohol = false;
    // determine if any alcoholic ingredient types
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