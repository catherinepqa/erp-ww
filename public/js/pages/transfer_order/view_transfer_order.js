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
                    {data: "system_id"},
                    {data: "expected_receipt_date"},
                    {data: "commit"},
                    {data: "system_id"},
                    {data: "order_priority"},
                    {data: "system_id"},
                    {data: "system_id"}
                ],
                language : {
                    "zeroRecords": " "
                }
            });
        },
        error: function () {
        }
    })
}

function editData(id) {
    var url = edit_url;
    url = url.replace(':slug', id);
    window.location.href=url;
}

$('.approve').click(function () {
   $('#updateStatus').submit();
});
