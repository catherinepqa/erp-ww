<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//-------- DASHBOARD --------//
Route::apiResource('dashboard', 'DashboardController');
Route::post('dashboard', ['as' => 'dashboard.index', 'uses' => 'DashboardController@index']);

//-------- INVENTORY --------//


//-------- CUSTOMERS --------//


//-------- SALES --------//
Route::group(['name' => 'sales.', 'prefix' => 'sales', 'namespace' => 'Sales'], function () {
	Route::get('sales_order', 'SalesOrderController@index')->name('sales_order');
	Route::get('sales_order/new', 'SalesOrderController@new')->name('new_sales_order');
	Route::get('sales_order/view/{id}', 'SalesOrderController@view')->name('view_sales_order');
	Route::get('sales_order/edit/{id}', 'SalesOrderController@edit')->name('edit_sales_order');
	Route::get('get_customer_details', 'SalesOrderController@getCustomerDetails')->name('get_customer_details');
	Route::get('search_item_by_name', 'SalesOrderController@searchItemByName')->name('search_item_by_name');
	Route::get('set_new_item', 'SalesOrderController@setNewItem')->name('set_new_item');
	Route::get('set_edit_item', 'SalesOrderController@setEditItem')->name('set_edit_item');
	Route::post('create_sales_order', 'SalesOrderController@createSalesOrder')->name('create_sales_order');
   	Route::post('update_sales_order', 'SalesOrderController@updateSalesOrder')->name('update_sales_order');

   	Route::get('invoices', 'InvoicesController@index')->name('invoices');
   	Route::get('invoices/new', 'InvoicesController@new')->name('new_invoices');
   	Route::get('invoices/new/{id}', 'InvoicesController@new')->name('new_invoices');

   	Route::post('create_invoice', 'InvoicesController@createInvoice')->name('create_invoice');
    Route::get('sales_order', ['as' => 'sales.order', 'uses' => 'SalesController@sales_order']);
    Route::get('currency_exchange', ['as' => 'sales.currency_exchange', 'uses' => 'SalesController@currency_exchange']);
});



//-------- PRODUCTS --------//
Route::group(['name' => 'products.', 'prefix' => 'products', 'namespace' => 'Products'], function () {
	Route::get('assembly', 'AssemblyController@index')->name('assembly');
    Route::get('new_assembly', 'AssemblyController@new')->name('new_assembly');
    Route::get('view_assembly/{id}', 'AssemblyController@view')->name('view_assembly');
	Route::get('edit_assembly/{id}', 'AssemblyController@edit')->name('edit_assembly');
    Route::get('get_subunit_of_measures', 'AssemblyController@getSubUnitOfMeasures')->name('get_subunit_of_measures');
    Route::get('search_item_by_name', 'AssemblyController@searchItemByName')->name('search_item_by_name');
    Route::get('get_bins_by_location_id', 'AssemblyController@getBinsByLocationID')->name('get_bins_by_location_id');
	Route::get('set_new_bom', 'AssemblyController@setNewBOM')->name('set_new_bom');
	Route::get('set_edit_bom', 'AssemblyController@setEditBOM')->name('set_edit_bom');
	Route::get('set_new_bin', 'AssemblyController@setNewBIN')->name('set_new_bin');
	Route::get('set_edit_bin', 'AssemblyController@setEditBIN')->name('set_edit_bin');
	Route::post('create_item', 'AssemblyController@createItem')->name('create_item');
	Route::post('update_item', 'AssemblyController@updateItem')->name('update_item');

});

//-------- TRANSFER INVENTORY --------//
Route::apiResource('inventory', 'TransferInventoryController');
Route::get('transfer_inventory', ['as' => 'inventory.transfer', 'uses' => 'TransferInventoryController@index']);
Route::get('add_transfer_inventory', ['as' => 'inventory.addTransfer', 'uses' => 'TransferInventoryController@addTransfer']);
Route::get('transfer_item_search', ['as' => 'inventory.transfer_item_search', 'uses' => 'TransferInventoryController@item_search']);
Route::get('transfer_getItems', ['as' => 'inventory.transfer_getItems', 'uses' => 'TransferInventoryController@getItems']);
Route::post('transfer_addData', ['as' => 'inventory.transfer_addData', 'uses' => 'TransferInventoryController@addData']);
Route::get('transfer_viewTransfer/{id}', ['as' => 'inventory.transfer_viewTransfer', 'uses' => 'TransferInventoryController@viewTransfer']);
Route::get('transfer_getBin', ['as' => 'inventory.transfer_getBin', 'uses' => 'TransferInventoryController@getBin']);
Route::get('transfer_getQtyAvailable', ['as' => 'inventory.transfer_getQtyAvailable', 'uses' => 'TransferInventoryController@getQtyAvailable']);
Route::get('transfer_dataList', ['as' => 'inventory.transfer_dataList', 'uses' => 'TransferInventoryController@dataList']);
Route::get('transfer_getTransferredBins', ['as' => 'inventory.transfer_getTransferredBins', 'uses' => 'TransferInventoryController@getTransferredBins']);
Route::get('transfer_getAllData', ['as' => 'inventory.transfer_getAllData', 'uses' => 'TransferInventoryController@getAllData']);
Route::get('transfer_editTransfer/{id}', ['as' => 'inventory.transfer_editTransfer', 'uses' => 'TransferInventoryController@editTransfer']);
Route::post('transfer_updateData', ['as' => 'inventory.transfer_updateData', 'uses' => 'TransferInventoryController@updateData']);

