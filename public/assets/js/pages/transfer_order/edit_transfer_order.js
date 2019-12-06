$(function() {
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

    tableList(system_id);
});

function tableList(id) {
    $.ajax({
        "url": ajaxTbl,
        method: 'GET',
        data: {'id': id},
        success: function (data) {
            $('#itemsTbl').DataTable({
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
                    {data: "qty_transferred"},
                    {data: "transfer_price"},
                    {data: "unit"},
                    {data: "amount"},
                    {data: "desc"},
                    {data: "transfer_order_id"},
                    {data: "expected_receipt_date"},
                    {data: "commit"},
                    {data: "transfer_order_id"},
                    {data: "order_priority"},
                    {data: "transfer_order_id"},
                    {data: "transfer_order_id"},
                    {data: "system_id"},
                ],
                language : {
                    "zeroRecords": " "
                },
                "aaSorting": [[ 13, 'asc' ]],
                columnDefs: [
                    // {
                    //     targets: 5,
                    //     'render': function (data, type, row){
                    //         var action_type = '';
                    //         var dataClass ='';
                    //         var qty_on_hand = '';
                    //         if (data != '10000') {
                    //             action_type = "saved_data";
                    //             dataClass = 'IA'+'_'+row['system_id'];
                    //         } else {
                    //             action_type = "virtual";
                    //             dataClass = 'VD_'+row['system_id'];
                    //         }
                    //         if (row['qty_on_hand'] == '') {
                    //             qty_on_hand = 0;
                    //         } else {
                    //             qty_on_hand = row['qty_on_hand'];
                    //         }
                    //         return '<a href="#/" class="detailBtn_'+dataClass+'" ' +
                    //             'onclick="inventoryDetail(\''+row['item_code']+'\',\''+dataClass+'\','+qty_on_hand+', ' +
                    //             '\''+row['desc']+'\','+row['system_id']+','+row['item_id']+',\''+action_type+'\')"> <i class="fa fa-cube"></i></a>';
                    //     }
                    // },
                    // {
                    //     targets: [8,9],
                    //     visible: false
                    // },
                    {
                        targets: 13,
                        'render': function (data, type, row){
                            var action_type = '';
                            var dataClass ='';
                            if (row['transfer_order_id'] != '10000') {
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
                    $('.commit_value').append('<input type="hidden" class="data_8_'+dataClass+'" value="'+value.commit_id+'">' +
                        '<input type="hidden" class="saved_item_id'+dataClass+'" value="'+value.item_id+'">' +
                        '<input type="hidden" class="saved_unit_id'+dataClass+'" value="'+value.unit_type_id+'">');
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

function editData(dataClass, id) {
    $('#updateModal').modal({
        backdrop: 'static',
        keyboard: false
    }, 'show');

    var $row = $('.edit_'+dataClass).closest("tr");
    var actions = '<a href="#/" class="save_edit_'+dataClass+' btn btn-success" onclick="saveEdit(\''+dataClass+'\')">Update</a> ' +
        '<a href="#/" class="cancel_edit_'+dataClass+' btn btn-danger" onclick="cancelEdit(\''+dataClass+'\')">Cancel</a>';

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

    $('.data_id').val(id);
    //$('.edit_item_code').val($('.item_code_value').val());
}

function saveEdit(dataClass) {
    var $row = $('.edit_'+dataClass).closest("tr");
    var item_id = '';
    var unit_id = '';

    if ($('.edit_item_id').val() == '') {
        item_id = $('.saved_item_id'+dataClass).val();
    } else {
        item_id = $('.edit_item_id').val();
    }

    if ($('.edit_unit_id').val() == '') {
        unit_id = $('.saved_unit_id'+dataClass).val();
    } else {
        unit_id = $('.edit_unit_id').val();
    }

    var data_inputs = '<div class="saved_order_data_'+dataClass+'">' +
        '<input type="hidden" name="data_id[]" value="'+$('.data_id').val()+'"">' +
        '<input type="hidden" name="item_id[]" value="'+item_id+'" class="data_1_'+dataClass+'">' +
        '<input type="hidden" name="qty[]" value="'+$('.edit_data_3').val()+'" class="data_2_'+dataClass+'">' +
        '<input type="hidden" name="units[]" value="'+unit_id+'" class="data_3_'+dataClass+'">' +
        '<input type="hidden" name="transfer_price[]" value="'+$('.edit_data_5').val()+'" class="data_4_'+dataClass+'">' +
        '<input type="hidden" name="amount[]" value="'+$('.edit_data_6').val()+'" class="data_5_'+dataClass+'">' +
        '<input type="hidden" name="receipt_date[]" value="'+$('.edit_data_7').val()+'" class="data_7_'+dataClass+'">' +
        '<input type="hidden" name="commit[]" value="'+$('.edit_data_8').val()+'" class="data_8_'+dataClass+'">' +
        '<input type="hidden" name="order_priority[]" value="'+$('.edit_data_9').val()+'" class="data_9_'+dataClass+'">' +
        '</div>';
    $('.update_hidden_values').append(data_inputs);

    $row.find("td:eq(0)").html($('.edit_data_1').val());
    $row.find("td:eq(1)").html($('.edit_data_3').val());
    $row.find("td:eq(2)").html($('.edit_data_5').val());
    $row.find("td:eq(3)").html($('.edit_data_4').val());
    $row.find("td:eq(4)").html($('.edit_data_6').val());
    $row.find("td:eq(7)").html($('.edit_data_7').val());
    $row.find("td:eq(8)").html($('.edit_data_8 option:selected').text());
    $row.find("td:eq(10)").html($('.edit_data_9').val());

    $('#updateModal').modal('toggle');
}

//ADD
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

$('.addBtn').click(function () {

    if ($('.data_1').val() == '') {
        $('.data_1_error').removeClass('hidden');
        $('.data_1').addClass('required_field');
    } else {
        var count = counter++;
        var actions = '<a href="#/" class="edit_'+count+'" onclick="editData('+count+')"><i class="fa fa-pencil"></i></a> ' +
            '<a href="#/" class="delete_'+count+'" onclick="deleteRow('+count+')"><i class="fa fa-trash-o"></i></a>';

        $('#itemsTbl').DataTable().row.add( {
            "item_name"             :   $('.data_1').val(),
            "qty_transferred"       :   $('.data_3').val(),
            "transfer_price"        :   $('.data_5').val(),
            "unit"                  :   $('.data_4').val(),
            "amount"                :   $('.data_6').val(),
            "desc"                  :   $('.data_2').val(),
            "transfer_order_id"     :   "",
            "expected_receipt_date" :   $('.data_7').val(),
            "commit"                :   $('.data_8 option:selected').text(),
            "transfer_order_id"     :   "",
            "order_priority"        :   $('.data_9').val(),
            "transfer_order_id"     :   "",
            "transfer_order_id"     :   "10000",
            "system_id"             :   count
        } ).draw();

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
    $('.data_1_error').addClass('hidden');
    $('.data_1').removeClass('required_field');
}

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
            $('.delete_hidden_values').append('<input type="hidden" name="to_deleted_id[]" value="'+id+'">');
            $('.saved_order_data_'+dataClass).remove();
            //$('.saved_item_data_'+dataClass).remove();
        } else {
            $('.add_order_data_'+dataClass).remove();
            //$('.data_items_'+dataClass).remove();
        }
        $row.remove();
    });
}
