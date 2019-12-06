<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaxTypes extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tax_types';

    public $primaryKey = 'tax_type_id';

    public $timestamps = false;

    /**
     * store new Tax Type
     * Return boolean true or false if saving was successful
     */
    public static function store_taxType ($request)
    {
        $taxType                    = new TaxTypes;
        $taxType->name              = $request->get('name');
        $taxType->description       = $request->get('description');
        $taxType->idx               = $request->get('idx');
        $taxType->created_by        = '1';
        $taxType->dt_created        = date('Y-m-d, H:i:s');
        $taxType->status            = 'Active';

        if ($taxType->save()){
            return true;
        } else {
            return false;
        }
    }

    /**
     * update Tax Type
     * Return boolean true or false if updating was successful
     */
    public static function update_taxType ($request, $id)
    {
        $taxType                    = self::find($id);
        $taxType->name              = $request->get('name');
        $taxType->description       = $request->get('description');
        $taxType->idx               = $request->get('idx');
        $taxType->lupd_by           = '1';
        $taxType->dt_lupd           = date('Y-m-d, H:i:s');
        $taxType->status            = 'Active';

        if ($taxType->update()) {
            return true;
        } else {
            return false;
        }
    }
}
