$('#date').datepicker({
    format: 'yyyy-mm-dd',
    todayHighlight: true
});

$(".number").on("input", function(evt) {
    var self = $(this);
    self.val(self.val().replace(/[^0-9\.]/g, ''));
    if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57))
    {
        evt.preventDefault();
    }
});

$('#item_search').typeahead({
    source: function(query, process) {
        $.ajax({
            url: searchPath,
            data: {search:$('#item_search').val()},
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
                $('.data_4').val(data[0].unit);
                $('.data_11').val(data[0].dept_name);
                $('.data_12').val(data[0].item_category_name);
                $('.item_id').val(item.item_id);
                $('.dept_id').val(data[0].dept_id);
                $('.item_cat_id').val(data[0].item_cat_id);
                $('.unit_id').val(data[0].unit_id);
                $('.item_code').val(data[0].item_code);
            }
        });
        return item.name;
    },
    minLength: 2
});

//UPDATE SEARCH ITEM
$('#update_item_search').typeahead({
    source: function(query, process) {
        $.ajax({
            url: searchPath,
            data: {search:$('#item_search').val()},
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
                $('.data_4_value').val(data[0].unit);
                $('.data_11_value').val(data[0].dept_name);
                $('.data_12_value').val(data[0].item_category_name);
                $('.item_id_value').val(item.item_id);
                $('.dept_id_value').val(data[0].dept_id);
                $('.item_cat_id_value').val(data[0].item_cat_id);
                $('.unit_id_value').val(data[0].unit_id);
                $('.item_code_value').val(data[0].item_code);
            }
        });
        return item.name;
    },
    minLength: 2
});

$('.location').change(function () {
    var location = $(this).val();
    var item_id = $('.item_id').val();

    $.ajax({
        url: getLocation,
        data: { location_id : location, item_id : item_id },
        type: 'GET',
        dataType: 'JSON',
        success: function(data) {
            if (data.length !== 0) {
                var c_value = data[0].qty_on_hand * data[0].last_purchase_cost;
                $('.data_5').val(data[0].qty_on_hand);
                $('.data_9').val(data[0].last_purchase_cost);
                $('.inventory_item_id').val(data[0].system_id);
                $('.data_6').val(c_value);
            }
        }
    });
});

//UPDATE LOCATION
$('.update_location').change(function () {
    var location = $(this).val();
    var item_id = $('.item_id_value').val();

    $.ajax({
        url: getLocation,
        data: { location_id : location, item_id : item_id },
        type: 'GET',
        dataType: 'JSON',
        success: function(data) {
            if (data.length !== 0) {
                var c_value = data[0].qty_on_hand * data[0].last_purchase_cost;
                $('.data_5_value').val(data[0].qty_on_hand);
                $('.data_9_value').val(data[0].last_purchase_cost);
                $('.inventory_item_id_value').val(data[0].system_id);
                $('.data_6_value').val(c_value);
            }
        }
    });
});

var counter = 0;

