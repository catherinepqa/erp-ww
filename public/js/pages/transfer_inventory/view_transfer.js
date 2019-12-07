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
                    {data: "qty_transferred"},
                    {data: "qty_transferred"},
                    {data: "system_id"},
                    {data: "item_weight"},
                    {data: "country"},
                    {data: "item_code"},
                    {data: "item_id"},
                ],
                language : {
                    "zeroRecords": " "
                },
                columnDefs: [
                    {
                        targets: 5,
                        'render': function (data, type, row){
                            return '<a href="#/" class="detailBtn_'+data+'" ' +
                                'onclick="inventoryDetail(\''+row['item_code']+'\','+data+','+row['item_id']+')"> <i class="fa fa-cube"></i></a>';
                        }
                    },
                    {
                        targets: [8,9],
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
function inventoryDetail(item_code, dataClass, item_id) {
    $('#binModal').modal({
        backdrop: 'static',
        keyboard: false
    }, 'show');

    var $row = $('.detailBtn_'+dataClass).closest("tr");
    $('.bin_items').html(item_code);
    $('.qty_bin_items').html($row.find("td:eq(3)").text());
    $('.desc_bin_items').html($row.find("td:eq(1)").text());

    $.ajax({
        url: getTransferredBins,
        data: { id : dataClass, item : item_id },
        type: 'GET',
        dataType: 'JSON',
        success: function(data) {
            $('.append_data').remove();
            $.each( data, function( key, value ) {
                var inputs = '<tr class="append_data">\n' +
                    '<td>'+value.from_bin+'</td>\n' +
                    '<td>'+value.to_bin+'</td>\n' +
                    '<td>'+value.quantity+'</td>\n' +
                    '<td>'+value.quantity+'</td>\n' +
                    '</tr>';
                $('#itemTbl tbody').append(inputs);
            });
        }
    });
    $(".alert_close").trigger("click");
}

function editData(id) {
    var url = edit_url;
    url = url.replace(':slug', id);
    window.location.href=url;
}
