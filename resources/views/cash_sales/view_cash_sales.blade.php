@extends('template')

@section('title', 'View Cash Sales')

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
        <h1>View Cash Sales</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Sales</li>
                <li class="breadcrumb-item">Cash Sales</li>
                <li class="breadcrumb-item active" aria-current="page">View Cash Sales</li>
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
                    <a href="{{ route('cash_sales.edit', $cashSale->cash_sales_id) }}" class="btn btn-success" title="">Edit</a>
                    <a href="{{ route('sales.cashsales') }}" class="btn btn-info" title="">Back</a>
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
                                <p><strong> {{ $cashSale->cash_sales_id }}</strong></p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Reference No</label>
                                <p><strong>{{ $cashSale->reference_no }}</strong></p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Date</label>
                                <input type="text" id="date" data-date-autoclose="true" class="form-control datepicker" name="" value="{{ $cashSale->cs_date }}" disabled>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Customer</label>
                                <select class="form-control" name="customer_id" disabled>
                                    <option>{{ $cashSale->fname . ' ' . $cashSale->lname }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Posting Period</label>
                                <select class="form-control" name="posting_period" disabled>
                                    <option>{{ $cashSale->posting_date }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Cheque #</label>
                                <p><strong>{{ $cashSale->cheque_no }}</strong></p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Memo</label>
                                <p><strong>{{ $cashSale->memo }}</strong></p>
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
                                <select class="form-control" name="location_id" id="location_id" disabled>
                                    <option value="">{{ $cashSale->loc_name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Department</label>
                                <select class="form-control" name="department_id" id="department_id" disabled>
                                    <option value="">{{ $cashSale->dept_name }}</option>
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
                                    <tbody>
                                        @foreach ($items as $item)
                                            <tr>
                                                <td>{{ $item->items->item_name }}</td>
                                                <td>{{ $item->description }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ $item->weight_unit }}</td>
                                                <td>{{ $item->rate }}</td>
                                                <td>{{ $item->amount }}</td>
                                                <td>{{ $item->tax_code }}</td>
                                                <td>{{ $item->tax_amount }}</td>
                                                <td>{{ $item->gross_amount }}</td>
                                                <td>{{ $item->options }}</td>
                                                <td>{{ $item->gift_certificate }}</td>
                                                <td>{{ $item->cost_estimate_type }}</td>
                                                <td>{{ $item->est_extended_cost }}</td>
                                                <td>{{ $item->memo }}</td>
                                                <td>{{ $item->item_weight }}</td>
                                                <td>{{ $item->manufacturer_country }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <br>

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
                                            <td><input type="text" name="" class="form-control" value="{{ $cashSale->bill_to }}" disabled> </td>
                                            <td><input type="text" name="" class="form-control" value="{{ $cashSale->billing_address }}" disabled> </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <br>

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
                                            <td><input type="text" name="" value="{{ $cashSale->shipping_carrier_id }}" class="form-control" disabled> </td>
                                            <td><input type="text" name="" value="{{ $cashSale->shipping_method }}" class="form-control" disabled> </td>
                                            <td><input type="text" name="" value="{{ $cashSale->shipping_cost }}" class="form-control" disabled> </td>
                                            <td><input type="text" name="" value="{{ $cashSale->shipping_tax_code_id }}" class="form-control" disabled> </td>
                                            <td><input type="text" name="" value="{{ $cashSale->shipping_tax_rate }}" class="form-control" disabled> </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <br>
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
                                            <td><input type="text" name="" value="{{ $cashSale->undep_funds }}" class="form-control" disabled> </td>
                                            <td><input type="text" name="" value="{{ $cashSale->account }}" class="form-control" disabled> </td>
                                            <td><input type="text" name="" value="{{ $cashSale->currency_id }}" class="form-control" disabled> </td>
                                            <td><input type="text" name="" value="{{ $cashSale->exchange_rate }}" class="form-control" disabled> </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hidden" id="hdnDiv"></div>
        <div class="col-lg-12">
            <div class="actionBtn" style="margin-bottom: 5%;">
                <a href="{{ route('cash_sales.edit', $cashSale->cash_sales_id) }}" class="btn btn-success" title="">Edit</a>
                <a href="{{ route('sales.cashsales') }}" class="btn btn-info" title="">Back</a>
            </div>
        </div>
    </form>
</div>

@endsection
@section('js')
<script>
    $('.datepicker').datepicker({
        todayHighlight: true
    });

</script>
@endsection
