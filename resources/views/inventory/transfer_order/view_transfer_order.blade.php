@extends('template')

@section('title', 'View Transfer Orders')

@section('css')
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
        .hidden {
            display: none;
        }
    </style>
@endsection

@section('breadcrumb')
    <div class="col-md-6 col-sm-12">
        <h1>View Transfer Orders</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Inventory</li>
                <li class="breadcrumb-item">Transfer Orders</li>
                <li class="breadcrumb-item active" aria-current="page">View Transfer Orders</li>
            </ol>
        </nav>
    </div>
    <div class="col-md-6 col-sm-12 text-right hidden-xs">
        <a href="#" class="btn btn-sm btn-primary" onclick="editData({{ $data_arr[0]['transfer_order_id'] }})" title="">Edit View</a>
        <a href="#" class="btn btn-sm btn-primary approve">Approve Order</a>
    </div>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
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
                                    <p>{{ date('F j, Y', strtotime($data_arr[0]['transferred_date'])) }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>From Location</label>
                                    <p>{{ $data_arr[0]['from_location'] }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>To Location</label>
                                    <p>{{ $toLocation[0]['name'] }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Departments</label>
                                    <p>{{ $data_arr[0]['dept'] }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Created By</label>
                                    <p>{{ $data_arr[0]['created_by'] }}</p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Memo</label>
                                    <p>{{ $data_arr[0]['memo'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-2"></div>
                            <div class="col-lg-8">
                                <a class="card">
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
                        </div>
                    </div>
                    <div class="tab-pane" id="Shipping">
                        <h6>Shipping Information</h6>
                        <br>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Ship Date</label>
                                    <p>{{ date('F j, Y', strtotime($data_arr[0]['shipping_date'])) }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Ship to Select</label>
                                    <p>{{ $data_arr[0]['shipping_to'] }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Shipping Carrier</label>
                                    <p>{{ $data_arr[0]['carrier'] }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Shipping Cost</label>
                                    <p>{{ $data_arr[0]['shipping_cost'] }}</p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Shipping Address</label>
                                    <p>{{ $data_arr[0]['shipping_address'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form method="post" action="{{ route('inventory.order_approveStatus') }}" id="updateStatus">
    @csrf
    <input type="hidden" name="status_id" value="{{ $data_arr[0]['transfer_order_id'] }}">
</form>

@if(session()->has('success'))
    <button class="btn btn-success btn-sm demo2 hidden"></button>
@endif
@endsection

@section('js')
    <script>
        var success_msg = "{{ session()->get('success') }}";
        var searchPath = "{{ route('inventory.order_item_search') }}";
        var getItem = "{{ route('inventory.order_getItems') }}";
        var ajaxTbl = "{{ route('inventory.order_dataList') }}";
        var page_id = "{{ $data_arr[0]['transfer_order_id'] }}";
        var edit_url = "{{ route("inventory.order_editOrder", ":slug") }}";
    </script>
    <script src="{{ URL::asset('assets/js/pages/transfer_order/view_transfer_order.js') }}"></script>
@endsection
