<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingCarrier extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shipping_carrier';

    public $primaryKey = 'shipping_carrier_id';

    public $timestamps = false;

    /**
     * store new Shipping Carrier
     * Return boolean true or false if saving was successful
     */
    public static function store_shippingCarrier ($request)
    {
        $shippingCarrier                    = new ShippingCarrier;
        $shippingCarrier->name              = $request->get('name');
        $shippingCarrier->description       = $request->get('description');

        if ($shippingCarrier->save()){
            return true;
        } else {
            return false;
        }
    }

    /**
     * update Shipping Carrier
     * Return boolean true or false if updating was successful
     */
    public static function update_shippingCarrier ($request, $id)
    {
        $shippingCarrier                    = self::find($id);
        $shippingCarrier->name              = $request->get('name');
        $shippingCarrier->description       = $request->get('description');

        if ($shippingCarrier->update()) {
            return true;
        } else {
            return false;
        }
    }
}