//ADDING ROW
$('.addBtn').click(function () {

    if ($('.data_8').val() == '' && $('.data_7').val() == '' && $('.data_1').val() == '') {
        $('.data_8_error').removeClass('hidden');
        $('.data_8').addClass('required_field');
        $('.data_7_error').removeClass('hidden');
        $('.data_7').addClass('required_field');
        $('.data_1_error').removeClass('hidden');
        $('.data_1').addClass('required_field');
    } else if ($('.data_7').val() == '') {
        $('.data_7_error').removeClass('hidden');
        $('.data_7').addClass('required_field');
    } else if ($('.data_8').val() == '') {
        $('.data_8_error').removeClass('hidden');
        $('.data_8').addClass('required_field');
    } else if ($('.data_1').val() == '') {
        $('.data_1_error').removeClass('hidden');
        $('.data_1').addClass('required_field');
    } else {
        var count = counter++;
        var actions = '<a href="#/" class="edit_'+count+'" onclick="editData('+count+')"><i class="fa fa-pencil"></i></a> ' +
            '<a href="#/" class="delete_'+count+'" onclick="deleteRow('+count+')"><i class="fa fa-trash-o"></i></a>';
        var int_detail = '<a href="#/" class="detailBtn_'+count+'" onclick="inventoryDetail('+count+','+$('.item_id').val()+',' +
            ''+$('.data_3').val()+', \''+$('.item_code').val()+'\')"> <i class="fa fa-cube"></i></a>';

        var inputs = '<tr>\n' +
            '<td>'+$('.data_1').val()+'</td>\n' +
            '<td>'+$('.data_2').val()+'</td>\n' +
            '<td>'+$('.data_3 option:selected').text()+'</td>\n' +
            '<td>'+$('.data_4').val()+'</td>\n' +
            '<td>'+$('.data_5').val()+'</td>\n' +
            '<td>'+$('.data_6').val()+'</td>\n' +
            '<td>'+$('.data_7').val()+'</td>\n' +
            '<td>'+$('.data_8').val()+'</td>\n' +
            '<td>'+$('.data_9').val()+'</td>\n' +
            '<td>'+int_detail+'</td>\n' +
            '<td>'+$('.data_11').val()+'</td>\n' +
            '<td>'+$('.data_12').val()+'</td>\n' +
            '<td>'+$('.data_13').val()+'</td>\n' +
            '<td>'+actions+'</td>\n' +
            '</tr>';
        $('#adjTbl tbody').append(inputs);
        var data_inputs = '<div class="add_adjustment_data_'+count+'">' +
            '<input type="hidden" name="item_id[]" value="'+$('.item_id').val()+'" class="data_1_'+count+'">' +
            '<input type="hidden" name="desc[]" value="'+$('.data_2').val()+'" class="data_2_'+count+'">' +
            '<input type="hidden" name="location[]" value="'+$('.data_3').val()+'" class="data_3_'+count+'">' +
            '<input type="hidden" name="units[]" value="'+$('.unit_id').val()+'" class="data_4_'+count+'">' +
            '<input type="hidden" name="qyt_on_hand[]" value="'+$('.data_5').val()+'" class="data_5_'+count+'">' +
            '<input type="hidden" name="c_value[]" value="'+$('.data_6').val()+'" class="data_6_'+count+'">' +
            '<input type="hidden" name="adjust_by[]" value="'+$('.data_7').val()+'" class="data_7_'+count+'">' +
            '<input type="hidden" name="new_qty[]" value="'+$('.data_8').val()+'" class="data_8_'+count+'">' +
            '<input type="hidden" name="est_cost[]" value="'+$('.data_9').val()+'" class="data_9_'+count+'">' +
            // '<input type="hidden" name="int_detail[]" value="'+$('.data_10').val()+'">' +
            '<input type="hidden" name="dept[]" value="'+$('.dept_id').val()+'" class="dept_id'+count+'">' +
            '<input type="hidden" name="item_cat[]" value="'+$('.item_cat_id').val()+'" class="item_cat_id'+count+'">' +
            '<input type="hidden" name="adj_memo[]" value="'+$('.data_13').val()+'" class="data_13_'+count+'">' +
            '<input type="hidden" name="inventory_item_id[]" value="'+$('.inventory_item_id').val()+'" class="inventory_item_id'+count+'">' +
            '</div>';
        $('.hidden_values').append(data_inputs);
        clearData();

        $('#addModal').modal('toggle');
    }
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
        '<input type="hidden" value="'+$('.data_3_'+dataClass).val()+'" class="data3_edit_value'+dataClass+'">' +
        '<input type="hidden" value="'+$('.data_4_'+dataClass).val()+'" class="data4_edit_value'+dataClass+'">' +
        '<input type="hidden" value="'+$row.find("td:eq(4)").text()+'" class="data5_edit_value'+dataClass+'">' +
        '<input type="hidden" value="'+$row.find("td:eq(5)").text()+'" class="data6_edit_value'+dataClass+'">' +
        '<input type="hidden" value="'+$row.find("td:eq(6)").text()+'" class="data7_edit_value'+dataClass+'">' +
        '<input type="hidden" value="'+$row.find("td:eq(7)").text()+'" class="data8_edit_value'+dataClass+'">' +
        '<input type="hidden" value="'+$row.find("td:eq(8)").text()+'" class="data9_edit_value'+dataClass+'">' +
        '<input type="hidden" value="'+$('.dept_id'+dataClass).val()+'" class="dept_id_edit_value'+dataClass+'">' +
        '<input type="hidden" value="'+$('.item_cat_id'+dataClass).val()+'" class="item_cat_id_edit_value'+dataClass+'">' +
        '<input type="hidden" value="'+$row.find("td:eq(13)").text()+'" class="data13_edit_value'+dataClass+'">' +
        '<input type="hidden" value="'+$('.inventory_item_id'+dataClass).val()+'" class="inventory_item_id_edit_value'+dataClass+'">' +
        '<input type="hidden" value="'+$('.data_1_'+dataClass).val()+'" class="item_id_edit_value'+dataClass+'">';
    $('.edit_values').html(hidden_values);

    $('.data_1_value').val($row.find("td:eq(0)").text());
    $('.data_2_value').val($row.find("td:eq(1)").text());
    $('.data_3_value').val($('.data_3_'+dataClass).val());
    $('.data_4_value').val($row.find("td:eq(3)").text());
    $('.data_5_value').val($row.find("td:eq(4)").text());
    $('.data_6_value').val($row.find("td:eq(5)").text());
    $('.data_7_value').val($row.find("td:eq(6)").text());
    $('.data_8_value').val($row.find("td:eq(7)").text());
    $('.data_9_value').val($row.find("td:eq(8)").text());
    $('.data_10_value').val($row.find("td:eq(9)").text());
    $('.data_11_value').val($row.find("td:eq(10)").text());
    $('.data_12_value').val($row.find("td:eq(11)").text());
    $('.data_13_value').val($row.find("td:eq(12)").text());
    $('.modal_update').html(actions);

    $('.item_id_value').val($('.data_1_'+dataClass).val());
    $('.dept_id_value').val($('.dept_id'+dataClass).val());
    $('.item_cat_id_value').val($('.item_cat_id'+dataClass).val());
    $('.unit_id_value').val($('.data_4_'+dataClass).val());
    $('.item_code_value').val($('.item_code_value').val());
    $('.inventory_item_id_value').val($('.inventory_item_id'+dataClass).val());
}

function saveEdit(dataClass) {
    var $row = $('.edit_'+dataClass).closest("tr");
    var actions = '<a href="#/" class="edit_'+dataClass+'" onclick="editData('+dataClass+')"><i class="fa fa-pencil"></i></a> ' +
        '<a href="#/" class="delete_'+dataClass+'" onclick="deleteRow('+dataClass+')"><i class="fa fa-trash-o"></i></a>';
    var int_detail = '<a href="#/" class="detailBtn_'+dataClass+'" onclick="inventoryDetail('+dataClass+','+$('.item_id_value').val()+',' +
        ''+$('.data_3_value').val()+', \''+$('.item_code_value').val()+'\')"> <i class="fa fa-cube"></i></a>';
    $row.find("td:eq(0)").html($('.data_1_value').val());
    $row.find("td:eq(1)").html($('.data_2_value').val());
    $row.find("td:eq(2)").html($('.data_3_value option:selected').text());
    $row.find("td:eq(3)").html($('.data_4_value').val());
    $row.find("td:eq(4)").html($('.data_5_value').val());
    $row.find("td:eq(5)").html($('.data_6_value').val());
    $row.find("td:eq(6)").html($('.data_7_value').val());
    $row.find("td:eq(7)").html($('.data_8_value').val());
    $row.find("td:eq(8)").html($('.data_9_value').val());
    $row.find("td:eq(9)").html(int_detail);
    $row.find("td:eq(10)").html($('.data_11_value').val());
    $row.find("td:eq(11)").html($('.data_12_value').val());
    $row.find("td:eq(12)").html($('.data_13_value').val());
    $row.find("td:eq(13)").html(actions);

    $('.data_1_'+dataClass).val($('.item_id_value').val());
    $('.data_2_'+dataClass).val($('.data_2_value').val());
    $('.data_3_'+dataClass).val($('.data_3_value').val());
    $('.data_4_'+dataClass).val($('.unit_id_value').val());
    $('.data_5_'+dataClass).val($('.data_5_value').val());
    $('.data_6_'+dataClass).val($('.data_6_value').val());
    $('.data_7_'+dataClass).val($('.data_7_value').val());
    $('.data_8_'+dataClass).val($('.data_8_value').val());
    $('.data_9_'+dataClass).val($('.data_9_value').val());
    $('.dept_id'+dataClass).val($('.dept_id_value').val());
    $('.item_cat_id'+dataClass).val($('.item_cat_id_value').val());
    $('.data_13_'+dataClass).val($('.data_13_value').val());
    $('.inventory_item_id'+dataClass).val($('.inventory_item_id_value').val());

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
    $row.find("td:eq(4)").html($('.data5_edit_value'+dataClass).val());
    $row.find("td:eq(5)").html($('.data6_edit_value'+dataClass).val());
    $row.find("td:eq(6)").html($('.data7_edit_value'+dataClass).val());
    $row.find("td:eq(7)").html($('.data8_edit_value'+dataClass).val());
    $row.find("td:eq(8)").html($('.data9_edit_value'+dataClass).val());
    $row.find("td:eq(9)").html($('.data10_edit_value'+dataClass).val());
    $row.find("td:eq(10)").html($('.data11_edit_value'+dataClass).val());
    $row.find("td:eq(11)").html($('.data12_edit_value'+dataClass).val());
    $row.find("td:eq(12)").html($('.data13_edit_value'+dataClass).val());
    $row.find("td:eq(13)").html(actions);
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
        $('.add_adjustment_data_'+dataClass).remove();
        $('.data_items_'+dataClass).remove();
    });
}

