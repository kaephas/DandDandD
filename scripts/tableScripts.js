/*
 * Kaephas & Zane
 * 6-1-2019
 * tableScripts.js
 *
 * Script to load/style datatable and clickable rows
 */

// converts prev/next to < / >, resizes table properly
$(document).ready( function () {
    $('#drinkTable').DataTable( {
        "oLanguage": {
            "oPaginate": {
                "sPrevious": "<",
                "sNext": ">"
            }
        },
        "rowReorder": {
            selector: 'td:nth-child(2)'
        },
        "responsive": true,
        "autoWidth": false
    });

} );

// Clickable Table Rows, redirect to drink/drinkName
let row = $(".clickableRow");

row.click(function() {
    window.location = $(this).attr('data-href');
});