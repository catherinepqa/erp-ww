<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Items;

class InventoryItems extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inventory_items';

    public $primaryKey = 'system_id';

    public $timestamps = false;

    public function items()
	{
  		return $this->belongsTo(Items::class, 'item_id', 'item_id');
	}
}
