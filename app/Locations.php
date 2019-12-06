<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'locations';

    public $primaryKey = 'location_id';

    public $timestamps = false;

    /**
     * Relationship with Bins table/model
     *
     */
    public function bins()
	{
  		return $this->hasMany(Bins::class, 'location_id', 'location_id');
	}

    /**
     * Relationship with Countries / Get Countries
     *
     */
    public function countries()
	{
  		return $this->belongsTo(Countries::class, 'country_id', 'country_id');
	}


    /**
     * store new Location
     * Return boolean true or false if saving was successful
     */
    public static function store_location ($request)
    {
        $location                     = new Locations;
        $location->name               = $request->get('name');
        $location->abbreviation       = $request->get('abbreviation');
        $location->sublocation_id     = $request->get('sublocation_id');
        $location->city               = $request->get('city');
        $location->state              = $request->get('state');
        $location->country_id         = $request->get('country_id');
        $location->zip_code           = $request->get('zip_code');
        $location->address_1          = $request->get('address_1');
        $location->address_2          = $request->get('address_2');
        $location->phone_no           = $request->get('phone_no');
        $location->use_bins           = $request->get('use_bins');
        $location->idx                = $request->get('idx');
        $location->dt_created         = date('Y-m-d, H:i:s');
        $location->status             = 'Active';

        if ($location->save()){
            return true;
        } else {
            return false;
        }
    }

    /**
     * update Location
     * Return boolean true or false if updating was successful
     */
    public static function update_location ($request, $id)
    {
        $location                    = self::find($id);
        $location->name               = $request->get('name');
        $location->abbreviation       = $request->get('abbreviation');
        $location->sublocation_id     = $request->get('sublocation_id');
        $location->city               = $request->get('city');
        $location->state              = $request->get('state');
        $location->country_id         = $request->get('country_id');
        $location->zip_code           = $request->get('zip_code');
        $location->address_1          = $request->get('address_1');
        $location->address_2          = $request->get('address_2');
        $location->phone_no           = $request->get('phone_no');
        $location->use_bins           = $request->get('use_bins');
        $location->idx                = $request->get('idx');
        $location->lupd_by            = '1';
        $location->dt_lupd            = date('Y-m-d, H:i:s');
        $location->status             = 'Active';

        if ($location->update()) {
            return true;
        } else {
            return false;
        }
    }
}
