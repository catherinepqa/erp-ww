<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customers';

    public $timestamps = false;

    public $primaryKey = 'customer_id';

    /**
     * store new customer
     * Return boolean true or false if saving was successful
     */
    public static function storeCustomer ($request)
    {
        $cust                       = new Customers;
        $cust->job_title            = $request->get('job_title');
        $cust->customer_type_id     = '1';
        $cust->salutation           = $request->get('salutation');
        $cust->company_name         = $request->get('company_name');
        $cust->company_address      = $request->get('company_address');
        $cust->fname                = $request->get('fname');
        $cust->lname                = $request->get('lname');
        $cust->mname                = $request->get('mname');
        $cust->representative       = $request->get('representative');
        $cust->memo                 = $request->get('memo');
        $cust->email_1              = $request->get('email_1');
        $cust->email_2              = $request->get('email_2');
        $cust->phone_1              = $request->get('phone_1');
        $cust->phone_2              = $request->get('phone_2');
        $cust->mobile               = $request->get('mobile');
        $cust->home                 = $request->get('home');
        $cust->fax                  = $request->get('fax');
        $cust->billing_label        = $request->get('billing_label');
        $cust->billing_address      = $request->get('billing_address');
        $cust->shipping_label       = $request->get('shipping_label');
        $cust->shipping_address     = $request->get('shipping_address');
        $cust->residential_label    = $request->get('residential_label');
        $cust->residential_address    = $request->get('residential_address');
        $cust->created_by           = '1';
        $cust->dt_created           = date('Y-m-d, H:i:s');
        $cust->status               = 'Active';

        if ($cust->save()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * store new customer
     * Return boolean true or false if saving was successful
     */
    public static function updateCustomer ($request, $id)
    {
        $cust                       = self::find($id);
        $cust->job_title            = $request->get('job_title');
        $cust->customer_type_id     = '1';
        $cust->salutation           = $request->get('salutation');
        $cust->company_name         = $request->get('company_name');
        $cust->company_address      = $request->get('company_address');
        $cust->fname                = $request->get('fname');
        $cust->lname                = $request->get('lname');
        $cust->mname                = $request->get('mname');
        $cust->representative       = $request->get('representative');
        $cust->memo                 = $request->get('memo');
        $cust->email_1              = $request->get('email_1');
        $cust->email_2              = $request->get('email_2');
        $cust->phone_1              = $request->get('phone_1');
        $cust->phone_2              = $request->get('phone_2');
        $cust->mobile               = $request->get('mobile');
        $cust->home                 = $request->get('home');
        $cust->fax                  = $request->get('fax');
        $cust->billing_label        = $request->get('billing_label');
        $cust->billing_address      = $request->get('billing_address');
        $cust->shipping_label       = $request->get('shipping_label');
        $cust->shipping_address     = $request->get('shipping_address');
        $cust->residential_label    = $request->get('residential_label');
        $cust->residential_address  = $request->get('residential_address');
        $cust->lupd_by              = '1';
        $cust->dt_lupd              = date('Y-m-d, H:i:s');
        $cust->status               = 'Active';

        if ($cust->update()) {
            return true;
        } else {
            return false;
        }
    }
}
