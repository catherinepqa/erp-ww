@extends('template')

@section('title', 'Sales by New Customer Country (Gross Amt)')

@section('css')

@endsection

@section('breadcrumb')
    <div class="col-md-6 col-sm-12">
        <h1>Sales by New Customer Country (Gross Amt) Report</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Reports</li>
                <li class="breadcrumb-item active">Sales by New Customer Country (Gross Amt)</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="body">
                <div class="row" style="margin-top: 3%;">
                    <div class="col-lg-12">
                        <ul class="accordion2">
                            <li class="accordion-item">
                                <h3 class="accordion-thumb"><span>Filter</span></h3>
                                <div class="accordion-panel" style="display: none;">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>Shipping Address Country</label>
                                                <select class="form-control" id="country">
                                                    <option>- All</option>
                                                    @foreach ($countries as $country)
                                                        <option value="{{ $country->name }}">{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>Sales Order Date Between </label>
                                                <input type="text" id="so_date_a" data-date-autoclose="true" class="form-control datepicker" name="so_date_a" placeholder="dd/mm/yyyy">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>And</label>
                                                <input type="text" id="so_date_b" data-date-autoclose="true" class="form-control datepicker" name="so_date_b" placeholder="dd/mm/yyyy">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <button class="btn btn-info pull-right" type="button" onClick="filter()" style="margin-top: 6%;">Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <br>
                <div class="col-lg-12">
                    <button type="button" name="button" class="btn btn-raised btn-default export" title="Excel" data-name="xlsx" onClick="exportReport(this);"><i class="fa fa-file-excel-o" aria-hidden="true" style="color:green"></i></button>
                    <button type="button" name="button" class="btn btn-raised btn-default export" title="PDF" data-name="pdf" onClick="exportReport(this);"><i class="fa fa-file-pdf-o" aria-hidden="true" style="color:red"></i></button>
                    <button type="button" name="button" class="btn btn-raised btn-default export" title="CSV" data-name="csv" onClick="exportReport(this);"><i class="fa fa-file-text" aria-hidden="true" style="color:blue"></i></button>
                    <button type="button" name="button" class="btn btn-raised btn-default" title="Print" onClick="printReport()"><i class="fa fa-print" aria-hidden="true"></i></button>
                </div>
                <div class="row" style="margin-top: 3%;">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable salesNewCustomer">
                                <thead>
                                    <tr>
                                        <th>COUNTRY</th>
                                        <th>CUSTOMER</th>
                                        <th>FIRST SALES DATA</th>
                                        <th>ORDER DATE</th>
                                        <th>SALES (GROSS) ()</th>
                                        <th>NUMBER OF CUSTOMERS ()</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="hidden_values" style="display: none">
                        @include('report_partials._printSalesNewCustomer');
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{ URL::asset('assets/js/printPage.js') }}"></script>
<script>
    $(".accordion-thumb").click(function() {
        $(this).closest( "li" ).toggleClass("is-active").children(".accordion-panel").slideToggle("ease-out");
    });

    $('.datepicker').datepicker({
        todayHighlight: true
    });

    function printReport()
    {
        // $('#printDatatable').DataTable().destroy();
        $('.oldTr').remove();
        $('#salesNewCustomer').printThis();
        window.close();
    }

    function filter()
    {
        var country = $('#country').val();
        var so_date_a = $('#so_date_a').val();
        var so_date_b = $('#so_date_b').val();

        $.ajax({
            url: "{{ action('ReportsController@filterSalesNewCustomer') }}",
            method: 'GET',
            dataType: "json",
            data: {'country' : country, 'so_date_a' : so_date_a, 'so_date_b' : so_date_b},
            success: function (data) {
                if (data.salesNew != '') {
                    var stock = [];

                    stock.push('<tr class="newTr">\n' +
                        '<td>'+ data.country +'</td>\n' +
                        '</tr>');

                    $.each(data.salesNew, function (key, value) {
                        stock.push(
                            '<tr class="newTr">\n' +
                            '<td> </td>\n' +
                            '<td>'+ value.customer_id +'</td>\n' +
                            '<td>'+ value.so_date +'</td>\n' +
                            '<td>'+ value.so_date +'</td>' +
                            '<td>'+ value.gross_amount +'</td>\n' +
                            '<td>#</td>\n' +
                            '</tr>');

                         return
                    });
                    $('.salesNewCustomer tbody').append(stock);
                } else {
                    $('.newTr').remove();
                }
            },
            error: function () {
            }
        });
    }

    function exportReport(btn)
    {
        var country   = $('#country').val();
        var so_date_a = $('#so_date_a').val();
        var so_date_b = $('#so_date_b').val();
        var type      = btn.getAttribute('data-name');

        $.ajax({
            url: "{{ action('ReportsController@exportSalesNewCustomer') }}",
            method: 'GET',
            xhrFields: {
                responseType: 'blob'
            },
            data: {'country' : country, 'so_date_a' : so_date_a, 'so_date_b' : so_date_b, 'type' : type},
            success: function (data) {
                var a = document.createElement('a');
                var url = window.URL.createObjectURL(data);
                a.href = url;
                a.download = 'myfile.' + type;
                document.body.append(a);
                a.click();
                a.remove();
                window.URL.revokeObjectURL(url);
            },
            error: function () {
            }
        })
    }
</script>
@endsection
