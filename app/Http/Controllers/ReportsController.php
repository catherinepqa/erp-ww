<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Locations;
use App\ItemTypes;
use App\Items;
use App\InventoryItems;
use App\Countries;
use App\SalesOrder;
use App\Exports\InventoryStatusCommittedExport;
use App\Exports\InventoryStatusExport;
use App\Exports\StockAvailableExport;
use App\Exports\SalesNewCustomerExport;
use App\Exports\SalesRepeatCustomerExport;
use App\Exports\SalesCustomerExport;
use App\Exports\DailySalesExport;
use App\Exports\TotalSalesExport;
use Illuminate\Database\Eloquent\Builder;
use Excel;
use PDF;

class ReportsController extends Controller
{
    /**
     * Display data for current inventory status.
     *
     * @return \Illuminate\Http\Response
     */
    public function currentInventoryStatus()
    {
        $locations = Locations::all();
        $item_types = ItemTypes::all();
        return view ('reports.currentInventoryStatus', compact('locations', 'item_types'));
    }

    /**
     * Export function for current inventory report
     * Return data for partials to print
     *
     * @return \Illuminate\Http\Response
     */
    public function exportInventoryStatus (Request $request)
    {
        $location_id    = request('location_id');
        $print          = request('type');
        $data           = ItemTypes::select([
                            'item_types.item_type_id',
                            'item_types.name',
                            'items.item_id',
                            'items.item_name',
                            'items.item_description',
                            'inventory_items.preferred_stock_level',
                            'inventory_items.qty_on_order',
                            'inventory_items.qty_on_hand',
                            'inventory_items.qty_committed',
                            'inventory_items.qty_in_transit',
                            'inventory_items.qty_back_ordered',
                            'locations.name as loc_name',
                        ])
                        ->leftjoin('items', 'item_types.item_type_id', '=', 'items.item_type_id')
                        ->leftjoin('inventory_items', 'items.item_id', '=', 'inventory_items.item_id')
                        ->leftjoin('locations', 'items.location_id', '=', 'locations.location_id')
                        ->where('items.location_id', '=' , $location_id)
                        // ->groupBy('item_types.item_type_id')
                        ->get();

        switch ($print) {
            case 'xlsx':
                return Excel::download(new InventoryStatusExport ($data), 'inventoryStatus.xlsx');
                break;
            case 'pdf':
                $item_types = $data;
                $pdf = PDF::loadView('report_partials._pdfInventoryStatus', compact('item_types'))->setPaper('a4', 'landscape');
                return $pdf->download('inventoryStatus.pdf');
                break;
            case 'csv':
                return Excel::download(new InventoryStatusExport ($data), 'inventoryStatus.csv');
                break;
            default:
                // code...
                break;
        }

        return json_encode([
            'success' => true,
        ]);
    }

    /**
     * Return data for based on filter passed
     *
     * @return \Illuminate\Http\Response
     */
    public function filterInventoryStatus (Request $request)
    {
        $item_id      = request('item_id');
        $location_id  = request('location_id');
        $data         = ItemTypes::select([
                            'item_types.item_type_id',
                            'item_types.name',
                            'items.item_id',
                            'items.item_name',
                            'items.item_description',
                            'inventory_items.preferred_stock_level',
                            'inventory_items.qty_on_order',
                            'inventory_items.qty_on_hand',
                            'inventory_items.qty_committed',
                            'inventory_items.qty_in_transit',
                            'inventory_items.qty_back_ordered',
                            'locations.name as loc_name',
                        ])
                        ->leftjoin('items', 'item_types.item_type_id', '=', 'items.item_type_id')
                        ->leftjoin('inventory_items', 'items.item_id', '=', 'inventory_items.item_id')
                        ->leftjoin('locations', 'items.location_id', '=', 'locations.location_id')
                        ->where('items.location_id', '=' , $location_id)
                        // ->groupBy('item_types.item_type_id')
                        ->get();

        return json_encode(['int' => $data]);
    }

    /**
     * Display data for current inventory status committed.
     *
     * @return \Illuminate\Http\Response
     */
    public function inventoryStatusCommitted()
    {
        $locations = Locations::all();
        $item_types = ItemTypes::all();

        return view ('reports.inventoryStatusCommitted', compact('locations', 'item_types'));
    }

