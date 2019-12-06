<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BinItems extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bin_items';

    public $timestamps = false;

    public static function checkExistingData($item_id, $location_id, $bin_id)
    {
        $data = DB::table('bin_items')
            ->select('bin_items.*')
            ->where([
                ['bin_items.item_id', '=', $item_id],
                ['bin_items.location_id', '=', $location_id],
                ['bin_items.bin_id', '=', $bin_id],
            ])
            ->get();
        if (!empty($data)) {
            return json_decode( json_encode($data), true);
        } else {
            return false;
        }
    }
}
