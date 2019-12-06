@extends('template')

@section('title', 'Currencies')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/parsleyjs/css/parsley.css') }}">
@endsection

@section('breadcrumb')
    <div class="col-md-6 col-sm-12">
        <h1>Edit Currency</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Setup</li>
                <li class="breadcrumb-item">Currencies</li>
                <li class="breadcrumb-item active" aria-current="page">Edit Currency</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <!-- CONTENT -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ action('SetupController@update_currency', $currency->currency_id) }}" data-parsley-validate  method="post">
                    {{ csrf_field() }}
                    {{ method_field('put') }}
                <div class="actionBtn">
                    <button class="btn btn-success" type="submit">Save</button>
                    <a href="{{ route('setup.currencies.index') }}" class="btn btn-danger" title="">Cancel</a>
                    <button class="btn btn-info" type="button">Reset</button>
                </div>
                <br>
                <div class="body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" required value="{{ $currency->name }}">
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Country</label>
                                <select class="form-control" name="country_id" value="{{ $currency->country_id }}" required>
                                    <option disabled selected value>Select...</option>
                                    @foreach ($countries as $country)
                                        @if ($country->country_id == $currency->country_id)
                                            <option value="{{ $country->country_id }}" selected>{{ $country->name }}</option>
                                        @else
                                            <option value="{{ $country->country_id }}">{{ $country->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('country_id'))
                                    <span class="text-danger">{{ $errors->first('country_id') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>ISO Code</label>
                                <input type="text" class="form-control" name="iso_code" value="{{ $currency->iso_code }}" required data-parsley-maxlength="10">
                                @if ($errors->has('iso_code'))
                                    <span class="text-danger">{{ $errors->first('iso_code') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Symbol</label>
                                <input type="text" class="form-control" name="symbol" value="{{ $currency->symbol }}" data-parsley-maxlength="10">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>Idx</label>
                                <input type="text" class="form-control" name="idx" required data-parsley-trigger="keyup" data-parsley-type="digits"  value="{{ $currency->idx }}">
                                @if ($errors->has('idx'))
                                    <span class="text-danger">{{ $errors->first('idx') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="actionBtn" style="margin-bottom: 5%;">
                <button class="btn btn-success" type="submit">Save</button>
                <a href="{{ route('setup.currencies.index') }}" class="btn btn-danger" title="">Cancel</a>
                <button class="btn btn-info" type="button">Reset</button>
            </div>
        </div>
        </form>
    </div>
@endsection
@section('js')
    <script src="{{ URL::asset('assets/js/pages/forms/setup.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/parsleyjs/js/parsley.min.js') }}"></script>
@endsection
