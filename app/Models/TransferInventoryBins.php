<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TransferInventoryBins extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transfer_inventory_bins';

    public $timestamps = false;

    public static function addData($request, $lastId, $index, $item_id, $transferred_id)
    {
        date_default_timezone_set('Asia/Manila');
        $data = ['transfer_inventory_id' => $lastId, 'transferred_inventory_items_id' => $transferred_id, 'item_id' => $item_id,
            'from_bin_id' => $request->from_bin_id[$index], 'to_bin_id' => $request->to_bin_id[$index],
            'quantity' => $request->transfer_bin_qty[$index], 'created_by' => 1, 'dt_created' => date('Y-m-d H:i:s'),
            'status' => 'Active'];

        if (DB::table('transfer_inventory_bins')->insert($data)) {
            return true;
        } else {
            return false;
        }
    }

    public static function updateData($request, $index, $item_id)
    {
        date_default_timezone_set('Asia/Manila');

        $data = ['from_bin_id' => $request->from_bin_id[$index], 'to_bin_id' => $request->to_bin_id[$index],
            'quantity' => $request->transfer_bin_qty[$index], 'lupd_by' => 1, 'dt_lupd' => date('Y-m-d H:i:s')];

        DB::table('transfer_inventory_bins')
            ->where('system_id', $request->bin_data_id)
            ->update($data);
    }
}
