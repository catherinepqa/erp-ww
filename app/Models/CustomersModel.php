<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CustomersModel extends Model
{
   protected $table = 'customers';

   public static function getCustomerByCustomerID($request)
    {
       $customer = DB::table("customers")
       				->where('customer_id', $request->customerID)
                    ->get();

         return $customer;
    }
}
