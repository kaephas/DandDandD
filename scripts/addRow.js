/*
 * Kaephas & Zane
 * 5-27-2019
 * addRow.js
 *
 * enables adding and removing ingredient rows on button click
 */

let typeList = ['cognac', 'gin', 'pisco', 'rum', 'tequila', 'vodka', 'whiskey', 'bitters', 'club soda', 'egg',
    'fruit/juice', 'liquor', 'milk/cream', 'mint', 'soft drink', 'sweetener', 'tonic', 'vermouth', 'misc'];

// add another row of ingredients on addRow click
$("#addRow").click(function(e) {
    e.preventDefault();

    let count = ($(".ing-row").length);

    // if(numRows > 0) {
    //     $(".ing-row").each(function(index) {
    //         console.log( count );
    //         count++;
    //     });
    // }

    let formRow = $("#new-row");
    formRow.html(generateRow(count));
    formRow.prop('id', '');
    $("#replace").prop('id', 'new-row');
});

// remove last row of ingredients on removeRow click
$("#removeRow").click(function(e) {
   e.preventDefault();


   let count = $(".ing-row").length;
    console.log(count);
   if(count > 0) {
       $(".ing-row").last().remove();
   }


});

/**
 * Generates ingredient row for add/edit drinks
 * @param {int} count the number of current rows
 * @returns {string} newRow  the html of the new row
 */
function generateRow(count) {

    let newRow = '<div class="row border pt-2 ing-row">' +
        '<div class="col-md-3 form-group ">' +
        '<label for="qty' + count + '">Qty</label>' +
        '<input id="qty' + count + '" type="text" name="qtys[]" class="form-control" required>' +
        '</div>' +
        '<div class="col-md-5 form-group">' +
        '<label for="ing' + count + '">Ingredient</label>' +
        '<input id="' + count + '" type="text" name="ings[]" class="form-control" required>' +
        '</div>' +
        '<div class="col-md-4 form-group">' +
        '<label for="type' + count + '">Category</label>' +
        '<select id="type' + count + '" name="types[]" class="form-control" required>' +
        '<option value="" selected>choose category...</option>';

    // generate option for each type
    for(let type of typeList) {

        newRow += '<option value="' + type + '">' + type + '</option>';
    }

    // end each row with an hr to separate and a new div to use to replace for future row adding
    newRow += '</select>' +
        '</div>' +
        '<hr>' +
        '</div>' +
        '<div id="replace"></div>';

    return newRow;
}

// reroute to delete drink confirmation page on delete click
$("#delDrink").on('click', function(e) {
    e.preventDefault();
    window.location.replace("../delete/" + $(document).find('title').text());
});
