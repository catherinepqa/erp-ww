<!doctype html>
<html lang="en">

<head>
    <title>WW ERP | @yield('title')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="description" content="Oculux Bootstrap 4x admin is super flexible, powerful, clean &amp; modern responsive admin dashboard with unlimited possibilities.">
    <meta name="keywords" content="admin template, Oculux admin template, dashboard template, flat admin template, responsive admin template, web app, Light Dark version">
    <meta name="author" content="GetBootstrap, design by: puffintheme.com">


    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="icon" href="{{ URL::asset('assets/images/favicon.png') }}" type="image/x-icon">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/animate-css/vivify.min.css') }}">

    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/c3/c3.min.css') }}"/>

    @yield('css')

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/site.min.css') }}">

    <!-- CUSTOM CSS -->
    <link rel="stylesheet" href="{{ URL::asset('css/custom.css') }}">
</head>

<body class="theme-cyan font-montserrat light_version">

    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
            <div class="bar4"></div>
            <div class="bar5"></div>
        </div>
    </div>

    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>

    <div id="wrapper">

        <nav class="navbar top-navbar">
            <div class="container-fluid">

                <div class="navbar-left">
                    <div class="navbar-btn">
                        <a href="#"><img src="{{ URL::asset('assets/images/favicon.png') }}" alt="Oculux Logo" class="img-fluid logo"></a>
                        <button type="button" class="btn-toggle-offcanvas"><i class="lnr lnr-menu fa fa-bars"></i></button>
                    </div>
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle icon-menu" data-toggle="dropdown">
                                <i class="icon-envelope"></i>
                                <span class="notification-dot bg-green">4</span>
                            </a>
                            <ul class="dropdown-menu right_chat email vivify fadeIn">
                                <li class="header green">You have 4 New eMail</li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="media">
                                            <div class="avtar-pic w35 bg-red"><span>FC</span></div>
                                            <div class="media-body">
                                                <span class="name">James Wert <small class="float-right text-muted">Just now</small></span>
                                                <span class="message">Update GitHub</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="media">
                                            <div class="avtar-pic w35 bg-indigo"><span>FC</span></div>
                                            <div class="media-body">
                                                <span class="name">Folisise Chosielie <small class="float-right text-muted">12min ago</small></span>
                                                <span class="message">New Messages</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle icon-menu" data-toggle="dropdown">
                                <i class="icon-bell"></i>
                                <span class="notification-dot bg-azura">4</span>
                            </a>
                            <ul class="dropdown-menu feeds_widget vivify fadeIn">
                                <li class="header blue">You have 4 New Notifications</li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="feeds-left bg-red"><i class="fa fa-check"></i></div>
                                        <div class="feeds-body">
                                            <h4 class="title text-danger">Issue Fixed <small class="float-right text-muted">9:10 AM</small></h4>
                                            <small>WE have fix all Design bug with Responsive</small>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="feeds-left bg-info"><i class="fa fa-user"></i></div>
                                        <div class="feeds-body">
                                            <h4 class="title text-info">New User <small class="float-right text-muted">9:15 AM</small></h4>
                                            <small>I feel great! Thanks team</small>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <div class="navbar-right">
                    <div id="navbar-menu">
                        <ul class="nav navbar-nav">
                            <li><a href="javascript:void(0);" class="search_toggle icon-menu" title="Search Result"><i class="icon-magnifier"></i></a></li>
                            <li><a href="#" class="icon-menu"><i class="icon-power"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="progress-container"><div class="progress-bar" id="myBar"></div></div>
        </nav>

        <div class="search_div">
            <div class="card">
                <div class="body">
                    <form id="navbar-search" class="navbar-form search-form">
                        <div class="input-group mb-0">
                            <input type="text" class="form-control" placeholder="Search...">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="icon-magnifier"></i></span>
                                <a href="javascript:void(0);" class="search_toggle btn btn-danger"><i class="icon-close"></i></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <span>Search Result <small class="float-right text-muted">About 90 results (0.47 seconds)</small></span>
            <div class="table-responsive">
                <table class="table table-hover table-custom spacing5">
                    <tbody>
                    <tr>
                        <td class="w40">
                            <span></span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avtar-pic w35 bg-red" data-toggle="tooltip" data-placement="top" title="" data-original-title="Avatar Name"><span></span></div>
                                <div class="ml-3">
                                    <a href="#" title=""></a>
                                    <p class="mb-0"></p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="megamenu" class="megamenu particles_js">
            <a href="javascript:void(0);" class="megamenu_toggle btn btn-danger"><i class="icon-close"></i></a>
            <div id="particles-js"></div>
        </div>

        <div id="left-sidebar" class="sidebar">
            <div class="navbar-brand">
                <a href="#"><img src="{{ URL::asset('assets/images/favicon.png') }}" alt="Oculux Logo" class="img-fluid logo"><span>WW ERP</span></a>
                <button type="button" class="btn-toggle-offcanvas btn btn-sm float-right"><i class="lnr lnr-menu icon-close"></i></button>
            </div>

            <div class="sidebar-scroll">
                <div class="user-account">
                    <div class="user_div">
                        <img src="{{ URL::asset('assets/images/admin.png') }}" class="user-photo" alt="User Profile Picture">
                    </div>
                    <div class="dropdown">
                        <span>Welcome,</span>
                        <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown"><strong>Administrator</strong></a>
                        <ul class="dropdown-menu dropdown-menu-right account vivify flipInY">
                            <li><a href="#"><i class="icon-user"></i>My Profile</a></li>
                            <li><a href="#"><i class="icon-envelope-open"></i>Messages</a></li>
                            <li><a href="javascript:void(0);"><i class="icon-settings"></i>Settings</a></li>
                        </ul>
                    </div>
                </div>

                <nav id="left-sidebar-nav" class="sidebar-nav">
                    <ul id="main-menu" class="metismenu">
                        <li class="{{ request()->routeIs('dashboard*') ? 'active' : '' }}">
                            <a href="{{ route('dashboard.index') }}"><i class="icon-speedometer"></i><span>Dashboard</span></a>
                        </li>

                        <li class="{{ Request::is('inventory/*') ? 'active open' : '' }}">
                            <a href="#Inventory" class="has-arrow"><i class="fa fa-th-large"></i></i><span>Inventory</span></a>
                            <ul>
                                <li class="{{ (request()->is('inventory/inventory_adjustment')) || Request::is('inventory/inventory_adjustment/*') ? 'active' : '' }}">
                                    <a href="{{ route('inventory_adjustment') }}">Inventory Adjustment</a>
                                </li>
                                <li><a href="">Bin Transfer </a></li>
                                <li class="{{ (request()->is('inventory/transfer_inventory')) || Request::is('inventory/transfer_inventory/*') ? 'active' : '' }}">
                                    <a href="{{ route('transfer_inventory') }}">Transfer Inventory</a>
                                </li>
                                <li><a>Reallocate Items</a>
                                <li><a href="">Inventory Distribution</a></li>
                                <li class="{{ (request()->is('inventory/transfer_orders')) || Request::is('inventory/transfer_orders/*') ? 'active' : '' }}">
                                    <a href="{{ route('transfer_orders') }}">Transfer Orders</a>
                                </li>
                                <li class="{{ (request()->is('inventory/order_items')) || Request::is('inventory/order_items/*') ? 'active' : '' }}">
                                    <a href="{{ route('order_items') }}">Order Items & Approval</a>
                                </li>
                                <li><a href="">Commit Orders</a></li>
                                <li><a href="">Negative Inventory</a></li>
                            </ul>
                        </li>

                        <li class="{{ request()->routeIs('customers*') ? 'active open' : '' }}">
                            <a href="#Customer" class="has-arrow"><i class="fa fa-users"></i><span>Customers</span></a>
                            <ul>
                                <li><a href="">Customers</a></li>
                                <li class="{{ (request()->is('customer_payment')) ? 'active' : '' }}"><a href="#">Customer Payment</a></li>
                                <li><a href="">Customer Refund</a></li>
                                <li><a href="">Assessment & Approval of Customer Refund</a></li>
                                <li><a href="">Customer Cases</a></li>
                                <li><a href="">Chargeback</a></li>
                                <li><a href="">Need Attention</a></li>
                                <li><a href="">Customer Deposits</a></li>
                                <li><a href="">Cash Refund</a></li>
                            </ul>
                        </li>

                        <li class="{{ Request::is('sales/*') ? 'active open' : '' }}">
                            <a href="#Sales" class="has-arrow"><i class="fa fa-cubes"></i><span>Sales</span></a>
                            <ul>
                                <li class="{{ Request::is('sales/sales_order') || Request::is('sales/sales_order/new') || Request::is('sales/sales_order/new/*') || Request::is('sales/sales_order/view/*') || Request::is('sales/sales_order/edit/*') ? 'active' : '' }}">
                                    <a href="{{ route('sales_order') }}">Sales Order</a>
                                </li>
                                <li class="{{ Request::is('sales/invoices') || Request::is('sales/invoices/new') || Request::is('sales/invoices/new/*') ? 'active' : '' }}">
                                    <a href="{{ route('invoices') }}">Invoices</a>
                                </li>
                                <li class="{{ (request()->is('cashsales')) ? 'active' : '' }}"><a href="{{ route('sales.cashsales') }}">Cash Sales</a></li>
                                <li><a href="">Item Receipt</a></li>
                                <li><a href="">Credit Memos</a></li>
                                <li><a href="">Order Assessment & Item Fullfillment</a></li>
                                <li><a href="">Combine Orders</a></li>
                                <li><a href="">Customisation of Existing Unshipped Order</a></li>
                                <li><a href="">Cancellation of Unshipped Order</a></li>
                                <li><a href="">Packing & Shipping</a></li>
                                <li><a href="">Currency Exchange Rates Adjustment</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="#Purchases" class="has-arrow"><i class="fa fa-shopping-cart"></i><span>Purchases</span></a>
                            <ul>
                                <li><a href="#">Purchase Order</a></li>
                                <li><a href="#">PO Adjustment & Approval</a></li>
                                <li><a href="#">Receive & Billing of Orders</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="#Returns" class="has-arrow"><i class="fa fa-reply"></i><span>Returns</span></a>
                            <ul>
                                <li><a href="#">Returned Order</a></li>
                                <li><a href="#">Assessment & Approval of Returned Order</a></li>
                                <li><a href="return_auth.html">Return Authorisation</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="#Accounting" class="has-arrow"><i class="fa fa-calculator"></i><span>Accounting</span></a>
                            <ul>
                                <li><a href="#">Exchanges Rates</a></li>
                            </ul>
                        </li>

                        <li class="{{ Request::is('products/*') ? 'active open' : '' }}">
                            <a href="#Products" class="has-arrow"><i class="fa fa-cubes"></i><span>Products</span></a>
                            <ul>
                                <li><a href="#">Inventory Items</a></li>

                                <li class="{{ Request::is('products/assembly') || Request::is('products/new_assembly') || Request::is('products/view_assembly/*') || Request::is('products/edit_assembly/*') ? 'active' : '' }}">
                                    <a href="{{ route('assembly') }}">Assembly/Bill of Materials</a>
                                </li>

                                <li><a href="#">Kit/Package</a></li>
                                <li><a href="#">Gift Certificates/Vouchers</a></li>
                            </ul>
                        </li>

                         <li class="{{ request()->routeIs('reports*') ? 'active open' : '' }}">
                            <a href="#Reports" class="has-arrow"><i class="fa fa-file-text"></i><span>Reports</span></a>
                            <ul>
                                <li class="{{ (request()->is('currentInventoryStatus')) ? 'active' : '' }}"><a href="{{ route('reports.currentInventoryStatus') }}">Current Invetory Status</a></li>
                                <li class="{{ (request()->is('inventoryStatusCommitted')) ? 'active' : '' }}"><a href="{{ route('reports.inventoryStatusCommitted') }}">Current Invetory Status Committed</a></li>
                                <li class="{{ (request()->is('stockAvailable')) ? 'active' : '' }}"><a href="{{ route('reports.stockAvailable') }}">Stock Available By Locations</a></li>
                                <li><a href="#">Inventory Valuation </a></li>
                                <li><a href="#">Inventory Revenue</a></li>
                                <li><a href="#">Inventory Health </a></li>
                                <li class="{{ (request()->is('salesNewCustomer')) ? 'active' : '' }}"><a href="{{ route('reports.salesNewCustomer') }}">Sales By New Customer Country (Gross Amount)</a></li>
                                <li class="{{ (request()->is('salesRepeatCustomer')) ? 'active' : '' }}"><a href="{{ route('reports.salesRepeatCustomer') }}">Sales By Repeat Customer Country (Gross Amount)</a></li>
                                <li class="{{ (request()->is('salesCustomer')) ? 'active' : '' }}"><a href="{{ route('reports.salesCustomer') }}">Sales By Customer (New Amount)</a></li>
                                <li><a href="#">Sales Transaction Status</a></li>
                                <li><a href="#">Compare Sales</a></li>
                                <li><a href="#">Sales Order Register</a></li>
                                <li><a href="#">Sales By Country</a></li>
                                <li class="{{ (request()->is('dailySales')) ? 'active' : '' }}"><a href="{{ route('reports.dailySales') }}">Daily Sales</a></li>
                                <li class="{{ (request()->is('totalSales')) ? 'active' : '' }}"><a href="{{ route('reports.totalSales') }}">Total Sales</a></li>
                                <li><a href="#">Production Sales Back Order</a></li>
                                <li><a href="#">Sales Item Summary</a></li>
                                <li><a href="#">Returns</a></li>
                                <li><a href="#">Exchanges</a></li>
                                <li><a href="#">Reship Items</a></li>
                                <li><a href="#">Custom Tax Claims</a></li>
                                <li><a href="#">Investigations Launched with Carriers</a></li>
                                <li><a href="#">Tasks Completed by CS Reps</a></li>
                                <li><a href="#">Picking Tickets</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="#Utilities" class="has-arrow"><i class="fa fa-wrench"></i><span>Utilities</span></a>
                            <ul>
                                <li><a href="#">Batch Upload for Price Update</a></li>
                                <li><a href="#">Batch Upload for Last Chance, Oversell & Discontinued Items</a></li>
                                <li><a href="#">Batch Upload for PSL BTP Inventory Items</a></li>
                                <li><a href="#">Batch Upload for Inventory Adjustment</a></li>
                                <li><a href="#">Batch Upload for Manual Sales</a></li>
                                <li><a href="#">Batch Upload for Kit/Package Item</a></li>
                                <li><a href="#">Batch Upload for Bin</a></li>
                            </ul>
                        </li>

                        <li class="{{ request()->routeIs('setup*') ? 'active open' : '' }}">
                            <a href="#Setup" class="has-arrow"><i class="fa fa-users"></i><span>Setup</span></a>
                            <ul>
                                <li class="{{ (request()->is('department/departments')) ? 'active' : '' }}"><a href="{{ route('setup.department.departments') }}">Departments</a></li>
                                <li class="{{ (request()->is('location/locations')) ? 'active' : '' }}"><a href="{{ route('setup.location.locations') }}">Locations</a></li>
                                <li class="{{ (request()->is('production_team/index')) ? 'active' : '' }}"><a href="{{ route('setup.production_team.index') }}">Production Team</a></li>
                                <li class="{{ (request()->is('item_categories/index')) ? 'active' : '' }}"><a href="{{ route('setup.item_categories.index') }}">Item Categories</a></li>
                                <li class="{{ (request()->is('item_type/index')) ? 'active' : '' }}"><a href="{{ route('setup.item_types.index') }}">Item Type</a></li>
                                <li class="{{ (request()->is('product_categories/index')) ? 'active' : '' }}"><a href="{{ route('setup.product_categories.index') }}">Product Categories</a></li>
                                <li class="{{ (request()->is('styles/index')) ? 'active' : '' }}"><a href="{{ route('setup.styles.index') }}">Styles</a></li>
                                <li class="{{ (request()->is('fabric/index')) ? 'active' : '' }}"><a href="{{ route('setup.fabric.index') }}">Fabric</a></li>
                                <li class="{{ (request()->is('colour/index')) ? 'active' : '' }}"><a href="{{ route('setup.colour.index') }}">Colour</a></li>
                                <li class="{{ (request()->is('top_sizes/index')) ? 'active' : '' }}"><a href="{{ route('setup.top_sizes.index') }}">Top Sizes</a></li>
                                <li class="{{ (request()->is('sizes/index')) ? 'active' : '' }}"><a href="{{ route('setup.sizes.index') }}">Sizes</a></li>
                                <li class="{{ (request()->is('back_variations/index')) ? 'active' : '' }}"><a href="{{ route('setup.back_variations.index') }}">Back Variations</a></li>
                                <li class="{{ (request()->is('style_variations/index')) ? 'active' : '' }}"><a href="{{ route('setup.style_variations.index') }}">Style Variations</a></li>
                                <li class="{{ (request()->is('prints/index')) ? 'active' : '' }}"><a href="{{ route('setup.prints.index') }}">Prints</a></li>
                                <li class="{{ (request()->is('trouser_length/index')) ? 'active' : '' }}"><a href="{{ route('setup.trouser_length.index') }}">Trouser Length</a></li>
                                <li class="{{ (request()->is('item_options/index')) ? 'active' : '' }}"><a href="{{ route('setup.item_options.index') }}">Item Options</a></li>
                                <li class="{{ (request()->is('wicked_o_meter/index')) ? 'active' : '' }}"><a href="{{ route('setup.wicked_o_meter.index') }}">Wicked-O-Meter</a></li>
                                <li class="{{ (request()->is('unit_of_measures/index')) ? 'active' : '' }}"><a href="{{ route('setup.unit_of_measures.index') }}">Unit of Measures</a></li>
                                <li class="{{ (request()->is('weight_units/index')) ? 'active' : '' }}"><a href="{{ route('setup.weight_units.index') }}">Weight Units</a></li>
                                <li class="{{ (request()->is('bins/index')) ? 'active' : '' }}"><a href="{{ route('setup.bins.index') }}">Bins</a></li>
                                <li class="{{ (request()->is('currencies/index')) ? 'active' : '' }}"><a href="{{ route('setup.currencies.index') }}">Currencies</a></li>
                                <li class="{{ (request()->is('exchange_rates/index')) ? 'active' : '' }}"><a href="{{ route('setup.exchange_rates.index') }}">Exchange Rates</a></li>
                                <li class="{{ (request()->is('shipping_carrier/index')) ? 'active' : '' }}"><a href="{{ route('setup.shipping_carrier.index') }}">Shipping Carrier</a></li>
                                <li class="{{ (request()->is('countries/index')) ? 'active' : '' }}"><a href="{{ route('setup.countries.index') }}">Countries</a></li>
                                <li class="{{ (request()->is('tax_codes/index')) ? 'active' : '' }}"><a href="{{ route('setup.tax_codes.index') }}">Tax Codes</a></li>
                                <li class="{{ (request()->is('tax_types/index')) ? 'active' : '' }}"><a href="{{ route('setup.tax_types.index') }}">Tax Types</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <div id="main-content">
            <div class="container-fluid">
                <div class="block-header">
                    <div class="row clearfix">
                        @yield('breadcrumb')
                    </div>
                </div>
                <!-- CONTENT -->
                @yield('content')
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ URL::asset('assets/vendor/jquery/jquery.min.js') }}"></script>

    <!-- Javascript -->
    <script src="{{ URL::asset('assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ URL::asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
    <script src="{{ URL::asset('assets/bundles/c3.bundle.js') }}"></script>
    <script src="{{ URL::asset('assets/bundles/mainscripts.bundle.js') }}"></script>
    <script src="{{ URL::asset('assets/js/index.js') }}"></script>

    @yield('script')
</body>
</html>
