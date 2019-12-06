$(function() {
    $(".demo2").trigger("click");
    tableList(page_id);
});

$('.demo2').click(function(){
    swal({
        title: "Good job!",
        text: success_msg,
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
                        targets: [13,14,15,16,17],
                        visible: false
                    }
                ]
            });
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

    $.ajax({
        url: getAdjustedBins,
        data: { data_id : data_id },
        type: 'GET',
        dataType: 'JSON',
        success: function(data) {
            $.each( data, function( key, value ) {
                var inputs = '<tr>\n' +
                    '<td>'+value.bin_no+'</td>\n' +
                    '<td>'+value.qty+'</td>\n' +
                    '</tr>';
                $('#itemTbl tbody').append(inputs);
            });
        }
    });
    $(".alert_close").trigger("click");
}
