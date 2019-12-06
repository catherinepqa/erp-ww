<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BinItems;
use App\UnitOfMeasures;
use App\InventoryItems;
use App\ItemTypes;
use App\CashSalesItems;

class Items extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'items';

    public $primaryKey = 'item_id';

    public function binitems()
	{
  		return $this->hasMany(BinItems::class, 'item_id', 'item_id');
	}

    public function unitofmeasures()
	{
  		return $this->hasOne(UnitOfMeasures::class, 'unit_type_id', 'stock_unit');
	}

    public function inventoryitems()
	{
  		return $this->hasMany(InventoryItems::class, 'item_id', 'item_id');
	}

    public function itemtypes()
	{
  		return $this->belongsTo(ItemTypes::class, 'item_type_id', 'item_type_id');
	}

    public function cashsalesitems()
	{
  		return $this->hasMany(CashSalesItems::class, 'item_id', 'item_id');
	}
}
