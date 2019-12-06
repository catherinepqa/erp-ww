@extends('template')

@section('title', 'Sales Order - Edit')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/parsleyjs/css/parsley.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/sweetalert/sweetalert.css') }}">

    <style>
        .table-custom tr th {
            background: #f8f9fa !important;
        }

        .table-custom tr td {
            background: #f8f9fa !important;
        }

        .table-custom tr td > input {
            background: #ffffff !important;
            text-align: right;
        }

        .btn-group > button {
            height: 100px !important;
        }

        .typeahead-dropdown > .dropdown-menu {
            width: 96.4% !important;
        }

        .typeahead .dropdown-item {
            
            color: #000000 !important;
        }

        .dropdown-item > strong {
            color: #17C2D7 !important;
        }
    </style>
@endsection

@section('breadcrumb')
    <div class="col-md-12 col-sm-12">
        <h1>Sales Order</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Sales</li>
                <li class="breadcrumb-item">Sales Order</li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <form id="form">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                     <div>
                        <button id="save-top" class="btn btn-success" type="button">Save</button>
                        <button id="cancel-top" class="btn btn-danger" type="button">Cancel</button>
                    </div>

                    <br>

                    <div id="alert"></div>

                    <div class="header">
                        <h2>Primary Information</h2>
                    </div>

                    <div class="body">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label><b>Sales Order No.</b></label>
                                            <input id="sales-order-no" type="text" class="form-control" required value="{{ $sales_order->reference_no }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-6"></div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Customer Name</label>
                                            <select id="customer-name" class="form-control" required>
                                                <option value="">Select...</option>

                                                @foreach ($customers as $row)
                                                    <option @if($row->customer_id  == $sales_order->customer_id) selected @endif value="{{ $row->customer_id }}">{{ $row->lname }}, {{ $row->fname }} {{ $row->mname }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Customer Email</label>
                                            <input id="customer-email" type="text" class="form-control" value="{{ $sales_order->customer_email }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">    
                                        <label>Sales Order Date</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                            </div>
                                            <input id="sales-order-date" data-date-autoclose="true" class="form-control" data-date-format="mm/dd/yyyy" required data-parsley-required data-parsley-trigger-after-failure="change" data-parsley-errors-container="#error-sales-order-date" value="{{ date('m/d/Y', strtotime($sales_order->so_date)) }}">
                                        </div>

                                        <p id="error-sales-order-date"></p>
                                    </div>

                                    <div class="col-lg-6">    
                                        <label>Sales Effective Date</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                            </div>
                                            <input id="sales-effective-date" data-date-autoclose="true" class="form-control" data-date-format="mm/dd/yyyy" required data-parsley-required data-parsley-trigger-after-failure="change" data-parsley-errors-container="#error-sales-effective-date" value="{{ date('m/d/Y', strtotime($sales_order->sales_effective_date)) }}">
                                        </div>

                                        <p id="error-sales-effective-date"></p>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>PO No.</label>
                                            <input id="po-no" type="text" class="form-control" value="{{ $sales_order->po_no }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-6"></div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Internal Status</label>
                                             <select id="internal-status" class="form-control" required>
                                                <option value="">Select...</option>

                                                @foreach ($internal_status as $row)
                                                    <option @if($row->status_id  == $sales_order->internal_status) selected @endif value="{{ $row->status_id }}">{{ $row->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Web Status</label>
                                            <select id="web-status" class="form-control" required>
                                                <option value="">Select...</option>

                                                @foreach ($web_status as $row)
                                                    <option @if($row->status_id  == $sales_order->web_status) selected @endif value="{{ $row->status_id }}">{{ $row->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card-footer text-center">
                                            <div class="row clearfix" style="margin-left: 0%; color: rgb(23, 25, 28);">
                                                <h6 class="mt-3">Summary</h6>
                                            </div>
                                        </div>

                                        <div class="body">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label>Subtotal</label>
                                                </div>

                                                <div class="col-lg-6">
                                                    <label id="summary-sub-total" class=" pull-right">0.00</label>
                                                </div>

                                                <div class="col-lg-6" style="margin-top: 15px;">
                                                    <label>Discount Item</label>
                                                </div>

                                                <div class="col-lg-6" style="margin-top: 15px;">
                                                    <label id="summary-discount-item" class=" pull-right">0.00</label>
                                                </div>

                                                <div class="col-lg-6" style="margin-top: 15px;">
                                                    <label>Tax</label>
                                                </div>

                                                <div class="col-lg-6" style="margin-top: 15px;">
                                                    <label id="summary-tax" class=" pull-right">0.00</label>
                                                </div>

                                                <div class="col-lg-6" style="margin-top: 15px;">
                                                    <label>Shipping Cost</label>
                                                </div>

                                                <div class="col-lg-6" style="margin-top: 15px;">
                                                    <label id="summary-shipping-cost" class=" pull-right">0.00</label>
                                                </div>

                                                <div class="col-lg-6" style="margin-top: 15px;">
                                                    <label>Gift Certificate</label>
                                                </div>

                                                <div class="col-lg-6" style="margin-top: 15px;">
                                                    <label id="summary-gift-certificate" class=" pull-right">0.00</label>
                                                </div>

                                                <div class="col-lg-12" style="margin-top: 15px; border-bottom: 1px solid; margin-bottom: 2%;">
                                                </div>
                                                
                                                <div class="col-lg-6" style="margin-top: 15px;">
                                                    <label><b>Total</b></label>
                                                </div>

                                                <div class="col-lg-6" style="margin-top: 15px;">
                                                    <label id="summary-total" class=" pull-right"><b>0.00</b></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2>Classification</h2>
                    </div>

                    <div class="body">
                         <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Department</label>
                                    <select id="departments" class="form-control" required>
                                        <option value="">Select...</option>

                                        @foreach ($departments as $row)
                                            <option @if($row->department_id  == $sales_order->department_id) selected @endif value="{{ $row->department_id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Location</label>
                                    <select id="location" class="form-control" required>
                                        <option value="">Select...</option>

                                        @foreach ($locations as $row)
                                            <option @if($row->location_id  == $sales_order->location_id) selected @endif value="{{ $row->location_id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                         </div>
                    </div>
                </div>
            </div>

             <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2>Memo</h2>
                    </div>

                    <div class="body">
                         <div class="row">
                             <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Customer Memo</label>
                                    <textarea id="customer-memo" class="form-control" rows="4">{{ $sales_order->customer_memo }}</textarea> 
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Internal Memo</label>
                                    <textarea id="internal-memo" class="form-control" rows="4">{{ $sales_order->internal_memo }}</textarea> 
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
                            <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#items">Items</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#shipping">Shipping</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#billing">Billing</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#accounting">Accounting</a></li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane show active" id="items" style="margin-top: 30px;">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Coupon Code</label>
                                            <input id="coupon-code" type="text" class="form-control" value="{{ $sales_order->coupon_code }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Discount Item</label>
                                            <select id="discount-item" class="form-control">
                                                <option value="">Select...</option>

                                                @foreach ($discount_type as $row)
                                                    <option @if($row->discount_type_id  == $sales_order->discount_type_id) selected @endif value="{{ $row->discount_type_id }}~{{ $row->rate }}">{{ $row->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Discount Rate</label>
                                            <input id="discount-rate" type="text" class="form-control" readonly value="{{ IS_NULL($sales_order->discount_rate) ? '' : $sales_order->discount_rate .'%' }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table id="tblitems" class="table header-border table-hover table-custom spacing5">
                                        <thead>
                                            <tr>
                                                <th class=""><b>System ID</b></th>
                                                <th class=""><b>Sales Order ID</b></th>
                                                <th class=""><b>Item ID</b></th>
                                                <th class=""><b>Unit Type ID</b></th>
                                                <th class=""><b>Tax Code ID</b></th>
                                                <th class=""><b>Commit ID</b></th>
                                                <th class=""><b>Cost Estimate Type ID</b></th>
                                                <th class=""><b>Crud</b></th>
                                                <th><b>Item</b></th>
                                                <th><b>Item Description</b></th>
                                                <th><b>On Hand</b></th>
                                                <th><b>Quantity</b></th>
                                                <th><b>Units</b></th>
                                                <th><b>Tax Code</b></th>
                                                <th><b>Tax Rate</b></th>
                                                <th><b>Rate</b></th>
                                                <th><b>Amount</b></th>
                                                <th><b>Gross Amount</b></th>
                                                <th><b>Tax Amount</b></th>
                                                <th><b>Commit</b></th>
                                                <th><b>Order Priority</b></th>
                                                <th><b>Cost Estimate Type</b></th>
                                                <th><b>Est. Extended Cost</b></th>
                                                <th><b>With Work Order</b></th>
                                                <th><b>With Customisation</b></th>
                                                <th><b>Customisation</b></th>
                                                <th><b>Memo</b></th>
                                                <th style="width: 3px;"></th>
                                                <th style="width: 3px;"></th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($sales_order_items as $row)
                                                <tr id="{{ $row->item_id }}">
                                                    <td class="">{{ $row->system_id }}</td>
                                                    <td class="">{{ $row->sales_order_id }}</td>
                                                    <td class="">{{ $row->item_id }}</td>
                                                    <td class="">{{ $row->unit_type_id }}</td>
                                                    <td class="">{{ $row->tax_code_id }}</td>
                                                    <td class="">{{ $row->commit_id }}</td>
                                                    <td class="">{{ $row->cost_estimate_type_id }}</td>
                                                    <td class=""></td>
                                                    <td>{{ $row->item_name }}</td>
                                                    <td>{{ $row->item_description }}</td>
                                                    <td class="align-right">{{ $row->qty_on_hand }}</td>
                                                    <td class="align-right">{{ $row->quantity }}</td>
                                                    <td>{{ $row->unit_type }}</td>
                                                    <td>{{ $row->tax_type }} : {{ $row->tax_code }}</td>
                                                    <td class="align-right">{{ IS_NULL($row->tax_rate) ? '' : $row->tax_rate .'%'  }}</td>
                                                    <td class="align-right">{{ $row->rate }}</td>
                                                    <td class="align-right">{{ $row->amount }}</td>
                                                    <td class="align-right">{{ $row->gross_amount }}</td>
                                                    <td class="align-right">{{ $row->tax_amount }}</td>
                                                    <td>{{ $row->commit }}</td>
                                                    <td class="align-right">{{ $row->order_priority }}</td>
                                                    <td>{{ $row->cost_estimate_type }}</td>
                                                    <td class="align-right">{{ $row->est_extended_cost }}</td>
                                                    <td>{{ ($row->create_wo == 1) ? 'Yes' : 'No' }}</td>
                                                    <td>{{ ($row->create_customisation == 1) ? 'Yes' : 'No' }}</td>
                                                    <td>{{ $row->customisation_name }}</td>
                                                    <td>{{ $row->customisation_notes }}</td>
                                                    <td>
                                                        <a onclick="setEditItem(this)" title="Edit"><i class="fa fa-pencil green"></i></a>
                                                    </td>
                                                    <td>
                                                        <a onclick="deleteItem(this);" title="Delete"><i class="fa fa-trash-o red"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <button id="add-item" class="btn btn-outline-info" type="button" style="margin-top: 15px;">Add Item</button>
                            </div>

                            <div class="tab-pane" id="shipping" style="margin-top: 30px;">
                                <div class="row">
                                    <div class="col-lg-4">    
                                        <h6>Shipping Information</h6>

                                        <div class="row">
                                            <div class="col-lg-12">    
                                                <label>Shipping Date</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                    </div>
                                                    <input id="shipping-date" data-date-autoclose="true" class="form-control" data-date-format="mm/dd/yyyy" value="{{ IS_NULL($sales_order->shipping_date) ? '' : date('m/d/Y', strtotime($sales_order->shipping_date)) }}">
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Shipping Carrier</label>
                                                    <select id="shipping-carrier" class="form-control">
                                                        <option value="">Select...</option>

                                                        @foreach ($shipping_carrier as $row)
                                                            <option @if($row->shipping_carrier_id  == $sales_order->shipping_carrier_id) selected @endif value="{{ $row->shipping_carrier_id }}">{{ $row->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Shipping Cost</label>
                                                    <input id="shipping-cost" type="text" class="form-control" onkeypress="return IsDouble(event);" value="{{ $sales_order->shipping_cost }}">
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Shipping Tax Code</label>
                                                    <select id="shipping-tax-code" class="form-control">
                                                        <option value="">Select...</option>

                                                        @foreach ($tax_codes as $row)
                                                            <option @if($row->tax_code_id == $sales_order->shipping_tax_code_id) selected @endif value="{{ $row->tax_code_id }}~{{ $row->tax_rate }}">{{ $row->tax_type }} : {{ $row->tax_code }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Shipping Tax Rate</label> 
                                                     <input id="shipping-tax-rate" type="text" class="form-control" readonly value="{{ IS_NULL($sales_order->shipping_tax_rate) ? '' : $sales_order->shipping_tax_rate .'%' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-8">    
                                        <h6>Shipping Address</h6>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Ship To</label>
                                                    <input id="ship-to" type="text" class="form-control" value="{{ $sales_order->shipping_to }}">
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Address</label>
                                                    <textarea id="shipping-address" class="form-control" rows="4">{{ $sales_order->shipping_address }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="billing" style="margin-top: 30px;">
                                <div class="row">
                                    <div class="col-lg-4">    
                                        <h6>Billing Information</h6>

                                        <div class="row">
                                           <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Terms</label>
                                                    <select id="terms" class="form-control">
                                                        <option value="">Select...</option>

                                                        @foreach ($terms as $row)
                                                            <option @if($row->term_id == $sales_order->term_id) selected @endif value="{{ $row->term_id }}">{{ $row->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-8">    
                                        <h6>Billing Address</h6>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Bill To</label>
                                                    <input id="bill-to" type="text" class="form-control" value="{{ $sales_order->billing_to }}">
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Address</label>
                                                    <textarea id="billing-address" class="form-control" rows="4">{{ $sales_order->billing_address }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">   
                                        <h6>Payment</h6>

                                        <div class="row">
                                           <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label>Payment Method</label>
                                                    <select id="payment-method" class="form-control">
                                                        <option value="">Select...</option>

                                                        @foreach ($payment_methods as $row)
                                                            <option @if($row->payment_method_id == $sales_order->payment_method_id) selected @endif value="{{ $row->payment_method_id }}">{{ $row->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <h6>Gift Certificates</h6>

                                        <div class="table-responsive">
                                            <table id="tblgc" class="table header-border table-hover table-custom spacing5">
                                                <thead>
                                                    <tr>
                                                        <th class="hide"><b></b></th>
                                                        <th><b>Gift Certificate No.</b></th>
                                                        <th><b>Description</b></th>
                                                        <th><b>Amount Applied</b></th>
                                                        <th><b>Available Credit</b></th>
                                                        <th style="width: 3px;"></th>
                                                        <th style="width: 3px;"></th>
                                                    </tr>
                                                </thead>

                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>

                                        <button id="add-gc" class="btn btn-outline-info" type="button" style="margin-top: 15px;">Add GC</button>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="accounting" style="margin-top: 30px;">
                                <div class="row">
                                    <div class="col-lg-4">    
                                        <h6>Account Information</h6>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Currency</label>
                                                    <select id="currency" class="form-control">
                                                        <option value="">Select...</option>

                                                        @foreach ($currencies as $row)
                                                            <option @if($row->currency_id == $sales_order->currency_id) selected @endif value="{{ $row->currency_id }}~{{ $row->rate }}">{{ $row->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Exchange Rate</label> 
                                                    <input id="exchange-rate" type="text" class="form-control" readonly value="{{ $sales_order->exchange_rate }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>

                    <div style="margin-bottom: 1%">
                        <button id="save-bottom" class="btn btn-success" type="button">Save</button>
                        <button id="cancel-bottom" class="btn btn-danger" type="button">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <input id="sales-order-id" type="hidden" value="{{ $id }}">  
    </form>

    <!-- modal - start -->
    <div id="modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"  aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div id="modal-header" class="modal-header">
                    <h5 class="modal-title h4"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body"></div>

                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
    <!-- modal - end -->
@endsection

@section('script')
    <script src="{{ URL::asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/parsleyjs/js/parsley.min.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/typeahead/typeahead.min.js') }}"></script>

    <script src="{{ URL::asset('js/alert.js') }}"></script>
    <script src="{{ URL::asset('js/pages/sales/sales_order_edit.js') }}"></script>
@endsection