$('.cancelBtn').click(function () {
    clearData();
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
    $('.data_10').val('');
    $('.data_11').val('');
    $('.data_12').val('');
    $('.data_13').val('');
    $('.data_8_error').addClass('hidden');
    $('.data_8').removeClass('required_field');
    $('.data_7_error').addClass('hidden');
    $('.data_7').removeClass('required_field');
    $('.data_1_error').addClass('hidden');
    $('.data_1').removeClass('required_field');
}

$('.btnSave').click(function () {
    $('#dataForm').submit();
});

$(function() {
    $(".demo2").trigger("click");
});

$('.demo2').click(function(){
    swal({
        title: "Good job!",
        text: success_msg,
        type: "success"
    });
});

function inventoryDetail(dataClass, item_id, location_id, item_code) {
    $('#binModal').modal({
        backdrop: 'static',
        keyboard: false
    }, 'show');

    var $row = $('.detailBtn_'+dataClass).closest("tr");
    $('.bin_items').html(item_code);
    $('.qty_bin_items').html($row.find("td:eq(7)").text());
    $('.desc_bin_items_value').html($row.find("td:eq(1)").text());
    $('.dataClass').val(dataClass);
    $('.item_location_id').val(location_id);

    $('.bin_items_value').val(item_id);
    $('.qty_bin_items_value').val($row.find("td:eq(7)").text());

    addRowsItem();

    $.ajax({
        url: getBin,
        data: { location_id : location_id },
        type: 'GET',
        dataType: 'JSON',
        success: function(data) {
            if (data.length !== 0) {
                $.each( data, function( key, value ) {
                    $("#bin_list").append(new Option(value.bin_no, value.bin_id));
                });
            }
        }
    });

    $(".alert_close").trigger("click");
}

function addRowsItem() {
    var row = '<div class="row">' +
        '<div class="col-lg-6"><select id="bin_list" class="form-control"><option value="">Select...</option></select></div> ' +
        '<div class="col-lg-6"><input type="text" class="form-control bin_quantity"></div> ' +
        '</div>';
    $('.add_row_items').html(row);
}

$('.itemAdd').click(function () {
    var dataClass = $('.dataClass').val();
    var action = '<a href="#/" class="delete_item_'+dataClass+'" onclick="deleteItemRow('+dataClass+')"><i class="fa fa-trash-o"></i></a>';

    var inputs = '<tr>\n' +
        '<td>'+$('#bin_list option:selected').text()+'</td>\n' +
        '<td>'+$('.bin_quantity').val()+'</td>\n' +
        '<td>'+action+'</td>\n' +
        '</tr>';
    $('#itemTbl tbody').append(inputs);

    var bin_items_id = $('.bin_items_value').val();
    var bin_qty = $('.qty_bin_items_value').val();
    var item_location_id = $('.item_location_id').val();
    var bin_new_qty = $('.bin_quantity').val();
    var bin_list_id = $('#bin_list').val();

    var data_inputs = '<div class="data_items_'+dataClass+'">' +
        '<input type="hidden" name="bin_items_id[]" value="'+bin_items_id+'">' +
        '<input type="hidden" name="bin_qty[]" value="'+bin_qty+'">' +
        '<input type="hidden" name="item_location_id[]" value="'+item_location_id+'">' +
        '<input type="hidden" name="bin_new_qty[]" value="'+bin_new_qty+'">' +
        '<input type="hidden" name="bin_list_id[]" value="'+bin_list_id+'">' +
        '</div>';
    $('.hidden_values').append(data_inputs);
});

$('.item_addBtn').click(function () {
    var num = 0;
    $("#itemTbl tbody tr").each(function() {
        var data = $(this).children('td:nth-child(2)').text();
        num += parseInt(data);
    });
    $('#is_add').val('1');

    var qty = $('.qty_bin_items_value').val();

    if (num < qty) {
        $('.error').html('<div class="alert alert-danger alert-dismissible" role="alert">\n' +
            '<button type="button" class="close alert_close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>\n' +
            'You still have a remaining quantity\n' +
            '</div>');
    } else if (num > qty) {
        $('.error').html('<div class="alert alert-danger alert-dismissible" role="alert">\n' +
            '<button type="button" class="close alert_close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>\n' +
            'Entered quantity exceeds the maximum limit\n' +
            '</div>');
    } else {
        $('#binModal').modal('toggle');
    }
});

$('.item_cancelBtn').click(function () {
    var dataClass = $('.dataClass').val();
    var bin_item = $('#is_add').val();

    if (bin_item == '1') {
        $('#binModal').modal('toggle');
    } else {
        $('.data_items_'+dataClass).remove();
    }
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
    });
}
