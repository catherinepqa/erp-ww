<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaxCodes extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tax_codes';

    public $primaryKey = 'tax_code_id';

    public $timestamps = false;

    /**
     * store new Tax Code
     * Return boolean true or false if saving was successful
     */
    public static function store_taxCode ($request)
    {
        $taxCode                    = new TaxCodes;
        $taxCode->code              = $request->get('code');
        $taxCode->description       = $request->get('description');
        $taxCode->rate              = $request->get('rate');
        $taxCode->effective_from    = date('Y-m-d', strtotime($request->get('effective_from')));
        $taxCode->valid_until       = date('Y-m-d', strtotime($request->get('valid_until')));
        $taxCode->tax_agency        = $request->get('tax_agency');

        if ($taxCode->save()){
            return true;
        } else {
            return false;
        }
    }

    /**
     * update Tax Code
     * Return boolean true or false if updating was successful
     */
    public static function update_taxCode ($request, $id)
    {
        $taxCode                    = self::find($id);
        $taxCode->code              = $request->get('code');
        $taxCode->description       = $request->get('description');
        $taxCode->rate              = $request->get('rate');
        $taxCode->effective_from    = date('Y-m-d', strtotime($request->get('effective_from')));
        $taxCode->valid_until       = date('Y-m-d', strtotime($request->get('valid_until')));
        $taxCode->tax_agency        = $request->get('tax_agency');

        if ($taxCode->update()) {
            return true;
        } else {
            return false;
        }
    }
}
