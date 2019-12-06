$('#date').datepicker({
    format: 'yyyy-mm-dd',
    todayHighlight: true,
});

$('#item_search').typeahead({
    source: function(query, process) {
        $.ajax({
            url: searchPath,
            data: {search : $('#item_search').val(), location : $('.from_location').val()},
            type: 'GET',
            dataType: 'JSON',
            success: function(data) {
                process(data);
            }
        });
    },
    updater: function(item) {
        $.ajax({
            url: getItem,
            data: { id : item.item_id },
            type: 'GET',
            dataType: 'JSON',
            success: function(data) {
                $('.data_2').val(data[0].item_description);
                $('.data_3').val(data[0].unit);
                $('.data_4').val(data[0].qty_on_hand);
                $('.item_id').val(item.item_id);
                $('.unit_id').val(data[0].unit_id);
                $('.item_code').val(data[0].item_code);
            }
        });
        return item.name;
    },
    minLength: 2,
});

var counter = 0;

//ADDING ROW
$('.addBtn').click(function () {

    if ($('.data_1').val() == '') {
        $('.data_1_error').removeClass('hidden');
        $('.data_1').addClass('required_field');
    } else {
        var count = counter++;
        var actions = '<a href="#/" class="edit_'+count+'" onclick="editData('+count+')"><i class="fa fa-pencil"></i></a> ' +
            '<a href="#/" class="delete_'+count+'" onclick="deleteRow('+count+')"><i class="fa fa-trash-o"></i></a>';
        var int_detail = '<a href="#/" class="detailBtn_'+count+'" onclick="inventoryDetail(\''+$('.item_code').val()+'\', ' +
            ''+count+','+$('.data_4').val()+',\''+$('.data_2').val()+'\','+$('.item_id').val()+')"> <i class="fa fa-cube"></i></a>';

        var inputs = '<tr>\n' +
            '<td>'+$('.data_1').val()+'</td>\n' +
            '<td>'+$('.data_2').val()+'</td>\n' +
            '<td>'+$('.data_3').val()+'</td>\n' +
            '<td>'+$('.data_4').val()+'</td>\n' +
            '<td>'+$('.data_5').val()+'</td>\n' +
            '<td>'+int_detail+'</td>\n' +
            '<td>'+$('.data_6').val()+'</td>\n' +
            '<td>'+$('.data_7 option:selected').text()+'</td>\n' +
            '<td>'+actions+'</td>\n' +
            '</tr>';
        $('#transTbl tbody').append(inputs);
        var data_inputs = '<div class="add_transfer_data_'+count+'">' +
            '<input type="hidden" name="item_id[]" value="'+$('.item_id').val()+'" class="data_1_'+count+'">' +
            '<input type="hidden" name="desc[]" value="'+$('.data_2').val()+'" class="data_2_'+count+'">' +
            '<input type="hidden" name="units[]" value="'+$('.unit_id').val()+'" class="data_3_'+count+'">' +
            '<input type="hidden" name="qty_transfer[]" value="'+$('.data_5').val()+'" class="data_4_'+count+'">' +
            '<input type="hidden" name="weight[]" value="'+$('.data_6').val()+'" class="data_5_'+count+'">' +
            '<input type="hidden" name="country[]" value="'+$('.data_7').val()+'" class="data_7_'+count+'">' +
            '</div>';
        $('.hidden_values').append(data_inputs);
        clearData();

        $('#addModal').modal('toggle');
    }
});

$('.btnSave').click(function () {
   $('#addFormData').submit();
});

//EDIT
$('#update_item_search').typeahead({
    source: function(query, process) {
        $.ajax({
            url: searchPath,
            data: {search : $('#item_search').val(), location : $('.from_location').val()},
            type: 'GET',
            dataType: 'JSON',
            success: function(data) {
                process(data);
            }
        });
    },
    updater: function(item) {
        $.ajax({
            url: getItem,
            data: { id : item.item_id },
            type: 'GET',
            dataType: 'JSON',
            success: function(data) {
                $('.data_2_value').val(data[0].item_description);
                $('.data_3_value').val(data[0].unit);
                $('.data_4_value').val(data[0].qty_on_hand);
                $('.item_id_value').val(item.item_id);
                $('.unit_id_value').val(data[0].unit_id);
                $('.item_code_value').val(data[0].item_code);
            }
        });
        return item.name;
    },
    minLength: 2,
});

