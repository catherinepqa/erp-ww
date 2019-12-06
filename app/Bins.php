<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bins extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bins';

    public $primaryKey = 'bin_id';

    public $timestamps = false;

    /**
     * Relationship with Locations / Get Locations
     *
     */

    public function locations()
	{
  		return $this->belongsTo(Locations::class, 'location_id', 'location_id');
	}

    /**
     * store new Bin
     * Return boolean true or false if saving was successful
     */
    public static function store_bin ($request)
    {
        $bin                    = new Bins;
        $bin->bin_no            = $request->get('bin_no');
        $bin->description       = $request->get('description');
        $bin->location_id       = $request->get('location_id');
        $bin->idx               = $request->get('idx');
        $bin->created_by        = '1';
        $bin->dt_created        = date('Y-m-d, H:i:s');
        $bin->status            = 'Active';

        if ($bin->save()){
            return true;
        } else {
            return false;
        }
    }

    /**
     * update Bin
     * Return boolean true or false if updating was successful
     */
    public static function update_bin ($request, $id)
    {
        $bin                    = self::find($id);
        $bin->bin_no            = $request->get('bin_no');
        $bin->description       = $request->get('description');
        $bin->location_id       = $request->get('location_id');
        $bin->idx               = $request->get('idx');
        $bin->lupd_by           = '1';
        $bin->dt_lupd           = date('Y-m-d, H:i:s');
        $bin->status            = 'Active';

        if ($bin->update()) {
            return true;
        } else {
            return false;
        }
    }
}