Route::get('bin_transfer', ['as' => 'inventory.bin_transfer', 'uses' => 'InventoryController@bin_transfer']);
Route::get('reallocate_item', ['as' => 'inventory.reallocate_item', 'uses' => 'InventoryController@reallocate_item']);

//-------- TRANSFER ORDERS --------//
Route::apiResource('inventory', 'TransferInventoryController');
Route::get('transfer_orders', ['as' => 'inventory.transfer_orders', 'uses' => 'TransferOrderController@index']);
Route::get('add_transfer_orders', ['as' => 'inventory.add_transfer_orders', 'uses' => 'TransferOrderController@addOrders']);
Route::get('order_item_search', ['as' => 'inventory.order_item_search', 'uses' => 'TransferOrderController@item_search']);
Route::get('order_getItems', ['as' => 'inventory.order_getItems', 'uses' => 'TransferOrderController@getItems']);
Route::post('order_addDataProcess', ['as' => 'inventory.order_addDataProcess', 'uses' => 'TransferOrderController@addDataProcess']);
Route::get('order_viewOrders/{id}', ['as' => 'inventory.order_viewOrders', 'uses' => 'TransferOrderController@viewOrders']);
Route::get('order_dataList', ['as' => 'inventory.order_dataList', 'uses' => 'TransferOrderController@dataList']);
Route::get('order_getAllData', ['as' => 'inventory.order_getAllData', 'uses' => 'TransferOrderController@getAllData']);
Route::get('order_editOrder/{id}', ['as' => 'inventory.order_editOrder', 'uses' => 'TransferOrderController@editOrder']);
Route::post('order_updateData', ['as' => 'inventory.order_updateData', 'uses' => 'TransferOrderController@updateData']);
Route::post('order_approveStatus', ['as' => 'inventory.order_approveStatus', 'uses' => 'TransferOrderController@approveStatus']);

//-------- ORDER ITEMS --------//
Route::apiResource('inventory', 'OrderItemsController');
Route::get('order_items', ['as' => 'inventory.order_items', 'uses' => 'OrderItemsController@index']);
Route::get('order_items_dataList', ['as' => 'inventory.order_items_dataList', 'uses' => 'OrderItemsController@dataList']);
Route::post('order_approveOrder', ['as' => 'inventory.order_approveOrder', 'uses' => 'OrderItemsController@approveOrder']);

//-------- CUSTOMER PAYMENT --------//
Route::apiResource('customers', 'CustomerPaymentController');
Route::get('customer_payment', ['as' => 'customers.payment', 'uses' => 'CustomerPaymentController@index']);


//-------- BIN TRANSFER --------//
Route::apiResource('bintransfer', 'BinTransferController');
Route::get('create_bin_transfer', ['as' => 'bintransfer.create', 'uses' => 'BinTransferController@create']);
Route::post('store', ['as' => 'bintransfer.store', 'uses' => 'BinTransferController@store']);
Route::get('view_bin_transfer/{id}', ['as' => 'bintransfer.view', 'uses' => 'BinTransferController@show']);
Route::get('edit_bin_transfer/{id}', ['as' => 'bintransfer.edit', 'uses' => 'BinTransferController@edit']);
Route::put('update_bin_transfer/{id}', ['as' => 'bintransfer.update', 'uses' => 'BinTransferController@update']);
Route::post('binInventoryDetail', ['as' => 'bintransfer.binInventoryDetail', 'uses' => 'BinTransferController@binInventoryDetail']);
Route::get('checkLocationItems', ['as' => 'bintransfer.checkLocationItems', 'uses' => 'BinTransferController@checkLocationItems']);
Route::get('checkItemBin', ['as' => 'bintransfer.checkItemBin', 'uses' => 'BinTransferController@checkItemBin']);
Route::get('inventoryDetailForm', ['as' => 'bintransfer.inventoryDetailForm', 'uses' => 'BinTransferController@inventoryDetailForm']);

//-------- REALLOCATE ITEMS --------//
Route::apiResource('reallocate_items', 'ReallocateItemsController');
Route::get('create_reallocate_items', ['as' => 'reallocate_items.create', 'uses' => 'ReallocateItemsController@create']);
Route::post('store', ['as' => 'reallocate_items.store', 'uses' => 'ReallocateItemsController@store']);
Route::get('getSalesOrderItems', ['as' => 'reallocate_items.getSalesOrderItems', 'uses' => 'ReallocateItemsController@getSalesOrderItems']);
Route::post('qtyCommitted', ['as' => 'reallocate_items.qtyCommitted', 'uses' => 'ReallocateItemsController@qtyCommitted']);

