@extends('template')

@section('title', 'Exchange Rates')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/parsleyjs/css/parsley.css') }}">
@endsection

@section('breadcrumb')
    <div class="col-md-6 col-sm-12">
        <h1>Edit Exchange Rate</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Setup</li>
                <li class="breadcrumb-item">Exchange Rates</li>
                <li class="breadcrumb-item active" aria-current="page">Edit Exchange Rate</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <!-- CONTENT -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ action('SetupController@update_exchangeRate', $exchangeRate->system_id) }}" data-parsley-validate  method="post">
                    {{ csrf_field() }}
                    {{ method_field('put') }}
                <div class="actionBtn">
                    <button class="btn btn-success" type="submit">Save</button>
                    <a href="{{ route('setup.exchange_rates.index') }}" class="btn btn-danger" title="">Cancel</a>
                    <button class="btn btn-info" type="button">Reset</button>
                </div>
                <br>
                <div class="body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Currency</label>
                                <select class="form-control" name="currency_id" placeholder="Select..." value="{{ $exchangeRate->currency_id }}" required>
                                    <option value="">Select...</option>
                                    @foreach ($currencies as $currency)
                                        @if ($currency->currency_id == $exchangeRate->currency_id)
                                            <option value="{{ $currency->currency_id }}" selected>{{ $currency->name }}</option>
                                        @else
                                            <option value="{{ $currency->currency_id }}">{{ $currency->name }}</option>
                                        @endif
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
                                <input type="text" class="form-control" name="amount" value="{{ $exchangeRate->amount }}" required data-parsley-maxlength="10" data-parsley-trigger="keyup" data-parsley-type="number">
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
                                <input type="text" class="form-control datepicker" placeholder="yyyy/mm/dd" name="effective_date" value="{{ $exchangeRate->effective_date }}" required>
                                @if ($errors->has('effective_date'))
                                    <span class="text-danger">{{ $errors->first('effective_date') }}</span>
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
                <a href="{{ route('setup.exchange_rates.index') }}" class="btn btn-danger" title="">Cancel</a>
                <button class="btn btn-info" type="button">Reset</button>
            </div>
        </div>
        </form>
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
