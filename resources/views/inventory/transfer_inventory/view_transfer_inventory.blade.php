@extends('template')

@section('title', 'View Transfer Inventory')

@section('css')
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

@section('breadcrumb')
    <div class="col-md-6 col-sm-12">
        <h1>View Transfer Inventory</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Inventory</li>
                <li class="breadcrumb-item">Transfer Inventory</li>
                <li class="breadcrumb-item active" aria-current="page">View Transfer Inventory</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <br>
                <div class="header">
                    <h2>Primary Information</h2>
                </div>
                <div class="body">
                    <form method="post" action="#" id="addFormData">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Reference No.</label>
                                    <strong><p>{{ $data_arr[0]['reference_no'] }}</p></strong>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Transfer Date</label>
                                    <p>{{ date('F j, Y', strtotime($data_arr[0]['transferred_date'])) }}</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Posting Period</label>
                                    <p>{{ date('Y-M',  strtotime($data_arr[0]['posting_period'])) }}</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>From Location</label>
                                    <p>{{ $data_arr[0]['from_location'] }}</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>To Location</label>
                                    <p>{{ $toLocation[0]['name'] }}</p>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label>Memo</label>
                                    <p>{{ $data_arr[0]['memo'] }}</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Created By</label>
                                    <p>{{ $data_arr[0]['created_by'] }}</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Departments</label>
                                    <p>{{ $data_arr[0]['dept'] }}</p>
                                </div>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <div class="tab-pane show active" id="adj">
                        <div class="table-responsive">
                            <table id="transTbl" class="table table-hover js-basic-example dataTable table-custom spacing5">
                                <thead>
                                <tr>
                                    <th>Item <span class="required">*</span></th>
                                    <th>Description</th>
                                    <th>Units</th>
                                    <th>Qty. on Hand</th>
                                    <th>Qty. to Transfer</th>
                                    <th>Inventory Detail</th>
                                    <th>Weight (G)</th>
                                    <th>Country of Manufacture</th>
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

    <!-- BIN ITEMS MODAL -->
    <div class="modal fade bd-example-modal-lg" id="binModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel">Inventory Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="error"></div>
                    <input type="hidden" class="itemClass" value="">
                    <input type="hidden" class="item_location_id" value="">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Item</label>
                                <strong><p class="bin_items"></p></strong>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Quantity</label>
                                <strong><p class="qty_bin_items"></p></strong>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Description</label>
                                <strong><p class="desc_bin_items"></p></strong>
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
                                            <th width="25%">From Bins <span class="required">*</span></th>
                                            <th width="25%">To Bins <span class="required">*</span></th>
                                            <th width="25%">Available</th>
                                            <th width="25%">Quantity <span class="required">*</span></th>
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

@section('js')
    <script>
        var success_msg = "{{ session()->get('success') }}";
        var page_id = "{{ $data_arr[0]['transfer_inventory_id'] }}";
        var ajaxTbl = "{{ route('inventory.transfer_dataList') }}";
        var getTransferredBins = "{{ route('inventory.transfer_getTransferredBins') }}";
    </script>
    <script src="{{ URL::asset('assets/js/pages/transfer_inventory/view_transfer.js') }}"></script>
@endsection
