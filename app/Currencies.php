<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currencies extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'currencies';

    public $primaryKey = 'currency_id';

    public $timestamps = false;

    /**
     * Relationship with Countries / Get Countries
     *
     */

    public function countries()
	{
  		return $this->belongsTo(Countries::class, 'country_id', 'country_id');
	}

    /**
     * Relationship with ExchangeRates table/model
     *
     */
    public function exchangeRates()
	{
  		return $this->hasMany(ExchangeRates::class, 'currency_id', 'currency_id');
	}

    /**
     * store new Currency
     * Return boolean true or false if saving was successful
     */
    public static function store_currency ($request)
    {
        $currency                    = new Currencies;
        $currency->name              = $request->get('name');
        $currency->country_id        = $request->get('country_id');
        $currency->iso_code          = $request->get('iso_code');
        $currency->symbol            = $request->get('symbol');
        $currency->idx               = $request->get('idx');
        $currency->created_by        = '1';
        $currency->dt_created        = date('Y-m-d, H:i:s');
        $currency->status            = 'Active';

        if ($currency->save()){
            return true;
        } else {
            return false;
        }
    }

    /**
     * update Currency
     * Return boolean true or false if updating was successful
     */
    public static function update_currency ($request, $id)
    {
        $currency                    = self::find($id);
        $currency->name              = $request->get('name');
        $currency->country_id        = $request->get('country_id');
        $currency->iso_code          = $request->get('iso_code');
        $currency->symbol            = $request->get('symbol');
        $currency->idx               = $request->get('idx');
        $currency->lupd_by           = '1';
        $currency->dt_lupd           = date('Y-m-d, H:i:s');
        $currency->status            = 'Active';

        if ($currency->update()) {
            return true;
        } else {
            return false;
        }
    }
}