//-------- REPORTS --------//
Route::apiResource('reports', 'ReportsController');
//-------- CURRENT INVENTORY STATUS COMMITTED REPORT --------//
Route::get('inventoryStatusCommitted', ['as' => 'reports.inventoryStatusCommitted', 'uses' => 'ReportsController@inventoryStatusCommitted']);
Route::post('inventoryStatusCommitted', ['as' => 'reports.', 'uses' => 'ReportsController@inventoryStatusCommitted']);
Route::get('filterInventoryStatusCommitted', ['as' => 'reports.filterInventoryStatusCommitted', 'uses' => 'ReportsController@filterInventoryStatusCommitted']);
Route::get('exportInventoryStatusCommitted', ['as' => 'reports.exportInventoryStatusCommitted', 'uses' => 'ReportsController@exportInventoryStatusCommitted']);

//-------- CURRENT INVENTORY STATUS REPORT --------//
Route::get('currentInventoryStatus', ['as' => 'reports.currentInventoryStatus', 'uses' => 'ReportsController@currentInventoryStatus']);
Route::get('filterInventoryStatus', ['as' => 'reports.filterInventoryStatus', 'uses' => 'ReportsController@filterInventoryStatus']);
Route::get('exportInventoryStatus', ['as' => 'reports.exportInventoryStatus', 'uses' => 'ReportsController@exportInventoryStatus']);

//-------- STOCK AVAILABLE BY LOCATION REPORT --------//
Route::get('stockAvailable', ['as' => 'reports.stockAvailable', 'uses' => 'ReportsController@stockAvailable']);
Route::get('filterStockAvailable', ['as' => 'reports.filterStockAvailable', 'uses' => 'ReportsController@filterStockAvailable']);
Route::get('exportStockAvailable', ['as' => 'reports.exportStockAvailable', 'uses' => 'ReportsController@exportStockAvailable']);

//-------- SALES NEW CUSTOMER COUNTRY (GROSS AMT) REPORT --------//
Route::get('salesNewCustomer', ['as' => 'reports.salesNewCustomer', 'uses' => 'ReportsController@salesNewCustomer']);
Route::get('filterSalesNewCustomer', ['as' => 'reports.filterSalesNewCustomer', 'uses' => 'ReportsController@filterSalesNewCustomer']);
Route::get('exportSalesNewCustomer', ['as' => 'reports.exportSalesNewCustomer', 'uses' => 'ReportsController@exportSalesNewCustomer']);

//-------- SALES by REPEAT CUSTOMER COUNTRY (GROSS AMT) REPORT --------//
Route::get('salesRepeatCustomer', ['as' => 'reports.salesRepeatCustomer', 'uses' => 'ReportsController@salesRepeatCustomer']);
Route::get('filterSalesRepeatCustomer', ['as' => 'reports.filterSalesRepeatCustomer', 'uses' => 'ReportsController@filterSalesRepeatCustomer']);
Route::get('exportSalesRepeatCustomer', ['as' => 'reports.exportSalesRepeatCustomer', 'uses' => 'ReportsController@exportSalesRepeatCustomer']);

//-------- SALES by CUSTOMER COUNTRY (NET AMT) REPORT --------//
Route::get('salesCustomer', ['as' => 'reports.salesCustomer', 'uses' => 'ReportsController@salesCustomer']);
Route::get('filterSalesCustomer', ['as' => 'reports.filterSalesCustomer', 'uses' => 'ReportsController@filterSalesCustomer']);
Route::get('exportSalesCustomer', ['as' => 'reports.exportSalesCustomer', 'uses' => 'ReportsController@exportSalesCustomer']);

//-------- DAILY SALES REPORT --------//
Route::get('dailySales', ['as' => 'reports.dailySales', 'uses' => 'ReportsController@dailySales']);
Route::get('filterDailySales', ['as' => 'reports.filterDailySales', 'uses' => 'ReportsController@filterDailySales']);
Route::get('exportDailySales', ['as' => 'reports.exportDailySales', 'uses' => 'ReportsController@exportDailySales']);

//-------- TOTAL SALES REPORT --------//
Route::get('totalSales', ['as' => 'reports.totalSales', 'uses' => 'ReportsController@totalSales']);
Route::get('filterTotalSales', ['as' => 'reports.filterTotalSales', 'uses' => 'ReportsController@filterTotalSales']);
Route::get('exportTotalSales', ['as' => 'reports.exportTotalSales', 'uses' => 'ReportsController@exportTotalSales']);

