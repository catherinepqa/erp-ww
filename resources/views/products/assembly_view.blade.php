@extends('template')

@section('title', 'Assembly/Bill of Materials - Item ID: '. $id)

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
        <h1>Assembly/Bill of Materials</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Products</li>
                <li class="breadcrumb-item">Assembly/Bill of Materials</li>
                <li class="breadcrumb-item active" aria-current="page"><b>Item ID : {{ $id }}</b></li>
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
                    </div>

                    <br>

                    <div class="header">
                        <h2>Primary Information</h2>
                    </div>

                    <div class="body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Item Code</label>
                                	<label class="block"><b>{{ $items->item_code }}</b></label>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Subitem Of</label>
                                    <label class="block"><b><a href="{{ url('products/view_assembly/'. $items->subitem_id) }}">{{ $items->subitem }}</a></b></label>
                                </div>
                            </div>

                            <div class="col-lg-4"></div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Item Name</label>
                                    <label class="block"><b>{{ $items->item_name }}</b></label>
                                </div>
                            </div>

                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label>Item Description</label>
                                   	<label class="block"><b>{{ $items->item_description }}</b></label>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>UPC Code</label>
                                   	<label class="block"><b>{{ $items->upc_code }}</b></label>
                                </div>
                            </div>
                           

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>External ID</label>
                                    <label class="block"><b>{{ $items->external_id }}</b></label>
                                </div>
                            </div>

                            <div class="col-lg-4"></div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Wicked O Meter</label>
                                    <label class="block"><b>{{ $items->wicked_o_meter }}</b></label>
                                </div>
                            </div>

                             <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Item BOM Barcode</label>
                                    <label class="block"><b>{{ $items->item_bom_barcode }}</b></label>
                                </div>
                            </div>


                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Production Team</label>
                                    <label class="block"><b>{{ $items->production_team }}</b></label>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Item Style</label>
                                   	<label class="block"><b>{{ $items->item_style }}</b></label>
                                </div>
                            </div>

                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label>Item Style Description</label>
                                    <label class="block"><b>{{ $items->item_style_description }}</b></label>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Item Classification</label>
                                   	<label class="block"><b>{{ $items->item_classification }}</b></label>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Item Options</label>
                                    <label class="block"><b>{{ $items->item_option_description }}</b></label>
                                </div>
                            </div>
                           
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Product Category</label>
                                    <label class="block"><b>{{ $items->product_category_descripton }}</b></label>
                                </div>
                            </div>

                            <div class="col-lg-4">    
                                <div class="form-group">
                                    <label>Release Date</label>
                                    <label class="block"><b>{{ date('m/d/Y', strtotime($items->release_date)) }}</b></label>
                                </div>
                            </div>


                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Vendors Code</label>
                                   	<label class="block"><b></b></label>
                                </div>
                            </div>

                            <div class="col-lg-4"></div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Oversell Item</label>
                                   	<label class="block"><b>{{ $items->oversell ? 'Yes' : 'No' }}</b></label>
                                </div>
                            </div>
                            
                            <div class="col-lg-8"></div>

                            <div class="col-lg-4" style="margin-top: 50px;">
                                <div class="form-group">
                                    <label>Unit Type</label>
                                    <label class="block"><b>{{ $items->unit_type_descripton }}</b></label>
                                </div>
                            </div>

                            <div class="col-lg-4" style="margin-top: 50px;">
                                <div class="form-group">
                                    <label>Stock Unit</label>
                                   	<label class="block"><b>{{ $items->stock_unit_descripton }}</b></label>
                                </div>
                            </div>

                            <div class="col-lg-4" style="margin-top: 50px;">
                                <div class="form-group">
                                    <label>Purchase Unit</label>
                                    <label class="block"><b>{{ $items->purchase_unit_descripton }}</b></label>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Sales Unit</label>
                                    <label class="block"><b>{{ $items->sale_unit_descripton }}</b></label>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Consumption Unit</label>
                                   	<label class="block"><b>{{ $items->consumption_unit_descripton }}</b></label>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Base Unit</label>
                                    <label class="block"><b>{{ $items->base_unit }}</b></label>
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
                                   	<label class="block"><b>{{ $items->department }}</b></label>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Item Category</label>
                                    <label class="block"><b>{{ $items->item_category }}</b></label>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Location</label>
                                   	<label class="block"><b>{{ $items->location }}</b></label>
                                </div>
                            </div>
                        </div>    
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="body">
                         <ul class="nav nav-tabs3">
                            <li class="nav-item"><a class="nav-link show active" data-toggle="tab" href="#purchasing"><i class="fa fa-angle-right"></i> Purchasing / Inventory</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#matrix"><i class="fa fa-angle-right"></i> Matrix / Sub Item</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#sales"><i class="fa fa-angle-right"></i> Sales / Pricing</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#accounting"><i class="fa fa-angle-right"></i> Accounting</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#store"><i class="fa fa-angle-right"></i> Web Store</a></li>
                        </ul>

                        <div class="tab-content">

                            <!--PURCHASING-->
                            <div class="tab-pane show active" id="purchasing">
                                <h6 style="margin-top: 30px;">Item / Cost Detail</h6>

                                <div class="row">
                                	<div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Track Landed Cost</label>
                                           	<label class="block"><b>{{ $items->track_landed_cost ? 'Yes' : 'No' }}</b></label>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Costing Method</label>
                                           	<label class="block"><b>{{ $items->costing_method }}</b></label>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Purchase Price <i>*per kg</i></label>
                                          	<label class="block"><b>{{ $items->purchase_price }}</b></label>
                                        </div>
                                    </div>

                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label>Purchase Description</label>
                                           	<label class="block"><b>{{ $items->purchase_description }}</b></label>
                                        </div>
                                    </div>

                                    <div class="col-lg-4"></div>

                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label>Stock Description</label>
                                           	<label class="block"><b>{{ $items->stock_description }}</b></label>
                                        </div>
                                    </div>
                                </div>    

                                <h6 style="margin-top: 20px;">Inventory Management</h6>

                                <div class="row">
                                	<div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Use Bins</label>
                                           	<label class="block"><b>{{ $items->use_bins ? 'Yes' : 'No' }}</b></label>
                                        </div>
                                    </div>
                                </div>    

                                <h6 style="margin-top: 20px;"></h6>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Manufacturer</label>
                                           	<label class="block"><b>{{ $items->manufacturer }}</b></label>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>MPN</label>
                                           	<label class="block"><b>{{ $items->mpn }}</b></label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Manufacturer Country</label>
                                            <label class="block"><b>{{ $items->manufacturer_country_descripton }}</b></label>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <ul class="nav nav-tabs">
                                    <li class="nav-item"><a class="nav-link show active" data-toggle="tab" href="#tab-location">Location <strong>•</strong></a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-bom">Bill of Materials <strong>•</strong></a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-bin">Bin Numbers</a></li>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane show active" id="tab-location">
                                        <div class="table-responsive">
                                            <table id="tblloc" class="table header-border table-hover table-custom" style="margin-bottom: 0">
                                                <thead>
                                                    <tr>
                                                        <th class="align-center" style="width: 40%"><b>Location</b></th>
                                                        <th class="align-center"><b>Build Point</b></th>
                                                        <th class="align-center"><b>Preferred Stock Level</b></th>
                                                        <th class="align-center"><b>Default Return Cost</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                     @foreach ($inventory_items as $row)
                                                        <tr>
                                                            <td>{{ $row->location_name }}</td>
                                                            <td class="align-right">{{ $row->build_point }}</td>
                                                            <td class="align-right">{{ $row->preferred_stock_level }}</td>
                                                            <td class="align-right">{{ $row->default_return_cost }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="tab-bom">
                                        <div class="table-responsive">
                                            <table id="tblbom" class="table header-border table-hover table-custom">
                                                <thead>
                                                    <tr>
                                                        <th class="align-center"><b>Item</b></th>
                                                        <th class="align-center"><b>Item Description</b></th>
                                                        <th class="align-center"><b>Component Yield</b></th>
                                                        <th class="align-center"><b>BOM Quantity</b></th>
                                                        <th class="align-center"><b>Item Source</b></th>
                                                        <th class="align-center"><b>Quantity</b></th>
                                                        <th class="align-center"><b>Units</b></th>
                                                        <th class="align-center"><b>Tax Code</b></th>
                                                        <th class="align-center"><b>Tax Rate</b></th>
                                                        <th class="align-center"><b>Effective Date</b></th>
                                                        <th class="align-center"><b>Obselete Date</b></th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach ($bom as $row)
                                                        <tr>
                                                            <td>{{ $row->item_name }}</td>
                                                            <td>{{ $row->item_description }}</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>{{ $row->item_source }}</td>
                                                            <td class="align-right">{{ $row->quantity }}</td>
                                                            <td>{{ $row->unit_type }}</td>
                                                            <td>{{ $row->tax_type }} : {{ $row->tax_code }}</td>
                                                            <td class="align-right">{{ $row->tax_rate }}</td>
                                                            <td>@if ($row->effective_date != NULL) {{ date('m/d/Y', strtotime($row->effective_date)) }} @endif</td>
                                                            <td>@if ($row->obselete_date != NULL) {{ date('m/d/Y', strtotime($row->obselete_date)) }} @endif</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane" id="tab-bin">
                                        <div class="table-responsive">
                                            <table id="tblbin" class="table header-border table-hover table-custom">
                                                <thead>
                                                    <tr>
                                                        <th class="align-center" style="width: 40%"><b>Location</b></th>
                                                        <th class="align-center" style="width: 15%"><b>Bin Number</b></th>
                                                        <th class="align-center" style="width: 15%"><b>Preferred<br>(Per Location)</b></th>
                                                        <th class="align-center" style="width: 15%"><b>On Hand</b></th>
                                                        <th class="align-center" style="width: 15%"><b>Available</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($bins as $row)
                                                        <tr>
                                                            <td>{{ $row->location }}</td>
                                                            <td>{{ $row->bin_no }}</td>
                                                            <td>{{ $row->preferred_per_location ? 'Yes' : 'No' }}</td>
                                                            <td class="align-right">{{ $row->quantity }}</td>
                                                            <td class="align-right"></td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>    
                                </div>    
                            </div>

                            <!--MATRIX-->
                            <div class="tab-pane" id="matrix">
                                <div class="row" style="margin-top: 30px;">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Matrix Item Name Template <span style="color: red">*</span> </label>
                                           	<label class="block"><b>{{ $items->matrix_item_name_template }}</b></label>
                                        </div>
                                    </div>  
                                    
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Colour</label>
                                           	<label class="block"><b>{{ $items->colour_descripton }}</b></label>
                                        </div>
                                    </div>  

                                    <div class="col-lg-4">
                                         <div class="form-group">
                                            <label>Back Variation</label>
                                            <label class="block"><b>{{ $items->back_variation_descripton }}</b></label>
                                        </div>
                                    </div>    

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Style</label>
                                            <label class="block"><b>{{ $items->style_descripton }}</b></label>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Top Size</label>
                                            <label class="block"><b>{{ $items->top_size_descripton }}</b></label>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                         <div class="form-group">
                                            <label>Style Variation</label>
                                            <label class="block"><b>{{ $items->style_variation_descripton }}</b></label>
                                        </div>
                                    </div>


                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Fabric</label>
                                            <label class="block"><b>{{ $items->fabric_descripton }}</b></label>
                                        </div>  
                                    </div>  

                                     <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Size</label>
                                            <label class="block"><b>{{ $items->size_descripton }}</b></label>
                                        </div>
                                    </div>  

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Print</label>
                                            <label class="block"><b>{{ $items->print_descripton }}</b></label>
                                        </div>
                                    </div>

                                    <div class="col-lg-8"></div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Trouser Length</label>
                                            <label class="block"><b>{{ $items->trouser_length_descripton }}</b></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!--SALES-->
                            <div class="tab-pane" id="sales">
                                <h6 style="margin-top: 30px;">Sales</h6>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Cost Estimate Type</label>
                                            <label class="block"><b>{{ $items->cost_estimate_type }}</b></label>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Item Defined Cost</label>
                                            <label class="block"><b>{{ $items->item_defined_cost }}</b></label>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Minimum Quantity</label>
                                            <label class="block"><b>{{ $items->minimum_quantity }}</b></label>
                                        </div>
                                    </div>
                                </div>

                                <h6 style="margin-top: 20px;">Shipping</h6>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Item Weight</label>
                                            <label class="block"><b>{{ $items->item_weight }} {{ $items->weight_unit }}</b></label>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Shipping Cost</label>
                                            <label class="block"><b>{{ $items->shipping_cost }}</b></label>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Handling Cost</label>
                                            <label class="block"><b>{{ $items->handling_cost }}</b></label>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Ships Individually</label>
                                            <label class="block"><b>{{ $items->ships_individualy ? 'Yes' : 'No' }}</b></label>
                                        </div>
                                    </div>

                                    <div class="col-lg-8"></div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Prices Included Tax</label>
                                            <label class="block"><b>{{ $items->price_included_tax ? 'Yes' : 'No' }}</b></label>
                                        </div>
                                    </div>
                                </div>

                                <h6 style="margin-top: 20px;">Price Levels</h6>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table id="tblpl" class="table header-border table-hover table-custom" style="margin-bottom: 0">
                                                <thead>
                                                    <tr>
                                                        <th class="align-center" style="width: 80%;"><b>Currency</b></th>
                                                        <th class="align-center"><b>Amount</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                     @foreach ($price_levels as $row)
                                                        <tr>
                                                            <td>{{ $row->currency }}</td>
                                                            <td class="align-right">{{ $row->amount }}</td>
                                                        </tr>
                                                    @endforeach   
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>            

                            <!--ACCOUNTING-->
                            <div class="tab-pane" id="accounting">
                                <h6 style="margin-top: 30px;">Taxes</h6>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Tax Code</label>
                                            <label class="block"><b>{{ $items->tax_code_description }}</b></label>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Purchase Tax Code</label>
                                            <label class="block"><b>{{ $items->purchase_tax_code_description }}</b></label>
                                        </div>
                                    </div>

                                    <div class="col-lg-4"></div>
                                </div>
                            </div>

                            <!--STORE-->
                            <div class="tab-pane" id="store">
                                <h6 style="margin-top: 30px;">Web Store Displays</h6>

                                <div class="row">
                                    <div class="col-lg-4">
                                         <div class="form-group">
                                            <label>Display in Web Site</label>
                                            <label class="block"><b>{{ $items->display_on_web ? 'Yes' : 'No' }}</b></label>
                                        </div>
                                    </div>

                                    <div class="col-lg-8">
                                        <label>Detailed Description</label>
                                        <label class="block"><b>{!! $items->detailed_description !!}</b></label>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group" style="margin-top: 20px;">
                                            <label>Webstore Display Name</label>
                                            <label class="block"><b>{{ $items->display_name }}</b></label>
                                        </div>
                                    </div>

                                    <div class="col-lg-8" style="margin-top: 15px;">
                                        <label>Featured Description</label>
                                        <label class="block"><b>{!! $items->featured_description !!}</b></label>
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
                baseUrl : window.location.protocol + '//' + window.location.host + '/products/',
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

                new: function() {
                    window.location.href = App.baseUrl + "new_assembly"; 
                },

                edit: function() {
                    window.location.href = App.baseUrl + "edit_assembly/" + {{ $id }}; 
                },

                back: function() {
                    window.history.back();
                }
            }
        
            App.init();
        }); 
    </script>
@endsection
