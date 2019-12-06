@extends('template')

@section('title', 'Tax Codes')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/parsleyjs/css/parsley.css') }}">
@endsection

@section('breadcrumb')
    <div class="col-md-6 col-sm-12">
        <h1>Tax Codes</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Setup</li>
                <li class="breadcrumb-item active" aria-current="page">Tax Codes</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form action="{{ action('SetupController@store_taxCode') }}"  data-parsley-validate enctype="multipart/form-data" method="post">
                {{ csrf_field() }}
                <div class="card">
                    <div class="actionBtn">
                        <button class="btn btn-success" type="submit">Save</button>
                        <a href="{{ route('setup.tax_codes.index') }}" class="btn btn-danger" title="">Cancel</a>
                        <button class="btn btn-info" type="button">Reset</button>
                    </div>
                    <br>
                    <div class="header">
                        <h2>Primary Information</h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Code</label>
                                    <input type="text" class="form-control" name="code" required data-parsley-maxlength="10">
                                    @if ($errors->has('code'))
                                        <span class="text-danger">{{ $errors->first('code') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" rows="3" cols="10" name="description"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Rate</label>
                                    <input type="text" class="form-control" name="rate" data-parsley-trigger="keyup" data-parsley-type="number">
                                    @if ($errors->has('rate'))
                                        <span class="text-danger">{{ $errors->first('rate') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Effective From</label>
                                    <input type="text" class="form-control datepicker" placeholder="yyyy/mm/dd" name="effective_from">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Valid Until</label>
                                    <input type="text" class="form-control datepicker" placeholder="yyyy/mm/dd" name="valid_until">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Tax Agency</label>
                                    <input type="text" class="form-control" name="tax_agency">
                                </div>
                            </div>
                        </div>
                    </br>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script src="../assets/js/addRowTable.js"></script>
    <script src="{{ URL::asset('assets/js/pages/forms/setup.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/parsleyjs/js/parsley.min.js') }}"></script>
@endsection
