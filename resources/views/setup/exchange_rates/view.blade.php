@extends('template')

@section('title', 'Exchange Rates')

@section('css')

@endsection

@section('breadcrumb')
    <div class="col-md-6 col-sm-12">
        <h1>View Exchange Rate</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Setup</li>
                <li class="breadcrumb-item">Exchange Rates</li>
                <li class="breadcrumb-item active" aria-current="page">View Exchange Rate</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <!-- CONTENT -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="actionBtn">
                    <a href="{{ route('setup.exchange_rates.edit', $exchangeRate->system_id) }}" class="btn btn-success" title="">Edit Exchange Rate</a>
                    <a href="{{ route('setup.exchange_rates.index') }}" class="btn btn-info" title="">Back</a>
                </div>
                <br>
                <div class="body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Currency</label>
                                <select class="form-control" name="currency_id" placeholder="Select..." value="{{ $exchangeRate->currency_id }}" disabled>
                                    <option value="">Select...</option>
                                    @foreach ($currencies as $currency)
                                        @if ($currency->currency_id == $exchangeRate->currency_id)
                                            <option value="{{ $currency->currency_id }}" selected>{{ $currency->name }}</option>
                                        @else
                                            <option value="{{ $currency->currency_id }}">{{ $currency->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Amount</label>
                                <input type="text" class="form-control" name="amount" value="{{ $exchangeRate->amount }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>Effective Date</label>
                                <input type="text" class="form-control datepicker" placeholder="yyyy/mm/dd" name="effective_date" value="{{ $exchangeRate->effective_date }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Date Created</label>
                                <input type="text" id="dt_created" data-date-autoclose="true" value="{{ $exchangeRate->dt_created }}" class="form-control datepicker" name="dt_created" disabled>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Created by </label>
                                <input type="text" id="created_by" data-date-autoclose="true" value="{{ $exchangeRate->created_by }}" class="form-control datepicker" name="created_by" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="actionBtn" style="margin-bottom: 5%;">
                <a href="{{ route('setup.exchange_rates.edit', $exchangeRate->system_id) }}" class="btn btn-success" title="">Edit Exchange Rate</a>
                <a href="{{ route('setup.exchange_rates.index') }}" class="btn btn-info" title="">Back</a>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script src="../assets/js/addRowTable.js"></script>
<script>
    $('.datepicker').datepicker({
        todayHighlight: true
    });
</script>
@endsection
