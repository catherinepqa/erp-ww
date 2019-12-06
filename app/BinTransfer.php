<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BinItems;
use App\BinItransferredItems;

class BinTransfer extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bin_transfer';

    public $timestamps = false;

    public $primaryKey = 'bin_transfer_id';

    /**
     * store new Bin Transfer Transaction
     * Return boolean true or false if saving was successful
     */
    public static function storeBin ($request)
    {
        $bin_transfer                   = new BinTransfer;
        $bin_transfer->transferred_date = date('Y-m-d', strtotime($request->get('transfer_date')));
        $bin_transfer->location_id      = $request->get('location');
        $bin_transfer->created_by       = '1';
        $bin_transfer->memo             = $request->get('memo');
        $bin_transfer->dt_created       = date('Y-m-d, H:i:s');
        $bin_transfer->status           = 'Active';

        if ($bin_transfer->save()) {
            $new_bin_transfer                 = self::find($bin_transfer->bin_transfer_id);
            $new_bin_transfer->reference_no   = 'BT00000000' . $bin_transfer->bin_transfer_id;

            if ($new_bin_transfer->update()) {

                $item_id        = $request->get('item_id');
                $quantity       = $request->get('quantity');
                $bin_qty        = $request->get('bin_quantity');
                $from_bin_id    = $request->get('from_bin_id');
                $to_bin_id      = $request->get('to_bin_id');

                for ($i=0; $i<count($item_id); $i++) {
                    $bin_items                   = new BinItems;
                    $bin_items->item_id          = $item_id[$i];
                    $bin_items->location_id      = $request->get('location');
                    $bin_items->quantity         = $quantity[$i];
                    $bin_items->bin_id           = '1';
                    $bin_items->created_by       = '1';
                    $bin_items->dt_created       = date('Y-m-d, H:i:s');
                    $bin_items->status           = 'Active';

                    if ($bin_items->save()) {
                        if (array_key_exists($item_id[$i], $from_bin_id)) {
                            $bin_transfered_item                   = new BinItransferredItems;
                            $bin_transfered_item->bin_transfer_id  = $bin_transfer->bin_transfer_id;
                            $bin_transfered_item->item_id          = $item_id[$i];
                            $bin_transfered_item->from_bin_id      = $from_bin_id[$item_id[$i]];
                            $bin_transfered_item->to_bin_id        = $to_bin_id[$item_id[$i]];
                            $bin_transfered_item->quantity         = $bin_qty[$item_id[$i]];
                            $bin_transfered_item->created_by       = '1';
                            $bin_transfered_item->dt_created       = date('Y-m-d, H:i:s');
                            $bin_transfered_item->status           = 'Active';
                            $bin_transfered_item->save();
                        } else {
                            continue;
                        }
                    }
                }
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * update Bin Transfer Transaction
     * Return boolean true or false if updating was successful
     */
    public static function updateBin ($request, $id)
    {
        $bin_transfer                   = self::find($id);
        $bin_transfer->transferred_date = date('Y-m-d', strtotime($request->get('transfer_date')));
        $bin_transfer->location_id      = $request->get('location');
        $bin_transfer->lupd_by          = '1';
        $bin_transfer->dt_lupd          = date('Y-m-d, H:i:s');
        $bin_transfer->memo             = $request->get('memo');
        $bin_transfer->status           = 'Active';

        if ($bin_transfer->update()) {
            return true;
        } else {
            return false;
        }
    }
}
