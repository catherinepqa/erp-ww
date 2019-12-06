@extends('template')

@section('title', 'Sales Order - Sales Order ID: '. $id)

@section('css')
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

        .block {
            display: block;
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
                <li class="breadcrumb-item active" aria-current="page"><b>Sales Order ID : {{ $id }}</b></li>
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
                        <button id="new-top" class="btn btn-primary" type="button">New</button>
                        <button id="edit-top" class="btn btn-success" type="button">Edit</button>
                        <button id="back-top" class="btn btn-danger" type="button">Back</button>


                        <button id="btnGroupDrop1" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="padding: 7.5px 18px;">
                            Actions
                        </button>
                        <div class="dropdown-menu" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -84px, 0px);">
                            <a class="dropdown-item" href="{{ url('sales/invoices/new/'. $id) }}">Bill</a>
                            <a class="dropdown-item" href="javascript:void(0);">Fulfill</a>
                            <a class="dropdown-item" href="javascript:void(0);">Cancel</a>
                        </div>
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
                                            <label>Sales Order No.</label>
                                            <label class="block"><b>{{ $sales_order->reference_no }}</b></label>
                                        </div>
                                    </div>

                                    <div class="col-lg-6"></div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Customer Name</label>
                                            <label class="block"><b>{{ $sales_order->lname }}, {{ $sales_order->fname }} {{ $sales_order->mname }}</b></label>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Customer Email</label>
                                            <label class="block"><b>{{ $sales_order->customer_email }}</b></label>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">    
                                        <div class="form-group">
                                            <label>Sales Order Date</label>
                                            <label class="block"><b>{{ date('m/d/Y', strtotime($sales_order->so_date)) }}</b></label>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">    
                                        <div class="form-group">
                                            <label>Sales Effective Date</label>
                                            <label class="block"><b>{{ date('m/d/Y', strtotime($sales_order->sales_effective_date)) }}</b></label>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>PO No.</label>
                                            <label class="block"><b>{{ $sales_order->po_no }}</b></label>
                                        </div>
                                    </div>

                                    <div class="col-lg-6"></div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Internal Status</label>
                                            <label class="block"><b>{{ $sales_order->internal_status_description }}</b></label>
                                        </div>
                                    </div>

                                    <div class="col-lg-6"></div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Web Status</label>
                                            <label class="block"><b>{{ $sales_order->web_status_description }}</b></label>
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
                                    <label class="block"><b>{{ $sales_order->department }}</b></label>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Location</label>
                                    <label class="block"><b>{{ $sales_order->location }}</b></label>
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
                                    <label class="block">{{ $sales_order->customer_memo }}</label>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Internal Memo</label>
                                    <label class="block">{{ $sales_order->internal_memo }}</label>
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
                                            <label class="block"><b>{{ $sales_order->coupon_code }}</b></label>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Discount Item</label>
                                            <label class="block"><b>{{ $sales_order->discount_type }}</b></label>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Discount Rate</label>
                                            <label class="block"><b>{{ IS_NULL($sales_order->discount_rate) ? '' : $sales_order->discount_rate .'%' }}</b></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table id="tblitems" class="table header-border table-hover table-custom">
                                        <thead>
                                            <tr>
                                                <th class="align-center"><b>Item</b></th>
                                                <th class="align-center"><b>Item Description</b></th>
                                                <th class="align-center"><b>On Hand</b></th>
                                                <th class="align-center"><b>Quantity</b></th>
                                                <th class="align-center"><b>Units</b></th>
                                                <th class="align-center"><b>Tax Code</b></th>
                                                <th class="align-center"><b>Tax Rate</b></th>
                                                <th class="align-center"><b>Rate</b></th>
                                                <th class="align-center"><b>Amount</b></th>
                                                <th class="align-center"><b>Gross Amount</b></th>
                                                <th class="align-center"><b>Tax Amount</b></th>
                                                <th class="align-center"><b>Commit</b></th>
                                                <th class="align-center"><b>Order Priority</b></th>
                                                <th class="align-center"><b>Cost Estimate Type</b></th>
                                                <th class="align-center"><b>Est. Extended Cost</b></th>
                                                <th class="align-center"><b>With Work Order</b></th>
                                                <th class="align-center"><b>With Customisation</b></th>
                                                <th class="align-center"><b>Customisation</b>
                                                <th class="align-center"><b>Customisation Notes</b>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($sales_order_items as $row)
                                                <tr>
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
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane" id="shipping" style="margin-top: 30px;">
                                <div class="row">
                                    <div class="col-lg-4">    
                                        <h6>Shipping Information</h6>

                                        <div class="row">
                                            <div class="col-lg-12">    
                                                <div class="form-group">
                                                    <label>Shipping Date</label>
                                                    <label class="block"><b>@if ($sales_order->shipping_date != NULL) {{ date('m/d/Y', strtotime($sales_order->shipping_date)) }} @endif</b></label>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Shipping Carrier</label>
                                                    <label class="block"><b>{{ $sales_order->shipping_carrier }}</b></label>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Shipping Cost</label>
                                                    <label class="block"><b>{{ $sales_order->shipping_cost }}</b></label>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Shipping Tax Code</label>
                                                    <label class="block"><b>{{ $sales_order->shipping_tax_code }}</b></label>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Shipping Tax Rate</label> 
                                                    <label class="block"><b>{{ IS_NULL($sales_order->shipping_tax_rate) ? '' : $sales_order->shipping_tax_rate .'%' }}</b></label>
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
                                                    <label class="block"><b>{{ $sales_order->shipping_to }}</b></label>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Address</label>
                                                    <label class="block"><b>{{ $sales_order->shipping_address }}</b></label>
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
                                                    <label class="block"><b>{{ $sales_order->terms }}</b></label>
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
                                                    <label class="block"><b>{{ $sales_order->billing_to }}</b></label>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Address</label>
                                                    <label class="block"><b>{{ $sales_order->billing_address }}</b></label>
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
                                                    <label class="block"><b>{{ $sales_order->payment_method }}</b></label>
                                                </div>
                                            </div>
                                        </div>

                                        <h6>Gift Certificates</h6>

                                        <div class="table-responsive">
                                            <table id="tblgc" class="table header-border table-hover table-custom spacing5">
                                                <thead>
                                                    <tr>
                                                        <th><b>Gift Certificate No.</b></th>
                                                        <th><b>Description</b></th>
                                                        <th><b>Amount Applied</b></th>
                                                        <th><b>Available Credit</b></th>
                                                    </tr>
                                                </thead>

                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
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
                                                    <label class="block"><b>{{ $sales_order->currency }}</b></label>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Exchange Rate</label> 
                                                    <label class="block"><b>{{ $sales_order->exchange_rate }}</b></label>
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
                        <button id="new-bottom" class="btn btn-primary" type="button">New</button>
                        <button id="edit-bottom" class="btn btn-success" type="button">Edit</button>
                        <button id="back-bottom" class="btn btn-danger" type="button">Back</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
     <script>
        $(function () {
            var App = {
                baseUrl : window.location.protocol + '//' + window.location.host + '/sales/',
                csrfToken : $('meta[name="csrf-token"]').attr('content'),

                init: function () {
                    this.setElements();
                    this.bindEvents();
                },

                setElements: function () {
                    this.$new_top = $('#new-top'); 
                    this.$new_bottom = $('#new-bottom'); 
                    this.$edit_top = $('#edit-top'); 
                    this.$edit_bottom = $('#edit-bottom'); 
                    this.$back_top = $('#back-top'); 
                    this.$back_bottom = $('#back-bottom'); 
                },
              
                bindEvents: function () {
                    this.$new_top.on('click', this.new);
                    this.$new_bottom.on('click', this.new);
                    this.$edit_top.on('click', this.edit);
                    this.$edit_bottom.on('click', this.edit);
                    this.$back_top.on('click', this.back);
                    this.$back_bottom.on('click', this.back);
                },

                new : function() {
                    window.location.href = App.baseUrl + "sales_order/new"; 
                },

                edit : function() {
                    window.location.href = App.baseUrl + "sales_order/edit/" + {{ $id }}; 
                },

                back : function() {
                    window.history.back();
                }
            }
        
            App.init();
        }); 
    </script>
@endsection
