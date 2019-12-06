@extends('template')

@section('title', 'Back Variations')

@section('css')

@endsection

@section('breadcrumb')
    <div class="col-md-6 col-sm-12">
        <h1>View Back Variation</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Setup</li>
                <li class="breadcrumb-item">Back Variations</li>
                <li class="breadcrumb-item active" aria-current="page">View Back Variation</li>
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
                    <a href="{{ route('setup.back_variations.edit', $backVariation->back_variation_id) }}" class="btn btn-success" title="">Edit Back Variation</a>
                    <a href="{{ route('setup.back_variations.index') }}" class="btn btn-info" title="">Back</a>
                </div>
                <br>
                <div class="body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" required value="{{ $backVariation->name }}" disabled>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Abbreviation</label>
                                <input type="text" class="form-control" name="name" required value="{{ $backVariation->abbreviation }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>Idx</label>
                                <input type="text" class="form-control" name="idx" required data-parsley-trigger="keyup" data-parsley-type="digits"  value="{{ $backVariation->idx }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Date Created</label>
                                <input type="text" id="dt_created" data-date-autoclose="true" value="{{ $backVariation->dt_created }}" class="form-control datepicker" name="dt_created" disabled>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Created by </label>
                                <input type="text" id="created_by" data-date-autoclose="true" value="{{ $backVariation->created_by }}" class="form-control datepicker" name="created_by" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="actionBtn" style="margin-bottom: 5%;">
                <a href="{{ route('setup.back_variations.edit', $backVariation->back_variation_id) }}" class="btn btn-success" title="">Edit Back Variation</a>
                <a href="{{ route('setup.back_variations.index') }}" class="btn btn-info" title="">Back</a>
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