//-------- CASH SALES --------//
Route::apiResource('cash_sales', 'CashSalesController');
Route::get('create_cash_sales', ['as' => 'cash_sales.create', 'uses' => 'CashSalesController@create']);
Route::post('store_cash_sales', ['as' => 'cash_sales.store', 'uses' => 'CashSalesController@store']);
Route::get('checkItems', ['as' => 'cash_sales.checkItems', 'uses' => 'CashSalesController@checkItems']);
Route::get('itemDesc', ['as' => 'cash_sales.itemDesc', 'uses' => 'CashSalesController@itemDesc']);
Route::get('view_cash_sales/{id}', ['as' => 'cash_sales.view', 'uses' => 'CashSalesController@view']);
Route::get('edit_cash_sales/{id}', ['as' => 'cash_sales.edit', 'uses' => 'CashSalesController@edit']);
Route::get('cashSaleItems', ['as' => 'cash_sales.cashSaleItems', 'uses' => 'CashSalesController@cashSaleItems']);
Route::post('update_cash_sales/{id}', ['as' => 'cash_sales.udpate', 'uses' => 'CashSalesController@udpate']);


//-------- SETUP TABLES --------//
//-------- 2.13.2 -> DEPARTMENTS --------//
Route::apiResource('setup', 'SetupController');
Route::get('/department/departments', ['as' => 'setup.department.departments', 'uses' => 'SetupController@departments']);
Route::get('/department/edit_department/{id}', ['as' => 'setup.department.edit_department', 'uses' => 'SetupController@edit_department']);
Route::get('/department/new_department', ['as' => 'setup.department.new_department', 'uses' => 'SetupController@new_department']);
Route::post('/department/store_department', ['as' => 'setup.department.store_department', 'uses' => 'SetupController@store_department']);
Route::put('/department/update_department/{id}', ['as' => 'setup.department.update_department', 'uses' => 'SetupController@update_department']);
Route::get('/department/view_department/{id}', ['as' => 'setup.department.view_department', 'uses' => 'SetupController@view_department']);
//-------- 2.13.2 -> LOCATIONS --------//
Route::get('/location/locations', ['as' => 'setup.location.locations', 'uses' => 'SetupController@locations']);
Route::get('/location/edit_location/{id}', ['as' => 'setup.location.edit_location', 'uses' => 'SetupController@edit_location']);
Route::get('/location/new_location', ['as' => 'setup.location.new_location', 'uses' => 'SetupController@new_location']);
Route::post('/location/store_location', ['as' => 'setup.location.store_location', 'uses' => 'SetupController@store_location']);
Route::put('/location/update_location/{id}', ['as' => 'setup.location.update_location', 'uses' => 'SetupController@update_location']);
Route::get('/location/view_location/{id}', ['as' => 'setup.location.view_location', 'uses' => 'SetupController@view_location']);
//-------- 2.13.2 -> PRODUCTION TEAM --------//
Route::get('/production_team/index', ['as' => 'setup.production_team.index', 'uses' => 'SetupController@production_team']);
Route::get('/production_team/edit/{id}', ['as' => 'setup.production_team.edit', 'uses' => 'SetupController@edit_productionTeam']);
Route::get('/production_team/new', ['as' => 'setup.production_team.new', 'uses' => 'SetupController@new_productionTeam']);
Route::post('/production_team/store_productionTeam', ['as' => 'setup.production_team.store_productionTeam', 'uses' => 'SetupController@store_productionTeam']);
Route::put('/production_team/update_productionTeam/{id}', ['as' => 'setup.production_team.update_productionTeam', 'uses' => 'SetupController@update_productionTeam']);
Route::get('/production_team/view/{id}', ['as' => 'setup.production_team.view', 'uses' => 'SetupController@view_productionTeam']);


//-------- 2.13.3 -> PRODUCT CATEGORIES --------//
Route::get('/product_categories/index', ['as' => 'setup.product_categories.index', 'uses' => 'SetupController@product_categories']);
Route::get('/product_categories/edit/{id}', ['as' => 'setup.product_categories.edit', 'uses' => 'SetupController@edit_productCategories']);
Route::get('/product_categories/new', ['as' => 'setup.product_categories.new', 'uses' => 'SetupController@new_productCategory']);
Route::post('/product_categories/store_productCategory', ['as' => 'setup.product_categories.store_productCategory', 'uses' => 'SetupController@store_productCategory']);
Route::put('/product_categories/update_prouductCategory/{id}', ['as' => 'setup.product_categories.update_prouductCategory', 'uses' => 'SetupController@update_prouductCategory']);
Route::get('/product_categories/view/{id}', ['as' => 'setup.product_categories.view', 'uses' => 'SetupController@view_productCategory']);
//-------- 2.13.3 -> ITEM CATEGORIES --------//
Route::get('/item_categories/index', ['as' => 'setup.item_categories.index', 'uses' => 'SetupController@item_categories']);
Route::get('/item_categories/edit/{id}', ['as' => 'setup.item_categories.edit', 'uses' => 'SetupController@edit_itemCategory']);
Route::get('/item_categories/new', ['as' => 'setup.item_categories.new', 'uses' => 'SetupController@new_itemCategory']);
Route::post('/item_categories/store_itemCategory', ['as' => 'setup.item_categories.store_itemCategory', 'uses' => 'SetupController@store_itemCategory']);
Route::put('/item_categories/update_itemCategory/{id}', ['as' => 'setup.item_categories.update_itemCategory', 'uses' => 'SetupController@update_itemCategory']);
Route::get('/item_categories/view/{id}', ['as' => 'setup.item_categories.view', 'uses' => 'SetupController@view_itemCategory']);
//-------- 2.13.3 -> ITEM TYPE --------//
Route::get('/item_types/index', ['as' => 'setup.item_types.index', 'uses' => 'SetupController@item_types']);
Route::get('/item_types/edit/{id}', ['as' => 'setup.item_types.edit', 'uses' => 'SetupController@edit_itemType']);
Route::get('/item_types/new', ['as' => 'setup.item_types.new', 'uses' => 'SetupController@new_itemType']);
Route::post('/item_types/store_itemType', ['as' => 'setup.item_types.store_itemType', 'uses' => 'SetupController@store_itemType']);
Route::put('/item_types/update_itemType/{id}', ['as' => 'setup.item_types.update_itemType', 'uses' => 'SetupController@update_itemType']);
Route::get('/item_types/view/{id}', ['as' => 'setup.item_types.view', 'uses' => 'SetupController@view_itemType']);


