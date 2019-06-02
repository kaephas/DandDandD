<?php
/**
 * Created by PhpStorm.
 * User: Kaephas & Zane
 * Date: 6/1/2019
 * Time: 10:46
 */
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
 * @param $className
 */
function generateImage($className) {
    echo '<img src="images/' . strtolower($className) . '.jpg" alt="class image" class="img-fluid mx-auto">';
}

/**
 * @param $subclasses
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
