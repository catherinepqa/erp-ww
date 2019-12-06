<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CashSales;
use App\Locations;
use App\Departments;
use App\Customers;
use App\Items;
use App\CashSalesItems;
use DB;

class CashSalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations      = Locations::all();
        $departments    = Departments::all();
        $customers      = Customers::all();

        return view('cash_sales.create_cash_sales', compact('locations', 'departments', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $store  = CashSales::storeCashSale($request);

        if ($store !== false) {
                return redirect('/cashsales')->with('success', 'Successfully created new bin transfer!');
        } else {
            return Redirect::back()->withErrors('Failed to transfer bin. Please try again.')->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        $cashSale = CashSales::select([
                                'cash_sales.*',
                                'customers.fname',
                                'customers.lname',
                                'locations.name as loc_name',
                                'departments.name as dept_name'
                            ])
                            ->leftjoin('customers', 'cash_sales.customer_id', '=', 'customers.customer_id')
                            ->leftjoin('locations', 'cash_sales.location_id', '=', 'locations.location_id')
                            ->leftjoin('departments', 'cash_sales.department_id', '=', 'departments.department_id')
                            ->where('cash_sales.cash_sales_id', $id)->first();

        $items = CashSalesItems::with('Items')
                        ->where('cash_sales_id', $id)
                        // ->select('Items.item_name')
                        ->get();

        return view ('cash_sales.view_cash_sales', compact('cashSale', 'items'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cashSale = CashSales::select([
                                'cash_sales.*',
                                'customers.fname',
                                'customers.lname',
                                'locations.name as loc_name',
                                'departments.name as dept_name'
                            ])
                            ->leftjoin('customers', 'cash_sales.customer_id', '=', 'customers.customer_id')
                            ->leftjoin('locations', 'cash_sales.location_id', '=', 'locations.location_id')
                            ->leftjoin('departments', 'cash_sales.department_id', '=', 'departments.department_id')
                            ->where('cash_sales.cash_sales_id', $id)->first();

        $customers      = Customers::where('customer_id', '!=', $cashSale->customer_id)->get();
        $locations      = Locations::where('location_id', '!=', $cashSale->location_id)->get();
        $departments      = Departments::where('department_id', '!=', $cashSale->department_id)->get();

        return view ('cash_sales.edit_cash_sales', compact('cashSale', 'customers', 'locations', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $update = CashSales::updateData($request, $id);

        if ($update !== false) {
                return redirect('/cashsales')->with('success', 'Successfully updated this Cash Sale!');
        } else {
            return Redirect::back()->withErrors('Failed to update cash sale. Please try again.')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Get all items from specific location
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function checkItems (Request $request)
    {
        $items = Items::where(['location_id' => $request->get('location_id')])->get();

        if ($request->get('cash_sales_id')) {

            $cash_sale_id = $request->get('cash_sales_id');
            $saleItems = DB::table('cash_sales_items')->select('cash_sales_items.item_id')
                                    ->where('cash_sales_id', $cash_sale_id)
                                    ->get();

            $ids = [];
            foreach ($saleItems as $item) {
                $ids[] = $item->item_id;
            }

            $items = $items->whereNotIn('item_id', $ids);
        }

        if (!empty($items)) {
            $notEmpty = true;
        } else {
            $notEmpty = false;
        }

        return json_encode([
            'success' => $notEmpty,
            'data' => $items
        ]);
    }

    /**
     * Get descriptions of an item
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function itemDesc (Request $request)
    {
        $item = Items::select([
                    'items.item_description',
                    'inventory_items.qty_on_hand',
                    'unit_of_measures.abbreviation',
                    'tax_codes.code',
                    'tax_codes.rate',
                    'cost_estimate_type.name',
                    'items.item_weight',
                    'items.manufacturer_country'
                ])
                ->leftjoin('unit_of_measures', 'items.stock_unit', '=', 'unit_of_measures.unit_type_id')
                ->leftjoin('tax_codes', 'items.tax_code', '=', 'tax_codes.tax_code_id')
                ->leftjoin('inventory_items', 'items.item_id', '=', 'inventory_items.item_id')
                ->leftjoin('cost_estimate_type', 'items.cost_estimate_type_id', '=', 'cost_estimate_type.cost_estimate_type_id')
                ->where('items.item_id', $request->get('item_id'))
                ->first();

        if (!empty($item)) {
            $notEmpty = true;
        } else {
            $notEmpty = false;
        }

        return json_encode([
            'success' => $notEmpty,
            'item' => $item
        ]);
    }

    /**
     * Get cash_sales_items of cash sales
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cashSaleItems (Request $request)
    {
        $saleItems = CashSalesItems::select([
                                    'cash_sales_items.*',
                                    'items.item_name',
                                ])
                                ->leftjoin('items', 'cash_sales_items.item_id', '=', 'items.item_id')
                                ->where('cash_sales_id', $request->get('cash_sales_id'))
                                ->get();

        if (!empty($saleItems)) {
            $notEmpty = true;
        } else {
            $notEmpty = false;
        }

        return json_encode([
            'success' => $notEmpty,
            'saleItems' => $saleItems
        ]);
    }
}
