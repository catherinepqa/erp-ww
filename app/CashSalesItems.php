<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Items;

class CashSalesItems extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cash_sales_items';

    public $timestamps = false;

    public $primaryKey = 'system_id';

    public function items()
	{
  		return $this->belongsTo(Items::class, 'item_id', 'item_id');
	}

    /**
     * update cash sales items from updating cash sales_order
     * return true if success
     * loop through data
     */
    public static function updateCS_Items($request, $id)
    {
        $newItem                = $request->get('newItem');
        $deleteItem             = $request->get('delete_id');

        $item_id                = $request->get('item_id');
        $description            = $request->get('description');
        $quantity               = $request->get('quantity');
        $weight_unit            = $request->get('rate');
        $rate                   = $request->get('rate');
        $amount                 = $request->get('amount');
        $tax_code               = $request->get('tax_code_id');
        $tax_amount             = $request->get('tax_amount');
        $gross_amount           = $request->get('gross_amount');
        $options                = $request->get('options');
        $gift_certificate       = $request->get('gift_certificate');
        $cost_estimate_type     = $request->get('cost_estimate_type');
        $est_extended_cost      = $request->get('est_extended_cost');
        $item_memo              = $request->get('item_memo');
        $item_weight            = $request->get('item_weight');
        $manufacturer_country   = $request->get('manufacturer_country');

        if (isset($newItem)) {
            for ($i=0; $i < count($newItem); $i++) {
                $cash_sales_item                         = new CashSalesItems;
                $cash_sales_item->item_id                = $newItem[$i];
                $cash_sales_item->cash_sales_id          = $id;
                $cash_sales_item->description            = $description[$i];
                $cash_sales_item->quantity               = $quantity[$i];
                $cash_sales_item->weight_unit            = $weight_unit[$i];
                $cash_sales_item->rate                   = $rate[$i];
                $cash_sales_item->amount                 = $amount[$i];
                $cash_sales_item->tax_code               = $tax_code[$i];
                $cash_sales_item->tax_amount             = $tax_amount[$i];
                $cash_sales_item->gross_amount           = $gross_amount[$i];
                $cash_sales_item->options                = $options[$i];
                $cash_sales_item->gift_certificate       = $gift_certificate[$i];
                $cash_sales_item->cost_estimate_type     = $cost_estimate_type[$i];
                $cash_sales_item->est_extended_cost      = $est_extended_cost[$i];
                $cash_sales_item->memo                   = $item_memo[$i];
                $cash_sales_item->item_weight            = $item_weight[$i];
                $cash_sales_item->manufacturer_country   = $manufacturer_country[$i];
                $cash_sales_item->created_by             = 1;
                $cash_sales_item->dt_created             = date('Y-m-d H:i:s');
                $cash_sales_item->status                 = 'Active';
                $cash_sales_item->save();
            }
        }

        if (isset($deleteItem)) {
            for ($i=0; $i < count($deleteItem); $i++) {
                $delete = self::find($deleteItem[$i])->delete();
            }
        }

        for ($i=0; $i < count($item_id); $i++) {

            $cash_sales_item                         = self::find($item_id[$i]);
            $cash_sales_item->cash_sales_id          = $id;
            $cash_sales_item->description            = $description[$i];
            $cash_sales_item->quantity               = $quantity[$i];
            $cash_sales_item->weight_unit            = $weight_unit[$i];
            $cash_sales_item->rate                   = $rate[$i];
            $cash_sales_item->amount                 = $amount[$i];
            $cash_sales_item->tax_code               = $tax_code[$i];
            $cash_sales_item->tax_amount             = $tax_amount[$i];
            $cash_sales_item->gross_amount           = $gross_amount[$i];
            $cash_sales_item->options                = $options[$i];
            $cash_sales_item->gift_certificate       = $gift_certificate[$i];
            $cash_sales_item->cost_estimate_type     = $cost_estimate_type[$i];
            $cash_sales_item->est_extended_cost      = $est_extended_cost[$i];
            $cash_sales_item->memo                   = $item_memo[$i];
            $cash_sales_item->item_weight            = $item_weight[$i];
            $cash_sales_item->manufacturer_country   = $manufacturer_country[$i];
            $cash_sales_item->created_by             = 1;
            $cash_sales_item->dt_created             = date('Y-m-d H:i:s');
            $cash_sales_item->status                 = 'Active';
            $cash_sales_item->update();
        }
    }
}
