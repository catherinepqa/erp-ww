@extends('template')

@section('title', 'Stock Available By Location')

@section('css')

@endsection

@section('breadcrumb')
    <div class="col-md-6 col-sm-12">
        <h1>Stock Available By Location Report</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Reports</li>
                <li class="breadcrumb-item active">Stock Available By Location</li>
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
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Location</label>
                                                <select class="form-control" id="location_id">
                                                    <option>Select...</option>
                                                    @foreach ($locations as $location)
                                                        <option value="{{ $location->location_id }}">{{ $location->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
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
                            <table class="table table-bordered table-striped table-hover dataTable stockAvailableTbl">
                                <thead>
                                    <tr>
                                        <th>EXTERNAL ID</th>
                                        <th>DISPLAY NAME</th>
                                        <th>LOCATION AVAILABLE</th>
                                        <th>LOCATION PREFERRED STOCK LEVEL</th>
                                        <th>OVERSELL</th>
                                        <th>DISPLAY IN WEBSITE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="hidden_values" style="display: none">
                        @include('report_partials._printStockAvailable');
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

    function printReport()
    {
        // $('#printDatatable').DataTable().destroy();
        $('.oldTr').remove();
        $('#stockAvailable').printThis();
        window.close();
    }

    function filter()
    {
        var location_id = $('#location_id').val();

        $.ajax({
            url: "{{ action('ReportsController@filterStockAvailable') }}",
            method: 'GET',
            dataType: "json",
            data: {'location_id' : location_id},
            success: function (data) {
                if (data != '') {
                    var stock = [];

                    $.each(data, function (key, value) {
                        stock.push(
                            '<tr class="newTr">\n' +
                            '<td>'+ value.system_id +'</td>\n' +
                            '<td>'+ value.items.item_name +'</td>\n' +
                            '<td>'+ value.qty_on_hand +'</td>' +
                            '<td>'+ value.preferred_stock_level +'</td>\n' +
                            '<td>Yes</td>\n' +
                            '<td>No</td>\n' +
                            '</tr>');

                         return
                    });
                    $('.stockAvailableTbl tbody').append(stock);
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
        var location_id = $('#location_id').val();
        var type        = btn.getAttribute('data-name');

        $.ajax({
            url: "{{ action('ReportsController@exportStockAvailable') }}",
            method: 'GET',
            xhrFields: {
                responseType: 'blob'
            },
            data: {'location_id' : location_id, 'type': type},
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