    /**
     * Export function for  inventory status committed report
     * Return data for partials to print
     *
     * @return \Illuminate\Http\Response
     */
    public function exportInventoryStatusCommitted (Request $request)
    {
        $itemTypeId     = request('item_type_id');
        $location_id    = request('location_id');
        $print          = request('type');
        $data           = ItemTypes::select([
                            'item_types.item_type_id',
                            'item_types.name',
                            'items.item_id',
                            'items.item_name',
                            'items.item_description',
                            'inventory_items.preferred_stock_level',
                            'inventory_items.qty_on_order',
                            'inventory_items.qty_on_hand',
                            'inventory_items.qty_committed',
                            'inventory_items.qty_in_transit',
                            'inventory_items.qty_back_ordered',
                            'locations.name as loc_name',
                        ])
                        ->leftjoin('items', 'item_types.item_type_id', '=', 'items.item_type_id')
                        ->leftjoin('inventory_items', 'items.item_id', '=', 'inventory_items.item_id')
                        ->leftjoin('locations', 'items.location_id', '=', 'locations.location_id')
                        ->where('items.location_id', '=' , $location_id)
                        // ->groupBy('item_types.item_type_id')
                        ->get();

        switch ($print) {
            case 'xlsx':
                return Excel::download(new InventoryStatusCommittedExport ($data), 'inventoryStatusCommitted.xlsx');
                break;
            case 'pdf':
                $item_types = $data;
                $pdf = PDF::loadView('report_partials._pdfInventoryStatusCommitted', compact('item_types'))->setPaper('a4', 'landscape');
                return $pdf->download('inventoryStatusCommitted.pdf');
                break;
            case 'csv':
                return Excel::download(new InventoryStatusCommittedExport ($data), 'inventoryStatusCommitted.csv');
                break;
            default:
                // code...
                break;
        }

        return json_encode([
            'success' => true,
        ]);
    }

    /**
     * Return data for based on filter passed
     *
     * @return \Illuminate\Http\Response
     */
    public function filterInventoryStatusCommitted (Request $request)
    {
        $itemTypeId      = request('item_type_id');
        $location_id  = request('location_id');
        $data         = ItemTypes::select([
                            'item_types.item_type_id',
                            'item_types.name',
                            'items.item_id',
                            'items.item_name',
                            'items.item_description',
                            'inventory_items.preferred_stock_level',
                            'inventory_items.qty_on_order',
                            'inventory_items.qty_on_hand',
                            'inventory_items.qty_committed',
                            'inventory_items.qty_in_transit',
                            'inventory_items.qty_back_ordered',
                            'locations.name as loc_name',
                        ])
                        ->leftjoin('items', 'item_types.item_type_id', '=', 'items.item_type_id')
                        ->leftjoin('inventory_items', 'items.item_id', '=', 'inventory_items.item_id')
                        ->leftjoin('locations', 'items.location_id', '=', 'locations.location_id')
                        ->where('items.location_id', '=' , $location_id)
                        // ->groupBy('item_types.item_type_id')
                        ->get();

        return json_encode(['int' => $data]);
    }

    /**
     * Display data for stock available by location report.
     *
     * @return \Illuminate\Http\Response
     */
    public function stockAvailable()
    {
        $locations = Locations::all();
        $stocks = InventoryItems::all();
        return view ('reports.stockAvailable', compact('locations', 'stocks'));
    }

    /**
     * Export function for stock available by location report.
     * Return data for partials to print
     *
     * @return \Illuminate\Http\Response
     */
    public function exportStockAvailable (Request $request)
    {
        $location_id    = request('location_id');
        $print          = request('type');
        $data           = InventoryItems::with('Items')->where('location_id', $location_id)->get();

        switch ($print) {
            case 'xlsx':
                return Excel::download(new StockAvailableExport ($data), 'stockAvailable.xlsx');
                break;
            case 'pdf':
                $stocks = $data;
                $pdf = PDF::loadView('report_partials._pdfStockAvailable', compact('stocks'))->setPaper('a4', 'landscape');
                return $pdf->download('stockAvailable.pdf');
                break;
            case 'csv':
                return Excel::download(new StockAvailableExport ($data), 'stockAvailable.csv');
                break;
            default:
                // code...
                break;
        }

        return json_encode([
            'success' => true,
        ]);
    }

    /**
     * Return data for based on filter passed
     *
     * @return \Illuminate\Http\Response
     */
    public function filterStockAvailable (Request $request)
    {
        $location_id    = request('location_id');
        $data           = InventoryItems::with('Items')->where('location_id', $location_id)->get();

        return json_encode($data);
    }

