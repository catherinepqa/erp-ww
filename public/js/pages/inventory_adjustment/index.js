$(function() {
    $(".accordion-thumb").click(function() {
        $(this).closest( "li" ).toggleClass("is-active").children(".accordion-panel").slideToggle("ease-out");
    });

    $('.js-exportable').DataTable({
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend:    'copyHtml5',
                text:      '<i class="fa fa-files-o"></i>',
                titleAttr: 'Copy'
            },
            {
                extend:    'csvHtml5',
                text:      '<i class="fa fa-file-excel-o"></i>',
                titleAttr: 'Excel'
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fa fa-file-pdf-o"></i>',
                titleAttr: 'PDF'
            },
            {
                extend:    'print',
                text:      '<i class="fa fa-print"></i>',
                titleAttr: 'Print'
            }
        ],
        ajax: data_url,
        type: "GET",
        columns:[
            {data: "inventory_adjustment_id"},
            {data: "inventory_adjustment_id"},
            {data: "adjustment_date"},
            {data: "reference_no"},
            {data: "created_by"},
            {data: "adjustment_account"},
            {data: "memo"},
        ],
        columnDefs: [
            {
                targets: 0,
                'render': function (data, type, row){
                    return '<a href="#" class="edit" title="Edit" onclick="editData('+data+')"><i class="fa fa-pencil"></i></a>  ' +
                        '<a href="#" class="view" title="View" onclick="viewData('+data+')" style="margin-left: 30%;"><i class="fa fa-eye"></i></a>';
                }
            },
        ]
    });
});

function editData(id) {
    var url = edit_url;
    url = url.replace(':slug', id);
    window.location.href=url;
}

function viewData(id) {
    var url = view_url;
    url = url.replace(':slug', id);
    window.location.href=url;
}
