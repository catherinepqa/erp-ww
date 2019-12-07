@extends('template')

@section('title', 'View Inventory Adjustment')

@section('breadcrumb')
    <div class="col-md-10 col-sm-12">
        <h1>View Inventory Adjustment</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Inventory</li>
                <li class="breadcrumb-item">Inventory Adjustment</li>
                <li class="breadcrumb-item active" aria-current="page">View Inventory Adjustment</li>
            </ol>
        </nav>
    </div>
    <div class="col-md-2 col-sm-12 text-right hidden-xs">
        <a href="#" class="btn btn-sm btn-primary" onclick="editData({{ $data_arr['inventory_adjustment_id'] }})" title="">Edit View</a>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/sweetalert/sweetalert.css') }}">
    <style>
        .required {
            color: red;
        }
        .fa-pencil {
            color: #4ca746;
            font-size: 18px;
        }
        .fa-trash-o {
            color: #f66d9b;
            font-size: 18px;
        }
        .fa-check {
            color: #007bff;
            font-size: 18px;
        }
        .fa-times {
            color: #f66d9b;
            font-size: 18px;
        }
        .typeahead .dropdown-item {
            color: #212529 !important;
        }
        .hidden {
            display: none;
        }
        .fa-cube {
            font-size: 25px;
            color: #42a2b9;
        }
        .required_field {
            border-color: #dc3545 !important;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>Primary Information</h2>
                </div>

                <div class="body">
                    <form action="#" method="post" id="updateDataForm">
                        @csrf
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Reference No.</label>
                                    <p><b>{{ $data_arr['reference_no'] }}</b></p>
                                </div>
                            </div>

                            <div class="col-lg-8">
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Adjustment Date <span class="required">*</span> </label>
                                    <p>{{ date('m-d-Y', strtotime($data_arr['adjustment_date'])) }}</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Adjustment Account</label>
                                    <p>{{ $data_arr['adjustment_account'] }}</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Estimated Total Value</label>
                                    <p>{{ $data_arr['est_total_value'] }}</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Posting Period</label>
                                    <p>{{ date('Y-M',  strtotime($data_arr['posting_period'])) }}</p>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label>Memo</label>
                                    <p>{{ $data_arr['memo'] }}</p>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Created By</label>
                                    <p>{{ $data_arr['created_by'] }}</p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="body">
                    <ul class="nav nav-tabs3">
                        <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#adj">Adjustments</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="adj">
                            <div class="table-responsive">
                                <table id="adjTbl" class="table table-hover js-basic-example dataTable table-custom spacing5">
                                    <thead>
                                    <tr>
                                        <th>Item <span class="required">*</span></th>
                                        <th>Description</th>
                                        <th>Location</th>
                                        <th>Units</th>
                                        <th>Qty. on hand</th>
                                        <th>Current Value</th>
                                        <th>Adjust Qty By <span class="required">*</span></th>
                                        <th>New Quantity</th>
                                        <th>Est. Unit Cost</th>
                                        <th>Inventory Detail</th>
                                        <th>Department</th>
                                        <th>Item Category</th>
                                        <th>Memo</th>
                                        <th></th>
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

    <!-- BIN ITEMS MODAL -->
    <div class="modal fade bd-example-modal-lg" id="binModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel">Bin Items</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="error"></div>
                    <input type="hidden" class="dataClass" value="">
                    <input type="hidden" class="item_location_id" value="">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Item</label>
                                <strong><p class="bin_items"></p></strong>
                                <input type="hidden" class="bin_items_value" value="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Quantity</label>
                                <strong><p class="qty_bin_items"></p></strong>
                                <input type="hidden" class="qty_bin_items_value" value="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Description</label>
                                <strong><p class="desc_bin_items"></p></strong>
                                {{--                                <input type="hidden" class="desc_bin_items_value" value="">--}}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Units</label>
                                <strong><p>Each</p></strong>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <h6>Inventory Detail</h6>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="tab-pane show active" id="adj">
                                <div class="table-responsive">
                                    <table id="itemTbl" class="table table-hover js-basic-example dataTable table-custom spacing5">
                                        <thead>
                                        <tr>
                                            <th width="50%">Bin <span class="required">*</span></th>
                                            <th width="50%">Quantity <span class="required">*</span></th>
                                            <th></th>
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
    </div>

    @if(session()->has('success'))
        <button class="btn btn-success btn-sm demo2 hidden"></button>
    @endif
@endsection

@section('script')
    <script src="{{ URL::asset('assets/vendor/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ URL::asset('assets/bundles/datatablescripts.bundle.js') }}"></script>
    <script>
        var searchPath = "{{ route('inventory_adjustment_item_search') }}";
        var getItem = "{{ route('inventory_adjustment_getItems') }}";
        var getLocation = "{{ route('inventory_adjustment_getLocation') }}";
        var success_msg = "{{ session()->get('success') }}";
        var getBin = "{{ route('inventory_adjustment_getBin') }}";
        var page_id = "{{ $data_arr['inventory_adjustment_id'] }}";
        var ajaxTbl = "{{ route('inventory_adjustment_dataList') }}";
        var getAdjustedBins = "{{ route('inventory_adjustment_getAdjustedBins') }}";
        var edit_url = "{{ route("edit_inventory_adjustment", ":slug") }}";
    </script>
    <script src="{{ URL::asset('js/pages/inventory_adjustment/view.js') }}"></script>
@endsection