function editData(dataClass) {
    $('#updateModal').modal({
        backdrop: 'static',
        keyboard: false
    }, 'show');

    var $row = $('.edit_'+dataClass).closest("tr");
    var actions = '<a href="#/" class="save_edit_'+dataClass+' btn btn-success" onclick="saveEdit('+dataClass+')">Update</a> ' +
        '<a href="#/" class="cancel_edit_'+dataClass+' btn btn-danger" onclick="cancelEdit('+dataClass+')">Cancel</a>';

    var hidden_values = '<input type="hidden" value="'+$row.find("td:eq(0)").text()+'" class="data1_edit_value'+dataClass+'">' +
        '<input type="hidden" value="'+$row.find("td:eq(1)").text()+'" class="data2_edit_value'+dataClass+'">' +
        '<input type="hidden" value="'+$row.find("td:eq(2)").text()+'" class="data3_edit_value'+dataClass+'">' +
        '<input type="hidden" value="'+$row.find("td:eq(3)").text()+'" class="data4_edit_value'+dataClass+'">' +
        '<input type="hidden" value="'+$row.find("td:eq(4)").text()+'" class="data5_edit_value'+dataClass+'">' +
        '<input type="hidden" value="'+$row.find("td:eq(6)").text()+'" class="data6_edit_value'+dataClass+'">' +
        '<input type="hidden" value="'+$row.find("td:eq(7)").text()+'" class="data7_edit_value'+dataClass+'">';
    $('.edit_values').html(hidden_values);

    $('.data_1_value').val($row.find("td:eq(0)").text());
    $('.data_2_value').val($row.find("td:eq(1)").text());
    $('.data_3_value').val($row.find("td:eq(2)").text());
    $('.data_4_value').val($row.find("td:eq(3)").text());
    $('.data_5_value').val($row.find("td:eq(4)").text());
    $('.data_6_value').val($row.find("td:eq(6)").text());
    $('.data_7_value').val($('.data_7_'+dataClass).val());
    $('.modal_update').html(actions);

    $('.item_id_value').val($('.data_1_'+dataClass).val());
    $('.unit_id_value').val($('.data_4_'+dataClass).val());
    $('.item_code_value').val($('.item_code_value').val());
}

function saveEdit(dataClass) {
    var $row = $('.edit_'+dataClass).closest("tr");
    var actions = '<a href="#/" class="edit_'+dataClass+'" onclick="editData('+dataClass+')"><i class="fa fa-pencil"></i></a> ' +
        '<a href="#/" class="delete_'+dataClass+'" onclick="deleteRow('+dataClass+')"><i class="fa fa-trash-o"></i></a>';
    var int_detail = '<a href="#/" class="detailBtn_'+dataClass+'" onclick="inventoryDetail(\''+$('.item_code_value').val()+'\', ' +
        ''+dataClass+','+$('.data_4_value').val()+',\''+$('.data_2_value').val()+'\','+$('.item_id_value')+')"> <i class="fa fa-cube"></i></a>';
    $row.find("td:eq(0)").html($('.data_1_value').val());
    $row.find("td:eq(1)").html($('.data_2_value').val());
    $row.find("td:eq(2)").html($('.data_3_value').val());
    $row.find("td:eq(3)").html($('.data_4_value').val());
    $row.find("td:eq(4)").html($('.data_5_value').val());
    $row.find("td:eq(5)").html(int_detail);
    $row.find("td:eq(6)").html($('.data_6_value').val());
    $row.find("td:eq(7)").html($('.data_7_value option:selected').text());
    $row.find("td:eq(8)").html(actions);

    $('.data_1_'+dataClass).val($('.item_id_value').val());
    $('.data_2_'+dataClass).val($('.data_2_value').val());
    $('.data_3_'+dataClass).val($('.unit_id_value').val());
    $('.data_4_'+dataClass).val($('.data_4_value').val());
    $('.data_5_'+dataClass).val($('.data_5_value').val());
    $('.data_6_'+dataClass).val($('.data_6_value').val());
    $('.data_7_'+dataClass).val($('.data_7_value').val());

    $('#updateModal').modal('toggle');
}

function cancelEdit(dataClass) {
    var $row = $('.cancel_edit_'+dataClass).closest("tr");
    var actions = '<a href="#/" class="edit_'+dataClass+'" onclick="editData('+dataClass+')"><i class="fa fa-pencil"></i></a> ' +
        '<a href="#/" class="delete_'+dataClass+'" onclick="deleteRow('+dataClass+')"><i class="fa fa-trash-o"></i></a>';
    $row.find("td:eq(0)").html($('.data1_edit_value'+dataClass).val());
    $row.find("td:eq(1)").html($('.data2_edit_value'+dataClass).val());
    $row.find("td:eq(2)").html($('.data3_edit_value'+dataClass).val());
    $row.find("td:eq(3)").html($('.data4_edit_value'+dataClass).val());
    $row.find("td:eq(5)").html($('.data5_edit_value'+dataClass).val());
    $row.find("td:eq(6)").html($('.data6_edit_value'+dataClass).val());
    $row.find("td:eq(7)").html($('.data7_edit_value'+dataClass).val());
    $row.find("td:eq(8)").html(actions);

    $('#updateModal').modal('toggle');
}

