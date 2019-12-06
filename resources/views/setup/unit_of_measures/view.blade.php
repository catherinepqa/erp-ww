@extends('template')

@section('title', 'Unit of Measures')

@section('css')

@endsection

@section('breadcrumb')
    <div class="col-md-6 col-sm-12">
        <h1>View Unit of Measure</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Setup</li>
                <li class="breadcrumb-item">Unit of Measures</li>
                <li class="breadcrumb-item active" aria-current="page">View Unit of Measure</li>
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
                    <a href="{{ route('setup.unit_of_measures.edit', $unitOfMeasure->unit_type_id) }}" class="btn btn-success" title="">Edit Unit of Measure</a>
                    <a href="{{ route('setup.unit_of_measures.index') }}" class="btn btn-info" title="">Back</a>
                </div>
                <br>
                <div class="body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" required value="{{ $unitOfMeasure->name }}" disabled>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Abbreviation</label>
                                <input type="text" class="form-control" name="abbreviation" value="{{ $unitOfMeasure->abbreviation }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Plural Name</label>
                                <input type="text" class="form-control" name="plural_name" value="{{ $unitOfMeasure->plural_name }}" disabled>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Plural Abbreviation</label>
                                <input type="text" class="form-control" name="plural_abbreviation" value="{{ $unitOfMeasure->plural_abbreviation }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Conversion Rate</label>
                                <input type="text" class="form-control" name="conversion_rate" value="{{ $unitOfMeasure->conversion_rate }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Base Unit</label>
                                <input type="text" class="form-control" name="base_unit" value="{{ $unitOfMeasure->base_unit }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Sub-Unit Type</label>
                                <select class="form-control" name="subunit_type_id" value="{{ $unitOfMeasure->name }}" disabled>
                                    @if ($unitOfMeasures->isNotEmpty())
                                        <option value="{{ $unitOfMeasures[0]->bname }}" selected>{{ $unitOfMeasures[0]->bname }}</option>
                                    @else
                                        <option value="">Select...</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Date Created</label>
                                <input type="text" id="date_created" data-date-autoclose="true" value="{{ $unitOfMeasure->date_created }}" class="form-control datepicker" name="dt_created" disabled>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Created by </label>
                                <input type="text" id="created_by" data-date-autoclose="true" value="{{ $unitOfMeasure->created_by }}" class="form-control datepicker" name="created_by" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="actionBtn" style="margin-bottom: 5%;">
                <a href="{{ route('setup.unit_of_measures.edit', $unitOfMeasure->unit_type_id) }}" class="btn btn-success" title="">Edit Unit of Measure</a>
                <a href="{{ route('setup.unit_of_measures.index') }}" class="btn btn-info" title="">Back</a>
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
