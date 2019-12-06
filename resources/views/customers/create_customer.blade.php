@extends('template')

@section('title', 'New Customer')

@section('breadcrumb')
    <div class="col-md-6 col-sm-12">
        <h1>Create a new Customer</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Customers</li>
                <li class="breadcrumb-item active" aria-current="page">Create a new Customer</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
<!-- CONTENT -->
<div class="row">
    <form class="" id="myform" action="{{ action('CustomersController@store') }}" enctype="multipart/form-data" method="post">
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
                                <p>To Be Generated</p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Job Title</label>
                                <input type="text" class="form-control" name="job_title">
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
                                <input type="text" class="form-control" name="company_name">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Company Address</label>
                                <input type="text" class="form-control" name="company_address">
                            </div>
                        </div>


                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" class="form-control" name="fname">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Middle Name</label>
                                <input type="text" class="form-control" name="mname">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" class="form-control" name="lname">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Representative</label>
                                <input type="text" class="form-control" name="representative">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Memo</label>
                                <input type="text" class="form-control" name="memo">
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
                                <input type="text" class="form-control" name="email_1">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Email 2</label>
                                <input type="text" class="form-control" name="email_2">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Phone 1</label>
                                <input type="text" class="form-control" name="phone_1">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Phone 2</label>
                                <input type="text" class="form-control" name="phone_2">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Mobile Number</label>
                                <input type="text" class="form-control" name="mobile">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Home Number</label>
                                <input type="text" class="form-control" name="home">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>FAX</label>
                                <input type="text" class="form-control" name="fax">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Billing Label</label>
                                <input type="text" class="form-control" name="billing_label">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Billing Address</label>
                                <input type="text" class="form-control" name="billing_address">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Shipping Label</label>
                                <input type="text" class="form-control" name="shipping_label">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Shipping Address</label>
                                <input type="text" class="form-control" name="shipping_address">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Residential Label</label>
                                <input type="text" class="form-control" name="residential_label">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Residential Address</label>
                                <input type="text" class="form-control" name="residential_address">
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