//-------- 2.13.4 -> STYLES --------//
Route::get('/styles/index', ['as' => 'setup.styles.index', 'uses' => 'SetupController@styles']);
Route::get('/styles/edit/{id}', ['as' => 'setup.styles.edit', 'uses' => 'SetupController@edit_style']);
Route::get('/styles/new', ['as' => 'setup.styles.new', 'uses' => 'SetupController@new_style']);
Route::post('/styles/store_style', ['as' => 'setup.styles.store_style', 'uses' => 'SetupController@store_style']);
Route::put('/styles/update_style/{id}', ['as' => 'setup.styles.update_style', 'uses' => 'SetupController@update_style']);
Route::get('/styles/view/{id}', ['as' => 'setup.styles.view', 'uses' => 'SetupController@view_style']);
//-------- 2.13.4 -> FABRIC --------//
Route::get('/fabric/index', ['as' => 'setup.fabric.index', 'uses' => 'SetupController@fabric']);
Route::get('/fabric/edit/{id}', ['as' => 'setup.fabric.edit', 'uses' => 'SetupController@edit_fabric']);
Route::get('/fabric/new', ['as' => 'setup.fabric.new', 'uses' => 'SetupController@new_fabric']);
Route::post('/fabric/store_fabric', ['as' => 'setup.fabric.store_fabric', 'uses' => 'SetupController@store_fabric']);
Route::put('/fabric/update_fabric/{id}', ['as' => 'setup.fabric.update_fabric', 'uses' => 'SetupController@update_fabric']);
Route::get('/fabric/view/{id}', ['as' => 'setup.fabric.view', 'uses' => 'SetupController@view_fabric']);
//-------- 2.13.4 -> COLOUR --------//
Route::get('/colour/index', ['as' => 'setup.colour.index', 'uses' => 'SetupController@colour']);
Route::get('/colour/edit/{id}', ['as' => 'setup.colour.edit', 'uses' => 'SetupController@edit_colour']);
Route::get('/colour/new', ['as' => 'setup.colour.new', 'uses' => 'SetupController@new_colour']);
Route::post('/colour/store_colour', ['as' => 'setup.colour.store_colour', 'uses' => 'SetupController@store_colour']);
Route::put('/colour/update_colour/{id}', ['as' => 'setup.colour.update_colour', 'uses' => 'SetupController@update_colour']);
Route::get('/colour/view/{id}', ['as' => 'setup.colour.view', 'uses' => 'SetupController@view_colour']);
//-------- 2.13.4 -> TOP SIZES --------//
Route::get('/top_sizes/index', ['as' => 'setup.top_sizes.index', 'uses' => 'SetupController@top_sizes']);
Route::get('/top_sizes/edit/{id}', ['as' => 'setup.top_sizes.edit', 'uses' => 'SetupController@edit_topSize']);
Route::get('/top_sizes/new', ['as' => 'setup.top_sizes.new', 'uses' => 'SetupController@new_topSize']);
Route::post('/top_sizes/store_topSize', ['as' => 'setup.top_sizes.store_topSize', 'uses' => 'SetupController@store_topSize']);
Route::put('/top_sizes/update_topSize/{id}', ['as' => 'setup.top_sizes.update_topSize', 'uses' => 'SetupController@update_topSize']);
Route::get('/top_sizes/view/{id}', ['as' => 'setup.top_sizes.view', 'uses' => 'SetupController@view_topSize']);
//-------- 2.13.4 -> SIZES --------//
Route::get('/sizes/index', ['as' => 'setup.sizes.index', 'uses' => 'SetupController@sizes']);
Route::get('/sizes/edit/{id}', ['as' => 'setup.sizes.edit', 'uses' => 'SetupController@edit_size']);
Route::get('/sizes/new', ['as' => 'setup.sizes.new', 'uses' => 'SetupController@new_size']);
Route::post('/sizes/store_size', ['as' => 'setup.sizes.store_size', 'uses' => 'SetupController@store_size']);
Route::put('/sizes/update_size/{id}', ['as' => 'setup.sizes.update_size', 'uses' => 'SetupController@update_size']);
Route::get('/sizes/view/{id}', ['as' => 'setup.sizes.view', 'uses' => 'SetupController@view_size']);
//-------- 2.13.4 -> BACK VARIATIONS --------//
Route::get('/back_variations/index', ['as' => 'setup.back_variations.index', 'uses' => 'SetupController@back_variations']);
Route::get('/back_variations/edit/{id}', ['as' => 'setup.back_variations.edit', 'uses' => 'SetupController@edit_backVariation']);
Route::get('/back_variations/new', ['as' => 'setup.back_variations.new', 'uses' => 'SetupController@new_backVariation']);
Route::post('/back_variations/store_backVariation', ['as' => 'setup.back_variations.store_backVariation', 'uses' => 'SetupController@store_backVariation']);
Route::put('/back_variations/update_backVariation/{id}', ['as' => 'setup.back_variations.update_backVariation', 'uses' => 'SetupController@update_backVariation']);
Route::get('/back_variations/view/{id}', ['as' => 'setup.back_variations.view', 'uses' => 'SetupController@view_backVariation']);
//-------- 2.13.4 -> STYLE VARIATIONS --------//
Route::get('/style_variations/index', ['as' => 'setup.style_variations.index', 'uses' => 'SetupController@style_variations']);
Route::get('/style_variations/edit/{id}', ['as' => 'setup.style_variations.edit', 'uses' => 'SetupController@edit_styleVariation']);
Route::get('/style_variations/new', ['as' => 'setup.style_variations.new', 'uses' => 'SetupController@new_styleVariation']);
Route::post('/style_variations/store_styleVariation', ['as' => 'setup.style_variations.store_styleVariation', 'uses' => 'SetupController@store_styleVariation']);
Route::put('/style_variations/update_styleVariation/{id}', ['as' => 'setup.style_variations.update_styleVariation', 'uses' => 'SetupController@update_styleVariation']);
Route::get('/style_variations/view/{id}', ['as' => 'setup.style_variations.view', 'uses' => 'SetupController@view_styleVariation']);
//-------- 2.13.4 -> PRINTS --------//
Route::get('/prints/index', ['as' => 'setup.prints.index', 'uses' => 'SetupController@prints']);
Route::get('/prints/edit/{id}', ['as' => 'setup.prints.edit', 'uses' => 'SetupController@edit_print']);
Route::get('/prints/new', ['as' => 'setup.prints.new', 'uses' => 'SetupController@new_print']);
Route::post('/prints/store_print', ['as' => 'setup.prints.store_print', 'uses' => 'SetupController@store_print']);
Route::put('/prints/update_print/{id}', ['as' => 'setup.prints.update_print', 'uses' => 'SetupController@update_print']);
Route::get('/prints/view/{id}', ['as' => 'setup.prints.view', 'uses' => 'SetupController@view_print']);
//-------- 2.13.4 -> TROUSER LENGTH --------//
Route::get('/trouser_length/index', ['as' => 'setup.trouser_length.index', 'uses' => 'SetupController@trouser_length']);
Route::get('/trouser_length/edit/{id}', ['as' => 'setup.trouser_length.edit', 'uses' => 'SetupController@edit_trouserLength']);
Route::get('/trouser_length/new', ['as' => 'setup.trouser_length.new', 'uses' => 'SetupController@new_trouserLength']);
Route::post('/trouser_length/store_trouserLength', ['as' => 'setup.trouser_length.store_trouserLength', 'uses' => 'SetupController@store_trouserLength']);
Route::put('/trouser_length/update_trouserLength/{id}', ['as' => 'setup.trouser_length.update_trouserLength', 'uses' => 'SetupController@update_trouserLength']);
Route::get('/trouser_length/view/{id}', ['as' => 'setup.trouser_length.view', 'uses' => 'SetupController@view_trouserLength']);
//-------- 2.13.4 -> ITEM OPTIONS --------//
Route::get('/item_options/index', ['as' => 'setup.item_options.index', 'uses' => 'SetupController@item_options']);
Route::get('/item_options/edit/{id}', ['as' => 'setup.item_options.edit', 'uses' => 'SetupController@edit_itemOption']);
Route::get('/item_options/new', ['as' => 'setup.item_options.new', 'uses' => 'SetupController@new_itemOption']);
Route::post('/item_options/store_itemOption', ['as' => 'setup.item_options.store_itemOption', 'uses' => 'SetupController@store_itemOption']);
Route::put('/item_options/update_itemOption/{id}', ['as' => 'setup.item_options.update_itemOption', 'uses' => 'SetupController@update_itemOption']);
Route::get('/item_options/view/{id}', ['as' => 'setup.item_options.view', 'uses' => 'SetupController@view_itemOption']);
//-------- 2.13.4 -> WICKED-O-METER --------//
Route::get('/wicked_o_meter/index', ['as' => 'setup.wicked_o_meter.index', 'uses' => 'SetupController@wicked_o_meter']);
Route::get('/wicked_o_meter/edit/{id}', ['as' => 'setup.wicked_o_meter.edit', 'uses' => 'SetupController@edit_wickedoMeter']);
Route::get('/wicked_o_meter/new', ['as' => 'setup.wicked_o_meter.new', 'uses' => 'SetupController@new_wickedoMeter']);
Route::post('/wicked_o_meter/store_wickedoMeter', ['as' => 'setup.wicked_o_meter.store_wickedoMeter', 'uses' => 'SetupController@store_wickedoMeter']);
Route::put('/wicked_o_meter/update_wickedoMeter/{id}', ['as' => 'setup.wicked_o_meter.update_wickedoMeter', 'uses' => 'SetupController@update_wickedoMeter']);
Route::get('/wicked_o_meter/view/{id}', ['as' => 'setup.wicked_o_meter.view', 'uses' => 'SetupController@view_wickedoMeter']);


