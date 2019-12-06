<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'departments';

    public $primaryKey = 'department_id';

    public $timestamps = false;

    /**
     * store new Department
     * Return boolean true or false if saving was successful
     */
    public static function store_department ($request)
    {
        $department                    = new Departments;
        $department->name              = $request->get('name');
        $department->abbreviation      = $request->get('abbreviation');
        $department->subdepartment_id  = $request->get('subdepartment_id');
        $department->idx               = $request->get('idx');
        $department->dt_created        = date('Y-m-d, H:i:s');
        $department->status            = 'Active';

        if ($department->save()){
            return true;
        } else {
            return false;
        }
    }

    /**
     * update Department
     * Return boolean true or false if updating was successful
     */
    public static function update_department ($request, $id)
    {
        $department                    = self::find($id);
        $department->name              = $request->get('name');
        $department->abbreviation      = $request->get('abbreviation');
        $department->subdepartment_id  = $request->get('subdepartment_id');
        $department->idx               = $request->get('idx');
        $department->lupd_by           = '1';
        $department->dt_lupd           = date('Y-m-d, H:i:s');
        $department->status            = 'Active';

        if ($department->update()) {
            return true;
        } else {
            return false;
        }
    }
}
