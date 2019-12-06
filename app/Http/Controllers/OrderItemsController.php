<?php

namespace App\Http\Controllers;

use App\Models\TransferOrders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderItemsController extends Controller
{
    public function index()
    {
        return view('inventory.order_items.order_items');
    }

    public function dataList()
    {
        $data = DB::table('transfer_orders')
            ->leftjoin('locations', 'locations.location_id', '=', 'transfer_orders.from_location_id')
            ->leftjoin('locations as tl', 'tl.location_id', '=', 'transfer_orders.to_location_id')
            ->select('transfer_orders.transfer_order_id as id', 'transfer_orders.dt_created as date',
                'transfer_orders.reference_no as order_number', 'transfer_orders.created_by as employee',
                'transfer_orders.memo as memo', 'locations.name as from_location', 'tl.name as to_location',
                'transfer_orders.shipping_cost as amount')
            ->where('transfer_orders.status', '=', 'New')
            ->get();

        $array = json_decode( json_encode($data), true);

        return $array;
    }

    public function approveOrder(Request $request)
    {
        $approve_id = explode( ',', $request->approved_id );

        foreach ($approve_id as & $value) {
            TransferOrders::updateStatus($value);
        }

        return redirect()->route('inventory.order_items')->with('success', 'Successfully Approved the Order Items');
    }
}