//-------- 2.13.5 -> UNIT OF MEASURES --------//
Route::get('/unit_of_measures/index', ['as' => 'setup.unit_of_measures.index', 'uses' => 'SetupController@unit_of_measures']);
Route::get('/unit_of_measures/edit/{id}', ['as' => 'setup.unit_of_measures.edit', 'uses' => 'SetupController@edit_unitOfMeasure']);
Route::get('/unit_of_measures/new', ['as' => 'setup.unit_of_measures.new', 'uses' => 'SetupController@new_unitOfMeasure']);
Route::post('/unit_of_measures/store_unitOfMeasure', ['as' => 'setup.unit_of_measures.store_unitOfMeasure', 'uses' => 'SetupController@store_unitOfMeasure']);
Route::put('/unit_of_measures/update_unitOfMeasure/{id}', ['as' => 'setup.unit_of_measures.update_unitOfMeasure', 'uses' => 'SetupController@update_unitOfMeasure']);
Route::get('/unit_of_measures/view/{id}', ['as' => 'setup.unit_of_measures.view', 'uses' => 'SetupController@view_unitOfMeasure']);
//-------- 2.13.5 -> WEIGHT UNITS --------//
Route::get('/weight_units/index', ['as' => 'setup.weight_units.index', 'uses' => 'SetupController@weight_units']);
Route::get('/weight_units/edit/{id}', ['as' => 'setup.weight_units.edit', 'uses' => 'SetupController@edit_weightUnit']);
Route::get('/weight_units/new', ['as' => 'setup.weight_units.new', 'uses' => 'SetupController@new_weightUnit']);
Route::post('/weight_units/store_weightUnit', ['as' => 'setup.weight_units.store_weightUnit', 'uses' => 'SetupController@store_weightUnit']);
Route::put('/weight_units/update_weightUnit/{id}', ['as' => 'setup.weight_units.update_weightUnit', 'uses' => 'SetupController@update_weightUnit']);
Route::get('/weight_units/view/{id}', ['as' => 'setup.weight_units.view', 'uses' => 'SetupController@view_weightUnit']);


