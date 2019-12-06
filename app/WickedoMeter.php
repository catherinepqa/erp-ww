<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WickedoMeter extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wicked_o_meter';

    public $primaryKey = 'wicked_o_meter_id';

    public $timestamps = false;

    /**
     * store new Wicker-O-Meter
     * Return boolean true or false if saving was successful
     */
    public static function store_wickedoMeter ($request)
    {
        $wickedoMeter                    = new WickedoMeter;
        $wickedoMeter->name              = $request->get('name');
        $wickedoMeter->idx               = $request->get('idx');
        $wickedoMeter->created_by        = '1';
        $wickedoMeter->dt_created        = date('Y-m-d, H:i:s');
        $wickedoMeter->status            = 'Active';

        if ($wickedoMeter->save()){
            return true;
        } else {
            return false;
        }
    }

    /**
     * update Wicker-O-Meter
     * Return boolean true or false if updating was successful
     */
    public static function update_wickedoMeter ($request, $id)
    {
        $wickedoMeter                    = self::find($id);
        $wickedoMeter->name              = $request->get('name');
        $wickedoMeter->idx               = $request->get('idx');
        $wickedoMeter->lupd_by           = '1';
        $wickedoMeter->dt_lupd           = date('Y-m-d, H:i:s');
        $wickedoMeter->status            = 'Active';

        if ($wickedoMeter->update()) {
            return true;
        } else {
            return false;
        }
    }
}
