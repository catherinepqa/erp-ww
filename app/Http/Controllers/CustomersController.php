<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customers;

class CustomersController extends Controller
{
    public function customers()
    {
        $customers = Customers::all();
        return view('customers.customers', compact('customers'));
    }

    public function customer_payment()
    {
        return view('customers.customer_payment');
    }

    public function customer_refund()
    {
        return view('customers.customer_refund');
    }

    public function assessment()
    {
        return view('customers.assessment');
    }

    public function customer_cases()
    {
        return view('customers.customer_cases');
    }

    public function chargeback()
    {
        return view('customers.chargeback');
    }

    public function need_attention()
    {
        return view('customers.need_attention');
    }

    public function customer_deposit()
    {
        return view('customers.customer_deposit');
    }

    public function cash_refund()
    {
        return view('customers.cash_refund');
    }

    /*
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.create_customer');
    }

    /**
     * Save a new customer to database
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $save  = Customers::storeCustomer($request);

        if ($save !== false) {
                return redirect('/customers')->with('success', 'Successfully created new customer!');
        } else {
            return Redirect::back()->withErrors('Failed to create a new customer. Please try again.')->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer  = Customers::findOrFail($id);
        return view('customers.edit_customer', compact('customer'));
    }

    /**
     * Show the customer detials
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer  = Customers::findOrFail($id);
        return view('customers.edit_customer', compact('customer'));
    }

    /**
     * Update customer to database
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $update  = Customers::updateCustomer($request, $id);

        if ($update !== false) {
                return redirect('/customers')->with('success', 'Successfully updated a customer!');
        } else {
            return Redirect::back()->withErrors('Failed to update a customer. Please try again.')->withInput();
        }
    }
}
