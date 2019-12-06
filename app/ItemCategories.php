<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemCategories extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'item_categories';

    public $primaryKey = 'item_category_id';

    public $timestamps = false;

    /**
     * store new Item Category
     * Return boolean true or false if saving was successful
     */
    public static function store_itemCategory ($request)
    {
        $itemCategory                       = new ItemCategories;
        $itemCategory->name                 = $request->get('name');
        $itemCategory->abbreviation         = $request->get('abbreviation');
        $itemCategory->subitem_category_id  = $request->get('subitem_category_id');
        $itemCategory->idx                  = $request->get('idx');
        $itemCategory->dt_created           = date('Y-m-d, H:i:s');
        $itemCategory->status               = 'Active';

        if ($itemCategory->save()){
            return true;
        } else {
            return false;
        }
    }

    /**
     * update Item Category
     * Return boolean true or false if updating was successful
     */
    public static function update_itemCategory ($request, $id)
    {
        $itemCategory                       = self::find($id);
        $itemCategory->name                 = $request->get('name');
        $itemCategory->abbreviation         = $request->get('abbreviation');
        $itemCategory->subitem_category_id  = $request->get('subitem_category_id');
        $itemCategory->idx                  = $request->get('idx');
        $itemCategory->lupd_by              = '1';
        $itemCategory->dt_lupd              = date('Y-m-d, H:i:s');
        $itemCategory->status               = 'Active';

        if ($itemCategory->update()) {
            return true;
        } else {
            return false;
        }
    }
}
