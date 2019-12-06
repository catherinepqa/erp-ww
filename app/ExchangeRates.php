<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExchangeRates extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'exchange_rates';

    public $primaryKey = 'system_id';

    public $timestamps = false;

    /**
     * Relationship with Currencies / Get Currencies
     *
     */
    public function currencies()
	{
  		return $this->belongsTo(Currencies::class, 'currency_id', 'currency_id');
	}

    /**
     * store new Exchange Rate
     * Return boolean true or false if saving was successful
     */
    public static function store_exchangeRate ($request)
    {
        $exchangeRate                    = new ExchangeRates;
        $exchangeRate->currency_id       = $request->get('currency_id');
        $exchangeRate->amount            = $request->get('amount');
        $exchangeRate->effective_date    = date('Y-m-d', strtotime($request->get('effective_date')));
        $exchangeRate->created_by        = '1';
        $exchangeRate->dt_created        = date('Y-m-d, H:i:s');
        $exchangeRate->status            = 'Active';

        if ($exchangeRate->save()){
            return true;
        } else {
            return false;
        }
    }

    /**
     * update Exchange Rate
     * Return boolean true or false if updating was successful
     */
    public static function update_exchangeRate ($request, $id)
    {
        $exchangeRate                    = self::find($id);
        $exchangeRate->currency_id       = $request->get('currency_id');
        $exchangeRate->amount            = $request->get('amount');
        $exchangeRate->effective_date    = date('Y-m-d', strtotime($request->get('effective_date')));
        $exchangeRate->lupd_by           = '1';
        $exchangeRate->dt_lupd           = date('Y-m-d, H:i:s');
        $exchangeRate->status            = 'Active';

        if ($exchangeRate->update()) {
            return true;
        } else {
            return false;
        }
    }
}
