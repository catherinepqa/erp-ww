@extends('template')

@section('title', 'Current Inventory Status')

@section('css')

@endsection

@section('breadcrumb')
    <div class="col-md-6 col-sm-12">
        <h1>Current Inventory Status Report</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Reports</li>
                <li class="breadcrumb-item active">Current Inventory Status</li>
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
                                                        <option value="{{ $location->location_id }}"> {{ $location->name }}</option>
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
                            <table class="table table-bordered table-striped table-hover dataTable inventoryTable" id="inventoryTable">
                                <thead>
                                    <tr>
                                        <th colspan="2">ITEM</th>
                                        <th colspan="7" class="loc_name"></th>
                                        <th colspan="7">TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Item</td>
                                        <td>DESCRIPTION</td>

                                        <td>Reorder Pt.</td>
                                        <td>Preferred Stock Level</td>
                                        <td>QTY on Work Order</td>
                                        <td>Current On Hand</td>
                                        <td>QTY Committed</td>
                                        <td>QTY Transit</td>
                                        <td>QTY on Back Order</td>

                                        <td>Reorder Pt.</td>
                                        <td>Preferred Stock Level</td>
                                        <td>QTY on Work Order</td>
                                        <td>Current On Hand</td>
                                        <td>QTY Committed</td>
                                        <td>QTY Transit</td>
                                        <td>QTY on Back Order</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="hidden_values" style="display: none">
                        @include('report_partials._printInventoryStatus');
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
        $('.newTr').remove();
        $('#inventoryStatus').printThis();
        window.close();
    }

    function filter()
    {
        var location_id = $('#location_id').val();

        $.ajax({
            url: "{{ action('ReportsController@filterInventoryStatus') }}",
            method: 'GET',
            dataType: "json",
            data: {'location_id' : location_id},
            success: function (data) {
                if (data.int != '') {
                    var items = [];
                    // $('.inventoryTable').DataTable().destroy();
                    var name = [];
                    $('.loc_name').html(data.int[0].loc_name);
                    $.each(data.int, function (key, value) {
                        if (name != value.name) {
                            items.push('<tr class="loadedTr">\n' +
                                '<td colspan="16">'+ value.name +'</td>\n' +
                                '</tr>\n' );

                            items.push(
                                '<tr class="loadedTr">\n' +
                                '<td>'+ value.item_name +'</td>\n' +
                                '<td>'+ value.item_description +'</td>\n' +
                                '<td>0</td>' +
                                '<td>'+ (value.preferred_stock_level == null ? 0 : value.preferred_stock_level) +'</td>' +
                                '<td>'+ (value.qty_on_order == null ? 0 : value.qty_on_order) +'</td>\n' +
                                '<td>'+ (value.qty_on_hand == null ? 0 : value.qty_on_hand) +'</td>\n' +
                                '<td>'+ (value.qty_committed == null ? 0 : value.qty_committed) +'</td>\n' +
                                '<td>'+ (value.qty_in_transit == null ? 0 : value.qty_in_transit) +'</td>\n' +
                                '<td>'+ (value.qty_back_ordered == null ? 0 : value.qty_back_ordered) +'</td>\n' +
                                '</tr>');
                        } else {
                            items.push(
                                '<tr class="loadedTr">\n' +
                                '<td>'+ value.item_name +'</td>\n' +
                                '<td>'+ value.item_description +'</td>\n' +
                                '<td>0</td>' +
                                '<td>'+ (value.preferred_stock_level == null ? 0 : value.preferred_stock_level) +'</td>' +
                                '<td>'+ (value.qty_on_order == null ? 0 : value.qty_on_order) +'</td>\n' +
                                '<td>'+ (value.qty_on_hand == null ? 0 : value.qty_on_hand) +'</td>\n' +
                                '<td>'+ (value.qty_committed == null ? 0 : value.qty_committed) +'</td>\n' +
                                '<td>'+ (value.qty_in_transit == null ? 0 : value.qty_in_transit) +'</td>\n' +
                                '<td>'+ (value.qty_back_ordered == null ? 0 : value.qty_back_ordered) +'</td>\n' +
                                '</tr>');
                        }

                        name.push(value.name);

                         return
                    });
                    $('.inventoryTable tbody').append(items);
                } else {
                    $('.loadedTr').remove();
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
            url: "{{ action('ReportsController@exportInventoryStatus') }}",
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
