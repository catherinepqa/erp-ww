<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\SalesOrderItems;

class SalesOrder extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sales_order';

    public $primaryKey = 'sales_order_id';

    public function salesorderitems()
	{
  		return $this->hasMany(SalesOrderItems::class, 'sales_order_id', 'sales_order_id');
	}
}
