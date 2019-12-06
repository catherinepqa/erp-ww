@extends('template')

@section('title', 'Exchange Rates')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/parsleyjs/css/parsley.css') }}">
@endsection

@section('breadcrumb')
    <div class="col-md-6 col-sm-12">
        <h1>Exchange Rates</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Setup</li>
                <li class="breadcrumb-item active" aria-current="page">Exchange Rates</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form action="{{ action('SetupController@store_exchangeRate') }}" data-parsley-validate  method="post">
                {{ csrf_field() }}
                <div class="card">
                    <div class="actionBtn">
                        <button class="btn btn-success" type="submit">Save</button>
                        <a href="{{ route('setup.exchange_rates.index') }}" class="btn btn-danger" title="">Cancel</a>
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
                                    <label>Currency</label>
                                    <select class="form-control" name="currency_id" required>
                                        <option value="">Select...</option>
                                        @foreach ($currencies as $currency)
                                            <option value="{{ $currency->currency_id }}">{{ $currency->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('currency_id'))
                                        <span class="text-danger">{{ $errors->first('currency_id') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="text" class="form-control" name="amount" required data-parsley-maxlength="10" data-parsley-trigger="keyup" data-parsley-type="number">
                                    @if ($errors->has('amount'))
                                        <span class="text-danger">{{ $errors->first('amount') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label>Effective Date</label>
                                    <input type="text" class="form-control datepicker" placeholder="yyyy/mm/dd" name="effective_date" required>
                                    @if ($errors->has('effective_date'))
                                        <span class="text-danger">{{ $errors->first('effective_date') }}</span>
                                    @endif
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
<script>
    $('.datepicker').datepicker({
        todayHighlight: true,
    });
</script>
@endsection
