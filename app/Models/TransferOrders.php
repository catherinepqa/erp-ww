<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TransferOrders extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transfer_orders';

    public $timestamps = false;

    public static function addData($request)
    {
        date_default_timezone_set('Asia/Manila');
        $data = ['reference_no' => 0, 'transferred_date' => $request->trans_date, 'from_location_id' => $request->from_location,
            'to_location_id' => $request->to_location, 'department_id' => $request->dept, 'memo' => $request->memo,
            'incoterm_id' => 1, 'firmed' => 1, 'shipping_date' => $request->ship_date, 'shipping_carrier_id' => $request->ship_carrier,
            'shipping_cost' => $request->ship_cost, 'shipping_to' => $request->ship_to, 'shipping_address' => $request->ship_add,
            'created_by' => 1, 'dt_created' => date('Y-m-d H:i:s'), 'status' => 'New'];

        if (DB::table('transfer_orders')->insert($data)) {

            $system_id = DB::getPdo()->lastInsertId();

            return $system_id;
        } else {
            return false;
        }
    }

    public static function updateReferenceNumber($id)
    {
        DB::table('transfer_orders')
            ->where('transfer_order_id', $id)
            ->update(['reference_no' => 'TO00000000'.$id.'']);
    }

    public static function updateData($request)
    {
        date_default_timezone_set('Asia/Manila');
        $data = ['transferred_date' => $request->trans_date, 'from_location_id' => $request->from_location,
            'to_location_id' => $request->to_location, 'department_id' => $request->dept, 'memo' => $request->memo,
            'incoterm_id' => 1, 'firmed' => 1, 'shipping_date' => $request->ship_date, 'shipping_carrier_id' => $request->ship_carrier,
            'shipping_cost' => $request->ship_cost, 'shipping_to' => $request->ship_to, 'shipping_address' => $request->ship_add,
            'lupd_by' => 1, 'dt_lupd' => date('Y-m-d H:i:s')];

        DB::table('transfer_orders')
            ->where('transfer_order_id', $request->system_id)
            ->update($data);
    }

    public static function updateStatus($id)
    {
        date_default_timezone_set('Asia/Manila');
        DB::table('transfer_orders')
            ->where('transfer_order_id', $id)
            ->update(['status' => 'Approved', 'lupd_by' =>1, 'dt_lupd' => date('Y-m-d H:i:s')]);
    }
}