    /**
     * Display data for Sales New Customer Country (Gross Amt) Report.
     *
     * @return \Illuminate\Http\Response
     */
    public function salesNewCustomer()
    {
        $locations = Locations::all();
        $countries = Countries::all();
        $salesNew  = SalesOrder::all();
        return view ('reports.salesNewCustomer', compact('locations', 'salesNew', 'countries'));
    }

    /**
     * Export function for Sales New Customer Country (Gross Amt) Report.
     * Return data for partials to print
     *
     * @return \Illuminate\Http\Response
     */
    public function exportSalesNewCustomer (Request $request)
    {
        $so_date_a   = date('Y-m-d', strtotime($request->get('so_date_a')));
        $so_date_b   = date('Y-m-d', strtotime($request->get('so_date_b')));
        $country     = request('country');
        $print       = request('type');
        $data        = SalesOrder::with('SalesOrderItems')
                            ->where('shipping_address', 'like', '%' . $country . '%')
                            ->whereBetween('so_date', [$so_date_a, $so_date_b])
                            ->get();

        foreach ($data as $salesOrder) {
            foreach ($salesOrder->salesorderitems as $order_item) {
                $salesOrder['gross_amount'] += $order_item->gross_amount;
            }
        }

        switch ($print) {
            case 'xlsx':
                return Excel::download(new SalesNewCustomerExport ($data), 'salesNewCustomer.xlsx');
                break;
            case 'pdf':
                $salesNew = $data;
                $pdf = PDF::loadView('report_partials._pdfSalesNewCustomer', compact('salesNew'))->setPaper('a4', 'landscape');
                return $pdf->download('salesNewCustomer.pdf');
                break;
            case 'csv':
                return Excel::download(new SalesNewCustomerExport ($data), 'salesNewCustomer.csv');
                break;
            default:
                // code...
                break;
        }

        return json_encode([
            'success' => true,
        ]);
    }

    /**
     * Return data for Sales New Customer Country (Gross Amt) Report based on filter passed
     *
     * @return \Illuminate\Http\Response
     */
    public function filterSalesNewCustomer (Request $request)
    {
        $so_date_a      = date('Y-m-d', strtotime($request->get('so_date_a')));
        $so_date_b      = date('Y-m-d', strtotime($request->get('so_date_b')));
        $country        = request('country');
        $data           = SalesOrder::with('SalesOrderItems')
                            ->where('shipping_address', 'like', '%' . $country . '%')
                            ->whereBetween('so_date', [$so_date_a, $so_date_b])
                            ->get();

        foreach ($data as $salesOrder) {
            foreach ($salesOrder->salesorderitems as $order_item) {
                $salesOrder['gross_amount'] += $order_item->gross_amount;
            }
        }

        return json_encode([
            'salesNew' => $data,
            'country' => $country
        ]);
    }

    /**
     * Display data for Sales by Repeat Customer Country (Gross Amt) Report.
     *
     * @return \Illuminate\Http\Response
     */
    public function salesRepeatCustomer()
    {
        $locations = Locations::all();
        $countries = Countries::all();
        $salesRepeat = SalesOrder::all();
        return view ('reports.salesRepeatCustomer', compact('locations', 'salesRepeat', 'countries'));
    }

    /**
     * Export function for Sales by Repeat Customer Country (Gross Amt) Report.
     * Return data for partials to print
     *
     * @return \Illuminate\Http\Response
     */
    public function exportSalesRepeatCustomer (Request $request)
    {
        $so_date_a      = date('Y-m-d', strtotime($request->get('so_date_a')));
        $so_date_b      = date('Y-m-d', strtotime($request->get('so_date_b')));
        $country        = request('country');
        $print          = request('type');
        $data           = SalesOrder::with('SalesOrderItems')
                            ->where('shipping_address', 'like', '%' . $country . '%')
                            ->whereBetween('so_date', [$so_date_a, $so_date_b])
                            ->get();

        foreach ($data as $salesOrder) {
            foreach ($salesOrder->salesorderitems as $order_item) {
                $salesOrder['gross_amount'] += $order_item->gross_amount;
            }
        }

        switch ($print) {
            case 'xlsx':
                return Excel::download(new SalesRepeatCustomerExport ($data), 'salesRepeatCustomer.xlsx');
                break;
            case 'pdf':
                $salesRepeat = $data;
                $pdf = PDF::loadView('report_partials._pdfSalesRepeatCustomer', compact('salesRepeat'))->setPaper('a4', 'landscape');
                return $pdf->download('salesRepeatCustomer.pdf');
                break;
            case 'csv':
                return Excel::download(new SalesRepeatCustomerExport ($data), 'salesRepeatCustomer.csv');
                break;
            default:
                // code...
                break;
        }

        return json_encode([
            'success' => true,
        ]);
    }

