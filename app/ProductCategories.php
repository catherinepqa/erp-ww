<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategories extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_categories';

    public $primaryKey = 'product_category_id';

    public $timestamps = false;

    /**
     * store new Product Categories
     * Return boolean true or false if saving was successful
     */
    public static function store_productCategory ($request)
    {
        $productCategory                    = new ProductCategories;
        $productCategory->name              = $request->get('name');
        $productCategory->idx               = $request->get('idx');
        $productCategory->created_by        = '1';
        $productCategory->dt_created        = date('Y-m-d, H:i:s');
        $productCategory->status            = 'Active';

        if ($productCategory->save()){
            return true;
        } else {
            return false;
        }
    }

    /**
     * update Product Categories
     * Return boolean true or false if updating was successful
     */
    public static function update_prouductCategory ($request, $id)
    {
        $productCategory                    = self::find($id);
        $productCategory->name              = $request->get('name');
        $productCategory->idx               = $request->get('idx');
        $productCategory->lupd_by           = '1';
        $productCategory->dt_lupd           = date('Y-m-d, H:i:s');
        $productCategory->status            = 'Active';

        if ($productCategory->update()) {
            return true;
        } else {
            return false;
        }
    }
}
