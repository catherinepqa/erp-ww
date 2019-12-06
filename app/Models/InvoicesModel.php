<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InvoicesModel extends Model
{
    public static function createInvoice($request)
    {
        $data = [
            'reference_no' => $request->invoiceNo,
            'reference_type_id' => $request->referenceTypeID,
            'reference_id' => $request->referenceID,
            'customer_id' => $request->customerID, 
            'customer_email' => $request->customerEmail, 
            'invoice_date' => date('Y-m-d', strtotime($request->invoiceDate)),
            'posting_period' => ($request->postingPeriod == '') ? NULL : $request->postingPeriod,
            'web_status' =>($request->webStatus == '') ? NULL : $request->webStatus,
            'representative_id' => ($request->representativeID == '') ? NULL : $request->representativeID,
            'sales_effective_date' => date('Y-m-d', strtotime($request->salesEffectiveDate)),
            'department_id' => $request->departmentID,
            'location_id' => $request->locationId,
            'order_memo' => ($request->orderMemo == '') ? NULL : $request->orderMemo,
            'internal_memo' => ($request->internalMemo == '') ? NULL : $request->internalMemo,
            'coupon_code' => ($request->couponCode == '') ? NULL : $request->couponCode,
            'discount_type_id' => ($request->discountItemID == '') ? NULL : $request->discountItemID,
            'discount_rate' => ($request->discountRate == '') ? NULL : $request->discountRate,
            'shipping_date' => ($request->shippingDate == '') ? NULL : date('Y-m-d', strtotime($request->shippingDate)), 
            'shipping_carrier_id' => ($request->shippingCarrierID == '') ? NULL : $request->shippingCarrierID,
            'shipping_cost' =>($request->shippingCost == '') ? NULL : $request->shippingCost,
            'shipping_tax_code' => ($request->shippingTaxCode == '') ? NULL : $request->shippingTaxCode,
            'shipping_tax_rate' => ($request->shippingTaxRate == '') ? NULL : $request->shippingTaxRate,
            'shipping_to' => ($request->shipTo == '') ? NULL : $request->shipTo,
            'shipping_address' => ($request->shippingAddress == '') ? NULL : $request->shippingAddress,
            'balance' => ($request->balance == '') ? NULL : $request->balance,
            'billing_to' => ($request->billTo == '') ? NULL : $request->billTo,
            'billing_address' => ($request->billingAddress == '') ? NULL : $request->billingAddress,
            'account_id' => ($request->accountID == '') ? NULL : $request->accountID,
            'currency_id' => ($request->currencyID == '') ? NULL : $request->currencyID,
            'exchange_rate' => ($request->exchangeRate == '') ? NULL : $request->exchangeRate,
            'tax_id' => ($request->taxID == '') ? NULL : $request->taxID,
            'created_by' => 1,
            'dt_created' => date('Y-m-d H:i:s'),
            'status' => 'Active'
        ];

        if (DB::table('invoices')->insert($data)) {
            $id = DB::getPdo()->lastInsertId();

            if ($request->invoiceItems) self::createInvoiceItems($id, $request->invoiceItems);

            return ['success' => true, 'id' => $id];
        }
    }

    public static function createInvoiceItems($id, $dt)
    { 
        for ($i = 0; $i < count($dt); $i++) {
            $data = [
                'invoice_id' => $id, 
                'item_id' => $dt[$i]['itemID'], 
                'quantity' =>  $dt[$i]['quantity'], 
                'amount' =>  $dt[$i]['amount'],
                'tax_code' => $dt[$i]['taxCodeID'],
                'total' =>  $dt[$i]['grossAmount'],
                'created_by' => 1,
                'dt_created' => date('Y-m-d H:i:s'),
                'status' => 'Active'
            ];

            DB::table('invoice_items')->insert($data);
        }
    }
}
