<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TransferredOrderItems extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transferred_order_items';

    public $timestamps = false;

    public static function addData($request, $lastId, $index, $item_id)
    {
        date_default_timezone_set('Asia/Manila');
        $data = ['transfer_order_id' => $lastId, 'item_id' => $item_id, 'unit_type_id' => $request->units[$index],
            'qty_transferred' => $request->qty[$index], 'transfer_price' => $request->transfer_price[$index],
            'amount' => $request->amount[$index], 'expected_receipt_date' => $request->receipt_date[$index], 'commit_id' => $request->commit[$index],
            'order_priority' => $request->order_priority[$index], 'memo' => '', 'created_by' => 1, 'dt_created' => date('Y-m-d H:i:s'),
            'status' => 'Active'];

        if (DB::table('transferred_order_items')->insert($data)) {
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
            'qty_transferred' => $request->qty[$index], 'transfer_price' => $request->transfer_price[$index],
            'amount' => $request->amount[$index], 'expected_receipt_date' => $request->receipt_date[$index], 'commit_id' => $request->commit[$index],
            'order_priority' => $request->order_priority[$index], 'memo' => '', 'lupd_by' => 1, 'dt_lupd' => date('Y-m-d H:i:s')];

        DB::table('transferred_order_items')
            ->where('system_id', $request->data_id[$index])
            ->update($data);
    }
}
