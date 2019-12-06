<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StyleVariations extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'style_variations';

    public $primaryKey = 'style_variation_id';

    public $timestamps = false;

    /**
     * store new Style Variations
     * Return boolean true or false if saving was successful
     */
    public static function store_styleVariation ($request)
    {
        $styleVariation                    = new StyleVariations;
        $styleVariation->name              = $request->get('name');
        $styleVariation->abbreviation      = $request->get('abbreviation');
        $styleVariation->idx               = $request->get('idx');
        $styleVariation->created_by        = '1';
        $styleVariation->dt_created        = date('Y-m-d, H:i:s');
        $styleVariation->status            = 'Active';

        if ($styleVariation->save()){
            return true;
        } else {
            return false;
        }
    }

    /**
     * update Style Variations
     * Return boolean true or false if updating was successful
     */
    public static function update_styleVariation ($request, $id)
    {
        $styleVariation                    = self::find($id);
        $styleVariation->name              = $request->get('name');
        $styleVariation->abbreviation      = $request->get('abbreviation');
        $styleVariation->idx               = $request->get('idx');
        $styleVariation->lupd_by           = '1';
        $styleVariation->dt_lupd           = date('Y-m-d, H:i:s');
        $styleVariation->status            = 'Active';

        if ($styleVariation->update()) {
            return true;
        } else {
            return false;
        }
    }
}