    /**
     * Return data for Sales by Repeat Customer Country (Gross Amt) Report based on filter passed
     *
     * @return \Illuminate\Http\Response
     */
    public function filterSalesRepeatCustomer (Request $request)
    {
        $so_date_a      = date('Y-m-d', strtotime($request->get('so_date_a')));
        $so_date_b      = date('Y-m-d', strtotime($request->get('so_date_b')));
        $country        = request('country');
        $data           = SalesOrder::with('SalesOrderItems')
                            ->where('shipping_address', 'like', '%' . $country . '%')
                            ->whereBetween('so_date', [$so_date_a, $so_date_b])
                            ->get();

        foreach ($data as $salesOrder) {
            foreach ($salesOrder->salesorderitems as $order_item) {
                $salesOrder['gross_amount'] += $order_item->gross_amount;
            }
        }

        return json_encode([
            'salesRepeat' => $data,
            'country' => $country
        ]);
    }

    /**
     * Display data for Sales by Customer Country (Net Amt) Report.
     *
     * @return \Illuminate\Http\Response
     */
    public function salesCustomer()
    {
        $locations = Locations::all();
        $salesCustomer  = SalesOrder::all();
        return view ('reports.salesCustomer', compact('locations', 'salesCustomer'));
    }

    /**
     * Export function for Sales by Customer Country (Net Amt) Report.
     * Return data for partials to print
     *
     * @return \Illuminate\Http\Response
     */
    public function exportSalesCustomer (Request $request)
    {
        $so_date_a   = date('Y-m-d', strtotime($request->get('so_date_a')));
        $so_date_b   = date('Y-m-d', strtotime($request->get('so_date_b')));
        $print       = request('type');
        $data        = SalesOrder::with('SalesOrderItems')
                            ->whereBetween('so_date', [$so_date_a, $so_date_b])
                            ->get();

        foreach ($data as $salesOrder) {
            foreach ($salesOrder->salesorderitems as $order_item) {
                $salesOrder['gross_amount'] += $order_item->gross_amount;
            }
        }

        switch ($print) {
            case 'xlsx':
                return Excel::download(new SalesCustomerExport ($data), 'salesCustomer.xlsx');
                break;
            case 'pdf':
                $salesCustomer = $data;
                $pdf = PDF::loadView('report_partials._pdfSalesCustomer', compact('salesCustomer'))->setPaper('a4', 'landscape');
                return $pdf->download('salesCustomer.pdf');
                break;
            case 'csv':
                return Excel::download(new SalesCustomerExport ($data), 'salesCustomer.csv');
                break;
            default:
                // code...
                break;
        }

        return json_encode([
            'success' => true,
        ]);
    }

    /**
     * Return data for Sales by Customer Country (Net Amt) Report based on filter passed
     *
     * @return \Illuminate\Http\Response
     */
    public function filterSalesCustomer (Request $request)
    {
        $so_date_a      = date('Y-m-d', strtotime($request->get('so_date_a')));
        $so_date_b      = date('Y-m-d', strtotime($request->get('so_date_b')));
        $data           = SalesOrder::with('SalesOrderItems')
                            ->whereBetween('so_date', [$so_date_a, $so_date_b])
                            ->get();

        foreach ($data as $salesOrder) {
            foreach ($salesOrder->salesorderitems as $order_item) {
                $salesOrder['gross_amount'] += $order_item->gross_amount;
            }
        }

        return json_encode([
            'salesCustomer' => $data,
        ]);
    }

    /**
     * Display data for Daily Sales Report.
     *
     * @return \Illuminate\Http\Response
     */
    public function dailySales()
    {
        $locations  = Locations::all();
        $dailySales = SalesOrder::all();
        return view ('reports.dailySales', compact('locations', 'dailySales'));
    }

