@extends('template')

@section('title', 'Tax Codes')

@section('css')

@endsection

@section('breadcrumb')
    <div class="col-md-6 col-sm-12">
        <h1>View Tax Code</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Setup</li>
                <li class="breadcrumb-item">Tax Codes</li>
                <li class="breadcrumb-item active" aria-current="page">View Tax Code</li>
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
                    <a href="{{ route('setup.tax_codes.edit', $taxCode->tax_code_id) }}" class="btn btn-success" title="">Edit Tax Code</a>
                    <a href="{{ route('setup.tax_codes.index') }}" class="btn btn-info" title="">Back</a>
                </div>
                <br>
                <div class="body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Code</label>
                                <input type="text" class="form-control" name="code" value="{{ $taxCode->code }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" rows="3" cols="10" name="description" disabled>{{ $taxCode->description }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Rate</label>
                                <input type="text" class="form-control" name="rate" value="{{ $taxCode->rate }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Effective From</label>
                                <input type="text" class="form-control datepicker" placeholder="yyyy/mm/dd" name="effective_from" value="{{ $taxCode->effective_from }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Valid Until</label>
                                <input type="text" class="form-control datepicker" placeholder="yyyy/mm/dd" name="valid_until" value="{{ $taxCode->valid_until }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Tax Agency</label>
                                <input type="text" class="form-control" name="tax_agency" value="{{ $taxCode->tax_agency }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Date Created</label>
                                <input type="text" id="dt_created" data-date-autoclose="true" value="{{ $taxCode->dt_created }}" class="form-control datepicker" name="dt_created" disabled>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Created by </label>
                                <input type="text" id="created_by" data-date-autoclose="true" value="{{ $taxCode->created_by }}" class="form-control datepicker" name="created_by" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="actionBtn" style="margin-bottom: 5%;">
                <a href="{{ route('setup.tax_codes.edit', $taxCode->tax_code_id) }}" class="btn btn-success" title="">Edit Tax Code</a>
                <a href="{{ route('setup.tax_codes.index') }}" class="btn btn-info" title="">Back</a>
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
