<?php
/**
 * Loaded dynamically on class change on character page
 * and updates class image and subclass
 *
 * @author Kaephas & Zane
 * @version 1.0
 */
// gain access to function to populate subclass list
include 'option_functions.php';

$subList = generateSubClasses();

session_start();

if(isset($_POST['char'])) {
    $charClass = $_POST['char'];
    generateImage($charClass);
} elseif(isset($_POST['subs'])) {
    generateSubs($subList[$_POST['subs']]);
}


/**
 * Generates the class image for character page
 * @param string $className     the name of the class
 * @return void
 */
function generateImage($className) {
    echo '<img src="images/' . strtolower($className) . '.jpg" alt="class image" class="img-fluid mx-auto">';
}

/**
 * Generates the select options for the character page
 * @param string[] $subclasses  the list of subclasses that match the current class
 * @return void
 */
function generateSubs($subclasses) {
    $output = "";
    foreach($subclasses as $sub) {
        $select = "";
        if(isset($_SESSION['sub'])) {
            if($sub == $_SESSION['sub']) {
                $select = "selected";
            }
        }
//        $output .= '<option value="' . $sub . '"' . $select . '>' . $sub . '</option>';
        $output .= "<option value=\"$sub\" $select>$sub</option>";
    }
    echo $output;
}
