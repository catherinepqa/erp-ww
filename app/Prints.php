<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prints extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'prints';

    public $primaryKey = 'print_id';

    public $timestamps = false;

    /**
     * store new Print
     * Return boolean true or false if saving was successful
     */
    public static function store_print ($request)
    {
        $print                    = new Prints;
        $print->name              = $request->get('name');
        $print->abbreviation      = $request->get('abbreviation');
        $print->idx               = $request->get('idx');
        $print->created_by        = '1';
        $print->dt_created        = date('Y-m-d, H:i:s');
        $print->status            = 'Active';

        if ($print->save()){
            return true;
        } else {
            return false;
        }
    }

    /**
     * update Print
     * Return boolean true or false if updating was successful
     */
    public static function update_print ($request, $id)
    {
        $print                    = self::find($id);
        $print->name              = $request->get('name');
        $print->abbreviation      = $request->get('abbreviation');
        $print->idx               = $request->get('idx');
        $print->lupd_by           = '1';
        $print->dt_lupd           = date('Y-m-d, H:i:s');
        $print->status            = 'Active';

        if ($print->update()) {
            return true;
        } else {
            return false;
        }
    }
}
