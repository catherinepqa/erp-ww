<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CashSales;

class SalesController extends Controller
{
    public function sales_order()
    {
        return view('sales.sales_order');
    }

    public function invoices()
    {
        return view('sales.invoices');
    }

    public function cashsales()
    {
        $cashSales = CashSales::all();
        return view('sales.cashsales', compact('cashSales'));
    }

    public function item_reciept()
    {
        return view('sales.item_receipt');
    }

    public function credit_memo()
    {
        return view('sales.credit_memo');
    }

    public function order_assessment()
    {
        return view('sales.order_assessment');
    }

    public function combine_order()
    {
        return view('sales.combine_orders');
    }

    public function customisation()
    {
        return view('sales.customisation');
    }

    public function cancellation()
    {
        return view('sales.cancellation');
    }

    public function packing_shipping()
    {
        return view('sales.packing_shipping');
    }

    public function currency_exchange()
    {
        return view('sales.currency_exchange');
    }
}
