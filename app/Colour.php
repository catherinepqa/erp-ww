<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Colour extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'colour';

    public $primaryKey = 'colour_id';

    public $timestamps = false;

    /**
     * store new Colour
     * Return boolean true or false if saving was successful
     */
    public static function store_colour ($request)
    {
        $colour                    = new Colour;
        $colour->name              = $request->get('name');
        $colour->abbreviation      = $request->get('abbreviation');
        $colour->idx               = $request->get('idx');
        $colour->created_by        = '1';
        $colour->dt_created        = date('Y-m-d, H:i:s');
        $colour->status            = 'Active';

        if ($colour->save()){
            return true;
        } else {
            return false;
        }
    }

    /**
     * update Colour
     * Return boolean true or false if updating was successful
     */
    public static function update_colour ($request, $id)
    {
        $colour                    = self::find($id);
        $colour->name              = $request->get('name');
        $colour->abbreviation      = $request->get('abbreviation');
        $colour->idx               = $request->get('idx');
        $colour->lupd_by           = '1';
        $colour->dt_lupd           = date('Y-m-d, H:i:s');
        $colour->status            = 'Active';

        if ($colour->update()) {
            return true;
        } else {
            return false;
        }
    }
}
