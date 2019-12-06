<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TransferredInventoryItems extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transferred_inventory_items';

    public $timestamps = false;

    public static function addData($request, $lastId, $index, $item_id)
    {
        date_default_timezone_set('Asia/Manila');
        $data = ['transfer_inventory_id' => $lastId, 'item_id' => $item_id, 'unit_type_id' => $request->units[$index],
            'qty_transferred' => $request->qty_transfer[$index], 'item_weight' => $request->weight[$index],
            'manufacturer_country' => $request->country[$index], 'created_by' => 1, 'dt_created' => date('Y-m-d H:i:s'),
            'status' => 'Active'];

        if (DB::table('transferred_inventory_items')->insert($data)) {
            $system_id = DB::getPdo()->lastInsertId();

            return $system_id;
        } else {
            return false;
        }
    }

    public static function updateData($request, $index, $item_id)
    {
        date_default_timezone_set('Asia/Manila');
        $data = ['item_id' => $item_id, 'unit_type_id' => $request->units[$index],
            'qty_transferred' => $request->qty_transfer[$index], 'item_weight' => $request->weight[$index],
            'manufacturer_country' => $request->country[$index], 'lupd_by' => 1, 'dt_lupd' => date('Y-m-d H:i:s')];

        DB::table('transferred_inventory_items')
            ->where('system_id', $request->data_id)
            ->update($data);
    }
}
