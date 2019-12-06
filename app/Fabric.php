<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fabric extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fabric';

    public $primaryKey = 'fabric_id';

    public $timestamps = false;

    /**
     * store new Fabric
     * Return boolean true or false if saving was successful
     */
    public static function store_fabric ($request)
    {
        $fabric                    = new Fabric;
        $fabric->name              = $request->get('name');
        $fabric->abbreviation      = $request->get('abbreviation');
        $fabric->idx               = $request->get('idx');
        $fabric->created_by        = '1';
        $fabric->dt_created        = date('Y-m-d, H:i:s');
        $fabric->status            = 'Active';

        if ($fabric->save()){
            return true;
        } else {
            return false;
        }
    }

    /**
     * update Fabric
     * Return boolean true or false if updating was successful
     */
    public static function update_fabric ($request, $id)
    {
        $fabric                    = self::find($id);
        $fabric->name              = $request->get('name');
        $fabric->abbreviation      = $request->get('abbreviation');
        $fabric->idx               = $request->get('idx');
        $fabric->lupd_by           = '1';
        $fabric->dt_lupd           = date('Y-m-d, H:i:s');
        $fabric->status            = 'Active';

        if ($fabric->update()) {
            return true;
        } else {
            return false;
        }
    }
}
