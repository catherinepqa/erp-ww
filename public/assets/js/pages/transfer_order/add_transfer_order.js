$('#date').datepicker({
    format: 'yyyy-mm-dd',
    todayHighlight: true,
});

$('#date1').datepicker({
    format: 'yyyy-mm-dd',
    todayHighlight: true,
});

$('#date2').datepicker({
    format: 'yyyy-mm-dd',
    todayHighlight: true,
});

$('#date3').datepicker({
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
                $('.data_3').val(data[0].qty_on_hand);
                $('.data_4').val(data[0].unit);
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

        var inputs = '<tr>\n' +
            '<td>'+$('.data_1').val()+'</td>\n' +
            '<td>'+$('.data_3').val()+'</td>\n' +
            '<td>'+$('.data_5').val()+'</td>\n' +
            '<td>'+$('.data_4').val()+'</td>\n' +
            '<td>'+$('.data_6').val()+'</td>\n' +
            '<td>'+$('.data_2').val()+'</td>\n' +
            '<td></td>\n' +
            '<td>'+$('.data_7').val()+'</td>\n' +
            '<td>'+$('.data_8 option:selected').text()+'</td>\n' +
            '<td></td>\n' +
            '<td>'+$('.data_9').val()+'</td>\n' +
            '<td></td>\n' +
            '<td></td>\n' +
            '<td>'+actions+'</td>\n' +
            '</tr>';
        $('#itemsTbl tbody').append(inputs);

        var data_inputs = '<div class="add_order_data_'+count+'">' +
            '<input type="hidden" name="item_id[]" value="'+$('.item_id').val()+'" class="data_1_'+count+'">' +
            '<input type="hidden" name="qty[]" value="'+$('.data_3').val()+'" class="data_2_'+count+'">' +
            '<input type="hidden" name="units[]" value="'+$('.unit_id').val()+'" class="data_3_'+count+'">' +
            '<input type="hidden" name="transfer_price[]" value="'+$('.data_5').val()+'" class="data_4_'+count+'">' +
            '<input type="hidden" name="amount[]" value="'+$('.data_6').val()+'" class="data_5_'+count+'">' +
            '<input type="hidden" name="receipt_date[]" value="'+$('.data_7').val()+'" class="data_7_'+count+'">' +
            '<input type="hidden" name="commit[]" value="'+$('.data_8').val()+'" class="data_8_'+count+'">' +
            '<input type="hidden" name="order_priority[]" value="'+$('.data_9').val()+'" class="data_9_'+count+'">' +
            '</div>';
        $('.hidden_values').append(data_inputs);
        clearData();

        $('#addModal').modal('toggle');
    }
});

function clearData() {
    $('.data_1').val('');
    $('.data_2').val('');
    $('.data_3').val('');
    $('.data_4').val('');
    $('.data_5').val('');
    $('.data_6').val('');
    $('.data_7').val('');
    $('.data_8').val('');
    $('.data_9').val('');
    $('.data_1_error').addClass('hidden');
    $('.data_1').removeClass('required_field');
}

