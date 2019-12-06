<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrouserLength extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trouser_length';

    public $primaryKey = 'trouser_length_id';

    public $timestamps = false;

    /**
     * store new Trouser Length
     * Return boolean true or false if saving was successful
     */
    public static function store_trouserLength ($request)
    {
        $trouserLength                    = new TrouserLength;
        $trouserLength->name              = $request->get('name');
        $trouserLength->abbreviation      = $request->get('abbreviation');
        $trouserLength->idx               = $request->get('idx');
        $trouserLength->created_by        = '1';
        $trouserLength->dt_created        = date('Y-m-d, H:i:s');
        $trouserLength->status            = 'Active';

        if ($trouserLength->save()){
            return true;
        } else {
            return false;
        }
    }

    /**
     * update Trouser Length
     * Return boolean true or false if updating was successful
     */
    public static function update_trouserLength ($request, $id)
    {
        $trouserLength                    = self::find($id);
        $trouserLength->name              = $request->get('name');
        $trouserLength->abbreviation      = $request->get('abbreviation');
        $trouserLength->idx               = $request->get('idx');
        $trouserLength->lupd_by           = '1';
        $trouserLength->dt_lupd           = date('Y-m-d, H:i:s');
        $trouserLength->status            = 'Active';

        if ($trouserLength->update()) {
            return true;
        } else {
            return false;
        }
    }
}