    /**
     * Export function for Daily Sales Report.
     * Return data for partials to print
     *
     * @return \Illuminate\Http\Response
     */
    public function exportDailySales (Request $request)
    {
        $so_date_a      = date('Y-m-d', strtotime($request->get('so_date_a')));
        $so_date_b      = date('Y-m-d', strtotime($request->get('so_date_b')));
        $location_id    = $request->get('location_id');
        $print          = request('type');
        $data           = SalesOrder::with('SalesOrderItems')
                            ->where('location_id', $location_id)
                            ->whereBetween('so_date', [$so_date_a, $so_date_b])
                            ->get();

        // foreach ($data as $salesOrder) {
        //     foreach ($salesOrder->salesorderitems as $order_item) {
        //         $salesOrder['gross_amount'] += $order_item->gross_amount;
        //     }
        // }

        switch ($print) {
            case 'xlsx':
                return Excel::download(new DailySalesExport ($data), 'dailySales.xlsx');
                break;
            case 'pdf':
                $dailySales = $data;
                $pdf = PDF::loadView('report_partials._pdfDailySales', compact('dailySales'))->setPaper('a4', 'landscape');
                return $pdf->download('dailySales.pdf');
                break;
            case 'csv':
                return Excel::download(new DailySalesExport ($data), 'dailySales.csv');
                break;
            default:
                // code...
                break;
        }

        return json_encode([
            'success' => true,
        ]);
    }

    /**
     * Return data for Daily Sales Report based on filter passed
     *
     * @return \Illuminate\Http\Response
     */
    public function filterDailySales (Request $request)
    {
        $so_date_a      = date('Y-m-d', strtotime($request->get('so_date_a')));
        $so_date_b      = date('Y-m-d', strtotime($request->get('so_date_b')));
        $location_id    = $request->get('location_id');
        $data           = SalesOrder::with('SalesOrderItems')
                            ->where('location_id', $location_id)
                            ->whereBetween('so_date', [$so_date_a, $so_date_b])
                            ->get();

        // foreach ($data as $salesOrder) {
        //     foreach ($salesOrder->salesorderitems as $order_item) {
        //         $salesOrder['gross_amount'] += $order_item->gross_amount;
        //     }
        // }

        return json_encode([
            'sales' => $data,
        ]);
    }

    /**
     * Display data for Total Sales Report.
     *
     * @return \Illuminate\Http\Response
     */
    public function totalSales()
    {
        $locations  = Locations::all();
        $totalSales = SalesOrder::all();
        return view ('reports.totalSales', compact('locations', 'totalSales'));
    }

    /**
     * Export function for Total Sales Report.
     * Return data for partials to print
     *
     * @return \Illuminate\Http\Response
     */
    public function exportTotalSales (Request $request)
    {
        $so_date_a      = date('Y-m-d', strtotime($request->get('so_date_a')));
        $so_date_b      = date('Y-m-d', strtotime($request->get('so_date_b')));
        $location_id    = $request->get('location_id');
        $print          = request('type');
        $data           = SalesOrder::with('SalesOrderItems')
                            ->where('location_id', $location_id)
                            ->whereBetween('so_date', [$so_date_a, $so_date_b])
                            ->get();

        // foreach ($data as $salesOrder) {
        //     foreach ($salesOrder->salesorderitems as $order_item) {
        //         $salesOrder['gross_amount'] += $order_item->gross_amount;
        //     }
        // }

        switch ($print) {
            case 'xlsx':
                return Excel::download(new TotalSalesExport ($data), 'totalSales.xlsx');
                break;
            case 'pdf':
                $totalSales = $data;
                $pdf = PDF::loadView('report_partials._pdfTotalSales', compact('totalSales'))->setPaper('a4', 'landscape');
                return $pdf->download('totalSales.pdf');
                break;
            case 'csv':
                return Excel::download(new TotalSalesExport ($data), 'totalSales.csv');
                break;
            default:
                // code...
                break;
        }

        return json_encode([
            'success' => true,
        ]);
    }

    /**
     * Return data for Total Sales Report based on filter passed
     *
     * @return \Illuminate\Http\Response
     */
    public function filterTotalSales (Request $request)
    {
        $so_date_a      = date('Y-m-d', strtotime($request->get('so_date_a')));
        $so_date_b      = date('Y-m-d', strtotime($request->get('so_date_b')));
        $location_id    = $request->get('location_id');
        $data           = SalesOrder::with('SalesOrderItems')
                            ->where('location_id', $location_id)
                            ->whereBetween('so_date', [$so_date_a, $so_date_b])
                            ->get();

        // foreach ($data as $salesOrder) {
        //     foreach ($salesOrder->salesorderitems as $order_item) {
        //         $salesOrder['gross_amount'] += $order_item->gross_amount;
        //     }
        // }

        return json_encode([
            'sales' => $data,
        ]);
    }
}
