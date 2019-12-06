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

$.ajax({
    "url": data_url,
    method: 'GET',
    success: function (data) {
        $('.js-exportable').DataTable({
            responsive: true,
            // bPaginate: false,
            // bLengthChange: false,
            bFilter: false,
            // bInfo: false,
            // bAutoWidth: false,
            //iDisplayLength: -1,
            bDestroy: true,
            data: data,
            columns:[
                {data: "id"},
                {data: "date"},
                {data: "order_number"},
                {data: "employee"},
                {data: "memo"},
                {data: "from_location"},
                {data: "to_location"},
                {data: "amount"}
            ],
            columnDefs: [
                {
                    targets: 0,
                    order: false,
                    'render': function (data, type, row){

                        return '<input type="checkbox" name="id[]" id="'+data+'">';
                    }
                },
            ]
        });
    },
    error: function () {
    }
});

$('.submit').click(function () {

    var selectedID = [];

    $(':checkbox[name="id[]"]:checked').each (function () {
        selectedID.push(this.id);
    });

    console.log(selectedID);
    $('.delete_id').val(selectedID);

    $('#deleteForm').submit();
});
