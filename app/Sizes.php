<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sizes extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sizes';

    public $primaryKey = 'size_id';

    public $timestamps = false;

    /**
     * store new Sizes
     * Return boolean true or false if saving was successful
     */
    public static function store_size ($request)
    {
        $size                    = new Sizes;
        $size->name              = $request->get('name');
        $size->abbreviation      = $request->get('abbreviation');
        $size->idx               = $request->get('idx');
        $size->created_by        = '1';
        $size->dt_created        = date('Y-m-d, H:i:s');
        $size->status            = 'Active';

        if ($size->save()){
            return true;
        } else {
            return false;
        }
    }

    /**
     * update Sizes
     * Return boolean true or false if updating was successful
     */
    public static function update_size ($request, $id)
    {
        $size                    = self::find($id);
        $size->name              = $request->get('name');
        $size->abbreviation      = $request->get('abbreviation');
        $size->idx               = $request->get('idx');
        $size->lupd_by           = '1';
        $size->dt_lupd           = date('Y-m-d, H:i:s');
        $size->status            = 'Active';

        if ($size->update()) {
            return true;
        } else {
            return false;
        }
    }
}
