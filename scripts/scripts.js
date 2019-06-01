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
    $("#headerRow").css('cursor', 'n-resize');

} );

let row = $(".clickableRow");

// $("#drinkTable tr").hover(function() {
// });

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