<?php

namespace App\Http\Controllers;

use App\Models\Commit;
use App\Models\Departments;
use App\Models\Items;
use App\Models\Locations;
use App\Models\ShippingCarrier;
use App\Models\TransferOrders;
use App\Models\TransferredOrderItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransferOrderController extends Controller
{
    public function index()
    {
        return view('inventory.transfer_order.transfer_orders');
    }

    public function addOrders()
    {
        date_default_timezone_set('Asia/Manila');
        $today = date('Y-m-d');
        $locations = Locations::all();
        $depts = Departments::all();
        $commit = Commit::all();
        $carrier = ShippingCarrier::all();

        return view('inventory.transfer_order.add_transfer_order',compact('today','locations', 'depts',
                    'commit', 'carrier'));
    }

    public function item_search(Request  $request)
    {
        print_r($request->input('query'));
        $result = Items::select('item_id', 'item_name as name')
            ->where([
                ['item_name', 'LIKE', "%{$request->search}%"],
                ['location_id', '=', $request->location],
            ])
            ->get();

        return response()->json($result);
    }

    public function getItems(Request $request)
    {
        $id = $request->id;

        $data = DB::table('items')
            ->leftjoin('weight_units', 'weight_units.weight_unit_id', '=', 'items.weight_unit_id')
            ->leftjoin('inventory_items', ([
                ['inventory_items.item_id', '=', 'items.item_id'],
                ['inventory_items.location_id', '=', 'items.location_id'],
            ]))
            ->select('items.item_description', 'weight_units.name as unit', 'weight_units.weight_unit_id as unit_id',
                'items.item_code', 'inventory_items.qty_on_hand as qty_on_hand')
            ->where('items.item_id', '=', $id)
            ->get();
        $array = json_decode( json_encode($data), true);
        return $array;
    }

    public function addDataProcess(Request $request)
    {
        $lastId = TransferOrders::addData($request);

        //UPDATE REFERENCE NUMBER
        TransferOrders::updateReferenceNumber($lastId);

        if (!empty($request->item_id)) {

            foreach ($request->item_id as $index => $pd) {

                //INVENTORY TRANSFERRED
                $transferred_id = TransferredOrderItems::addData($request, $lastId, $index, $pd);
            }
        }

        return redirect()->route('inventory.order_viewOrders',
            ['id' => $lastId])->with('success', 'Successfully Added Transferred the Order');
    }

    public function viewOrders($id)
    {
        $data = DB::table('transfer_orders')
            ->leftjoin('locations', 'locations.location_id', '=', 'transfer_orders.from_location_id')
            ->leftjoin('departments', 'departments.department_id', '=', 'transfer_orders.department_id')
            ->leftjoin('shipping_carrier', 'shipping_carrier.shipping_carrier_id', '=', 'transfer_orders.shipping_carrier_id')
            ->select('transfer_orders.*', 'locations.name as from_location', 'departments.name as dept', 'shipping_carrier.name as carrier')
            ->where([
                ['transfer_orders.transfer_order_id', '=', $id],
            ])
            ->get();
        $data_arr = json_decode( json_encode($data), true);

        $data1 = DB::table('locations')
            ->select('locations.name')
            ->where([
                ['locations.location_id', '=', $data_arr[0]['to_location_id']],
            ])
            ->get();
        $toLocation = json_decode( json_encode($data1), true);

        return view('inventory.transfer_order.view_transfer_order',compact('data_arr', 'toLocation'));
    }

    public function dataList(Request $request)
    {
        $data = DB::table('transferred_order_items')
            ->leftjoin('items', 'items.item_id', '=', 'transferred_order_items.item_id')
            ->leftjoin('weight_units', 'weight_units.weight_unit_id', '=', 'transferred_order_items.unit_type_id')
            ->leftjoin('commit', 'commit.commit_id', '=', 'transferred_order_items.commit_id')
            ->select('transferred_order_items.*', 'items.item_name as item_name', 'items.item_description as desc',
                'weight_units.name as unit', 'items.item_code as item_code', 'commit.name as commit')
            ->where([
                ['transferred_order_items.transfer_order_id', '=', $request->id],
            ])
            ->get();

        $array = json_decode( json_encode($data), true);

        return $array;
    }

    public function getAllData()
    {
        $data = TransferOrders::all();

        return response()->json(['data' => $data]);
    }

    public function editOrder($id)
    {
        date_default_timezone_set('Asia/Manila');
        $today = date('Y-m-d');
        $data = DB::table('transfer_orders')
            ->leftjoin('locations', 'locations.location_id', '=', 'transfer_orders.from_location_id')
            ->leftjoin('departments', 'departments.department_id', '=', 'transfer_orders.department_id')
            ->leftjoin('shipping_carrier', 'shipping_carrier.shipping_carrier_id', '=', 'transfer_orders.shipping_carrier_id')
            ->select('transfer_orders.*', 'locations.name as from_location', 'departments.name as dept', 'shipping_carrier.name as carrier')
            ->where([
                ['transfer_orders.transfer_order_id', '=', $id],
            ])
            ->get();
        $data_arr = json_decode( json_encode($data), true);

        $locations = Locations::all();
        $depts = Departments::all();
        $commit = Commit::all();
        $carrier = ShippingCarrier::all();

        return view('inventory.transfer_order.edit_transfer_order',compact('data_arr', 'today',
                    'locations', 'depts', 'commit', 'carrier'));
    }

    public function updateData(Request $request)
    {
        //UPDATE TRANSFER INVENTORY
        TransferOrders::updateData($request);

        $system_id = $request->system_id;

        if (!empty($request->item_id)) {
            foreach ($request->item_id as $index => $pd) {

                if (!empty($request->data_id[$index]))
                {
                    TransferredOrderItems::updateData($request, $index, $pd);
                } else {
                    $transferred_id = TransferredOrderItems::addData($request, $system_id, $index, $pd);
                }
            }
        }

        if (!empty($request->to_deleted_id)) {
            foreach ($request->to_deleted_id as $id) {
                DB::table('transferred_order_items')->where('system_id', $id)->delete();
                //DB::table('inventory_adjusted_bins')->where('transferred_inventory_items_id', $id)->delete();
            }
        }

        return redirect()->route('inventory.order_viewOrders',
            ['id' => $system_id])->with('success', 'Successfully Updated Transferred the Order');
    }

    public function approveStatus(Request $request)
    {
        $approve_id = $request->status_id;

        TransferOrders::updateStatus($approve_id);

        return redirect()->route('inventory.order_viewOrders',
            ['id' => $approve_id])->with('success', 'Successfully Approved the Transferred Order');
    }
}
