$(function() {
    $('#date').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true,
    });

    tableList(system_id);
});

function tableList(id) {
    $.ajax({
        "url": ajaxTbl,
        method: 'GET',
        data: {'id': id},
        success: function (data) {
            $('#transTbl').DataTable({
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
                    {data: "unit"},
                    {data: "qty_on_hand"},
                    {data: "qty_transferred"},
                    {data: "int"},
                    {data: "item_weight"},
                    {data: "country"},
                    {data: "item_code"},
                    {data: "item_id"},
                    {data: "system_id"},
                ],
                language : {
                    "zeroRecords": " "
                },
                "aaSorting": [[ 10, 'asc' ]],
                columnDefs: [
                    {
                        targets: 5,
                        'render': function (data, type, row){
                            var action_type = '';
                            var dataClass ='';
                            var qty_on_hand = '';
                            if (data != '10000') {
                                action_type = "saved_data";
                                dataClass = 'IA'+'_'+row['system_id'];
                            } else {
                                action_type = "virtual";
                                dataClass = 'VD_'+row['system_id'];
                            }
                            if (row['qty_on_hand'] == '') {
                                qty_on_hand = 0;
                            } else {
                                qty_on_hand = row['qty_on_hand'];
                            }
                            return '<a href="#/" class="detailBtn_'+dataClass+'" ' +
                                'onclick="inventoryDetail(\''+row['item_code']+'\',\''+dataClass+'\','+qty_on_hand+', ' +
                                '\''+row['desc']+'\','+row['system_id']+','+row['item_id']+',\''+action_type+'\')"> <i class="fa fa-cube"></i></a>';
                        }
                    },
                    {
                        targets: [8,9],
                        visible: false
                    },
                    {
                        targets: 10,
                        'render': function (data, type, row){
                            var action_type = '';
                            var dataClass ='';
                            var country_id = '';
                            if (row['int'] != '10000') {
                                action_type = "saved_data";
                                dataClass = 'IA'+'_'+data;
                            } else {
                                action_type = "virtual";
                                dataClass = 'VD_'+data;
                            }
                            return '<a href="#" class="edit_'+dataClass+'" onclick="editData(\''+dataClass+'\','+data+')"><i class="fa fa-pencil"></i></a>  ' +
                                '<a href="#" class="delete_'+dataClass+'" onclick="deleteRow(\''+dataClass+'\',\''+action_type+'\','+data+')"><i class="fa fa-trash-o"></i></a>';
                        }
                    },
                ]
            });
            if (data.length !== 0) {
                $.each( data, function( key, value ) {
                    dataClass = 'IA'+'_'+value.system_id;
                    $('.country_id').append('<input type="hidden" class="data_7_'+dataClass+'" value="'+value.manufacturer_country+'">');
                });
            }
        },
        error: function () {
        }
    })
}

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

function editData(dataClass, id) {
    $('#updateModal').modal({
        backdrop: 'static',
        keyboard: false
    }, 'show');

    var $row = $('.edit_'+dataClass).closest("tr");
    var actions = '<a href="#/" class="save_edit_'+dataClass+' btn btn-success" onclick="saveEdit(\''+dataClass+'\')">Update</a> ' +
        '<a href="#/" class="cancel_edit_'+dataClass+' btn btn-danger" onclick="cancelEdit(\''+dataClass+'\')">Cancel</a>';

    var hidden_values = '<input type="hidden" value="'+$row.find("td:eq(0)").text()+'" class="data1_edit_value'+dataClass+'">' +
        '<input type="hidden" value="'+$row.find("td:eq(1)").text()+'" class="data2_edit_value'+dataClass+'">' +
        '<input type="hidden" value="'+$row.find("td:eq(2)").text()+'" class="data3_edit_value'+dataClass+'">' +
        '<input type="hidden" value="'+$row.find("td:eq(3)").text()+'" class="data4_edit_value'+dataClass+'">' +
        '<input type="hidden" value="'+$row.find("td:eq(4)").text()+'" class="data5_edit_value'+dataClass+'">' +
        '<input type="hidden" value="'+$row.find("td:eq(6)").text()+'" class="data6_edit_value'+dataClass+'">' +
        '<input type="hidden" value="'+$('.data_7_'+dataClass).val()+'" class="data7_edit_value'+dataClass+'">';
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
    $('.data_id').val(id);
}

