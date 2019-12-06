<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\InventoryItems;
use App\SalesOrder;

class SalesOrderItems extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sales_order_items';

    public $primaryKey = 'system_id';

    public $timestamps = false;

    public static function updatedata ($request)
    {
        $sales_order_items_id   = $request->get('sales_order_items_id');
        $quantity_committed     = $request->get('qty_committed');
        $item_id                = $request->get('item_id');
        $qty_committed_count    = 0;

        for ($i=0; $i<count($sales_order_items_id); $i++) {
            $sales_items                   = self::find($sales_order_items_id[$i]);
            $sales_items->qty_committed    = $quantity_committed[$i];
            $sales_items->lupd_by          = '1';
            $sales_items->dt_lupd          = date('Y-m-d, H:i:s');

            $qty_committed_count += $quantity_committed[$i];
        }

        $inventory_items = InventoryItems::where('item_id', $item_id)
                          ->update([
                              'qty_committed' => $qty_committed_count,
                              'lupd_by' => '1',
                              'dt_lupd' => date('Y-m-d, H:i:s')]);

        if ($sales_items->save()) {
            return true;
        } else {
            return false;
        }
    }

    public function salesorder()
	{
  		return $this->belongsTo(SalesOrder::class, 'sales_order_id', 'sales_order_id');
	}
}
