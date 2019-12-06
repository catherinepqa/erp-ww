<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnitOfMeasures extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'unit_of_measures';

    public $primaryKey = 'unit_type_id';

    public $timestamps = false;

    public function items()
	{
  		return $this->hasOne(Items::class, 'stock_unit', 'unit_type_id');
	}

    /**
     * store new Unit of Measures
     * Return boolean true or false if saving was successful
     */
    public static function store_unitOfMeasure ($request)
    {
        $unitOfMeasure                       = new UnitOfMeasures;
        $unitOfMeasure->name                 = $request->get('name');
        $unitOfMeasure->abbreviation         = $request->get('abbreviation');
        $unitOfMeasure->plural_name          = $request->get('plural_name');
        $unitOfMeasure->plural_abbreviation  = $request->get('plural_abbreviation');
        $unitOfMeasure->conversion_rate      = $request->get('conversion_rate');
        $unitOfMeasure->base_unit            = $request->get('base_unit');
        $unitOfMeasure->subunit_type_id      = $request->get('subunit_type_id');
        $unitOfMeasure->created_by           = '1';
        $unitOfMeasure->date_created         = date('Y-m-d, H:i:s');
        $unitOfMeasure->status               = 'Active';

        if ($unitOfMeasure->save()){
            return true;
        } else {
            return false;
        }
    }

    /**
     * update Unit of Measures
     * Return boolean true or false if updating was successful
     */
    public static function update_unitOfMeasure ($request, $id)
    {
        $unitOfMeasure                       = self::find($id);
        $unitOfMeasure->name                 = $request->get('name');
        $unitOfMeasure->abbreviation         = $request->get('abbreviation');
        $unitOfMeasure->plural_name          = $request->get('plural_name');
        $unitOfMeasure->plural_abbreviation  = $request->get('plural_abbreviation');
        $unitOfMeasure->conversion_rate      = $request->get('conversion_rate');
        $unitOfMeasure->base_unit            = $request->get('base_unit');
        $unitOfMeasure->subunit_type_id      = $request->get('subunit_type_id');
        $unitOfMeasure->lupd_by              = '1';
        $unitOfMeasure->dt_lupd              = date('Y-m-d, H:i:s');
        $unitOfMeasure->status               = 'Active';

        if ($unitOfMeasure->update()) {
            return true;
        } else {
            return false;
        }
    }
}
