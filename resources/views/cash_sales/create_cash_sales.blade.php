@extends('template')

@section('title', 'Cash Sales')

@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/vendor/sweetalert/sweetalert.css') }}">
<style>
    .activeSelect {
        width: 250px;
    }
</style>
@endsection

@section('breadcrumb')
    <div class="col-md-6 col-sm-12">
        <h1>New Cash Sales</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Sales</li>
                <li class="breadcrumb-item">Cash Sales</li>
                <li class="breadcrumb-item active" aria-current="page">New Cash Sales</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')

<div class="row">
    <form action="{{ action('CashSalesController@store') }}" enctype="multipart/form-data" method="post">
        {{ csrf_field() }}
        <div class="col-lg-12">
            <div class="card">
                <div class="actionBtn">
                    <button class="btn btn-success" type="submit">Save</button>
                    <a href="{{ route('sales.cashsales') }}" class="btn btn-danger" title="">Cancel</a>
                    <button class="btn btn-info" type="button">Reset</button>
                </div>
                <br>
                <br>
                <div class="header">
                    <h2>Primary Information</h2>
                </div>
                <div class="body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Sale #</label>
                                <p>To Be Generated</p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Reference No</label>
                                <p>To Be Generated</p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Date</label>
                                <input type="text" id="date" data-date-autoclose="true" class="form-control datepicker" name="cs_date">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Customer</label>
                                <select class="form-control" name="customer_id" required>
                                    <option value="">Select...</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->customer_id }}"> {{ $customer->fname . ' ' . $customer->lname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Posting Period</label>
                                <select class="form-control" name="posting_period">
                                    <option>Select...</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Cheque #</label>
                                <input type="text" class="form-control" name="cheque_no">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Memo</label>
                                <input type="text" class="form-control" name="memo">
                            </div>
                        </div>
                    </div>
                </div>

                <br>
                <div class="header">
                    <h2>Classification</h2>
                </div>
                <div class="body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Location</label>
                                <select class="form-control" name="location_id" id="location_id" onchange="checkLocationItems(this)" required>
                                    <option value="">Select...</option>
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->location_id }}"> {{ $location->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Department</label>
                                <select class="form-control" name="department_id" id="department_id" required>
                                    <option value="">Select...</option>
                                    @foreach ($departments as $department)
                                     <option value="{{ $department->department_id }}"> {{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="body">
                    <ul class="nav nav-tabs3">
                        <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#item">ITEM</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#bill">BILLING</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#ship">SHIPPING</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#acct">ACCOUNTING</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="item">
                            <div class="table-responsive">
                                <table id="itemTbl" class="table table-hover js-basic-example dataTable table-custom spacing5">
                                    <thead>
                                    <tr>
                                        <th>ITEM</th>
                                        <th>DESCRIPTION</th>
                                        <th>QUANTITY</th>
                                        <th>WEIGHT UNIT</th>
                                        <th>RATE</th>
                                        <th>AMOUNT</th>
                                        <th>TAX CODE <span class="required">*</span></th>
                                        <th>TAX AMOUNT</th>
                                        <th>GROSS AMOUNT</th>
                                        <th>OPTIONS</th>
                                        <th>GIFT CERTIFICATE</th>
                                        <th>COST ESTIMATE TYPE</th>
                                        <th>EST EXTENDED COST</th>
                                        <th>MEMO</th>
                                        <th>ITEM WEIGHT</th>
                                        <th>MANUFACTURER COUNTRY</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <br>
                            <button class="btn btn-outline-info addBtn" type="button">Add Data</button>
                            <div class="hidden_values" style="display: none"></div>

                        </div>
                        <div class="tab-pane" id="bill">
                            <div class="table-responsive">
                                <table id="billTbl" class="table table-hover js-basic-example dataTable table-custom spacing5">
                                    <thead>
                                    <tr>
                                        <th>Bill To</th>
                                        <th>Billing Address</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select class="form-control" name="bill_to">
                                                    <option value="">Select</option>
                                                </select>
                                            </td>
                                            <td><input type="text" class="form-control" name="" value=""> </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <button class="btn btn-outline-info addBill" type="button">Save</button>

                        </div>
                        <div class="tab-pane" id="ship">
                            <div class="table-responsive">
                                <table id="shipTbl" class="table table-hover js-basic-example dataTable table-custom spacing5">
                                    <thead>
                                    <tr>
                                        <th>Shipping Carrier</th>
                                        <th>Shipping Method</th>
                                        <th>Shipping Cost</th>
                                        <th>Shipping Tax Code</th>
                                        <th>Shipping Tax Rate</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="text" class="form-control" name="" value=""> </td>
                                            <td><input type="text" class="form-control" name="" value=""> </td>
                                            <td><input type="text" class="form-control" name="" value=""> </td>
                                            <td><input type="text" class="form-control" name="" value=""> </td>
                                            <td><input type="text" class="form-control" name="" value=""> </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <button class="btn btn-outline-info addShip" type="button">Save</button>
                        </div>
                        <div class="tab-pane" id="acct">
                            <div class="table-responsive">
                                <table id="acctTbl" class="table table-hover js-basic-example dataTable table-custom spacing5">
                                    <thead>
                                    <tr>
                                        <th>Undep. Funds</th>
                                        <th>Account</th>
                                        <th>Currency</th>
                                        <th>Exchange Rate</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="text" class="form-control" name="" value=""> </td>
                                            <td><input type="text" class="form-control" name="" value=""> </td>
                                            <td><input type="text" class="form-control" name="" value=""> </td>
                                            <td><input type="text" class="form-control" name="" value=""> </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <button class="btn btn-outline-info addAcct" type="button">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hidden" id="hdnDiv"></div>
        <div class="col-lg-12">
            <div class="actionBtn" style="margin-bottom: 5%;">
                <button class="btn btn-success" type="submit">Save</button>
                <a href="{{ route('sales.cashsales') }}" class="btn btn-danger" title="">Cancel</a>
                <button class="btn btn-info" type="button">Reset</button>
            </div>
        </div>
    </form>
</div>

@endsection
@section('js')
<script src="{{ URL::asset('assets/vendor/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/cashSalesItemTable.js') }}"></script>
<script>
    $('.datepicker').datepicker({
        todayHighlight: true
    });

    $(function () {
        addRow();
    });

    function checkLocationItems() {
        var location_id   = $('#location_id').val();
        $.ajax({
            url: "{{ action('CashSalesController@checkItems') }}",
            method: 'GET',
            dataType: "json",
            data: {'location_id': location_id},
            success: function (data) {
                $('.activeSelect').empty();
                $('.activeSelect').append($("<option></option>").text('Select item'));
                $.each(data.data, function(key, value) {
                    $('.activeSelect')
                        .append($("<option></option>")
                        .attr("value", value.item_name)
                        .attr("dataid", value.item_id)
                        .attr("locationid", location_id)
                        .text(value.item_name));

                });
            },
            error: function () {
            }
        })
    }

    function itemDesc (data) {
        var item_id = data.options[data.selectedIndex].getAttribute('dataid');

        $.ajax({
            url: "{{ action('CashSalesController@itemDesc') }}",
            method: 'GET',
            dataType: "json",
            data: {'item_id': item_id},
            success: function (data) {
                $('.activeDesc').val(data.item.item_description);
                $('.activeQty').val(data.item.qty_on_hand);
                $('.activeWeightUnit').val(data.item.abbreviation);
                $('.activeTaxcode').val(data.item.code);
                $('.activeTaxamount').val(data.item.rate);
                $('.activeCostType').val(data.item.cost_estimate_type);
                $('.activeWeight').val(data.item.item_weight);
                $('.activeCount').val(data.item.manufacturer_country);
            },
            error: function () {
            }
        })
    }



</script>
@endsection
