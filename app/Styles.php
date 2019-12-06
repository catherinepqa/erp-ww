<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Styles extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'styles';

    public $primaryKey = 'style_id';

    public $timestamps = false;

    /**
     * store new Styles
     * Return boolean true or false if saving was successful
     */
    public static function store_style ($request)
    {
        $style                    = new Styles;
        $style->name              = $request->get('name');
        $style->abbreviation      = $request->get('abbreviation');
        $style->idx               = $request->get('idx');
        $style->created_by        = '1';
        $style->dt_created        = date('Y-m-d, H:i:s');
        $style->status            = 'Active';

        if ($style->save()){
            return true;
        } else {
            return false;
        }
    }

    /**
     * update Styles
     * Return boolean true or false if updating was successful
     */
    public static function update_style ($request, $id)
    {
        $style                    = self::find($id);
        $style->name              = $request->get('name');
        $style->abbreviation      = $request->get('abbreviation');
        $style->idx               = $request->get('idx');
        $style->lupd_by           = '1';
        $style->dt_lupd           = date('Y-m-d, H:i:s');
        $style->status            = 'Active';

        if ($style->update()) {
            return true;
        } else {
            return false;
        }
    }
}
