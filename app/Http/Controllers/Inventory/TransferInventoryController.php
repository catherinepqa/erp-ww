<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\BinItems;
use App\Models\Countries;
use App\Models\Departments;
use App\Models\InventoryItems;
use App\Models\Items;
use App\Models\Locations;
use App\Models\TransferInventory;
use App\Models\TransferInventoryBins;
use App\Models\TransferredInventoryItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransferInventoryController extends Controller
{
    public function index()
    {
        return view('inventory.transfer_inventory.transfer_inventory');
    }

    public function addTransfer()
    {
        date_default_timezone_set('Asia/Manila');
        $today = date('Y-m-d');
        $locations = Locations::all();
        $countries = Countries::all();
        $depts = Departments::all();
        for ($i = 1; $i <= 8; $i++)
        {
            $months[] = date("Y-M", strtotime( date( '2019-10' )." +$i months"));
        }

        return view('inventory.transfer_inventory.add_transfer_inventory',compact('countries','locations',
                    'today', 'months', 'depts'));
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

    public function addData(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $lastId = TransferInventory::addData($request);

        //UPDATE REFERENCE NUMBER
        TransferInventory::updateReferenceNumber($lastId);

        $item_id = $request->item_id;

        if (!empty($request->item_id)) {
            foreach ($item_id as $index => $pd) {

                //INVENTORY TRANSFERRED
                $transferred_id = TransferredInventoryItems::addData($request, $lastId, $index, $pd);

                //INVENTORY ITEMS
                $toLocation = InventoryItems::checkExistingData($pd, $request->to_location);

                if (empty($toLocation)) {
                    $item1 = ['item_id' => $pd, 'location_id' => $request->to_location, 'build_point' => 0,
                        'preferred_stock_level' => 0, 'qty_on_hand' => $request->qty_transfer[$index], 'created_by' => 1,
                        'dt_created' => date('Y-m-d H:i:s'), 'status' => 'Active'];
                    DB::table('inventory_items')->insert($item1);
                } else {
                    $total_qty = $toLocation[0]['qty_on_hand'] + $request->qty_transfer[$index];

                    DB::table('inventory_items')
                        ->where('system_id', $toLocation[0]['system_id'])
                        ->update(['qty_on_hand' => $total_qty, 'dt_lupd' => date('Y-m-d H:i:s'), 'lupd_by' => 1]);
                }

                //FROM LOCATION
                $fromLocation = InventoryItems::checkExistingData($pd, $request->from_location);

                if (!empty($fromLocation)) {
                    $total_qty = $fromLocation[0]['qty_on_hand'] - $request->qty_transfer[$index];

                    DB::table('inventory_items')
                        ->where('system_id', $fromLocation[0]['system_id'])
                        ->update(['qty_on_hand' => $total_qty, 'dt_lupd' => date('Y-m-d H:i:s'), 'lupd_by' => 1]);
                }

                //INVENTORY TRANSFERRED BINS
                if (!empty($request->bin_item_id)) {
                    foreach ($request->bin_item_id as $index1 => $pd1) {

                        //TO BIN ITEMS
                        $toBin = BinItems::checkExistingData($pd, $request->to_location, $request->to_bin_id[$index1]);

                        if (empty($toBin)) {
                            $toBinItem = ['item_id' => $pd, 'location_id' => $request->to_location, 'bin_id' => $request->to_bin_id[$index1],
                                'quantity' => $request->transfer_bin_qty[$index1], 'created_by' => 1, 'dt_created' => date('Y-m-d H:i:s'),
                                'status' => 'Active'];
                            DB::table('bin_items')->insert($toBinItem);
                        } else {
                            $total_qty = $toBin[0]['quantity'] + $request->transfer_bin_qty[$index1];

                            DB::table('bin_items')
                                ->where('system_id', $toBin[0]['system_id'])
                                ->update(['quantity' => $total_qty, 'dt_lupd' => date('Y-m-d H:i:s'), 'lupd_by' => 1]);
                        }

                        //FROM BIN ITEMS
                        $fromBin = BinItems::checkExistingData($pd, $request->from_location, $request->from_bin_id[$index1]);

                        if (!empty($fromBin)) {
                            $total_qty = $fromBin[0]['quantity'] - $request->transfer_bin_qty[$index1];

                            DB::table('bin_items')
                                ->where('system_id', $fromBin[0]['system_id'])
                                ->update(['quantity' => $total_qty, 'dt_lupd' => date('Y-m-d H:i:s'), 'lupd_by' => 1]);
                        }

                        TransferInventoryBins::addData($request, $lastId, $index1, $pd, $transferred_id);
                    }
                }
            }

        }
        return redirect()->route('view_transfer_inventory',
            ['id' => $lastId])->with('success', 'Successfully Transferred an Inventory');
    }

    public function getBin(Request $request)
    {
        $location_id = $request->location_id;

        $data = DB::table('bins')
            ->select('bins.bin_id','bins.bin_no')
            ->where([
                ['bins.location_id', '=', $location_id],
            ])
            ->get();
        $array = json_decode( json_encode($data), true);
        return $array;
    }

    public function getQtyAvailable(Request $request)
    {
        $bin_id = $request->bin_id;

        $data = DB::table('bin_items')
            ->select('bin_items.quantity')
            ->where([
                ['bin_items.bin_id', '=', $bin_id],
            ])
            ->get();
        $array = json_decode( json_encode($data), true);
        return $array;
    }

    public function viewTransfer($id)
    {
        $data = DB::table('transfer_inventory')
            ->leftjoin('locations', 'locations.location_id', '=', 'transfer_inventory.from_location_id')
            ->leftjoin('departments', 'departments.department_id', '=', 'transfer_inventory.department_id')
            ->select('transfer_inventory.*', 'locations.name as from_location', 'departments.name as dept')
            ->where([
                ['transfer_inventory.transfer_inventory_id', '=', $id],
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

        return view('inventory.transfer_inventory.view_transfer_inventory',compact('data_arr', 'toLocation'));
    }

    public function dataList(Request $request)
    {
        $data = DB::table('transferred_inventory_items')
            ->leftjoin('items', 'items.item_id', '=', 'transferred_inventory_items.item_id')
            ->leftjoin('weight_units', 'weight_units.weight_unit_id', '=', 'transferred_inventory_items.unit_type_id')
            ->leftjoin('countries', 'countries.country_id', '=', 'transferred_inventory_items.manufacturer_country')
            ->leftjoin('transfer_inventory', 'transfer_inventory.transfer_inventory_id', '=', 'transferred_inventory_items.transfer_inventory_id')
            ->leftjoin('inventory_items', ([
                ['inventory_items.item_id', '=', 'transferred_inventory_items.item_id'],
                ['inventory_items.location_id', '=', 'transfer_inventory.from_location_id']
            ]))
            ->select('transferred_inventory_items.*', 'items.item_name as item_name', 'items.item_description as desc',
                'weight_units.name as unit', 'countries.name as country', 'items.item_code as item_code',
                'inventory_items.qty_on_hand')
            ->where([
                ['transferred_inventory_items.transfer_inventory_id', '=', $request->id],
            ])
            ->get();

        $array = json_decode( json_encode($data), true);

        return $array;
    }

    public function getTransferredBins(Request $request)
    {
        $data = DB::table('transfer_inventory_bins')
            ->leftjoin('bins', 'bins.bin_id', '=', 'transfer_inventory_bins.from_bin_id')
            ->leftjoin('bins as tb', 'tb.bin_id', '=', 'transfer_inventory_bins.to_bin_id')
            ->select('transfer_inventory_bins.*', 'bins.bin_no as from_bin', 'tb.bin_no as to_bin')
            ->where([
                ['transfer_inventory_bins.transferred_inventory_items_id', '=', $request->id]
            ])
            ->get();
        $array = json_decode( json_encode($data), true);

        return $array;
    }

    public function getAllData()
    {
        $data = TransferInventory::all();

        return response()->json(['data' => $data]);
    }

    public function editTransfer($id)
    {
        $data = DB::table('transfer_inventory')
            ->select('transfer_inventory.*')
            ->where([
                ['transfer_inventory.transfer_inventory_id', '=', $id],
            ])
            ->get();
        $data_arr = json_decode( json_encode($data), true);

        $locations = Locations::all();
        $countries = Countries::all();
        $depts = Departments::all();
        for ($i = 1; $i <= 8; $i++)
        {
            $months[] = date("Y-M", strtotime( date( '2019-10' )." +$i months"));
        }

        return view('inventory.transfer_inventory.edit_transfer_inventory',compact('data_arr', 'countries',
            'locations', 'months', 'depts'));
    }

    public function updateData(Request $request)
    {
        date_default_timezone_set('Asia/Manila');

        //UPDATE TRANSFER INVENTORY
        TransferInventory::updateData($request);

        $system_id = $request->system_id;
        $item_id = $request->item_id;

        if (!empty($system_id)) {
            foreach ($item_id as $index => $pd) {
                $transferred_id = '';
                if (!empty($request->data_id[$index]))
                {
                    TransferredInventoryItems::updateData($request, $index, $pd);
                } else {
                    $transferred_id = TransferredInventoryItems::addData($request, $system_id, $index, $pd);
                }
                //INVENTORY ITEMS
                $toLocation = InventoryItems::checkExistingData($pd, $request->to_location);

                if (empty($toLocation)) {
                    $item1 = ['item_id' => $pd, 'location_id' => $request->to_location, 'build_point' => 0,
                        'preferred_stock_level' => 0, 'qty_on_hand' => $request->qty_transfer[$index], 'created_by' => 1,
                        'dt_created' => date('Y-m-d H:i:s'), 'status' => 'Active'];
                    DB::table('inventory_items')->insert($item1);
                } else {
                    $total_qty = $toLocation[0]['qty_on_hand'] + $request->qty_transfer[$index];

                    DB::table('inventory_items')
                        ->where('system_id', $toLocation[0]['system_id'])
                        ->update(['qty_on_hand' => $total_qty, 'dt_lupd' => date('Y-m-d H:i:s'), 'lupd_by' => 1]);
                }

                //FROM LOCATION
                $fromLocation = InventoryItems::checkExistingData($pd, $request->from_location);

                if (!empty($fromLocation)) {
                    $total_qty = $fromLocation[0]['qty_on_hand'] - $request->qty_transfer[$index];

                    DB::table('inventory_items')
                        ->where('system_id', $fromLocation[0]['system_id'])
                        ->update(['qty_on_hand' => $total_qty, 'dt_lupd' => date('Y-m-d H:i:s'), 'lupd_by' => 1]);
                }

                //INVENTORY TRANSFERRED BINS
                if (!empty($request->bin_items_id)) {
                    foreach ($request->bin_items_id as $index1 => $pd1) {
                        //TO BIN ITEMS
                        $to_bin_id = $request->to_bin_id[$index1];
                        $toBin = BinItems::checkExistingData($pd, $request->to_location, $to_bin_id);

                        if (empty($toBin)) {
                            $toBinItem = ['item_id' => $pd, 'location_id' => $request->to_location, 'bin_id' => $request->to_bin_id[$index1],
                                'quantity' => $request->transfer_bin_qty[$index1], 'created_by' => 1, 'dt_created' => date('Y-m-d H:i:s'),
                                'status' => 'Active'];
                            DB::table('bin_items')->insert($toBinItem);
                        } else {
                            $total_qty = $toBin[0]['quantity'] + $request->transfer_bin_qty[$index1];

                            DB::table('bin_items')
                                ->where('system_id', $toBin[0]['system_id'])
                                ->update(['quantity' => $total_qty, 'dt_lupd' => date('Y-m-d H:i:s'), 'lupd_by' => 1]);
                        }

                        //FROM BIN ITEMS
                        $fromBin = BinItems::checkExistingData($pd, $request->from_location, $request->from_bin_id[$index1]);

                        if (!empty($fromBin)) {
                            $total_qty = $fromBin[0]['quantity'] - $request->transfer_bin_qty[$index1];

                            DB::table('bin_items')
                                ->where('system_id', $fromBin[0]['system_id'])
                                ->update(['quantity' => $total_qty, 'dt_lupd' => date('Y-m-d H:i:s'), 'lupd_by' => 1]);
                        }

                        if (!empty($request->bin_data_id[$index1]))
                        {
                            TransferInventoryBins::updateData($request, $index1, $pd1);
                        } else {
                            TransferInventoryBins::addData($request, $system_id, $index1, $pd1, $transferred_id);
                        }
                    }
                }
            }

            if (!empty($request->ti_deleted_id)) {
                foreach ($request->ti_deleted_id as $id) {
                    DB::table('transferred_inventory_items')->where('system_id', $id)->delete();
                    DB::table('inventory_adjusted_bins')->where('transferred_inventory_items_id', $id)->delete();
                }
            }

            return redirect()->route('view_transfer_inventory', ['id' => $request->system_id])->with('success', 'Successfully Updated an Inventory Adjustment');
        }
    }
}