//-------- 2.13.6 -> BINS --------//
Route::get('/bins/index', ['as' => 'setup.bins.index', 'uses' => 'SetupController@bins']);
Route::get('/bins/edit/{id}', ['as' => 'setup.bins.edit', 'uses' => 'SetupController@edit_bin']);
Route::get('/bins/new', ['as' => 'setup.bins.new', 'uses' => 'SetupController@new_bin']);
Route::post('/bins/store_bin', ['as' => 'setup.bins.store_bin', 'uses' => 'SetupController@store_bin']);
Route::put('/bins/update_bin/{id}', ['as' => 'setup.bins.update_bin', 'uses' => 'SetupController@update_bin']);
Route::get('/bins/view/{id}', ['as' => 'setup.bins.view', 'uses' => 'SetupController@view_bin']);


//-------- 2.13.7 -> CURRENCIES --------//
Route::get('/currencies/index', ['as' => 'setup.currencies.index', 'uses' => 'SetupController@currencies']);
Route::get('/currencies/edit/{id}', ['as' => 'setup.currencies.edit', 'uses' => 'SetupController@edit_currency']);
Route::get('/currencies/new', ['as' => 'setup.currencies.new', 'uses' => 'SetupController@new_currency']);
Route::post('/currencies/store_currency', ['as' => 'setup.currencies.store_currency', 'uses' => 'SetupController@store_currency']);
Route::put('/currencies/update_currency/{id}', ['as' => 'setup.currencies.update_currency', 'uses' => 'SetupController@update_currency']);
Route::get('/currencies/view/{id}', ['as' => 'setup.currencies.view', 'uses' => 'SetupController@view_currency']);
//-------- 2.13.7 -> EXCHANGE RATES --------//
Route::get('/exchange_rates/index', ['as' => 'setup.exchange_rates.index', 'uses' => 'SetupController@exchange_rates']);
Route::get('/exchange_rates/edit/{id}', ['as' => 'setup.exchange_rates.edit', 'uses' => 'SetupController@edit_exchangeRate']);
Route::get('/exchange_rates/new', ['as' => 'setup.exchange_rates.new', 'uses' => 'SetupController@new_exchangeRate']);
Route::post('/exchange_rates/store_exchangeRate', ['as' => 'setup.exchange_rates.store_exchangeRate', 'uses' => 'SetupController@store_exchangeRate']);
Route::put('/exchange_rates/update_exchangeRate/{id}', ['as' => 'setup.exchange_rates.update_exchangeRate', 'uses' => 'SetupController@update_exchangeRate']);
Route::get('/exchange_rates/view/{id}', ['as' => 'setup.exchange_rates.view', 'uses' => 'SetupController@view_exchangeRate']);


