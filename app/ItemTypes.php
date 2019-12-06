<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemTypes extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'item_types';

    public $primaryKey = 'item_type_id';

    public $timestamps = false;

    public function items()
	{
  		return $this->hasMany(Items::class, 'item_type_id', 'item_type_id');
	}

    /**
     * store new Item Types
     * Return boolean true or false if saving was successful
     */
    public static function store_itemType ($request)
    {
        $itemType                    = new ItemTypes;
        $itemType->name              = $request->get('name');
        $itemType->idx               = $request->get('idx');
        $itemType->created_by        = '1';
        $itemType->dt_created        = date('Y-m-d, H:i:s');
        $itemType->status            = 'Active';

        if ($itemType->save()){
            return true;
        } else {
            return false;
        }
    }

    /**
     * update Item Types
     * Return boolean true or false if updating was successful
     */
    public static function update_itemType ($request, $id)
    {
        $itemType                    = self::find($id);
        $itemType->name              = $request->get('name');
        $itemType->idx               = $request->get('idx');
        $itemType->lupd_by           = '1';
        $itemType->dt_lupd           = date('Y-m-d, H:i:s');
        $itemType->status            = 'Active';

        if ($itemType->update()) {
            return true;
        } else {
            return false;
        }
    }
}
