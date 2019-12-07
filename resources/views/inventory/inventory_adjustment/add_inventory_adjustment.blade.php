@extends('template')

@section('title', 'New Inventory Adjustment')

@section('breadcrumb')
    <div class="col-md-12 col-sm-12">
        <h1>New Inventory Adjustment</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Inventory</li>
                <li class="breadcrumb-item">Inventory Adjustment</li>
                <li class="breadcrumb-item active" aria-current="page">New Inventory Adjustment</li>
            </ol>
        </nav>
    </div>
@endsection

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

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="action-btn">
                    <button class="btn btn-success btnSave" type="button">Save</button>
                    <a href="{{ route('inventory_adjustment') }}" class="btn btn-danger">Cancel</a>
                    <button class="btn btn-info" type="button">Reset</button>
                </div>

                <br>

                <div class="header">
                    <h2>Primary Information</h2>
                </div>

                <div class="body">
                    <form action="{{ route('inventory_adjustment_addingData') }}" method="post" id="dataForm">
                        @csrf
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Reference No.</label>
                                    <p><b>To Be Generated</b></p>
                                </div>
                            </div>

                            <div class="col-lg-8">
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Adjustment Date <span class="required">*</span> </label>
                                    <div class="input-group mb-3">
                                        <input type="text" id="date" data-date-autoclose="true" class="form-control" value="{{ $today }}" name="adj_date">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Adjustment Account</label>
                                    <input id="test" type="text" class="form-control" name="adj_account">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Estimated Total Value</label>
                                    <input type="text" class="form-control number" name="est_total_val">
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
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label>Memo</label>
                                    <textarea rows="5" class="form-control" name="memo"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Created By</label>
                                    <select class="form-control" name="created">
                                        <option>Select...</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" value="0" name="system_id">
                        <div class="hidden_values hidden"></div>
                        <input type="hidden" id="is_add" value="">
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
                            <br>
                            <button class="btn btn-outline-info" type="button" data-toggle="modal" data-target="#addModal" data-backdrop="static" data-keyboard="false">Add Data</button>
                            <div class="hidden_values" style="display: none"></div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="action-btn" style="margin-bottom: 5%;">
                <button class="btn btn-success btnSave" type="button">Save</button>
                <a href="{{ route('inventory_adjustment') }}" class="btn btn-danger">Cancel</a>
                <button class="btn btn-info" type="button">Reset</button>
            </div>
        </div>
    </div>

    <!-- add modal -->
    <div class="modal fade bd-example-modal-lg" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel">Add Adjustment</h5>
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
                                <textarea rows="5" class="form-control data_2"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Location</label>
                                <select class="form-control data_3 location">
                                    <option value="">Select...</option>
                                    @foreach($locations as $item)
                                        <option value="{{ $item->location_id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Units</label>
                                <input type="text" class="form-control data_4">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Qty. on hand</label>
                                <input type="text" class="form-control data_5">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Current Value</label>
                                <input type="text" class="form-control data_6">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Adjust Qty By <span class="required">*</span></label> <span class="required hidden data_7_error">This field is required</span>
                                <input type="text" class="form-control data_7" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>New Quantity <span class="required">*</span></label> <span class="required hidden data_8_error">This field is required</span>
                                <input type="text" class="form-control data_8" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Est. Unit Cost</label>
                                <input type="text" class="form-control data_9">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Department</label>
                                <input type="text" class="form-control data_11">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Item Category</label>
                                <input type="text" class="form-control data_12">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Memo</label>
                                <textarea rows="5" class="form-control data_13"></textarea>
                            </div>
                        </div>
                        <input type="hidden" class="item_id" value="">
                        <input type="hidden" class="dept_id" value="">
                        <input type="hidden" class="item_cat_id" value="">
                        <input type="hidden" class="unit_id" value="">
                        <input type="hidden" class="item_code" value="">
                        <input type="hidden" class="inventory_item_id" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success addBtn" type="button">Save</button>
                    <button class="btn btn-danger cancelBtn" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- update modal -->
    <div class="modal fade bd-example-modal-lg" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel">Update Adjustment</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Item <span class="required">*</span></label>
                                <input id="update_item_search" type="text" class="form-control data_1_value" required value="">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea rows="5" class="form-control data_2_value"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Location</label>
                                <select class="form-control data_3_value update_location">
                                    <option value="">Select...</option>
                                    @foreach($locations as $item)
                                        <option value="{{ $item->location_id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Units</label>
                                <input type="text" class="form-control data_4_value" value="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Qty. on hand</label>
                                <input type="text" class="form-control data_5_value" value="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Current Value</label>
                                <input type="text" class="form-control data_6_value" value="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Adjust Qty By <span class="required">*</span></label>
                                <input type="text" class="form-control data_7_value" required value="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>New Quantity <span class="required">*</span></label>
                                <input type="text" class="form-control data_8_value" required value="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Est. Unit Cost</label>
                                <input type="text" class="form-control data_9_value" value="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Department</label>
                                <input type="text" class="form-control data_11_value" value="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Item Category</label>
                                <input type="text" class="form-control data_12_value" value="">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Memo</label>
                                <textarea rows="5" class="form-control data_13_value"></textarea>
                            </div>
                        </div>
                        <input type="hidden" class="item_id_value" value="">
                        <input type="hidden" class="dept_id_value" value="">
                        <input type="hidden" class="item_cat_id_value" value="">
                        <input type="hidden" class="unit_id_value" value="">
                        <input type="hidden" class="item_code_value" value="">
                        <input type="hidden" class="inventory_item_id_value" value="">
                    </div>
                </div>
                <div class="modal-footer modal_update"></div>
                <div class="edit_values hidden"></div>
            </div>
        </div>
    </div>

    <!-- BIN ITEMS MODAL -->
    <div class="modal fade bd-example-modal-lg" id="binModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel">Bin Items</h5>
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
                                <div class="add_row_items"></div>
                                <br>
                                <button class="btn btn-outline-info itemAdd" type="button">Add Data</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success item_addBtn" type="button">Save</button>
                    <button class="btn btn-danger item_cancelBtn" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    @if(session()->has('success'))
        <button class="btn btn-success btn-sm demo2 hidden"></button>
    @endif
@endsection

@section('script')
    <script src="{{ URL::asset('assets/vendor/typeahead/typeahead.min.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        var searchPath = "{{ route('inventory_adjustment_item_search') }}";
        var getItem = "{{ route('inventory_adjustment_getItems') }}";
        var getLocation = "{{ route('inventory_adjustment_getLocation') }}";
        var success_msg = "{{ session()->get('success') }}";
        var getBin = "{{ route('inventory_adjustment_getBin') }}";
    </script>
    <script src="{{ URL::asset('js/pages/inventory_adjustment/add_inventory_adjustment.js') }}"></script>
@endsection