//EDIT
$('#update_item_search').typeahead({
    source: function(query, process) {
        $.ajax({
            url: searchPath,
            data: {search : $('#update_item_search').val(), location : $('.from_location').val()},
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
                $('.edit_data_2').val(data[0].item_description);
                $('.edit_data_3').val(data[0].qty_on_hand);
                $('.edit_data_4').val(data[0].unit);
                $('.edit_item_id').val(item.item_id);
                $('.edit_unit_id').val(data[0].unit_id);
                //$('.edit_item_code').val(data[0].item_code);
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
        '<input type="hidden" value="'+$row.find("td:eq(5)").text()+'" class="data2_edit_value'+dataClass+'">' +
        '<input type="hidden" value="'+$row.find("td:eq(1)").text()+'" class="data3_edit_value'+dataClass+'">' +
        '<input type="hidden" value="'+$row.find("td:eq(3)").text()+'" class="data4_edit_value'+dataClass+'">' +
        '<input type="hidden" value="'+$row.find("td:eq(2)").text()+'" class="data5_edit_value'+dataClass+'">' +
        '<input type="hidden" value="'+$row.find("td:eq(4)").text()+'" class="data6_edit_value'+dataClass+'">' +
        '<input type="hidden" value="'+$row.find("td:eq(7)").text()+'" class="data7_edit_value'+dataClass+'">' +
        '<input type="hidden" value="'+$row.find("td:eq(8)").text()+'" class="data8_edit_value'+dataClass+'">' +
        '<input type="hidden" value="'+$row.find("td:eq(10)").text()+'" class="data9_edit_value'+dataClass+'">';
    $('.edit_values').html(hidden_values);

    $('.edit_data_1').val($row.find("td:eq(0)").text());
    $('.edit_data_2').val($row.find("td:eq(5)").text());
    $('.edit_data_3').val($row.find("td:eq(1)").text());
    $('.edit_data_4').val($row.find("td:eq(3)").text());
    $('.edit_data_5').val($row.find("td:eq(2)").text());
    $('.edit_data_6').val($row.find("td:eq(4)").text());
    $('.edit_data_7').val($row.find("td:eq(7)").text());
    $('.edit_data_8').val($('.data_8_'+dataClass).val());
    $('.edit_data_9').val($row.find("td:eq(10)").text());
    $('.modal_update').html(actions);

    $('.edit_item_id').val($('.data_1_'+dataClass).val());
    $('.edit_unit_id').val($('.data_3_'+dataClass).val());
    //$('.edit_item_code').val($('.item_code_value').val());
}

function saveEdit(dataClass) {
    var $row = $('.edit_'+dataClass).closest("tr");
    var actions = '<a href="#/" class="edit_'+dataClass+'" onclick="editData('+dataClass+')"><i class="fa fa-pencil"></i></a> ' +
        '<a href="#/" class="delete_'+dataClass+'" onclick="deleteRow('+dataClass+')"><i class="fa fa-trash-o"></i></a>';
    $row.find("td:eq(0)").html($('.edit_data_1').val());
    $row.find("td:eq(1)").html($('.edit_data_3').val());
    $row.find("td:eq(2)").html($('.edit_data_5').val());
    $row.find("td:eq(3)").html($('.edit_data_4').val());
    $row.find("td:eq(4)").html($('.edit_data_6').val());
    $row.find("td:eq(7)").html($('.edit_data_7').val());
    $row.find("td:eq(8)").html($('.edit_data_8 option:selected').text());
    $row.find("td:eq(10)").html($('.edit_data_9').val());
    $row.find("td:eq(13)").html(actions);

    $('.data_1_'+dataClass).val($('.edit_item_id').val());
    $('.data_2_'+dataClass).val($('.edit_data_3').val());
    $('.data_3_'+dataClass).val($('.edit_unit_id').val());
    $('.data_4_'+dataClass).val($('.edit_data_5').val());
    $('.data_5_'+dataClass).val($('.edit_data_6').val());
    $('.data_7_'+dataClass).val($('.edit_data_7').val());
    $('.data_8_'+dataClass).val($('.edit_data_8').val());
    $('.data_9_'+dataClass).val($('.edit_data_9').val());

    $('#updateModal').modal('toggle');
}

function cancelEdit(dataClass) {
    var $row = $('.cancel_edit_'+dataClass).closest("tr");
    var actions = '<a href="#/" class="edit_'+dataClass+'" onclick="editData('+dataClass+')"><i class="fa fa-pencil"></i></a> ' +
        '<a href="#/" class="delete_'+dataClass+'" onclick="deleteRow('+dataClass+')"><i class="fa fa-trash-o"></i></a>';
    $row.find("td:eq(0)").html($('.data1_edit_value'+dataClass).val());
    $row.find("td:eq(1)").html($('.data3_edit_value'+dataClass).val());
    $row.find("td:eq(2)").html($('.data5_edit_value'+dataClass).val());
    $row.find("td:eq(3)").html($('.data4_edit_value'+dataClass).val());
    $row.find("td:eq(4)").html($('.data6_edit_value'+dataClass).val());
    $row.find("td:eq(7)").html($('.data7_edit_value'+dataClass).val());
    $row.find("td:eq(8)").html($('.data8_edit_value'+dataClass).val());
    $row.find("td:eq(10)").html($('.data9_edit_value'+dataClass).val());
    $row.find("td:eq(13)").html(actions);

    $('#updateModal').modal('toggle');
}

//DELETE ROW
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
        $('.add_order_data_'+dataClass).remove();
        //$('.data_items_'+dataClass).remove();
    });
}
