@extends('template')

@section('title', 'Edit Customer')

@section('breadcrumb')
    <div class="col-md-6 col-sm-12">
        <h1>Editing a Customer</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Customers</li>
                <li class="breadcrumb-item active" aria-current="page">Edit Customer</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
<!-- CONTENT -->
<div class="row">
    <form class="" id="myform" action="{{ action('CustomersController@update', $customer->customer_id) }}" enctype="multipart/form-data" method="post">
        {{ csrf_field() }}
        <div class="col-lg-12">
            <div class="card">
                <div class="actionBtn">
                    <button class="btn btn-success" type="submit">Save</button>
                    <button class="btn btn-danger" type="button">Cancel</button>
                    <button class="btn btn-info" type="button">Reset</button>
                </div>
                <br>
                <div class="header">
                    <h2>Primary Information</h2>
                </div>
                <div class="body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Customer ID</label>
                                <p>{{ $customer->customer_id}}</p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Job Title</label>
                                <input type="text" class="form-control" name="job_title" value="{{ $customer->job_title }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label>Category</label>
                            <select class="form-control" name="customer_type_id">
                                <option value="indiviual">Individual</option>
                                <option value="company">Company</option>
                            </select>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Salutation</label>
                                <select class="form-control" name="salutation">
                                    <option value="Mr.">Mr.</option>
                                    <option value="Ms.">Ms.</option>
                                    <option value="Mrs.">Mrs.</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Company Name</label>
                                <input type="text" class="form-control" name="company_name" value="{{ $customer->company_name }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Company Address</label>
                                <input type="text" class="form-control" name="company_address" value="{{ $customer->company_address }}">
                            </div>
                        </div>


                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" class="form-control" name="fname" value="{{ $customer->fname }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Middle Name</label>
                                <input type="text" class="form-control" name="mname" value="{{ $customer->mname }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" class="form-control" name="lname" value="{{ $customer->lname }}">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Representative</label>
                                <input type="text" class="form-control" name="representative" value="{{ $customer->representative }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Memo</label>
                                <input type="text" class="form-control" name="memo" value="{{ $customer->memo }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2>Contact Information</h2>
                </div>
                <div class="body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Email 1</label>
                                <input type="text" class="form-control" name="email_1" value="{{ $customer->email_1 }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Email 2</label>
                                <input type="text" class="form-control" name="email_2" value="{{ $customer->email_2 }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Phone 1</label>
                                <input type="text" class="form-control" name="phone_1" value="{{ $customer->phone_1 }}">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Phone 2</label>
                                <input type="text" class="form-control" name="phone_2" value="{{ $customer->phone_2 }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Mobile Number</label>
                                <input type="text" class="form-control" name="mobile" value="{{ $customer->mobile }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Home Number</label>
                                <input type="text" class="form-control" name="home" value="{{ $customer->home }}">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>FAX</label>
                                <input type="text" class="form-control" name="fax" value="{{ $customer->fax }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Billing Label</label>
                                <input type="text" class="form-control" name="billing_label" value="{{ $customer->billing_label }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Billing Address</label>
                                <input type="text" class="form-control" name="billing_address" value="{{ $customer->billing_address }}">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Shipping Label</label>
                                <input type="text" class="form-control" name="shipping_label" value="{{ $customer->shipping_label }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Shipping Address</label>
                                <input type="text" class="form-control" name="shipping_address" value="{{ $customer->shipping_address }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Residential Label</label>
                                <input type="text" class="form-control" name="residential_label" value="{{ $customer->residential_label }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Residential Address</label>
                                <input type="text" class="form-control" name="residential_address" value="{{ $customer->residential_address }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="actionBtn">
            <button class="btn btn-success" type="submit">Save</button>
            <button class="btn btn-danger" type="button">Cancel</button>
            <button class="btn btn-info" type="button">Reset</button>
        </div>
    </form>
</div>
@endsection