//-------- 2.13.8 -> SHIPPING CARRIER --------//
Route::get('/shipping_carrier/index', ['as' => 'setup.shipping_carrier.index', 'uses' => 'SetupController@shipping_carrier']);
Route::get('/shipping_carrier/edit/{id}', ['as' => 'setup.shipping_carrier.edit', 'uses' => 'SetupController@edit_shippingCarrier']);
Route::get('/shipping_carrier/new', ['as' => 'setup.shipping_carrier.new', 'uses' => 'SetupController@new_shippingCarrier']);
Route::post('/shipping_carrier/store_shippingCarrier', ['as' => 'setup.shipping_carrier.store_shippingCarrier', 'uses' => 'SetupController@store_shippingCarrier']);
Route::put('/shipping_carrier/update_shippingCarrier/{id}', ['as' => 'setup.shipping_carrier.update_shippingCarrier', 'uses' => 'SetupController@update_shippingCarrier']);
Route::get('/shipping_carrier/view/{id}', ['as' => 'setup.shipping_carrier.view', 'uses' => 'SetupController@view_shippingCarrier']);


//-------- 2.13.9 -> COUNTRIES --------//
Route::get('/countries/index', ['as' => 'setup.countries.index', 'uses' => 'SetupController@countries']);
Route::get('/countries/edit/{id}', ['as' => 'setup.countries.edit', 'uses' => 'SetupController@edit_country']);
Route::get('/countries/new', ['as' => 'setup.countries.new', 'uses' => 'SetupController@new_country']);
Route::post('/countries/store_country', ['as' => 'setup.countries.store_country', 'uses' => 'SetupController@store_country']);
Route::put('/countries/update_country/{id}', ['as' => 'setup.countries.update_country', 'uses' => 'SetupController@update_country']);
Route::get('/countries/view/{id}', ['as' => 'setup.countries.view', 'uses' => 'SetupController@view_country']);


//-------- 2.13.10 -> TAX CODES --------//
Route::get('/tax_codes/index', ['as' => 'setup.tax_codes.index', 'uses' => 'SetupController@tax_codes']);
Route::get('/tax_codes/edit/{id}', ['as' => 'setup.tax_codes.edit', 'uses' => 'SetupController@edit_taxCode']);
Route::get('/tax_codes/new', ['as' => 'setup.tax_codes.new', 'uses' => 'SetupController@new_taxCode']);
Route::post('/tax_codes/store_taxCode', ['as' => 'setup.tax_codes.store_taxCode', 'uses' => 'SetupController@store_taxCode']);
Route::put('/tax_codes/update_taxCode/{id}', ['as' => 'setup.tax_codes.update_taxCode', 'uses' => 'SetupController@update_taxCode']);
Route::get('/tax_codes/view/{id}', ['as' => 'setup.tax_codes.view', 'uses' => 'SetupController@view_taxCode']);

//-------- 2.13.10 -> TAX TYPES --------//
Route::get('/tax_types/index', ['as' => 'setup.tax_types.index', 'uses' => 'SetupController@tax_types']);
Route::get('/tax_types/edit/{id}', ['as' => 'setup.tax_types.edit', 'uses' => 'SetupController@edit_taxType']);
Route::get('/tax_types/new', ['as' => 'setup.tax_types.new', 'uses' => 'SetupController@new_taxType']);
Route::post('/tax_types/store_taxType', ['as' => 'setup.tax_types.store_taxType', 'uses' => 'SetupController@store_taxType']);
Route::put('/tax_types/update_taxType/{id}', ['as' => 'setup.tax_types.update_taxType', 'uses' => 'SetupController@update_taxType']);
Route::get('/tax_types/view/{id}', ['as' => 'setup.tax_types.view', 'uses' => 'SetupController@view_taxType']);
