@extends('template')

@section('title', 'Order Items & Approval')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/jquery-datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/sweetalert/sweetalert.css') }}">
@endsection

@section('breadcrumb')
    <div class="col-md-6 col-sm-12">
        <h1>Order Items & Approval</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Inventory</li>
                <li class="breadcrumb-item active" aria-current="page">Order Items & Approval</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="actionBtn">
                <span style="margin-right: 10px">
                    <button class="btn btn-success submit">Submit</button>
                    <button class="btn btn-info" type="button">Reset</button>
                </span>
                <span style="border-left: 1px solid #99a7b3; padding: 6px 1px 7px 13px;">
                    <button class="btn btn-default" type="button">Mark All</button>
                    <button class="btn btn-default" type="button" style="width: auto">Unmark All</button>
                </span>
            </div>
            <hr>
            <div class="body">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="form-group">
                            <label>Supervisor</label>
                            <select class="form-control">
                                <option>Select...</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Select Order Number</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>From</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>To</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover dataTable js-exportable">
                                <thead>
                                <tr>
                                    <th><input type="checkbox"></th>
                                    <th>Date</th>
                                    <th>Order #</th>
                                    <th>Employee</th>
                                    <th>Memo</th>
                                    <th>Source Location</th>
                                    <th>Destination Location</th>
                                    <th>Order Total</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <form method="post" action="{{ route('order_items_approveOrder') }}" id="deleteForm">
                    @csrf
                    <input type="hidden" class="delete_id" name="approved_id" value="">
                </form>
            </div>
        </div>
    </div>
</div>
@if(session()->has('success'))
    <button class="btn btn-success btn-sm demo2" style="display: none"></button>
@endif
@endsection

@section('script')
    <script src="{{ URL::asset('assets/vendor/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ URL::asset('assets/bundles/datatablescripts.bundle.js') }}"></script>
    <script>
        var data_url = "{{route('order_items_dataList')}}";
        var success_msg = "{{ session()->get('success') }}";
    </script>

    <script src="{{ URL::asset('js/pages/order_items/index.js') }}"></script>
@endsection
