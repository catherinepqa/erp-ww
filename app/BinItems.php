<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Bins;
use App\Items;

class BinItems extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bin_items';

    public $timestamps = false;

    /**
     * Relationship bin
     */
    public function bins()
	{
  		return $this->belongsTo(Bins::class, 'bin_id', 'bin_id');
	}

    /**
     * Relationship items
     */
    public function items()
	{
  		return $this->belongsTo(Items::class, 'item_id', 'item_id');
	}
}