function deleteRow(dataClass) {
    swal({
        title: "Are you sure you want to remove this data?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Yes",
        closeOnConfirm: true
    }, function () {
        var $row = $('.delete_'+dataClass).closest("tr");
        $row.remove();
        $('.add_transfer_data_'+dataClass).remove();
        $('.data_items_'+dataClass).remove();
    });
}

function clearData() {
    $('.data_1').val('');
    $('.data_2').val('');
    $('.data_3').val('');
    $('.data_4').val('');
    $('.data_5').val('');
    $('.data_6').val('');
    $('.data_7').val('');
    $('.data_1_error').addClass('hidden');
    $('.data_1').removeClass('required_field');
}

//INVENTORY DETAIL MODAL
function inventoryDetail(item_code, dataClass, quantity, desc, item_id) {
    $('#binModal').modal({
        backdrop: 'static',
        keyboard: false
    }, 'show');

    $('.bin_items').html(item_code);
    $('.bin_item_id').val(item_id);
    $('.qty_bin_items').html(quantity);
    $('.desc_bin_items').html(desc);
    $('.itemClass').val(dataClass);

    addRowsItem();

    //BIN FROM
    $.ajax({
        url: getBin,
        data: { location_id : $('.from_location').val() },
        type: 'GET',
        dataType: 'JSON',
        success: function(data) {
            if (data.length !== 0) {
                $.each( data, function( key, value ) {
                    $("#from_location_list").append(new Option(value.bin_no, value.bin_id));
                });
            }
        }
    });

    //BIN TO
    $.ajax({
        url: getBin,
        data: { location_id : $('.to_location').val() },
        type: 'GET',
        dataType: 'JSON',
        success: function(data) {
            if (data.length !== 0) {
                $.each( data, function( key, value ) {
                    $("#to_location_list").append(new Option(value.bin_no, value.bin_id));
                });
            }
        }
    });
}

function addRowsItem() {
    var row = '<div class="row">' +
        '<div class="col-lg-3"><select id="from_location_list" class="form-control" onchange="available(this);"><option value="">Select...</option></select></div> ' +
        '<div class="col-lg-3"><select id="to_location_list" class="form-control"><option value="">Select...</option></select></div>' +
        '<div class="col-lg-3"><input type="text" class="form-control available" readonly value=""></div> ' +
        '<div class="col-lg-3"><input type="text" class="form-control bin_quantity"></div>' +
        '</div>';
    $('.add_row_items').html(row);
}

function available(sel) {
    var id = sel.value;

    $.ajax({
        url: getQty,
        data: { bin_id : id },
        type: 'GET',
        dataType: 'JSON',
        success: function(data) {
            $('.available').val(data[0]['quantity']);
        }
    });
}

$('.itemAdd').click(function () {
    var dataClass = $('.itemClass').val();
    var action = '<a href="#/" class="delete_item_'+dataClass+'" onclick="deleteItemRow('+dataClass+')"><i class="fa fa-trash-o"></i></a>';

    var inputs = '<tr>\n' +
        '<td>'+$('#from_location_list option:selected').text()+'</td>\n' +
        '<td>'+$('#to_location_list option:selected').text()+'</td>\n' +
        '<td>'+$('.available').val()+'</td>\n' +
        '<td>'+$('.bin_quantity').val()+'</td>\n' +
        '<td>'+action+'</td>\n' +
        '</tr>';
    $('#itemTbl tbody').append(inputs);

    var data_inputs = '<div class="item_data_'+dataClass+'">' +
        '<input type="hidden" name="bin_item_id[]" value="'+$('.bin_item_id').val()+'">' +
        '<input type="hidden" name="from_bin_id[]" value="'+$('#from_location_list').val()+'">' +
        '<input type="hidden" name="to_bin_id[]" value="'+$('#to_location_list').val()+'">' +
        '<input type="hidden" name="transfer_bin_qty[]" value="'+$('.bin_quantity').val()+'">';
        '</div>';
    $('.hidden_values').append(data_inputs);
});

function deleteItemRow(dataClass) {
    swal({
        title: "Are you sure you want to remove this data?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Yes",
        closeOnConfirm: true
    }, function () {
        var $row = $('.delete_item_'+dataClass).closest("tr");
        $row.remove();
        $('.item_data_'+dataClass).remove();
    });
}

$('.item_addBtn').click(function () {
    $('#is_add').val('1');
    $('#binModal').modal('toggle');
});

$('.item_cancelBtn').click(function () {
    var dataClass = $('.itemClass').val();
    var bin_item = $('#is_add').val();

    if (bin_item == '1') {
        $('#binModal').modal('toggle');
    } else {
        $('.item_data_'+dataClass).remove();
        $('#binModal').modal('toggle');
    }
});
