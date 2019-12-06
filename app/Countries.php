<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
     protected $table = 'countries';

     public $primaryKey = 'country_id';

     public $timestamps = false;

     /**
      * Relationship with Currencies table/model
      *
      */
     public function currencies()
 	{
   		return $this->hasMany(Currencies::class, 'country_id', 'country_id');
 	}

     /**
      * Relationship with Locations table/model
      *
      */
     public function locations()
 	{
   		return $this->hasMany(Locations::class, 'country_id', 'country_id');
 	}

    /**
     * store new Country
     * Return boolean true or false if saving was successful
     */
    public static function store_country ($request)
    {
        $country                    = new Countries;
        $country->name              = $request->get('name');
        $country->abbreviation      = $request->get('abbreviation');
        $country->area_code         = $request->get('area_code');
        $country->idx               = $request->get('idx');
        $country->created_by        = '1';
        $country->dt_created        = date('Y-m-d, H:i:s');
        $country->status            = 'Active';

        if ($country->save()){
            return true;
        } else {
            return false;
        }
    }

    /**
     * update Country
     * Return boolean true or false if updating was successful
     */
    public static function update_country ($request, $id)
    {
        $country                    = self::find($id);
        $country->name              = $request->get('name');
        $country->abbreviation      = $request->get('abbreviation');
        $country->area_code         = $request->get('area_code');
        $country->idx               = $request->get('idx');
        $country->lupd_by           = '1';
        $country->dt_lupd           = date('Y-m-d, H:i:s');
        $country->status            = 'Active';

        if ($country->update()) {
            return true;
        } else {
            return false;
        }
    }
}
