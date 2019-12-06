<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TransferInventory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transfer_inventory';

    public $timestamps = false;

    public static function addData ($request)
    {
        date_default_timezone_set('Asia/Manila');
        $data = ['reference_no' => 0, 'transferred_date' => $request->trans_date, 'posting_period' => date('Y-m-d', strtotime($request->posting_period.'-01')),
                 'from_location_id' => $request->from_location, 'to_location_id' => $request->to_location, 'department_id' => $request->dept,
                 'memo' => $request->memo, 'created_by' => 1, 'dt_created' => date('Y-m-d H:i:s'), 'status' => 'Active'];

        if (DB::table('transfer_inventory')->insert($data)) {

            $system_id = DB::getPdo()->lastInsertId();

            return $system_id;
        } else {
            return false;
        }
    }

    public static function updateReferenceNumber($id)
    {
        DB::table('transfer_inventory')
            ->where('transfer_inventory_id', $id)
            ->update(['reference_no' => 'TI00000000'.$id.'']);
    }

    public static function updateData($request)
    {
        date_default_timezone_set('Asia/Manila');
        $data = ['transferred_date' => $request->trans_date, 'posting_period' => date('Y-m-d', strtotime($request->posting_period.'-01')),
            'from_location_id' => $request->from_location, 'to_location_id' => $request->to_location, 'department_id' => $request->dept,
            'memo' => $request->memo, 'lupd_by' => 1, 'dt_lupd' => date('Y-m-d H:i:s')];

        DB::table('transfer_inventory')
            ->where('transfer_inventory_id', $request->system_id)
            ->update($data);
    }
}