function saveEdit(dataClass) {
    var $row = $('.edit_'+dataClass).closest("tr");

    var inputs = '<div class="saved_data_'+dataClass+'">' +
        '<input type="hidden" name="data_id[]" value="'+$('.data_id').val()+'"">' +
        '<input type="hidden" name="item_id[]" value="'+$('.item_id_value').val()+'" class="data_1_'+dataClass+'">' +
        '<input type="hidden" name="desc[]" value="'+$('.data_2_value').val()+'" class="data_2_'+dataClass+'">' +
        '<input type="hidden" name="units[]" value="'+$('.unit_id_value').val()+'" class="data_3_'+dataClass+'">' +
        '<input type="hidden" name="qty_transfer[]" value="'+$('.data_4_value').val()+'" class="data_4_'+dataClass+'">' +
        '<input type="hidden" name="weight[]" value="'+$('.data_6_value').val()+'" class="data_6_'+dataClass+'">' +
        '<input type="hidden" name="country[]" value="'+$('.data_7_value').val()+'" class="data_7_'+dataClass+'">' +
        '</div>';
    $('.update_hidden_values').append(inputs);

    $row.find("td:eq(0)").html($('.data_1_value').val());
    $row.find("td:eq(1)").html($('.data_2_value').val());
    $row.find("td:eq(2)").html($('.data_3_value').val());
    $row.find("td:eq(3)").html($('.data_4_value').val());
    $row.find("td:eq(4)").html($('.data_5_value').val());
    $row.find("td:eq(6)").html($('.data_6_value').val());
    $row.find("td:eq(7)").html($('.data_7_value option:selected').text());

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

var counter = 0;

//ADDING ROW
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

$('.addBtn').click(function () {

    if ($('.data_1').val() == '') {
        $('.data_1_error').removeClass('hidden');
        $('.data_1').addClass('required_field');
    } else {
        var count = counter++;

        console.log($('.data_4').val());

        $('#transTbl').DataTable().row.add( {
            "item_name"         :   $('.data_1').val(),
            "desc"              :   $('.data_2').val(),
            "unit"              :   $('.data_3').val(),
            "qty_on_hand"       :   $('.data_4').val(),
            "qty_transferred"   :   $('.data_5').val(),
            "int"               :   "10000",
            "item_weight"       :   $('.data_6').val(),
            "country"           :   $('.data_7 option:selected').text(),
            "item_code"         :   $('.item_code').val(),
            "item_id"           :   $('.item_id').val(),
            "system_id"         :   count
        } ).draw();


        var data_inputs = '<div class="add_transfer_data_'+count+'">' +
            '<input type="hidden" name="item_id[]" value="'+$('.item_id').val()+'" class="data_1_VD_'+count+'">' +
            '<input type="hidden" name="desc[]" value="'+$('.data_2').val()+'" class="data_2_VD_'+count+'">' +
            '<input type="hidden" name="units[]" value="'+$('.unit_id').val()+'" class="data_3_VD_'+count+'">' +
            '<input type="hidden" name="qty_transfer[]" value="'+$('.data_5').val()+'" class="data_4_VD_'+count+'">' +
            '<input type="hidden" name="weight[]" value="'+$('.data_6').val()+'" class="data_5_VD_'+count+'">' +
            '<input type="hidden" name="country[]" value="'+$('.data_7').val()+'" class="data_7_VD_'+count+'">' +
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
    $('.data_1_error').addClass('hidden');
    $('.data_1').removeClass('required_field');
}

//INVENTORY DETAIL MODAL
function inventoryDetail(item_code, dataClass, quantity, desc, id, item_id, type) {
    $('#binModal').modal({
        backdrop: 'static',
        keyboard: false
    }, 'show');

    $('.bin_items').html(item_code);
    $('.bin_items_id').val(item_id);
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

    $.ajax({
        url: getTransferredBins,
        data: { id : id},
        type: 'GET',
        dataType: 'JSON',
        success: function(data) {
            console.log(data);
            if (data.length !== 0) {
                $('.append_data').remove();
                var action = '<a href="#/" class="delete_item_'+dataClass+'" onclick="deleteItemRow(\''+dataClass+'\',\''+type+'\','+id+')"><i class="fa fa-trash-o"></i></a>';
                $.each( data, function( key, value ) {
                    var inputs = '<tr class="append_data">\n' +
                        '<td>'+value.from_bin+'</td>\n' +
                        '<td>'+value.to_bin+'</td>\n' +
                        '<td>'+value.quantity+'</td>\n' +
                        '<td>'+value.quantity+'</td>\n' +
                        '<td>'+action+'</td>\n' +
                        '</tr>';
                    $('#itemTbl tbody').append(inputs);

                    var data_inputs = '<div class="saved_item_data_'+dataClass+'">' +
                        '<input type="hidden" name="bin_data_id[]" value="'+value.system_id+'">' +
                        '<input type="hidden" name="from_bin_id[]" value="'+value.from_bin_id+'">' +
                        '<input type="hidden" name="to_bin_id[]" value="'+value.to_bin_id+'">' +
                        '<input type="hidden" name="transfer_bin_qty[]" value="'+value.quantity+'">';
                    '</div>';
                    $('.update_hidden_values').append(data_inputs);
                });
            }
            else {
                $('.append_data').remove();
            }
        }
    });

    $(".alert_close").trigger("click");
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
            if (data.length !== 0) {
                $('.available').val(data[0]['quantity']);
            }
        }
    });
}

