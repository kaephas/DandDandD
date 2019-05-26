$(document).ready( function () {
    $('#drinkTable').DataTable();
} );

$(".clickableRow").click(function() {
    window.location = $(this).attr('data-href');
});