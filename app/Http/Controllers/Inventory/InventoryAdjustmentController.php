<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\BinItems;
use App\Models\InventoryAdjustedBins;
use App\Models\InventoryAdjustedItems;
use App\Models\InventoryAdjustment;
use App\Models\Items;
use App\Models\Locations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryAdjustmentController extends Controller
{
    public function index()
    {
        return view('inventory.inventory_adjustment.inventory_adjustment');
    }

    public function addAdjustment()
    {
        date_default_timezone_set('Asia/Manila');
        $today = date('m-d-Y');

        for ($i = 1; $i <= 8; $i++)
        {
            $months[] = date("Y-M", strtotime( date( '2019-10' )." +$i months"));
        }

        $locations = Locations::all();

        return view('inventory.inventory_adjustment.add_inventory_adjustment', compact('today','months', 'locations'));
    }

    public function item_search(Request  $request)
    {
        $result = Items::select('item_id', 'item_name as name')->where('item_name', 'LIKE', "%{$request->input('query')}%")->get();

        return response()->json($result);
    }

    public function getItems(Request $request)
    {
        $id = $request->id;

        $data = DB::table('items')
            ->leftjoin('departments', 'departments.department_id', '=', 'items.department_id')
            ->leftjoin('item_categories', 'item_categories.item_category_id', '=', 'items.item_category_id')
            ->leftjoin('weight_units', 'weight_units.weight_unit_id', '=', 'items.weight_unit_id')
            ->select('items.item_description', 'departments.name as dept_name', 'item_categories.name as item_category_name',
                    'weight_units.name as unit', 'departments.department_id as dept_id', 'item_categories.item_category_id as item_cat_id',
                    'weight_units.weight_unit_id as unit_id', 'items.item_code')
            ->where('items.item_id', '=', $id)
            ->get();
        $array = json_decode( json_encode($data), true);
        return $array;
    }

    public function getLocation(Request $request)
    {
        $item_id = $request->item_id;
        $location_id = $request->location_id;

        $data = DB::table('inventory_items')
            ->select('inventory_items.last_purchase_cost','inventory_items.qty_on_hand','inventory_items.system_id')
            ->where([
                ['inventory_items.item_id', '=', $item_id],
                ['inventory_items.location_id', '=', $location_id],
            ])
            ->get();
        $array = json_decode( json_encode($data), true);
        return $array;
    }

    public function addingData(Request $request)
    {
        $invent_adj = new InventoryAdjustment();
        $invent_adj->reference_no = 0;
        $invent_adj->adjustment_date = date('Y-m-d', strtotime(trim(str_replace('/','-',$request->adj_date))));
        $invent_adj->adjustment_account = 1;
        $invent_adj->est_total_value = $request->est_total_val;
        $invent_adj->posting_period = date('Y-m-d', strtotime($request->posting_period.'-01'));
        $invent_adj->memo = $request->memo;
        $invent_adj->created_by = 1;
        $invent_adj->dt_created = date('Y-m-d H:i:s');
        $invent_adj->status = 'Active';
        $invent_adj->save();

        //UPDATE REFERENCE NUMBER
        $lastInsertedId = $invent_adj->id;
        DB::table('inventory_adjustment')
            ->where('inventory_adjustment_id', $lastInsertedId)
            ->update(['reference_no' => 'IA00000000'.$lastInsertedId.'']);

        //ADDING ADJUSTED ITEMS
        $item_id = $request->item_id;
        $data = [];
        if (!empty($request->item_id)) {
            foreach($item_id as $index => $pd)
            {
                $item = ['inventory_adjustment_id' => $lastInsertedId, 'item_id' => $pd, 'department_id' => $request->dept[$index],
                    'item_category_id' => $request->item_cat[$index], 'location_id' => $request->location[$index], 'unit_type_id' => $request->units[$index],
                    'qty_adjusted' => $request->new_qty[$index], 'est_total_cost' => $request->est_cost[$index], 'memo' => $request->adj_memo[$index],
                    'created_by' => $request->adjust_by[$index], 'dt_created' => date('Y-m-d H:i:s'), 'status' => 'Active'];

                array_push($data,$item);

                //UPDATING INVENTORY ITEMS
                $total_qty = $request->new_qty[$index] + $request->qyt_on_hand[$index];
                DB::table('inventory_items')
                    ->where('system_id', $request->inventory_item_id[$index])
                    ->update(['qty_on_hand' => $total_qty, 'dt_lupd' => date('Y-m-d H:i:s')]);

                DB::table('inventory_adjusted_items')->insert($item);
                $system_id = DB::getPdo()->lastInsertId();

                //ADDING BIN ITEMS
                $bin_items_id = $request->bin_items_id;
                $bin_data = [];
                $adjusted_bin_data = [];
                if (!empty($bin_items_id)) {
                    foreach($bin_items_id as $index => $bin)
                    {
                        $item = ['item_id' => $bin, 'location_id' => $request->item_location_id[$index], 'bin_id' => $request->bin_list_id[$index],
                            'quantity' => $request->bin_new_qty[$index], 'created_by' => 1, 'dt_created' => date('Y-m-d H:i:s'),
                            'status' => 'Active'];

                        array_push($bin_data,$item);

                        $adjusted_bin = ['inventory_adjustment_id' => $lastInsertedId, 'inventory_adjusted_items_id' => $system_id, 'item_id' => $bin,
                            'bin_id' => $request->bin_list_id[$index], 'qty' => $request->bin_new_qty[$index], 'created_by' => 1,
                            'dt_created' => date('Y-m-d H:i:s'), 'status' => 'Active'];

                        array_push($adjusted_bin_data,$adjusted_bin);
                    }
                }

                BinItems::insert($bin_data);
                InventoryAdjustedBins::insert($adjusted_bin_data);
            }

            //InventoryAdjustedItems::insert($data);
        }

        //return redirect('/inventory_adjustment')->with('success', 'Successfully Created a new Inventory Adjustment');
        return redirect()->route('new_inventory_adjustment',
            ['id' => $lastInsertedId])->with('success', 'Successfully Created a new Inventory Adjustment');
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

    public function editAdjustment($id)
    {

        $data = DB::table('inventory_adjustment')->where('inventory_adjustment_id', $id)->first();
        $data_arr = json_decode( json_encode($data), true);

        //MONTHS
        for ($i = 1; $i <= 8; $i++)
        {
            $months[] = date("Y-M", strtotime( date( '2019-10' )." +$i months"));
        }
        $locations = Locations::all();

        return view('inventory.inventory_adjustment.edit_inventory_adjustment',compact('data_arr', 'months', 'locations'));
    }

    public function dataList(Request $request)
    {
        $data = DB::table('inventory_adjusted_items')
            ->leftjoin('departments', 'departments.department_id', '=', 'inventory_adjusted_items.department_id')
            ->leftjoin('item_categories', 'item_categories.item_category_id', '=', 'inventory_adjusted_items.item_category_id')
            ->leftjoin('weight_units', 'weight_units.weight_unit_id', '=', 'inventory_adjusted_items.unit_type_id')
            ->leftjoin('items', 'items.item_id', '=', 'inventory_adjusted_items.item_id')
            ->leftjoin('locations', 'locations.location_id', '=', 'inventory_adjusted_items.location_id')
            ->leftjoin('inventory_items', ([
                ['inventory_items.item_id', '=', 'inventory_adjusted_items.item_id'],
                ['inventory_items.location_id', '=', 'inventory_adjusted_items.location_id'],
            ]))
            ->leftjoin('inventory_adjusted_bins', 'inventory_adjusted_bins.inventory_adjusted_items_id', '=', 'inventory_adjusted_items.system_id')
            ->select('inventory_adjusted_items.*', 'departments.name as dept_name', 'item_categories.name as item_category_name',
                'weight_units.name as unit', 'departments.department_id as dept_id', 'item_categories.item_category_id as item_cat_id',
                'weight_units.weight_unit_id as unit_id', 'items.item_name as item_name', 'items.item_description as desc',
                'locations.name as location', 'inventory_items.qty_on_hand', 'items.item_code as item_code', 'inventory_items.system_id as inventory_items_id',
                'inventory_adjusted_bins.system_id as ia_bin_id')
            ->where('inventory_adjusted_items.inventory_adjustment_id', '=', $request->id)
            ->get();

        $array = json_decode( json_encode($data), true);
        $data_arr = [];

        foreach ($array as $item) {
            $orig_qty_on_hand = $item['qty_on_hand'];
            $c_value = $item['qty_on_hand'] * $item['est_total_cost'];
            $qty_hand = $item['qty_on_hand'] -= $item['qty_adjusted'];

            $item_arr = ['id' => $item['system_id'], 'inventory_adjustment_id' => $item['inventory_adjustment_id'], 'item_name' => $item['item_name'],
                         'desc' => $item['desc'], 'location' => $item['location'], 'unit' => $item['unit'], 'qty_hand' => $qty_hand, 'c_value' => $c_value,
                         'created_by' => $item['created_by'], 'qty_adjusted' => $item['qty_adjusted'], 'inventory' => '', 'dept_name' => $item['dept_name'],
                         'item_category_name' => $item['item_category_name'], 'adj_memo' => $item['memo'], 'est_total_cost' => $item['est_total_cost'],
                         'location_id' => $item['location_id'], 'item_code' => $item['item_code'], 'item_id' => $item['item_id'], 'unit_id' => $item['unit_id'],
                         'orig_qty_on_hand' => $orig_qty_on_hand, 'dept_id' => $item['dept_id'], 'item_cat_id' => $item['item_cat_id'],
                         'inventory_items_id' => $item['inventory_items_id'], 'ia_bin_id' => $item['ia_bin_id']];
            array_push($data_arr, $item_arr);
        }
        return $data_arr;
    }

    public function getAdjustedBins(Request $request)
    {
        $data_id = $request->data_id;

        $data = DB::table('inventory_adjusted_bins')
            ->leftjoin('bins', 'bins.bin_id', '=', 'inventory_adjusted_bins.bin_id')
            ->select('inventory_adjusted_bins.*', 'bins.*')
            ->where('inventory_adjusted_bins.system_id', '=', $data_id)
            ->get();
        $array = json_decode( json_encode($data), true);
        return $array;
    }

    public function updateData(Request $request)
    {
        $data = ['adjustment_date' => date('Y-m-d', strtotime(trim(str_replace('/','-',$request->adj_date)))), 'adjustment_account' => $request->adj_account,
                 'est_total_value' => $request->est_total_val, 'posting_period' => date('Y-m-d', strtotime($request->posting_period.'-01')),
                 'memo' => $request->memo, 'created_by' => 1, 'dt_lupd' => date('Y-m-d H:i:s')];

        DB::table('inventory_adjustment')
            ->where('inventory_adjustment_id', $request->adjusted_id)
            ->update($data);

        if (!empty($request->adjusted_id)) {
            $adjusted_id = $request->adjusted_id;

            foreach($adjusted_id as $index => $pd)
            {
                $item = ['item_id' => $request->item_id[$index], 'department_id' => $request->dept[$index],
                    'item_category_id' => $request->item_cat[$index], 'location_id' => $request->location[$index], 'unit_type_id' => $request->units[$index],
                    'qty_adjusted' => $request->new_qty[$index], 'est_total_cost' => $request->est_cost[$index], 'memo' => $request->adj_memo[$index],
                    'created_by' => $request->adjust_by[$index], 'dt_lupd' => date('Y-m-d H:i:s'), 'status' => 'Active'];

                DB::table('inventory_adjusted_items')
                    ->where('system_id', $pd)
                    ->update($item);

                //UPDATING INVENTORY ITEMS
//                $total_qty = $request->new_qty[$index] + $request->qyt_on_hand[$index];
//                DB::table('inventory_items')
//                    ->where('system_id', $request->inventory_item_id[$index])
//                    ->update(['qty_on_hand' => $total_qty, 'dt_lupd' => date('Y-m-d H:i:s')]);
            }

            if (!empty($request->add_item_id)) {
                $item_id = $request->add_item_id;

                foreach($item_id as $index => $pd)
                {
                    $item = ['inventory_adjustment_id' => $request->system_id, 'item_id' => $pd, 'department_id' => $request->add_dept[$index],
                        'item_category_id' => $request->add_item_cat[$index], 'location_id' => $request->add_location[$index], 'unit_type_id' => $request->add_units[$index],
                        'qty_adjusted' => $request->add_new_qty[$index], 'est_total_cost' => $request->add_est_cost[$index], 'memo' => $request->add_adj_memo[$index],
                        'created_by' => $request->add_adjust_by[$index], 'dt_created' => date('Y-m-d H:i:s'), 'status' => 'Active'];

                    //UPDATING INVENTORY ITEMS
                    $total_qty = $request->add_new_qty[$index] + $request->add_qyt_on_hand[$index];
                    DB::table('inventory_items')
                        ->where('system_id', $request->add_inventory_item_id[$index])
                        ->update(['qty_on_hand' => $total_qty, 'dt_lupd' => date('Y-m-d H:i:s')]);

                    DB::table('inventory_adjusted_items')->insert($item);
                    $system_id = DB::getPdo()->lastInsertId();

                    //ADDING BIN ITEMS
                    if (!empty($request->add_bin_items_id)) {
                        $bin_items_id = $request->add_bin_items_id;
                        $bin_data = [];
                        $adjusted_bin_data = [];

                        foreach($bin_items_id as $index => $bin)
                        {
                            $item = ['item_id' => $bin, 'location_id' => $request->add_item_location_id[$index], 'bin_id' => $request->add_bin_list_id[$index],
                                'quantity' => $request->add_bin_new_qty[$index], 'created_by' => 1, 'dt_created' => date('Y-m-d H:i:s'),
                                'status' => 'Active'];

                            array_push($bin_data,$item);

                            $adjusted_bin = ['inventory_adjustment_id' => $request->system_id, 'inventory_adjusted_items_id' => $system_id, 'item_id' => $bin,
                                'bin_id' => $request->add_bin_list_id[$index], 'qty' => $request->add_bin_new_qty[$index], 'created_by' => 1,
                                'dt_created' => date('Y-m-d H:i:s'), 'status' => 'Active'];

                            array_push($adjusted_bin_data,$adjusted_bin);
                        }

                        BinItems::insert($bin_data);
                        InventoryAdjustedBins::insert($adjusted_bin_data);
                    }
                }
            }
        }

        if (!empty($request->ia_deleted_id)) {
            foreach ($request->ia_deleted_id as $id) {
                DB::table('inventory_adjusted_items')->where('system_id', $id)->delete();
                DB::table('inventory_adjusted_bins')->where('inventory_adjusted_items_id', $id)->delete();
            }
        }

        return redirect()->route('view_inventory_adjustment', ['id' => $request->system_id])->with('success', 'Successfully Updated an Inventory Adjustment');
    }

    public function getAllData()
    {
        $data = InventoryAdjustment::all();

        return response()->json(['data' => $data]);
    }

    public function viewAdjustment($id)
    {
        $data = DB::table('inventory_adjustment')->where('inventory_adjustment_id', $id)->first();
        $data_arr = json_decode( json_encode($data), true);

        return view('inventory.inventory_adjustment.view_inventory_adjustment',compact('data_arr'));
    }
}
