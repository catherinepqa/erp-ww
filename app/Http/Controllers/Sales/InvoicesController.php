<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use App\Models\CustomersModel;
use App\Models\Status;
use App\Models\Representatives;
use App\Models\Departments;
use App\Models\Locations;
use App\Models\DiscountType;
use App\Models\ShippingCarrier;
use App\Models\Currencies;
use App\Models\ProductModel;
use App\Models\SalesOrderModel;
use App\Models\InvoicesModel;

class InvoicesController extends Controller
{
    public function index()
    {
        return view('sales.invoices');
    }

     public function new($id = null)
    {
        $customers = CustomersModel::where('status', 'Active')->orderBy('lname')->orderBy('fname')->get();
        $status = Status::where([['module_id', '2'],['status', 'Active']])->orderBy('idx')->get();
        $representatives = Representatives::where('status', 'Active')->orderBy('name')->get();
        $departments = Departments::where('status', 'Active')->orderBy('idx')->get();
        $locations = Locations::where('status', 'Active')->orderBy('idx')->get();
        $discount_type = DiscountType::where('status', 'Active')->orderBy('idx')->get();
        $shipping_carrier = ShippingCarrier::where('status', 'Active')->orderBy('idx')->get();
        $tax_codes = ProductModel::getTaxCode();
        $currencies = SalesOrderModel::getCurrencies();

        if (!IS_NULL($id)) {
            $sales_order = SalesOrderModel::getSalesOrderBySalesOrderID($id);
            $sales_order_items = SalesOrderModel::getSalesOrderItemsBySalesOrderID($id, $sales_order->location_id);
        }
        
        return view('sales.invoices_new', compact([
            'id',
            'customers',
            'status',
            'representatives',
            'departments',
            'locations',
            'discount_type',
            'shipping_carrier',
            'tax_codes',
            'currencies',
            'sales_order',
            'sales_order_items'
        ]));
    }

     public function createInvoice(Request $request){
        $data = InvoicesModel::createInvoice($request);
        
        echo json_encode($data);
    }
}
