<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CashSalesItems;

class CashSales extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cash_sales';

    public $timestamps = false;

    public $primaryKey = 'cash_sales_id';



    /**
     * store new Cash Sale
     * Return boolean true or false if saving was successful
     */
    public static function storeCashSale ($request)
    {
        date_default_timezone_set('Asia/Manila');
        $cashSales                          = new CashSales;
        $cashSales->cs_date                 = $request->get('cs_date');
        $cashSales->customer_id             = $request->get('customer_id');
        $cashSales->posting_date            = (empty($request->get('posting_date')) ? date('M-Y', strtotime($request->get('posting_date'))) : '');
        $cashSales->cheque_no               = $request->get('cheque_no');
        $cashSales->memo                    = $request->get('memo');
        $cashSales->location_id             = $request->get('location_id');
        $cashSales->department_id           = $request->get('department_id');
        $cashSales->bill_to                 = $request->get('bill_to');
        $cashSales->billing_address         = $request->get('billing_address');
        $cashSales->shipping_carrier_id     = $request->get('shipping_carrier_id');
        $cashSales->shipping_method         = $request->get('shipping_method');
        $cashSales->shipping_cost           = $request->get('shipping_cost');
        $cashSales->shipping_tax_code_id    = $request->get('shipping_tax_code_id');
        $cashSales->shipping_tax_rate       = $request->get('shipping_tax_rate');
        $cashSales->undep_funds             = $request->get('undep_funds');
        $cashSales->account                 = $request->get('account');
        $cashSales->currency_id             = $request->get('currency_id');
        $cashSales->exchange_rate           = $request->get('exchange_rate');
        $cashSales->created_by              = 1;
        $cashSales->dt_created              = date('Y-m-d H:i:s');
        $cashSales->status                  = 'Active';



        if ($cashSales->save()) {
            $new_cash_sale                 = self::find($cashSales->cash_sales_id);
            $new_cash_sale->reference_no   = 'CS00000000' . $new_cash_sale->cash_sales_id;

            if ($new_cash_sale->update()) {

                $item_id                = $request->get('item_id');
                $description            = $request->get('description');
                $quantity               = $request->get('quantity');
                $weight_unit            = $request->get('rate');
                $rate                   = $request->get('rate');
                $amount                 = $request->get('amount');
                $tax_code               = $request->get('tax_code_id');
                $tax_amount             = $request->get('tax_amount');
                $gross_amount           = $request->get('gross_amount');
                $options                = $request->get('options');
                $gift_certificate       = $request->get('gift_certificate');
                $cost_estimate_type     = $request->get('cost_estimate_type');
                $est_extended_cost      = $request->get('est_extended_cost');
                $item_memo              = $request->get('item_memo');
                $item_weight            = $request->get('item_weight');
                $manufacturer_country   = $request->get('manufacturer_country');

                for ($i=0; $i<count($item_id); $i++) {

                    $cash_sales_item                         = new CashSalesItems;
                    $cash_sales_item->item_id                = $item_id[$i];
                    $cash_sales_item->cash_sales_id          = $new_cash_sale->cash_sales_id;
                    $cash_sales_item->description            = (array_key_exists($item_id[$i], $description) ? $description[$item_id[$i]] : '');
                    $cash_sales_item->quantity               = (array_key_exists($item_id[$i], $quantity) ? $quantity[$item_id[$i]] : '');
                    $cash_sales_item->weight_unit            = (array_key_exists($item_id[$i], $weight_unit) ? $weight_unit[$item_id[$i]] : '');
                    $cash_sales_item->rate                   = (array_key_exists($item_id[$i], $rate) ? $rate[$item_id[$i]] : '');
                    $cash_sales_item->amount                 = (array_key_exists($item_id[$i], $amount) ? $amount[$item_id[$i]] : '');
                    $cash_sales_item->tax_code               = (array_key_exists($item_id[$i], $tax_code) ? $tax_code[$item_id[$i]] : '');
                    $cash_sales_item->tax_amount             = (array_key_exists($item_id[$i], $tax_amount) ? $tax_amount[$item_id[$i]] : '');
                    $cash_sales_item->gross_amount           = (array_key_exists($item_id[$i], $gross_amount) ? $gross_amount[$item_id[$i]] : '');
                    $cash_sales_item->options                = (array_key_exists($item_id[$i], $options) ? $options[$item_id[$i]] : '');
                    $cash_sales_item->gift_certificate       = (array_key_exists($item_id[$i], $gift_certificate) ? $gift_certificate[$item_id[$i]] : '');
                    $cash_sales_item->cost_estimate_type     = (array_key_exists($item_id[$i], $cost_estimate_type) ? $cost_estimate_type[$item_id[$i]] : '');
                    $cash_sales_item->est_extended_cost      = (array_key_exists($item_id[$i], $est_extended_cost) ? $est_extended_cost[$item_id[$i]] : '');
                    $cash_sales_item->memo                   = (array_key_exists($item_id[$i], $item_memo) ? $item_memo[$item_id[$i]] : '');
                    $cash_sales_item->item_weight            = (array_key_exists($item_id[$i], $item_weight) ? $item_weight[$item_id[$i]] : '');
                    $cash_sales_item->manufacturer_country   = (array_key_exists($item_id[$i], $manufacturer_country) ? $manufacturer_country[$item_id[$i]] : '');
                    $cash_sales_item->created_by             = 1;
                    $cash_sales_item->dt_created             = date('Y-m-d H:i:s');
                    $cash_sales_item->status                 = 'Active';
                    $cash_sales_item->save();

                }
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * update Cash Sales Items
     * Return boolean true or false if updating was successful
     */
    public static function updateData ($request, $id)
    {
        $cashSales                          = self::find($id);
        $cashSales->cs_date                 = $request->get('cs_date');
        $cashSales->customer_id             = $request->get('customer_id');
        $cashSales->posting_date            = (empty($request->get('posting_date')) ? date('M-Y', strtotime($request->get('posting_date'))) : '');
        $cashSales->cheque_no               = $request->get('cheque_no');
        $cashSales->memo                    = $request->get('memo');
        $cashSales->location_id             = $request->get('location_id');
        $cashSales->department_id           = $request->get('department_id');
        $cashSales->bill_to                 = $request->get('bill_to');
        $cashSales->billing_address         = $request->get('billing_address');
        $cashSales->shipping_carrier_id     = $request->get('shipping_carrier_id');
        $cashSales->shipping_method         = $request->get('shipping_method');
        $cashSales->shipping_cost           = $request->get('shipping_cost');
        $cashSales->shipping_tax_code_id    = $request->get('shipping_tax_code_id');
        $cashSales->shipping_tax_rate       = $request->get('shipping_tax_rate');
        $cashSales->undep_funds             = $request->get('undep_funds');
        $cashSales->account                 = $request->get('account');
        $cashSales->currency_id             = $request->get('currency_id');
        $cashSales->exchange_rate           = $request->get('exchange_rate');
        $cashSales->lupd_by                 = '1';
        $cashSales->dt_lupd                 = date('Y-m-d, H:i:s');
        $cashSales->status                  = 'Active';

        if ($cashSales->update()) {

            $items = CashSalesItems::updateCS_Items($request, $id);

            return true;
        } else {
            return false;
        }
    }
}
