// $(document).ready( function () {
//     $('#drinkTable').DataTable();
// } );

$(".clickableRow").click(function() {
    window.location = $(this).attr('data-href');
});

$(document).ready(function() {
   let table = $('#drinkTable').DataTable( {
       rowReorder: {
           selector: 'td:nth-child(2)'
       },
       responsive: true,
       "oLanguage": {
           "oPaginate": {
               "sPrevious": "<",
               "sNext": ">"
           }
       },

   });
    let firstChild = $('#drinkTable_previous:first-child');
       // firstChild.children('a:first').html('Prev');
});