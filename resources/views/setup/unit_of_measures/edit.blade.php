@extends('template')

@section('title', 'Unit of Measures')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/parsleyjs/css/parsley.css') }}">
@endsection

@section('breadcrumb')
    <div class="col-md-6 col-sm-12">
        <h1>Edit Unit of Measure</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Setup</li>
                <li class="breadcrumb-item">Unit of Measures</li>
                <li class="breadcrumb-item active" aria-current="page">Edit Unit of Measure</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <!-- CONTENT -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ action('SetupController@update_unitOfMeasure', $unitOfMeasure->unit_type_id) }}"  data-parsley-validate enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                    {{ method_field('put') }}
                <div class="actionBtn">
                    <button class="btn btn-success" type="submit">Save</button>
                    <a href="{{ route('setup.unit_of_measures.index') }}" class="btn btn-danger" title="">Cancel</a>
                    <button class="btn btn-info" type="button">Reset</button>
                </div>
                <br>
                <div class="body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" required value="{{ $unitOfMeasure->name }}">
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Abbreviation</label>
                                <input type="text" class="form-control" name="abbreviation" value="{{ $unitOfMeasure->abbreviation }}" data-parsley-maxlength="10">
                                @if ($errors->has('abbreviation'))
                                    <span class="text-danger">{{ $errors->first('abbreviation') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Plural Name</label>
                                <input type="text" class="form-control" name="plural_name" value="{{ $unitOfMeasure->plural_name }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Plural Abbreviation</label>
                                <input type="text" class="form-control" name="plural_abbreviation" value="{{ $unitOfMeasure->plural_abbreviation }}" data-parsley-maxlength="10">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Conversion Rate</label>
                                <input type="text" class="form-control" name="conversion_rate" value="{{ $unitOfMeasure->conversion_rate }}" data-parsley-trigger="keyup" data-parsley-type="digits">
                                @if ($errors->has('conversion_rate'))
                                    <span class="text-danger">{{ $errors->first('conversion_rate') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Base Unit</label>
                                <input type="text" class="form-control" name="base_unit" value="{{ $unitOfMeasure->base_unit }}" data-parsley-trigger="keyup" data-parsley-type="digits">
                                @if ($errors->has('base_unit'))
                                    <span class="text-danger">{{ $errors->first('base_unit') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Sub-Unit Type</label>
                                <select class="form-control" name="subunit_type_id" value="{{ $unitOfMeasure->name }}">
                                    <option value="">Select...</option>
                                    @foreach ($unitOfMeasures as $unitOfMeasureOption)
                                        @if ($unitOfMeasureOption->unit_type_id == $unitOfMeasure->subunit_type_id)
                                            <option value="{{ $unitOfMeasureOption->unit_type_id }}" selected>{{ $unitOfMeasureOption->name }}</option>
                                        @else
                                            <option value="{{ $unitOfMeasureOption->unit_type_id }}">{{ $unitOfMeasureOption->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="actionBtn" style="margin-bottom: 5%;">
                <button class="btn btn-success" type="submit">Save</button>
                <a href="{{ route('setup.unit_of_measures.index') }}" class="btn btn-danger" title="">Cancel</a>
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
