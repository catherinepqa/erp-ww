@extends('template')

@section('title', 'Transfer Orders')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/jquery-datatable/dataTables.bootstrap4.min.css') }}">
    <style>
        .fa-file-excel-o {
            color : #28a745;
        }
        .fa-file-pdf-o {
            color : #dc3545;
        }
        .fa-print {
            color : #007bff;
        }
        .btn {
            width: auto !important;
        }
        .fa-pencil {
            color: #4ca746;
            font-size: 18px;
        }
        .fa-trash-o {
            color: #f66d9b;
            font-size: 18px;
        }
        .fa-eye {
            color: #007bff;
            font-size: 18px;
        }
    </style>
@endsection

@section('breadcrumb')
    <div class="col-md-6 col-sm-12">
        <h1>Transfer Orders</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Inventory</li>
                <li class="breadcrumb-item active" aria-current="page">Transfer Orders</li>
            </ol>
        </nav>
    </div>
    <div class="col-md-6 col-sm-12 text-right hidden-xs">
        <a href="{{ route('inventory.add_transfer_orders') }}" class="btn btn-sm btn-primary" title="">New Transaction</a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-1">
                                    <label>View</label>
                                </div>
                                <div class="col-lg-6">
                                    <select class="form-control">
                                        <option>Select...</option>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <button class="btn btn-default btn-block" type="button">Edit View</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 3%;">
                        <div class="col-lg-12">
                            <ul class="accordion2">
                                <li class="accordion-item">
                                    <h3 class="accordion-thumb"><span>Filter</span></h3>
                                    <div class="accordion-panel" style="display: none;">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Type</label>
                                                    <select class="form-control">
                                                        <option>Select...</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Location</label>
                                                    <select class="form-control">
                                                        <option>Select...</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label>Style</label>
                                                    <select class="form-control">
                                                        <option>Select...</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <button class="btn btn-info pull-right" type="button">Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 3%;">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover dataTable js-exportable">
                                    <thead>
                                    <tr>
                                        <th>Edit | View</th>
                                        <th>Internal Id</th>
                                        <th>Date</th>
                                        <th>Document Number</th>
                                        <th>Name</th>
                                        <th>Account</th>
                                        <th>Memo</th>
                                        <th>Currency</th>
                                        <th>Amount (Foreign Currency)</th>
                                        <th>Amount</th>
                                        <th>RF-Smart Order Score</th>
                                        <th>Form Subtitle</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ URL::asset('assets/bundles/datatablescripts.bundle.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/jquery-datatable/buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/jquery-datatable/buttons/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/jquery-datatable/buttons/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/jquery-datatable/buttons/buttons.print.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="{{ URL::asset('assets/vendor/jquery-datatable/pdfmake/vfs_fonts.js') }}"></script>

    <script>
        var data_url = "{{route('inventory.order_getAllData')}}";
        var edit_url = "{{ route("inventory.order_editOrder", ":slug") }}";
        var view_url = "{{ route("inventory.order_viewOrders", ":slug") }}";
    </script>

    <script src="{{ URL::asset('assets/js/pages/transfer_order/index.js') }}"></script>
@endsection
