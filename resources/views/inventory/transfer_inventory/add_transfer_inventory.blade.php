@extends('template')

@section('title', 'Add Transfer Inventory')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
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
        <h1>Add Transfer Inventory</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Inventory</li>
                <li class="breadcrumb-item">Transfer Inventory</li>
                <li class="breadcrumb-item active" aria-current="page">Add Transfer Inventory</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="actionBtn">
                    <button class="btn btn-success btnSave" type="button">Save</button>
                    <a class="btn btn-danger" href="{{ route('transfer_inventory') }}">Cancel</a>
                    <button class="btn btn-info" type="button">Reset</button>
                </div>
                <br>
                <div class="header">
                    <h2>Primary Information</h2>
                </div>
                <div class="body">
                    <form method="post" action="{{ route('transfer_inventory_addData') }}" id="addFormData">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Reference No.</label>
                                    <strong><p>To Be Generated</p></strong>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Transfer Date</label>
                                    <div class="input-group mb-3">
                                        <input type="text" id="date" data-date-autoclose="true" class="form-control" value="{{ $today }}" name="trans_date">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Posting Period</label>
                                    <select class="form-control" name="posting_period">
                                        @foreach($months as $item)
                                            <option value="{{ $item }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>From Location</label>
                                    <select class="form-control from_location" name="from_location">
                                        <option>Select...</option>
                                        @foreach($locations as $item)
                                            <option value="{{ $item->location_id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>To Location</label>
                                    <select class="form-control to_location" name="to_location">
                                        <option>Select...</option>
                                        @foreach($locations as $item)
                                            <option value="{{ $item->location_id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label>Memo</label>
                                    <textarea rows="5" class="form-control memo" name="memo"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Created By</label>
                                    <select class="form-control" name="created_by">
                                        <option>Select...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Departments</label>
                                    <select class="form-control" name="dept">
                                        <option>Select...</option>
                                        @foreach($depts as $item)
                                            <option value="{{ $item->department_id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="hidden_values hidden"></div>
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
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <br>
                        <button class="btn btn-outline-info" type="button" data-toggle="modal" data-target="#addModal" data-backdrop="static" data-keyboard="false">Add Data</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="edit_values"></div>
        <input type="hidden" id="is_add" value="">

        <div class="col-lg-12">
            <div class="actionBtn" style="margin-bottom: 5%;">
                <button class="btn btn-success btnSave" type="button">Save</button>
                <a class="btn btn-danger" href="{{ route('transfer_inventory') }}">Cancel</a>
                <button class="btn btn-info" type="button">Reset</button>
            </div>
        </div>
    </div>

    <!-- ADD MODAL -->
    <div class="modal fade bd-example-modal-lg" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel">Transfer Inventory</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Item <span class="required">*</span></label> <span class="required hidden data_1_error">This field is required</span>
                                <input id="item_search" type="text" class="form-control data_1" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea rows="5" class="form-control data_2" readonly></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Units</label>
                                <input type="text" class="form-control data_3" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Qty. on hand</label>
                                <input type="text" class="form-control data_4" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Qty. to Transfer</label>
                                <input type="text" class="form-control data_5">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Weight (G)</label>
                                <input type="text" class="form-control data_6">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Country of Manufacture</label>
                                <select class="form-control data_7">
                                    <option>Select...</option>
                                    @foreach($countries as $item)
                                        <option value="{{ $item->country_id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" class="item_id" value="">
                    <input type="hidden" class="unit_id" value="">
                    <input type="hidden" class="item_code" value="">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success addBtn" type="button">Save</button>
                    <button class="btn btn-danger cancelBtn" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- UPDATE MODAL -->
    <div class="modal fade bd-example-modal-lg" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel">Transfer Inventory</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Item <span class="required">*</span></label> <span class="required hidden data_1_error">This field is required</span>
                                <input id="update_item_search" type="text" class="form-control data_1_value" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea rows="5" class="form-control data_2_value" readonly></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Units</label>
                                <input type="text" class="form-control data_3_value" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Qty. on hand</label>
                                <input type="text" class="form-control data_4_value" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Qty. to Transfer</label>
                                <input type="text" class="form-control data_5_value">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Weight (G)</label>
                                <input type="text" class="form-control data_6_value">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Country of Manufacture</label>
                                <select class="form-control data_7_value">
                                    <option>Select...</option>
                                    @foreach($countries as $item)
                                        <option value="{{ $item->country_id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" class="item_id_value" value="">
                    <input type="hidden" class="unit_id_value" value="">
                    <input type="hidden" class="item_code_value" value="">
                </div>
                <div class="modal-footer modal_update"></div>
            </div>
        </div>
    </div>

    <!-- BIN ITEMS MODAL -->
    <div class="modal fade bd-example-modal-lg" id="binModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel">Inventory Details</h5>
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
                                <input type="hidden" class="bin_item_id" value="">
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
                                <div class="add_row_items"></div>
                                <br>
                                <button class="btn btn-outline-info itemAdd" type="button">Add Data</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success item_addBtn" type="button">Save</button>
                    <button class="btn btn-danger item_cancelBtn" type="button">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/vendor/typeahead/typeahead.min.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        var searchPath = "{{ route('transfer_inventory_item_search') }}";
        var getItem = "{{ route('transfer_inventory_getItems') }}";
        var getBin = "{{ route('transfer_inventory_getBin') }}";
        var getQty = "{{ route('transfer_inventory_getQtyAvailable') }}";
    </script>
    <script src="{{ URL::asset('js/pages/transfer_inventory/add_transfer.js') }}"></script>
@endsection
