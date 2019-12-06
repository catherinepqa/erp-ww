<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemOptions extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'item_options';

    public $primaryKey = 'item_option_id';

    public $timestamps = false;

    /**
     * store new Item Option
     * Return boolean true or false if saving was successful
     */
    public static function store_itemOption ($request)
    {
        $itemOption                    = new ItemOptions;
        $itemOption->name              = $request->get('name');
        $itemOption->idx               = $request->get('idx');
        $itemOption->created_by        = '1';
        $itemOption->dt_created        = date('Y-m-d, H:i:s');
        $itemOption->status            = 'Active';

        if ($itemOption->save()){
            return true;
        } else {
            return false;
        }
    }

    /**
     * update Item Option
     * Return boolean true or false if updating was successful
     */
    public static function update_itemOption ($request, $id)
    {
        $itemOption                    = self::find($id);
        $itemOption->name              = $request->get('name');
        $itemOption->idx               = $request->get('idx');
        $itemOption->lupd_by           = '1';
        $itemOption->dt_lupd           = date('Y-m-d, H:i:s');
        $itemOption->status            = 'Active';

        if ($itemOption->update()) {
            return true;
        } else {
            return false;
        }
    }
}
