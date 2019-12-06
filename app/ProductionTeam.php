<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductionTeam extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'production_team';

    public $primaryKey = 'production_team_id';

    public $timestamps = false;

    /**
     * store new Production Team
     * Return boolean true or false if saving was successful
     */
    public static function store_productionTeam ($request)
    {
        $prodTeam                    = new ProductionTeam;
        $prodTeam->name              = $request->get('name');
        $prodTeam->abbreviation      = $request->get('abbreviation');
        $prodTeam->idx               = $request->get('idx');
        $prodTeam->dt_created        = date('Y-m-d, H:i:s');
        $prodTeam->status            = 'Active';

        if ($prodTeam->save()){
            return true;
        } else {
            return false;
        }
    }

    /**
     * update Production Team
     * Return boolean true or false if updating was successful
     */
    public static function update_productionTeam ($request, $id)
    {
        $prodTeam                    = self::find($id);
        $prodTeam->name              = $request->get('name');
        $prodTeam->abbreviation      = $request->get('abbreviation');
        $prodTeam->idx               = $request->get('idx');
        $prodTeam->lupd_by           = '1';
        $prodTeam->dt_lupd           = date('Y-m-d, H:i:s');
        $prodTeam->status            = 'Active';

        if ($prodTeam->update()) {
            return true;
        } else {
            return false;
        }
    }
}
