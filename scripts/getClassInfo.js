/*
 * Kaephas & Zane
 * 6-1-2019
 * getClassInfo.js
 *
 * loads image and subclass info on class change
 */

let imageDiv = $('#ajaxImg');
$(window).on('load', function() {

    let charClass = $('#class').val();
    imageDiv.load('model/getClassInfo.php', {char:charClass});
    $("#sub").load('model/getClassInfo.php', {subs:charClass});
});

$('#class').on('change', function() {

    let charClass = $('#class').val();
    imageDiv.load('model/getClassInfo.php', {char:charClass});
    $("#sub").load('model/getClassInfo.php', {subs:charClass});
});