/*
 * Kaephas & Zane
 * 6-1-2019
 * tableScripts.js
 *
 * Script to load/style datatable and clickable rows
 */

// converts prev/next to < / >
$(document).ready( function () {
    $('#drinkTable').DataTable( {
        "oLanguage": {
            "oPaginate": {
                "sPrevious": "<",
                "sNext": ">"
            }
        }
    });

    $("#drinkTable tr").css('cursor', 'pointer');
    // TODO: not working for some reason
    $("#headerRow").css('cursor', 'n-resize');

} );

let row = $(".clickableRow");

// Clickable Table Rows, redirect to drink/drinkName
row.click(function() {
    window.location = $(this).attr('data-href');
});
//
// $(document).ready(function() {
//    let table = $('#drinkTable').DataTable( {
//        rowReorder: {
//            selector: 'td:nth-child(2)'
//        },
//        responsive: true,
//        "oLanguage": {
//            "oPaginate": {
//                "sPrevious": "<",
//                "sNext": ">"
//            }
//        },
//
//    });
//     let firstChild = $('#drinkTable_previous:first-child');
//        // firstChild.children('a:first').html('Prev');
// });