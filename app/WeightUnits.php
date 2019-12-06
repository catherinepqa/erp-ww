<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WeightUnits extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'weight_units';

    public $primaryKey = 'weight_unit_id';

    public $timestamps = false;

    /**
     * store new Weight Units
     * Return boolean true or false if saving was successful
     */
    public static function store_weightUnit ($request)
    {
        $weightUnit                    = new WeightUnits;
        $weightUnit->name              = $request->get('name');
        $weightUnit->abbreviation      = $request->get('abbreviation');
        $weightUnit->base_unit         = $request->get('base_unit');
        $weightUnit->subweight_unit_id = $request->get('subweight_unit_id');
        $weightUnit->idx               = $request->get('idx');
        $weightUnit->created_by        = '1';
        $weightUnit->dt_created        = date('Y-m-d, H:i:s');
        $weightUnit->status            = 'Active';

        if ($weightUnit->save()){
            return true;
        } else {
            return false;
        }
    }

    /**
     * update Weight Units
     * Return boolean true or false if updating was successful
     */
    public static function update_weightUnit ($request, $id)
    {
        $weightUnit                    = self::find($id);
        $weightUnit->name              = $request->get('name');
        $weightUnit->abbreviation      = $request->get('abbreviation');
        $weightUnit->base_unit         = $request->get('base_unit');
        $weightUnit->subweight_unit_id = $request->get('subweight_unit_id');
        $weightUnit->idx               = $request->get('idx');
        $weightUnit->lupd_by           = '1';
        $weightUnit->dt_lupd           = date('Y-m-d, H:i:s');
        $weightUnit->status            = 'Active';

        if ($weightUnit->update()) {
            return true;
        } else {
            return false;
        }
    }
}
