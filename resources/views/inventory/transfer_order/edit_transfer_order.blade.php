@extends('template')

@section('title', 'Update Transfer Orders')

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
        .datepicker{z-index:1151 !important;}
    </style>
@endsection

@section('breadcrumb')
    <div class="col-md-6 col-sm-12">
        <h1>Update Transfer Orders</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Inventory</li>
                <li class="breadcrumb-item">Transfer Orders</li>
                <li class="breadcrumb-item active" aria-current="page">Update Transfer Orders</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
<form method="post" action="{{ route('inventory.order_updateData') }}">
    @csrf
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="actionBtn">
                    <button class="btn btn-success" type="submit">Save</button>
                    <button class="btn btn-danger" type="button">Cancel</button>
                    <button class="btn btn-info" type="button">Reset</button>
                    <button id="btnGroupDrop1" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Actions
                    </button>
                    <div class="dropdown-menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -84px, 0px);">
                        <a class="dropdown-item" href="javascript:void(0);">Dropdown link</a>
                        <a class="dropdown-item" href="javascript:void(0);">Dropdown link</a>
                    </div>
                </div>
                <br>
                <div class="header">
                    <h2>Primary Information</h2>
                </div>
                <div class="body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Order No.</label>
                                        <strong><p>{{ $data_arr[0]['reference_no'] }}</p></strong>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Transferred Date</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="date" data-date-autoclose="true" class="form-control" value="{{ $data_arr[0]['transferred_date'] }}" name="trans_date">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>From Location</label>
                                        <select class="form-control from_location" name="from_location">
                                            <option>Select...</option>
                                            @foreach($locations as $item)
                                                <option value="{{ $item->location_id }}" @if ($data_arr[0]['from_location_id'] == $item->location_id) selected @endif>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>To Location</label>
                                        <select class="form-control to_location" name="to_location">
                                            <option>Select...</option>
                                            @foreach($locations as $item)
                                                <option value="{{ $item->location_id }}" @if ($data_arr[0]['to_location_id'] == $item->location_id) selected @endif>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Departments</label>
                                        <select class="form-control" name="dept">
                                            <option>Select...</option>
                                            @foreach($depts as $item)
                                                <option value="{{ $item->department_id }}" @if ($data_arr[0]['department_id'] == $item->department_id) selected @endif>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Created By</label>
                                        <select class="form-control" name="created_by">
                                            <option>Select...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Memo</label>
                                        <textarea rows="5" class="form-control memo" name="memo">{{ $data_arr[0]['memo'] }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-8">
                                    <a class="card" href="javascript:void(0)">
                                        <div class="card-footer text-center">
                                            <div class="row clearfix" style="margin-left: 0%; color: rgb(23, 25, 28);">
                                                <h6 class="mt-3">Summary</h6>
                                            </div>
                                        </div>
                                        <div class="body">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label>Shipping Cost</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class=" pull-right">0.00</label>
                                                </div>
                                                <div class="col-lg-12" style="border-bottom: 1px solid; margin-bottom: 2%;"></div>
                                                <div class="col-lg-6">
                                                    <label>Total</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class=" pull-right">0.00</label>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="body">
                    <ul class="nav nav-tabs3">
                        <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#Items">Items</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Shipping">Shipping</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="Items">
                            <div class="tab-pane show active" >
                                <div class="table-responsive">
                                    <table id="itemsTbl" class="table table-hover js-basic-example dataTable table-custom spacing5">
                                        <thead>
                                        <tr>
                                            <th>Item <span class="required">*</span></th>
                                            <th>Quantity</th>
                                            <th>Transfer Price</th>
                                            <th>Units</th>
                                            <th>Amount</th>
                                            <th>Description</th>
                                            <th>Inventory Detail</th>
                                            <th>Expected Receipt Date</th>
                                            <th>Commit</th>
                                            <th>Commitment Confirmed</th>
                                            <th>Order Priority</th>
                                            <th>Options</th>
                                            <th>Closed</th>
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
                        <div class="tab-pane" id="Shipping">
                            <h6>Shipping Information</h6>
                            <br>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Ship Date</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="date1" data-date-autoclose="true" class="form-control" value="{{ $data_arr[0]['shipping_date'] }}" name="ship_date">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Ship to Select</label>
                                        <input type="text" class="form-control" name="ship_to" value="{{ $data_arr[0]['shipping_to'] }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Shipping Carrier</label>
                                        <select class="form-control from_location" name="ship_carrier">
                                            <option>Select...</option>
                                            @foreach($carrier as $item)
                                                <option value="{{ $item->shipping_carrier_id }}" @if ($data_arr[0]['shipping_carrier_id'] == $item->shipping_carrier_id) selected @endif>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Shipping Cost</label>
                                        <input type="text" class="form-control" name="ship_cost" value="{{ $data_arr[0]['shipping_cost'] }}">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Shipping Address</label>
                                        <input type="text" class="form-control" name="ship_add" value="{{ $data_arr[0]['shipping_address'] }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="actionBtn" style="margin-bottom: 5%;">
                <button class="btn btn-success" type="submit">Save</button>
                <button class="btn btn-danger" type="button">Cancel</button>
                <button class="btn btn-info" type="button">Reset</button>
                <button id="btnGroupDrop1" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    Actions
                </button>
                <div class="dropdown-menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -84px, 0px);">
                    <a class="dropdown-item" href="javascript:void(0);">Dropdown link</a>
                    <a class="dropdown-item" href="javascript:void(0);">Dropdown link</a>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="system_id" value="{{ $data_arr[0]['transfer_order_id'] }}">
    <div class="update_hidden_values hidden"></div>
    <div class="add_hidden_values hidden"></div>
    <div class="delete_hidden_values hidden"></div>
</form>

<div class="edit_values"></div>
<div class="commit_value"></div>
<input type="hidden" id="is_add" value="">

<!-- ADD MODAL -->
<div class="modal fade bd-example-modal-lg" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="myLargeModalLabel">Transfer Order</h5>
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
                            <label>Quantity</label>
                            <input type="text" class="form-control data_3" readonly>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Units</label>
                            <input type="text" class="form-control data_4" readonly>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Transfer Price</label>
                            <input type="text" class="form-control data_5">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="text" class="form-control data_6">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Expected Receipt Date</label>
                            <div class="input-group mb-3">
                                <input type="text" id="date2" data-date-autoclose="true" class="form-control data_7" value="">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Commit</label>
                            <select class="form-control data_8">
                                <option>Select...</option>
                                @foreach($commit as $item)
                                    <option value="{{ $item->commit_id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Order Priority</label>
                            <input type="text" class="form-control data_9">
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
                <h5 class="modal-title h4" id="myLargeModalLabel">Transfer Order</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Item <span class="required">*</span></label> <span class="required hidden data_1_error">This field is required</span>
                            <input id="update_item_search" type="text" class="form-control edit_data_1" required>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea rows="5" class="form-control edit_data_2" readonly></textarea>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="text" class="form-control edit_data_3" readonly>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Units</label>
                            <input type="text" class="form-control edit_data_4" readonly>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Transfer Price</label>
                            <input type="text" class="form-control edit_data_5">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="text" class="form-control edit_data_6">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Expected Receipt Date</label>
                            <div class="input-group mb-3">
                                <input type="text" id="date3" data-date-autoclose="true" class="form-control edit_data_7" value="">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Commit</label>
                            <select class="form-control edit_data_8">
                                <option>Select...</option>
                                @foreach($commit as $item)
                                    <option value="{{ $item->commit_id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Order Priority</label>
                            <input type="text" class="form-control edit_data_9">
                        </div>
                    </div>
                </div>
                <input type="hidden" class="data_id" value="">
                <input type="hidden" class="edit_item_id" value="">
                <input type="hidden" class="edit_unit_id" value="">
                <input type="hidden" class="edit_item_code" value="">
            </div>
            <div class="modal-footer modal_update"></div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        var searchPath = "{{ route('inventory.order_item_search') }}";
        var getItem = "{{ route('inventory.order_getItems') }}";
        var system_id = "{{ $data_arr[0]['transfer_order_id'] }}";
        var ajaxTbl = "{{ route('inventory.order_dataList') }}";
    </script>
    <script src="{{ URL::asset('assets/js/pages/transfer_order/edit_transfer_order.js') }}"></script>
@endsection
