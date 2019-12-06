<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SalesOrderModel extends Model
{
    public static function getSalesOrder()
    {
        $sales_order = DB::table("sales_order")
                    ->join('customers', 'sales_order.customer_id', '=', 'customers.customer_id')
                    ->select('sales_order.sales_order_id', 'sales_order.reference_no', 'sales_order.so_date',
                        'customers.customer_id', 'customers.lname', 'customers.fname', 'customers.mname')
                    ->orderBy('sales_order_id')
                    ->get();

         return $sales_order;
    }

    public static function getCurrencies()
    {
       $currencies = DB::table("currencies")
                    ->leftJoin('exchange_rates', function($join) 
                        {
                            $join->on('exchange_rates.currency_id', '=', 'currencies.currency_id');

                        })
                    ->select('currencies.currency_id', 'currencies.name', 'exchange_rates.amount AS rate')
                    ->where('currencies.status', 'Active')
                    ->orderBy('currencies.idx')
                    ->get();

         return $currencies;
    }

    public static function getItemsByName($request)
    {
       $items = DB::table("items")
                    ->join('unit_of_measures', 'items.unit_type', '=', 'unit_of_measures.unit_type_id')
                    ->join('tax_codes', 'items.tax_code', '=', 'tax_codes.tax_code_id')
                    ->join('tax_types', 'tax_codes.tax_type_id', '=', 'tax_types.tax_type_id')
                    ->leftJoin('inventory_items', function($join) use ($request)
                        {
                            $join->on('inventory_items.item_id', '=', 'items.item_id');
                            $join->on('inventory_items.location_id', '=', DB::raw($request->locationID));

                        })
                    ->leftJoin('price_levels', function($join) use ($request)
                        {
                            $join->on('price_levels.item_id', '=', 'items.item_id');
                            $join->on('price_levels.currency_id', '=', DB::raw($request->currencyID));

                        })
                    ->select('items.item_id', 'items.item_name as name', 'items.item_description', 'items.cost_estimate_type_id', 'items.item_defined_cost',
                        'unit_of_measures.unit_type_id', 'unit_of_measures.abbreviation as unit_type', 
                        'tax_codes.tax_code_id', 'tax_codes.code as tax_code', 'tax_codes.rate as tax_rate', 'tax_types.name as tax_type',
                        'inventory_items.system_id', 'inventory_items.qty_on_hand',
                        'price_levels.amount')
                    ->where('items.item_name', 'LIKE', "%{$request->itemName}%")
                    ->orderBy('items.item_name')
                    ->get();

         return $items;
    }

    public static function createSalesOrder($request)
    {
        $data = [
            'reference_no' => $request->salesOrderNo,
            'customer_id' => $request->customerID, 
            'customer_email' => $request->customerEmail, 
            'so_date' => date('Y-m-d', strtotime($request->salesOrderDate)),
            'sales_effective_date' => date('Y-m-d', strtotime($request->salesEffectiveDate)),
            'po_no' => ($request->poNo == '') ? NULL : $request->poNo,
            'internal_status' => $request->internalStatus,
            'web_status' => $request->webStatus,
            'department_id' => $request->departmentID,
            'location_id' => $request->locationId,
            'customer_memo' => ($request->customerMemo == '') ? NULL : $request->customerMemo,
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
            'term_id' => ($request->termID == '') ? NULL : $request->termID,
            'billing_to' => ($request->billTo == '') ? NULL : $request->billTo,
            'billing_address' => ($request->billingAddress == '') ? NULL : $request->billingAddress,
            'payment_method_id' => ($request->paymentMethodID == '') ? NULL : $request->paymentMethodID,
            'currency_id' => ($request->currencyID == '') ? NULL : $request->currencyID,
            'exchange_rate' => ($request->exchangeRate == '') ? NULL : $request->exchangeRate,
            'created_by' => 1,
            'dt_created' => date('Y-m-d H:i:s'),
            'status' => 'Active'
        ];

        if (DB::table('sales_order')->insert($data)) {
            $id = DB::getPdo()->lastInsertId();

            if ($request->salesOrderItems) self::createSalesOrderItems($id, $request->salesOrderItems);

            return ['success' => true, 'id' => $id];
        }
    }

    public static function createSalesOrderItems($id, $dt)
    { 
        for ($i = 0; $i < count($dt); $i++) {
            $data = [
                'sales_order_id' => $id, 
                'item_id' => $dt[$i]['itemID'], 
                'quantity' =>  $dt[$i]['quantity'], 
                'unit_type_id' => $dt[$i]['unitTypeID'],
                'tax_code' => $dt[$i]['taxCodeID'],
                'tax_rate' => $dt[$i]['taxRate'],
                'rate' =>  $dt[$i]['rate'],
                'amount' =>  $dt[$i]['amount'],
                'gross_amount' =>  $dt[$i]['grossAmount'],
                'tax_amount' =>  $dt[$i]['taxAmount'],
                'commit_id' =>  $dt[$i]['commitID'],
                'order_priority' => ($dt[$i]['orderPriority'] == '') ? NULL : $dt[$i]['orderPriority'],
                'cost_estimate_type_id' => ($dt[$i]['costEstimateTypeID'] == '') ? NULL : $dt[$i]['costEstimateTypeID'],
                'est_extended_cost' => ($dt[$i]['estExtendedCost'] == '') ? NULL : $dt[$i]['estExtendedCost'],
                'create_wo' => $dt[$i]['createWO'],
                'create_customisation' =>  $dt[$i]['createCustomisation'],
                'customisation_name' => ($dt[$i]['customisationName'] == '') ? NULL : $dt[$i]['customisationName'],
                'customisation_notes' => ($dt[$i]['customisationNotes'] == '') ? NULL : $dt[$i]['customisationNotes'],
                'created_by' => 1,
                'dt_created' => date('Y-m-d H:i:s'),
                'status' => 'Active'
            ];

            DB::table('sales_order_items')->insert($data);
        }
    }

    public static function getSalesOrderBySalesOrderID($id)
    {
        /*$sales_order = DB::table("sales_order")
                    ->join('customers', 'sales_order.customer_id', '=', 'customers.customer_id')
                    ->select('sales_order.*', 
                        'customers.lname', 'customers.fname', 'customers.mname')
                    ->where('sales_order.sales_order_id', $id)
                    ->first();*/

        $sql = "SELECT
                    sales_order.*, sales_order.shipping_tax_code shipping_tax_code_id,
                    customers.lname, customers.fname, customers.mname, 
                    GROUP_CONCAT(CASE WHEN status.status_id = sales_order.internal_status THEN status.name END) internal_status_description,
                    GROUP_CONCAT(CASE WHEN status.status_id = sales_order.web_status THEN status.name END) web_status_description,
                    departments.name department,
                    locations.name location,
                    discount_type.name discount_type,
                    shipping_carrier.name shipping_carrier,
                    tax_codes.tax_code shipping_tax_code,
                    terms.name terms,
                    payment_methods.name payment_method,
                    currencies.name currency
                FROM
                    sales_order
                    INNER JOIN customers 
                        ON (customers.customer_id = sales_order.customer_id)
                    INNER JOIN status
                        ON (FIND_IN_SET(status.status_id, CONCAT(sales_order.internal_status, ',', sales_order.web_status)))
                    INNER JOIN departments
                        ON (departments.department_id = sales_order.department_id)
                    INNER JOIN locations
                        ON (locations.location_id = sales_order.location_id)
                    LEFT JOIN discount_type
                        ON (discount_type.discount_type_id = sales_order.discount_type_id)
                    LEFT JOIN shipping_carrier
                        ON (shipping_carrier.shipping_carrier_id = sales_order.shipping_carrier_id)
                    LEFT JOIN
                        (
                            SELECT tax_codes.tax_code_id, CONCAT(tax_types.name, ' : ', tax_codes.code) tax_code
                            FROM tax_codes
                                INNER JOIN tax_types
                                ON (tax_types.tax_type_id = tax_codes.tax_type_id)
                        ) tax_codes
                        ON (tax_codes.tax_code_id = sales_order.shipping_tax_code)
                    LEFT JOIN terms
                        ON (terms.term_id = sales_order.term_id)
                    LEFT JOIN payment_methods
                        ON (payment_methods.payment_method_id = sales_order.payment_method_id)
                    LEFT JOIN currencies
                        ON (currencies.currency_id = sales_order.currency_id)
                WHERE sales_order_id = :id
                GROUP BY 
                    sales_order.sales_order_id";

        $sales_order = DB::select($sql, ['id' => $id])[0];

        return $sales_order;
    }

     public static function getSalesOrderItemsBySalesOrderID($id, $location_id)
    {
        $sales_order_items = DB::table("sales_order_items")
                    ->join('items', 'sales_order_items.item_id', '=', 'items.item_id')
                    ->join('unit_of_measures', 'sales_order_items.unit_type_id', '=', 'unit_of_measures.unit_type_id')
                    ->join('tax_codes', 'sales_order_items.tax_code', '=', 'tax_codes.tax_code_id')
                    ->join('tax_types', 'tax_codes.tax_type_id', '=', 'tax_types.tax_type_id')
                    ->join('commit', 'sales_order_items.commit_id', '=', 'commit.commit_id')
                    ->join('cost_estimate_type', 'sales_order_items.cost_estimate_type_id', '=', 'cost_estimate_type.cost_estimate_type_id')
                    ->select(
                        'sales_order_items.*', 'sales_order_items.tax_code AS tax_code_id',
                         DB::raw("(SELECT qty_on_hand 
                                   FROM inventory_items W
                                   WHERE item_id = sales_order_items.item_id AND location_id = ". $location_id .") AS qty_on_hand"),
                        'items.item_name', 'items.item_description',
                        'unit_of_measures.abbreviation AS unit_type',
                        'tax_codes.code AS tax_code', 'tax_types.name AS tax_type',
                        'commit.name AS commit',
                        'cost_estimate_type.name AS cost_estimate_type'
                    )
                    ->where('sales_order_items.sales_order_id', $id)
                    ->get();

        return $sales_order_items;
    }

    public static function updateSalesOrder($request)
    {
        $data = [
            'reference_no' => $request->salesOrderNo,
            'customer_id' => $request->customerID, 
            'customer_email' => $request->customerEmail, 
            'so_date' => date('Y-m-d', strtotime($request->salesOrderDate)),
            'sales_effective_date' => date('Y-m-d', strtotime($request->salesEffectiveDate)),
            'po_no' => ($request->poNo == '') ? NULL : $request->poNo,
            'internal_status' => $request->internalStatus,
            'web_status' => $request->webStatus,
            'department_id' => $request->departmentID,
            'location_id' => $request->locationId,
            'customer_memo' => ($request->customerMemo == '') ? NULL : $request->customerMemo,
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
            'term_id' => ($request->termID == '') ? NULL : $request->termID,
            'billing_to' => ($request->billTo == '') ? NULL : $request->billTo,
            'billing_address' => ($request->billingAddress == '') ? NULL : $request->billingAddress,
            'payment_method_id' => ($request->paymentMethodID == '') ? NULL : $request->paymentMethodID,
            'currency_id' => ($request->currencyID == '') ? NULL : $request->currencyID,
            'exchange_rate' => ($request->exchangeRate == '') ? NULL : $request->exchangeRate,
            'lupd_by' => 1,
            'dt_lupd' => date('Y-m-d H:i:s')
        ];

        if (DB::table('sales_order')->where('sales_order_id', $request->salesOrderID)->update($data)) {
            
            if ($request->salesOrderItems) self::updateSalesOrderItems($request->salesOrderID, $request->salesOrderItems);

            return true;
        }
    }

    public static function updateSalesOrderItems($id, $dt)
    { 
        for ($i = 0; $i < count($dt); $i++) {
            $data = [
                'sales_order_id' => $id, 
                'item_id' => $dt[$i]['itemID'], 
                'quantity' =>  $dt[$i]['quantity'], 
                'unit_type_id' => $dt[$i]['unitTypeID'],
                'tax_code' => $dt[$i]['taxCodeID'],
                'tax_rate' => $dt[$i]['taxRate'],
                'rate' =>  $dt[$i]['rate'],
                'amount' =>  $dt[$i]['amount'],
                'gross_amount' =>  $dt[$i]['grossAmount'],
                'tax_amount' =>  $dt[$i]['taxAmount'],
                'commit_id' =>  $dt[$i]['commitID'],
                'order_priority' => ($dt[$i]['orderPriority'] == '') ? NULL : $dt[$i]['orderPriority'],
                'cost_estimate_type_id' => ($dt[$i]['costEstimateTypeID'] == '') ? NULL : $dt[$i]['costEstimateTypeID'],
                'est_extended_cost' => ($dt[$i]['estExtendedCost'] == '') ? NULL : $dt[$i]['estExtendedCost'],
                'create_wo' => $dt[$i]['createWO'],
                'create_customisation' =>  $dt[$i]['createCustomisation'],
                'customisation_name' => ($dt[$i]['customisationName'] == '') ? NULL : $dt[$i]['customisationName'],
                'customisation_notes' => ($dt[$i]['customisationNotes'] == '') ? NULL : $dt[$i]['customisationNotes']
            ];

            if ($dt[$i]['systemID'] == '') {
                DB::table('sales_order_items')->insert(array_merge($data, ['created_by' => 1, 'dt_created' => date('Y-m-d H:i:s'), 'status' => 'Active']));
            } 
            else {
                DB::table('sales_order_items')->where('system_id', $dt[$i]['systemID'])->update(array_merge($data, ['lupd_by' => 1, 'dt_lupd' => date('Y-m-d H:i:s')]));
            }
        }
    }
}