$('.itemAdd').click(function () {
    var dataClass = $('.itemClass').val();
    var action_type = 'virtual';
    var action = '<a href="#/" class="delete_item_'+dataClass+'" onclick="deleteItemRow(\''+dataClass+'\',\''+action_type+'\',0)"><i class="fa fa-trash-o"></i></a>';

    var inputs = '<tr>\n' +
        '<td>'+$('#from_location_list option:selected').text()+'</td>\n' +
        '<td>'+$('#to_location_list option:selected').text()+'</td>\n' +
        '<td>'+$('.available').val()+'</td>\n' +
        '<td>'+$('.bin_quantity').val()+'</td>\n' +
        '<td>'+action+'</td>\n' +
        '</tr>';
    $('#itemTbl tbody').append(inputs);

    var data_inputs = '<div class="item_data_'+dataClass+'">' +
        '<input type="hidden" name="bin_items_id[]" value="'+$('.bin_items_id').val()+'">' +
        '<input type="hidden" name="from_bin_id[]" value="'+$('#from_location_list').val()+'">' +
        '<input type="hidden" name="to_bin_id[]" value="'+$('#to_location_list').val()+'">' +
        '<input type="hidden" name="transfer_bin_qty[]" value="'+$('.bin_quantity').val()+'">';
    '</div>';
    $('.add_hidden_values').append(data_inputs);
});

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
            $('.delete_hidden_values').append('<input type="hidden" name="ti_bin_items_deleted_id[]" value="'+data_id+'">');
            $('.saved_item_data_'+dataClass).addClass('delete_this_'+dataClass+'');
            $row.remove();
        } else {
            $row.remove();
        }
    });
}

$('.item_addBtn').click(function () {
    $('#is_add').val('1');
    $('#binModal').modal('toggle');
    var dataClass = $('.itemClass').val();
    $('.delete_this_'+dataClass).remove();
});

$('.item_cancelBtn').click(function () {
    var dataClass = $('.itemClass').val();
    var bin_item = $('#is_add').val();

    if (bin_item == '1') {
        $('#binModal').modal('toggle');
    } else {
        $('.saved_item_data_'+dataClass).remove();
        $('#binModal').modal('toggle');
    }
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
            $('.delete_hidden_values').append('<input type="hidden" name="ti_deleted_id[]" value="'+id+'">');
            $('.saved_data_'+dataClass).remove();
            $('.saved_item_data_'+dataClass).remove();
            $row.remove();
        } else {
            $('.add_adjustment_data_'+dataClass).remove();
            $('.data_items_'+dataClass).remove();
        }
    });
}

$('.btnSave').click(function () {
    $('#updateFormData').submit();
});
