<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BinTransfer;

class InventoryController extends Controller
{
    public function inventory_adjustment()
    {
        return view('inventory.inventory_adjustment');
    }

    public function bin_transfer()
    {
        $bin_transfers = BinTransfer::all();
        return view('inventory.bin_transfer', compact('bin_transfers'));
    }

    public function transfer_inventory()
    {
        return view('inventory.transfer_inventory');
    }

    public function reallocate_item()
    {
        return view('inventory.reallocate_item');
    }

    public function inventory_distribution()
    {
        return view('inventory.inventory_distribution');
    }

    public function transfer_order()
    {
        return view('inventory.transfer_orders');
    }

    public function order_items()
    {
        return view('inventory.order_items');
    }

    public function commit_orders()
    {
        return view('inventory.commit_orders');
    }

    public function negative_inventory()
    {
        return view('inventory.negative_inventory');
    }
}
