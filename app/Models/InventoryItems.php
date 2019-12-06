<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InventoryItems extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inventory_items';

    public $timestamps = false;

    public static function checkExistingData($item_id, $location_id)
    {
        $data = DB::table('inventory_items')
            ->select('inventory_items.*')
            ->where([
                ['inventory_items.item_id', '=', $item_id],
                ['inventory_items.location_id', '=', $location_id],
            ])
            ->get();
        if (!empty($data)) {
            return json_decode( json_encode($data), true);
        } else {
            return false;
        }
    }
}
