<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Locations;
use App\Items;
use App\SalesOrder;
use App\SalesOrderItems;
use DB;

class ReallocateItemsController extends Controller
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
        $locations = Locations::all();
        $items = Items::all();

        return view ('reallocate_items.create_reallocate_items', compact(['locations', 'items']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
     * Ajax request for getting item info in inventory_items table
     * Get sales order items using item_id and location_id
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getSalesOrderItems(Request $request)
    {
        // $sales_order = SalesOrder::where(['location_id' => $request->get('location_id')])
        $item = Items::find($request->get('item_id'))->with('InventoryItems')->first();

        $sales_order = DB::table('sales_order')
            ->join('sales_order_items', 'sales_order.sales_order_id', '=', 'sales_order_items.system_id')
            ->where(['sales_order.location_id' => $request->get('location_id')])
            ->where(['sales_order_items.item_id'  => $request->get('item_id')])
            ->select(
                'sales_order.dt_created',
                'sales_order.sales_order_id',
                'sales_order.customer_id',
                'sales_order_items.qty_ordered',
                'sales_order_items.qty_received',
                'sales_order_items.system_id'
            )
            ->get();

        return json_encode([
            'success' => 'true',
            'sales' => $sales_order,
            'item' => $item
        ]);
    }

    /**
     * Update sales order items of item's qty_committed
     * Update inventory items of item's qty_committed
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function qtyCommitted(Request $request)
    {
        $update  = SalesOrderItems::updatedata($request);

        if ($update !== false) {
                return redirect('/reallocate_item')->with('success', 'Successfully reallocated item!');
        } else {
            return Redirect::back()->withErrors('Failed to reallocate items. Please try again.')->withInput();
        }
    }
}
