$(function() {
    $(".demo2").trigger("click");
    tableList(page_id);
});

$('.demo2').click(function(){
    swal({
        title: "Good job!",
        text: 'test',
        type: "success"
    });
});

$('#date').datepicker({
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

function tableList(id) {
    $.ajax({
        "url": ajaxTbl,
        method: 'GET',
        data: {'id': id},
        success: function (data) {
            $('#adjTbl').DataTable({
                responsive: true,
                bPaginate: false,
                bLengthChange: false,
                bFilter: false,
                bInfo: false,
                bAutoWidth: false,
                iDisplayLength: -1,
                bDestroy: true,
                data: data,
                columns:[
                    {data: "item_name"},
                    {data: "desc"},
                    {data: "location"},
                    {data: "unit"},
                    {data: "qty_hand"},
                    {data: "c_value"},
                    {data: "created_by"},
                    {data: "qty_adjusted"},
                    {data: "est_total_cost"},
                    {data: "inventory"},
                    {data: "dept_name"},
                    {data: "item_category_name"},
                    {data: "adj_memo"},
                    {data: "id"},
                    {data: "location_id"},
                    {data: "item_code"},
                    {data: "item_id"},
                    {data: "ia_bin_id"},
                ],
                language : {
                    "zeroRecords": " "
                },
                columnDefs: [
                    {
                        targets: 9,
                        'render': function (data, type, row){
                            var action_type = '';
                            var dataClass ='';
                            if (row['id'] != '10000') {
                                action_type = "saved_data";
                                dataClass = 'IA'+'_'+row['id'];
                            } else {
                                action_type = "virtual";
                                dataClass = 'VD_'+data;
                            }
                            return '<a href="#/" class="detailBtn_'+dataClass+'" ' +
                                'onclick="inventoryDetail(\''+dataClass+'\',\''+action_type+'\','+row['item_id']+',' +
                                ''+row['location_id']+', \''+row['item_code']+'\','+row['ia_bin_id']+')"> <i class="fa fa-cube"></i></a>';
                        }
                    },
                    {
                        targets: [14,15,16,17],
                        visible: false
                    },
                    {
                        targets: 13,
                        'render': function (data, type, row){
                            var action_type = '';
                            var dataClass ='';
                            if (row['id'] != '10000') {
                                action_type = "saved_data";
                                dataClass = 'IA'+'_'+row['id'];
                            } else {
                                action_type = "virtual";
                                dataClass = 'VD_'+data;
                            }
                            return '<a href="#" class="edit_'+dataClass+'" onclick="editData(\''+dataClass+'\')"><i class="fa fa-pencil"></i></a>  ' +
                                '<a href="#" class="delete_'+dataClass+'" onclick="deleteRow(\''+dataClass+'\',\''+action_type+'\','+row['id']+')"><i class="fa fa-trash-o"></i></a>';
                        }
                    },
                ]
            });

            if (data.length !== 0) {
                $.each( data, function( key, value ) {
                    dataClass = 'IA'+'_'+value.id;
                    var inputs = '<div class="saved_data_'+dataClass+'">' +
                        '<input type="hidden" name="item_id[]" value="'+value.item_id+'" class="data_1_'+dataClass+'">' +
                        '<input type="hidden" name="desc[]" value="'+value.desc+'" class="data_2_'+dataClass+'">' +
                        '<input type="hidden" name="location[]" value="'+value.location_id+'" class="data_3_'+dataClass+'">' +
                        '<input type="hidden" name="units[]" value="'+value.unit_id+'" class="data_4_'+dataClass+'">' +
                        '<input type="hidden" name="qyt_on_hand[]" value="'+value.orig_qty_on_hand+'" class="data_5_'+dataClass+'">' +
                        '<input type="hidden" name="c_value[]" value="'+value.c_value+'" class="data_6_'+dataClass+'">' +
                        '<input type="hidden" name="adjust_by[]" value="'+value.created_by+'" class="data_7_'+dataClass+'">' +
                        '<input type="hidden" name="new_qty[]" value="'+value.qty_adjusted+'" class="data_8_'+dataClass+'">' +
                        '<input type="hidden" name="est_cost[]" value="'+value.est_total_cost+'" class="data_9_'+dataClass+'">' +
                        '<input type="hidden" name="dept[]" value="'+value.dept_id+'" class="dept_id'+dataClass+'">' +
                        '<input type="hidden" name="item_cat[]" value="'+value.item_cat_id+'" class="item_cat_id'+dataClass+'">' +
                        '<input type="hidden" name="adj_memo[]" value="'+value.adj_memo+'" class="data_13_'+dataClass+'">' +
                        '<input type="hidden" name="inventory_item_id[]" value="'+value.inventory_items_id+'" class="inventory_item_id'+dataClass+'">' +
                        '<input type="hidden" name="adjusted_id[]" value="'+value.id+'" class="adjusted_id_'+dataClass+'">' +
                        '<input type="hidden" value="'+value.item_code+'" class="item_code_'+dataClass+'">' +
                        '</div>';
                    $('.update_hidden_values').append(inputs);
                });
            }
        },
        error: function () {
        }
    })
}

//INVENTORY DETAIL
function inventoryDetail(dataClass, type, item_id, location_id, item_code, data_id) {
    $('#binModal').modal({
        backdrop: 'static',
        keyboard: false
    }, 'show');

    var $row = $('.detailBtn_'+dataClass).closest("tr");
    $('.qty_bin_items').html($row.find("td:eq(7)").text());
    $('.desc_bin_items_value').html($row.find("td:eq(1)").text());
    $('.bin_items').html(item_code);

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

    $.ajax({
        url: getAdjustedBins,
        data: { data_id : data_id },
        type: 'GET',
        dataType: 'JSON',
        success: function(data) {
            var action = '<a href="#/" class="delete_item_'+dataClass+'" onclick="deleteItemRow(\''+dataClass+'\',\''+type+'\','+data_id+')"><i class="fa fa-trash-o"></i></a>';

            $.each( data, function( key, value ) {
                var inputs = '<tr>\n' +
                    '<td>'+value.bin_no+'</td>\n' +
                    '<td>'+value.qty+'</td>\n' +
                    '<td>'+action+'</td>\n' +
                    '</tr>';
                $('#itemTbl tbody').append(inputs);

                var data_inputs = '<div class="data_items_'+dataClass+'">' +
                    '<input type="hidden" name="bin_items_id[]" class="edit_bin_items_id_'+dataClass+'" value="'+item_id+'">' +
                    '<input type="hidden" name="bin_qty[]" class="edit_bin_qty_'+dataClass+'" value="'+$row.find("td:eq(7)").text()+'">' +
                    '<input type="hidden" name="item_location_id[]" class="edit_item_location_id_'+dataClass+'" value="'+location_id+'">' +
                    '<input type="hidden" name="bin_new_qty[]" class="edit_bin_new_qty_'+dataClass+'" value="'+value.qty+'">' +
                    '<input type="hidden" name="bin_list_id[]" class="edit_bin_list_id_'+dataClass+'" value="'+value.bin_id+'">' +
                    '<input type="hidden" name="adjusted_bin_id[]" class="edit_adjusted_bin_id_'+dataClass+'" value="'+value.inventory_adjustment_id+'">' +
                    '</div>';
                $('.update_hidden_values').append(data_inputs);
            });
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

function deleteItemRow(dataClass, type, data_id) {
    swal({
        title: "Are you sure you want to remove this data?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Yes",
        closeOnConfirm: true
    }, function () {
        var $row = $('.delete_item_'+dataClass).closest("tr");

        if (type == 'saved_data') {
            $('.delete_hidden_values').append('<input type="hidden" name="ia_bin_items_deleted_id[]" value="'+data_id+'">');
            $('.data_items_'+dataClass).addClass('delete_this_'+dataClass+'');
            $row.remove();
        } else {
            $row.remove();
        }
    });
}

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
        var dataClass = $('.dataClass').val();
        $('.delete_this_'+dataClass).remove();
    }
});

$('.item_cancelBtn').click(function () {
    var dataClass = $('.dataClass').val();
    var bin_item = $('#is_add').val();

    if (bin_item == '1') {
        $('#binModal').modal('toggle');
    } else {
        $('.data_items_'+dataClass).remove();
        $('#binModal').modal('toggle');
    }
});

$('.itemAdd').click(function () {
    var dataClass = $('.dataClass').val();
    var type = 'virtual';
    var action = '<a href="#/" class="delete_item_'+dataClass+'" onclick="deleteItemRow(\''+dataClass+'\',\''+type+'\')"><i class="fa fa-trash-o"></i></a>';

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
        '<input type="hidden" name="add_bin_items_id[]" value="'+bin_items_id+'">' +
        '<input type="hidden" name="add_bin_qty[]" value="'+bin_qty+'">' +
        '<input type="hidden" name="add_item_location_id[]" value="'+item_location_id+'">' +
        '<input type="hidden" name="add_bin_new_qty[]" value="'+bin_new_qty+'">' +
        '<input type="hidden" name="add_bin_list_id[]" value="'+bin_list_id+'">' +
        '</div>';
    $('.add_hidden_values').append(data_inputs);
});

//UPDATE DATA
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

function editData(dataClass) {
    $('#updateModal').modal({
        backdrop: 'static',
        keyboard: false
    }, 'show');

    var $row = $('.edit_'+dataClass).closest("tr");
    var actions = '<a href="#/" class="save_edit_'+dataClass+' btn btn-success" onclick="saveEdit(\''+dataClass+'\')">Update</a> ' +
        '<a href="#/" class="cancel_edit_'+dataClass+' btn btn-danger" onclick="cancelEdit(\''+dataClass+'\')">Cancel</a>';

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
    $('.item_code_value').val($('.item_code_'+dataClass).val());
    $('.inventory_item_id_value').val($('.inventory_item_id'+dataClass).val());
}

function saveEdit(dataClass) {
    var $row = $('.edit_'+dataClass).closest("tr");
    $row.find("td:eq(0)").html($('.data_1_value').val());
    $row.find("td:eq(1)").html($('.data_2_value').val());
    $row.find("td:eq(2)").html($('.data_3_value option:selected').text());
    $row.find("td:eq(3)").html($('.data_4_value').val());
    $row.find("td:eq(4)").html($('.data_5_value').val());
    $row.find("td:eq(5)").html($('.data_6_value').val());
    $row.find("td:eq(6)").html($('.data_7_value').val());
    $row.find("td:eq(7)").html($('.data_8_value').val());
    $row.find("td:eq(8)").html($('.data_9_value').val());
    // $row.find("td:eq(9)").html(int_detail);
    $row.find("td:eq(10)").html($('.data_11_value').val());
    $row.find("td:eq(11)").html($('.data_12_value').val());
    $row.find("td:eq(12)").html($('.data_13_value').val());
    // $row.find("td:eq(13)").html(actions);
    $('#adjTbl').DataTable().draw();

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
    //$row.find("td:eq(13)").html(actions);

    $('#updateModal').modal('toggle');
}

//ADD DATA
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

var counter = 0;

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

        $('#adjTbl').DataTable().row.add( {
            "item_name"             :   $('.data_1').val(),
            "desc"                  :   $('.data_2').val(),
            "location"              :   $('.data_3 option:selected').text(),
            "unit"                  :   $('.data_4').val(),
            "qty_hand"              :   $('.data_5').val(),
            "c_value"               :   $('.data_6').val(),
            "created_by"            :   $('.data_7').val(),
            "qty_adjusted"          :   $('.data_8').val(),
            "est_total_cost"        :   $('.data_9').val(),
            "inventory"             :   count,
            "dept_name"             :   $('.data_11').val(),
            "item_category_name"    :   $('.data_12').val(),
            "adj_memo"              :   $('.data_13').val(),
            "id"                    :   "10000",
            "location_id"           :   $('.data_3').val(),
            "item_code"             :   $('.item_code').val(),
            "item_id"               :   $('.item_id').val(),
            "ia_bin_id"             :   0,
        } ).draw();

        var data_inputs = '<div class="add_adjustment_data_VD_'+count+'">' +
            '<input type="hidden" name="add_item_id[]" value="'+$('.item_id').val()+'" class="data_1_'+count+'">' +
            '<input type="hidden" name="add_desc[]" value="'+$('.data_2').val()+'" class="data_2_'+count+'">' +
            '<input type="hidden" name="add_location[]" value="'+$('.data_3').val()+'" class="data_3_'+count+'">' +
            '<input type="hidden" name="add_units[]" value="'+$('.unit_id').val()+'" class="data_4_'+count+'">' +
            '<input type="hidden" name="add_qyt_on_hand[]" value="'+$('.data_5').val()+'" class="data_5_'+count+'">' +
            '<input type="hidden" name="add_c_value[]" value="'+$('.data_6').val()+'" class="data_6_'+count+'">' +
            '<input type="hidden" name="add_adjust_by[]" value="'+$('.data_7').val()+'" class="data_7_'+count+'">' +
            '<input type="hidden" name="add_new_qty[]" value="'+$('.data_8').val()+'" class="data_8_'+count+'">' +
            '<input type="hidden" name="add_est_cost[]" value="'+$('.data_9').val()+'" class="data_9_'+count+'">' +
            // '<input type="hidden" name="int_detail[]" value="'+$('.data_10').val()+'">' +
            '<input type="hidden" name="add_dept[]" value="'+$('.dept_id').val()+'" class="dept_id'+count+'">' +
            '<input type="hidden" name="add_item_cat[]" value="'+$('.item_cat_id').val()+'" class="item_cat_id'+count+'">' +
            '<input type="hidden" name="add_adj_memo[]" value="'+$('.data_13').val()+'" class="data_13_'+count+'">' +
            '<input type="hidden" name="add_inventory_item_id[]" value="'+$('.inventory_item_id').val()+'" class="inventory_item_id'+count+'">' +
            '</div>';
        $('.add_hidden_values').append(data_inputs);
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
    $('#updateDataForm').submit();
});

function deleteRow(dataClass, type, id) {
    swal({
        title: "Are you sure you want to remove this data?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Yes",
        closeOnConfirm: true
    }, function () {
        var $row = $('.delete_'+dataClass).closest("tr");
        if (type == 'saved_data') {
            $('.delete_hidden_values').append('<input type="hidden" name="ia_deleted_id[]" value="'+id+'">');
            $('.saved_data_'+dataClass).remove();
            $('.data_items_'+dataClass).remove();
            $row.remove();
        } else {
            $('.add_adjustment_data_'+dataClass).remove();
            $('.data_items_'+dataClass).remove();
        }
    });
}
