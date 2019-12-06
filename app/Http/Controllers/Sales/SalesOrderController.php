<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use App\Models\CustomersModel;
use App\Models\Status;
use App\Models\Departments;
use App\Models\Locations;
use App\Models\DiscountType;
use App\Models\CostEstimateType;
use App\Models\Commit;
use App\Models\ShippingCarrier;
use App\Models\Terms;
use App\Models\PaymentMethods;
use App\Models\Currencies;
use App\Models\ProductModel;
use App\Models\SalesOrderModel;

class SalesOrderController extends Controller
{
    public function index()
    {
        $sales_order = SalesOrderModel::getSalesOrder();

        return view('sales.sales_order', compact(['sales_order']));
    }

    public function new()
    {
        $customers = CustomersModel::where('status', 'Active')->orderBy('lname')->orderBy('fname')->get();
        $internal_status = Status::where([['module_id', '1'],['status', 'Active']])->orderBy('idx')->get();
        $web_status = Status::where([['module_id', '2'],['status', 'Active']])->orderBy('idx')->get();
        $departments = Departments::where('status', 'Active')->orderBy('idx')->get();
        $locations = Locations::where('status', 'Active')->orderBy('idx')->get();
        $discount_type = DiscountType::where('status', 'Active')->orderBy('idx')->get();
        $shipping_carrier = ShippingCarrier::where('status', 'Active')->orderBy('idx')->get();
        $tax_codes = ProductModel::getTaxCode();
        $terms = Terms::where('status', 'Active')->orderBy('idx')->get();
        $payment_methods = PaymentMethods::where('status', 'Active')->orderBy('idx')->get();
        $currencies = SalesOrderModel::getCurrencies();

        return view('sales.sales_order_new', compact([
            'customers',
            'internal_status',
            'web_status',
            'departments',
            'locations',
            'discount_type',
            'shipping_carrier',
            'tax_codes',
            'terms',
            'payment_methods',
            'currencies'
        ]));
    }

     public function getCustomerDetails(Request $request){
        $customer = CustomersModel::getCustomerByCustomerID($request);

        return $customer;
    }

    public function setNewItem(){
        $cost_estimate_type = CostEstimateType::where('status', 'Active')->orderBy('idx')->get();
        $commit = Commit::where('status', 'Active')->orderBy('idx')->get();
        
        return view('sales.sales_order_new_item_new', compact(['cost_estimate_type', 'commit']));
    }

    public function setEditItem(Request $request){
        $cost_estimate_type = CostEstimateType::where('status', 'Active')->orderBy('idx')->get();
        $commit = Commit::where('status', 'Active')->orderBy('idx')->get();
        
        $dt = [
            $request->itemID, 
            $request->unitTypeID, 
            $request->taxCodeID, 
            $request->commitID,
            $request->costEstimateTypeID,
            $request->itemName,
            $request->itemDescription,
            $request->onHand,
            $request->quantity,
            $request->units,
            $request->taxCode,
            $request->taxRate,
            $request->rate,
            $request->amount,
            $request->grossAmount,
            $request->taxAmount,
            $request->orderPriority,
            $request->estExtendedCost,
            $request->withWorkOrder,
            $request->withCustomisation,
            $request->customisationName,
            $request->memo
        ];

        return view('sales.sales_order_new_item_edit', compact(['cost_estimate_type', 'commit', 'dt']));
    }

    public function searchItemByName(Request $request){
        $items = SalesOrderModel::getItemsByName($request);

        return response()->json($items);
    }

    public function createSalesOrder(Request $request){
        $data = SalesOrderModel::createSalesOrder($request);
        
        echo json_encode($data);
    }

    public function view($id){
        $sales_order = SalesOrderModel::getSalesOrderBySalesOrderID($id);
        $sales_order_items = SalesOrderModel::getSalesOrderItemsBySalesOrderID($id, $sales_order->location_id);

        return view('sales.sales_order_view', compact(['id', 'sales_order', 'sales_order_items']));
    }

    public function edit($id){
        $customers = CustomersModel::where('status', 'Active')->orderBy('lname')->orderBy('fname')->get();
        $internal_status = Status::where([['module_id', '1'],['status', 'Active']])->orderBy('idx')->get();
        $web_status = Status::where([['module_id', '2'],['status', 'Active']])->orderBy('idx')->get();
        $departments = Departments::where('status', 'Active')->orderBy('idx')->get();
        $locations = Locations::where('status', 'Active')->orderBy('idx')->get();
        $discount_type = DiscountType::where('status', 'Active')->orderBy('idx')->get();
        $shipping_carrier = ShippingCarrier::where('status', 'Active')->orderBy('idx')->get();
        $tax_codes = ProductModel::getTaxCode();
        $terms = Terms::where('status', 'Active')->orderBy('idx')->get();
        $payment_methods = PaymentMethods::where('status', 'Active')->orderBy('idx')->get();
        $currencies = SalesOrderModel::getCurrencies();
        $sales_order = SalesOrderModel::getSalesOrderBySalesOrderID($id);
        $sales_order_items = SalesOrderModel::getSalesOrderItemsBySalesOrderID($id, $sales_order->location_id);

        return view('sales.sales_order_edit', compact([
            'id',
            'customers',
            'internal_status',
            'web_status',
            'departments',
            'locations',
            'discount_type',
            'shipping_carrier',
            'tax_codes',
            'terms',
            'payment_methods',
            'currencies',
            'sales_order',
            'sales_order_items'
        ]));
    }

    public function updateSalesOrder(Request $request) {
        $data['success'] = SalesOrderModel::updateSalesOrder($request);
        
        echo json_encode($data);
    }
}
