<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TopSizes extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'top_sizes';

    public $primaryKey = 'top_size_id';

    public $timestamps = false;

    /**
     * store new Top Size
     * Return boolean true or false if saving was successful
     */
    public static function store_topSize ($request)
    {
        $topSize                    = new TopSizes;
        $topSize->name              = $request->get('name');
        $topSize->abbreviation      = $request->get('abbreviation');
        $topSize->idx               = $request->get('idx');
        $topSize->created_by        = '1';
        $topSize->dt_created        = date('Y-m-d, H:i:s');
        $topSize->status            = 'Active';

        if ($topSize->save()){
            return true;
        } else {
            return false;
        }
    }

    /**
     * update Top Size
     * Return boolean true or false if updating was successful
     */
    public static function update_topSize ($request, $id)
    {
        $topSize                    = self::find($id);
        $topSize->name              = $request->get('name');
        $topSize->abbreviation      = $request->get('abbreviation');
        $topSize->idx               = $request->get('idx');
        $topSize->lupd_by           = '1';
        $topSize->dt_lupd           = date('Y-m-d, H:i:s');
        $topSize->status            = 'Active';

        if ($topSize->update()) {
            return true;
        } else {
            return false;
        }
    }
}
