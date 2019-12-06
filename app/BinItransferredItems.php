<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BinItransferredItems extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bin_itransferred_items';

    public $timestamps = false;

    public static function saveInventoryDetail()
    {
        $bin_transfer                   = new BinItransferredItems;
        $bin_transfer->from_bin_id      = $request->get('from_bin_id');
        $bin_transfer->to_bin_id        = $request->get('to_bin_id');
        $bin_transfer->quantity         = $request->get('quantity');
        $bin_transfer->bin_transfer_id  = $request->get('bin_transfer_id');
        $bin_transfer->item_id          = $request->get('item_id');
        $bin_transfer->created_by       = '1';
        $bin_transfer->dt_created       = date('Y-m-d, H:i:s');
        $bin_transfer->status           = 'Active';

        if ($bin_transfer->save()) {
            return true;
        } else {
            return false;
        }
    }

}
