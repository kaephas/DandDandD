/*
 * Kaephas & Zane
 * 6-1-2019
 * getClassInfo.js
 *
 * loads image and subclass info on class change
 */

// loads class image and subclass based on class value in select box (first load or after post)
let imageDiv = $('#ajaxImg');
$(window).on('load', function() {

    let charClass = $('#class').val();
    imageDiv.load('model/getClassInfo.php', {char:charClass});
    $("#sub").load('model/getClassInfo.php', {subs:charClass});
});

// changes class image and subclass when select option changes
$('#class').on('change', function() {

    let charClass = $('#class').val();
    imageDiv.load('model/getClassInfo.php', {char:charClass});
    $("#sub").load('model/getClassInfo.php', {subs:charClass});
});