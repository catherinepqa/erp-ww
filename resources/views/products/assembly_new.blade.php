@extends('template')

@section('title', 'Assembly/Bill of Materials - New')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/multi-select/css/multi-select.css') }}">
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

        .multiselect-selected-text {
            display: block;
            width: 100%;
            height: 100%;
            word-wrap: break-word;
            white-space: normal;
        }

        .multiselect-container .input-group {
            margin: 8px;
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
        <h1>Assembly/Bill of Materials</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Products</li>
                <li class="breadcrumb-item">Assembly/Bill of Materials</li>
                <li class="breadcrumb-item active" aria-current="page"><b>New</b></li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <form id="form">
        {{csrf_field()}}

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
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label><b>Item Code</b></label>
                                    <input id="item-code" type="text" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-lg-8"></div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Item Name</label>
                                    <input id="item-name" type="text" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label>Item Description</label>
                                    <textarea id="item-description" class="form-control" rows="4" required></textarea> 
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>UPC Code</label>
                                    <input id="upc-code" type="text" class="form-control" required>
                                </div>
                            </div>
                           

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>External ID</label>
                                    <input id="external-id" type="text" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-lg-4"></div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Wicked O Meter</label>
                                    <select id="wicked-o-meter" class="form-control">
                                        <option value="">Select...</option>

                                        @foreach ($wicked_o_meter as $row)
                                            <option value="{{ $row->wicked_o_meter_id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                             <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Item BOM Barcode</label>
                                    <input id="item-bom-barcode" type="text" class="form-control">
                                </div>
                            </div>


                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Production Team</label>
                                    <select id="production-team" class="form-control">
                                        <option value="">Select...</option>

                                         @foreach ($production_team as $row)
                                            <option value="{{ $row->production_team_id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Item Style</label>
                                    <input id="item-style" type="text" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label>Item Style Description</label>
                                    <textarea id="item-style-description" class="form-control" rows="4"></textarea> 
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Item Classification</label>
                                    <input id="item-classification" type="text" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Item Options</label>
                                    <div class="multiselect_div">
                                        <select id="item-options" name="style_variation[]" class="multiselect multiselect-custom" multiple="multiple">
                                             @foreach ($item_options as $row)
                                                <option value="{{ $row->item_option_id }}">{{ $row->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Product Category</label>
                                    <div class="multiselect_div">
                                        <select id="product-category" name="style_variation[]" class="multiselect multiselect-custom" multiple="multiple">
                                             @foreach ($product_categories as $row)
                                                <option value="{{ $row->product_category_id }}">{{ $row->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">    
                                <label>Release Date</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <input id="release-date" data-date-autoclose="true" class="form-control" data-date-format="mm/dd/yyyy" required data-parsley-required data-parsley-trigger-after-failure="change" data-parsley-errors-container="#error-release-date">
                                </div>

                                <p id="error-release-date"></p>
                            </div>


                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Vendors Code</label>
                                    <input id="vendors-code" type="text" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-4"></div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <div class="fancy-checkbox" style="margin-top: 15px;">
                                        <label><input id="oversell" type="checkbox"><span>Oversell Item</span></label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-8"></div>

                            <div class="col-lg-4" style="margin-top: 50px;">
                                <div class="form-group">
                                    <label>Unit Type</label>
                                    <select id="unit-type" class="form-control" required>
                                        <option value="">Select...</option>

                                        @foreach ($unit_of_measures as $row)
                                            <option value="{{ $row->unit_type_id }}~{{ $row->abbreviation }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4" style="margin-top: 50px;">
                                <div class="form-group">
                                    <label>Stock Unit</label>
                                    <select id="stock-unit" class="form-control">
                                        <option>Select...</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4" style="margin-top: 50px;">
                                <div class="form-group">
                                    <label>Purchase Unit</label>
                                    <select id="purchase-unit" class="form-control">
                                        <option>Select...</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Sales Unit</label>
                                    <select id="sales-unit" class="form-control">
                                        <option>Select...</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Consumption Unit</label>
                                    <select id="consumption-unit" class="form-control">
                                        <option>Select...</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Base Unit</label>
                                     <input id="base-unit" type="text" class="form-control" readonly>
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
                                            <option value="{{ $row->department_id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Item Category</label>
                                    <select id="item-category" class="form-control">
                                        <option value="">Select...</option>

                                        @foreach ($item_categories as $row)
                                            <option value="{{ $row->item_category_id }}">{{ $row->description }}</option>
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
                                            <option value="{{ $row->location_id }}">{{ $row->name }}</option>
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
                                        <div class="fancy-checkbox" style="margin-top: 30px;">
                                            <label><input id="track-landed-cost" type="checkbox"><span>Track Landed Cost</span></label>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Costing Method</label>
                                            <select id="costing-method" class="form-control">
                                                <option value="">Select...</option>

                                                 @foreach ($costing_method as $row)
                                                    <option value="{{ $row->costing_method_id }}">{{ $row->name }}</option>
                                                 @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Purchase Price <i>*per kg</i></label>
                                            <input id="purchase-price" type="text" class="form-control" onkeypress="return IsDouble(event);">
                                        </div>
                                    </div>

                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label>Purchase Description</label>
                                            <textarea id="purchase-description" class="form-control" rows="3" cols="10"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-4"></div>

                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label>Stock Description</label>
                                            <textarea id="stock-description" class="form-control" rows="3" cols="10"></textarea>
                                        </div>
                                    </div>
                                </div>    

                                <h6 style="margin-top: 20px;">Inventory Management</h6>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="fancy-checkbox">
                                            <label><input id="use-bins" type="checkbox"><span>Use Bins</span></label>
                                        </div>
                                    </div>
                                </div>    

                                <h6 style="margin-top: 20px;">Manufacturer</h6>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Manufacturer</label>
                                            <input id="manufacturer" type="text" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>MPN</label>
                                            <input id="mpn" type="text" class="form-control">
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Manufacturer Country</label>
                                            <select id="manufacturer-country" class="form-control">
                                                <option value="">Select...</option>

                                                 @foreach ($countries as $row)
                                                    <option value="{{ $row->country_id }}">{{ $row->name }}</option>
                                                 @endforeach
                                            </select>
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
                                            <table id="tblloc" class="table header-border table-hover table-custom spacing5" style="margin-bottom: 0">
                                                <thead>
                                                    <tr>
                                                        <th class="">Location ID</th>
                                                        <th style="width: 40%"><b>Location</b></th>
                                                        <th class="align-right"><b>Build Point</b></th>
                                                        <th class="align-right"><b>Preferred Stock Level</b></th>
                                                        <th class="align-right"><b>Default Return Cost</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($locations as $row)
                                                        <tr>
                                                            <td class="">{{ $row->location_id }}</td>
                                                            <td>{{ $row->name }}</td>
                                                            <td><input id="bp-{{ $row->location_id }}" type="text" class="form-control" onkeypress="return IsInteger(event);"></td>
                                                            <td><input id="psl-{{ $row->location_id }}" type="text" class="form-control" onkeypress="return IsInteger(event);"></td>
                                                            <td><input id="drc-{{ $row->location_id }}" type="text" class="form-control" onkeypress="return IsDouble(event);"></td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="tab-bom">
                                        <div class="table-responsive">
                                            <table id="tblbom" class="table header-border table-hover table-custom spacing5">
                                                <thead>
                                                    <tr>
                                                        <th class=""><b>System ID</b></th>
                                                        <th class=""><b>Item ID</b></th>
                                                        <th class=""><b>Unit Type ID</b></th>
                                                        <th class=""><b>Tax Code ID</b></th>
                                                        <th class=""><b>Item Source ID</b></th>
                                                        <th class=""><b>Crud</b></th>
                                                        <th><b>Item</b></th>
                                                        <th><b>Item Description</b></th>
                                                        <th><b>Component Yield</b></th>
                                                        <th><b>BOM Quantity</b></th>
                                                        <th><b>Item Source</b></th>
                                                        <th><b>Quantity</b></th>
                                                        <th><b>Units</b></th>
                                                        <th><b>Tax Code</b></th>
                                                        <th><b>Tax Rate</b></th>
                                                        <th><b>Effective Date</b></th>
                                                        <th><b>Obselete Date</b></th>
                                                        <th style="width: 3px;"></th>
                                                        <th style="width: 3px;"></th>
                                                    </tr>
                                                </thead>

                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>

                                        <button id="add-data-bom" class="btn btn-outline-info" type="button" style="margin-top: 15px;">Add Data</button>
                                    </div>
                                    
                                    <div class="tab-pane" id="tab-bin">
                                        <div class="table-responsive">
                                            <table id="tblbin" class="table header-border table-hover table-custom spacing5">
                                                <thead>
                                                    <tr>
                                                        <th class=""><b>System ID</b></th>
                                                        <th class=""><b>Location ID</b></th>
                                                        <th class=""><b>Bin ID</b></th>
                                                        <th class=""><b>CRUD</b></th>
                                                        <th><b>Location</b></th>
                                                        <th><b>Bin Number</b></th>
                                                        <th><b>Location Active</b></th>
                                                        <th><b>Preferred Location</b></th>
                                                        <th style="width: 3px;"></th>
                                                        <th style="width: 3px;"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   
                                                </tbody>
                                            </table>
                                        </div>

                                        <button id="add-data-bin" class="btn btn-outline-info" type="button">Add Data</button>
                                    </div>    
                                </div>    
                            </div>

                            <!--MATRIX-->
                            <div class="tab-pane" id="matrix">
                                <div class="row" style="margin-top: 30px;">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Matrix Item Name Template <span style="color: red">*</span> </label>
                                            <textarea id="matrix-item-name-template" class="form-control" readonly="readonly" style="height: 100px;"></textarea>
                                        </div>
                                    </div>  
                                    
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Colour</label>
                                           
                                            <div class="multiselect_div">
                                                <select id="colour" name="colour[]" class="multiselect multiselect-custom" multiple="multiple" data-parsley-required data-parsley-trigger-after-failure="change" data-parsley-errors-container="#error-colour">
                                                    @foreach ($colour as $row)
                                                        <option value="{{ $row->colour_id }}">{{ $row->name }}</option>
                                                    @endforeach
                                                </select>

                                                <p id="error-colour"></p>
                                            </div>
                                        </div>
                                    </div>  

                                    <div class="col-lg-4">
                                         <div class="form-group">
                                            <label>Back Variation</label>
                                            <div class="multiselect_div">
                                                <select id="back-variation" name="back_variation[]" class="multiselect multiselect-custom" multiple="multiple">
                                                    @foreach ($back_variations as $row)
                                                        <option value="{{ $row->back_variation_id }}">{{ $row->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>    

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Style</label>
                                            <div class="multiselect_div">
                                                <select id="style" name="style[]" class="multiselect multiselect-custom" multiple="multiple" data-parsley-required data-parsley-trigger-after-failure="change" data-parsley-errors-container="#error-style">
                                                    @foreach ($styles as $row)
                                                        <option value="{{ $row->style_id }}">{{ $row->name }}</option>
                                                    @endforeach
                                                </select>

                                                <p id="error-style"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Top Size</label>
                                            <div class="multiselect_div">
                                                <select id="top-size" name="top_size[]" class="multiselect multiselect-custom" multiple="multiple">
                                                    @foreach ($top_sizes as $row)
                                                        <option value="{{ $row->top_size_id }}">{{ $row->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                         <div class="form-group">
                                            <label>Style Variation</label>
                                            <div class="multiselect_div">
                                                <select id="style-variation" name="style_variation[]" class="multiselect multiselect-custom" multiple="multiple">
                                                    @foreach ($style_variations as $row)
                                                        <option value="{{ $row->style_variation_id }}">{{ $row->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Fabric</label>
                                            <div class="multiselect_div">
                                                <select id="fabric" name="fabric[]" class="multiselect multiselect-custom" multiple="multiple" data-parsley-required data-parsley-trigger-after-failure="change" data-parsley-errors-container="#error-fabric">
                                                    @foreach ($fabric as $row)
                                                        <option value="{{ $row->fabric_id }}">{{ $row->name }}</option>
                                                    @endforeach
                                                </select>

                                                <p id="error-fabric"></p>
                                            </div>
                                        </div>  
                                    </div>  

                                     <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Size</label>
                                            <div class="multiselect_div">
                                                <select id="size" name="size[]" class="multiselect multiselect-custom" multiple="multiple" data-parsley-required data-parsley-trigger-after-failure="change" data-parsley-errors-container="#error-size">
                                                    @foreach ($sizes as $row)
                                                        <option value="{{ $row->size_id }}">{{ $row->name }}</option>
                                                    @endforeach
                                                </select>

                                                <p id="error-size"></p>
                                            </div>
                                        </div>
                                    </div>  

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Print</label>
                                            <div class="multiselect_div">
                                                <select id="print" name="print[]" class="multiselect multiselect-custom" multiple="multiple">
                                                    @foreach ($prints as $row)
                                                        <option value="{{ $row->print_id }}">{{ $row->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-8"></div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Trouser Length</label>
                                            <div class="multiselect_div">
                                                <select id="trouser-length" name="trouser_length[]" class="multiselect multiselect-custom" multiple="multiple">
                                                    @foreach ($trouser_length as $row)
                                                        <option value="{{ $row->trouser_length_id }}">{{ $row->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
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
                                            <select id="cost-estimate-type" class="form-control">
                                                <option value="">Select...</option>

                                                @foreach ($cost_estimate_type as $row)
                                                    <option value="{{ $row->cost_estimate_type_id }}">{{ $row->name }}</option>
                                                 @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Item Defined Cost</label>
                                            <input id="item-defined-cost" type="text" class="form-control" onkeypress="return IsDouble(event);">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Minimum Quantity</label>
                                            <input id="minimum-quantity" type="text" class="form-control" onkeypress="return IsInteger(event);">
                                        </div>
                                    </div>
                                </div>

                                <h6 style="margin-top: 20px;">Shipping</h6>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Item Weight</label>
                                            <div class="row">
                                                <div class="col-lg-8" style="padding-right: 0;">
                                                    <input id="item-weight" type="text" class="form-control" onkeypress="return IsInteger(event);">
                                                </div>
                                                <div class="col-lg-4">
                                                    <select id="weight-unit" class="form-control">
                                                        @foreach ($weight_units as $row)
                                                            <option value="{{ $row->weight_unit_id }}" @if($row->weight_unit_id  == 3) selected @endif >
                                                                {{ $row->abbreviation }}
                                                            </option>
                                                         @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Shipping Cost</label>
                                            <input id="shipping-cost" type="text" class="form-control" onkeypress="return IsDouble(event);">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Handling Cost</label>
                                            <input id="handling-cost" type="text" class="form-control" onkeypress="return IsDouble(event);">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="fancy-checkbox">
                                            <label><input id="ships-individually" type="checkbox"><span>Ships Individually</span></label>
                                        </div>
                                    </div>

                                    <div class="col-lg-8"></div>

                                    <div class="col-lg-4">
                                        <div class="fancy-checkbox">
                                            <label><input id="prices-included-tax" type="checkbox"><span>Prices Included Tax</span></label>
                                        </div>
                                    </div>
                                </div>

                                <h6 style="margin-top: 20px;">Price Levels</h6>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table id="tblpl" class="table header-border table-hover table-custom spacing5" style="margin-bottom: 0">
                                                <thead>
                                                    <tr>
                                                        <th class=""><b>Currency ID</b></th>
                                                        <th style="width: 80%;"><b>Currency</b></th>
                                                        <th style="text-align: right;"><b>Amount</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($currencies as $row)
                                                        <tr>
                                                            <td class="">{{ $row->currency_id }}</td>
                                                            <td>{{ $row->name }}</td>
                                                            <td><input id="pl-{{ $row->currency_id }}" type="text" class="form-control" onkeypress="return IsDouble(event);"></td>
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
                                            <select id="tax-code" class="form-control" required>
                                                <option value="">Select...</option>

                                                @foreach ($tax_codes as $row)
                                                    <option value="{{ $row->tax_code_id }}">{{ $row->tax_type }} : {{ $row->tax_code }}</option>
                                                 @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Purchase Tax Code</label>
                                            <select id="purchase-tax-code" class="form-control" required>
                                                <option value="">Select...</option>

                                                 @foreach ($tax_codes as $row)
                                                    <option value="{{ $row->tax_code_id }}">{{ $row->tax_type }} : {{ $row->tax_code }}</option>
                                                 @endforeach
                                            </select>
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
                                        <div class="fancy-checkbox" style="margin-top: 25px;">
                                            <label><input id="display-in-web" type="checkbox"><span>Display in Web Site</span></label>
                                        </div>

                                        <div class="form-group" style="margin-top: 20px;">
                                            <label>Webstore Display Name</label>
                                            <input id="webstore-display-name" type="text" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-8">
                                        <label>Detailed Description</label>
                                        <div id="detailed-description"></div>
                                    </div>

                                    <div class="col-lg-4"></div>

                                    <div class="col-lg-8" style="margin-top: 15px;">
                                        <label>Featured Description</label>
                                        <div id="featured-description"></div>
                                    </div>

                                    <div class="col-lg-12" style="margin-bottom: 15px;"></div>
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
    <script src="{{ URL::asset('assets/vendor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/ckeditor/sample.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/multi-select/js/jquery.multi-select.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/parsleyjs/js/parsley.min.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/typeahead/typeahead.min.js') }}"></script>

    <script src="{{ URL::asset('js/alert.js') }}"></script>
    <script src="{{ URL::asset('js/pages/products/assembly_new.js') }}"></script>
@endsection
