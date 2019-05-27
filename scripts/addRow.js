let newRow = '<div class="row border pt-2">' +
    '<div class="col-md-3 form-group ">' +
    '<label>Qty</label>' +
    '<input type="text" name="qty[]" class="form-control">' +
    '</div>' +
    '<div class="col-md-5 form-group">' +
    '<label>Ingredient</label>' +
    '<input type="text" name="ings[]" class="form-control">' +
    '</div>' +
    '<div class="col-md-4 form-group">' +
    '<label>Category</label>' +
    '<select name="type[]" class="form-control" placeholder="Choose one...">';

let types = [];
let items = $("select:last");
let things = items.children();
for (let i = 0; i < things.length; i++) {
    types.push(things[i].innerHTML);
}

for(let type of types) {
    newRow += '<option value="type">' + type + '</option>';
}


newRow += '</select>' +
    '</div>' +
    '</div>' +
    '<div id="replace"></div>';

$("#addRow").click(function(e) {
    e.preventDefault();


    let formRow = $("#new-row");
    formRow.html(newRow);
    formRow.prop('id', '');
    $("#replace").prop('id', 'new-row');
});