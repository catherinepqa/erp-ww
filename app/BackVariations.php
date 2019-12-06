<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BackVariations extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'back_variations';

    public $primaryKey = 'back_variation_id';

    public $timestamps = false;

    /**
     * store new Back Variations
     * Return boolean true or false if saving was successful
     */
    public static function store_backVariation ($request)
    {
        $backVariation                    = new BackVariations;
        $backVariation->name              = $request->get('name');
        $backVariation->abbreviation      = $request->get('abbreviation');
        $backVariation->idx               = $request->get('idx');
        $backVariation->created_by        = '1';
        $backVariation->dt_created        = date('Y-m-d, H:i:s');
        $backVariation->status            = 'Active';

        if ($backVariation->save()){
            return true;
        } else {
            return false;
        }
    }

    /**
     * update Back Variations
     * Return boolean true or false if updating was successful
     */
    public static function update_backVariation ($request, $id)
    {
        $backVariation                    = self::find($id);
        $backVariation->name              = $request->get('name');
        $backVariation->abbreviation      = $request->get('abbreviation');
        $backVariation->idx               = $request->get('idx');
        $backVariation->lupd_by           = '1';
        $backVariation->dt_lupd           = date('Y-m-d, H:i:s');
        $backVariation->status            = 'Active';

        if ($backVariation->update()) {
            return true;
        } else {
            return false;
        }
    }
}
