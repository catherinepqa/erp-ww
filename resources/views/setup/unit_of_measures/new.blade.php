@extends('template')

@section('title', 'Unit of Measures')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/parsleyjs/css/parsley.css') }}">
@endsection

@section('breadcrumb')
    <div class="col-md-6 col-sm-12">
        <h1>Unit of Measures</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Setup</li>
                <li class="breadcrumb-item active" aria-current="page">Unit of Measures</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form action="{{ action('SetupController@store_unitOfMeasure') }}"  data-parsley-validate enctype="multipart/form-data" method="post">
                {{ csrf_field() }}
                <div class="card">
                    <div class="actionBtn">
                        <button class="btn btn-success" type="submit">Save</button>
                        <a href="{{ route('setup.unit_of_measures.index') }}" class="btn btn-danger" title="">Cancel</a>
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
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" required>
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Abbreviation</label>
                                    <input type="text" class="form-control" name="abbreviation" data-parsley-maxlength="10">
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
                                    <input type="text" class="form-control" name="plural_name">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Plural Abbreviation</label>
                                    <input type="text" class="form-control" name="plural_abbreviation" data-parsley-maxlength="10">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Conversion Rate</label>
                                    <input type="text" class="form-control" name="conversion_rate" data-parsley-trigger="keyup" data-parsley-type="digits">
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
                                    <input type="text" class="form-control" name="base_unit" data-parsley-trigger="keyup" data-parsley-type="digits">
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
                                    <select class="form-control" name="subunit_type_id">
                                        <option value="">Select...</option>
                                        @foreach ($unitOfMeasures as $unitOfMeasure)
                                            <option value="{{ $unitOfMeasure->unit_type_id }}">{{ $unitOfMeasure->name }}</option>
                                        @endforeach
                                    </select>
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
    <script src="{{ URL::asset('assets/js/pages/forms/setup.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/parsleyjs/js/parsley.min.js') }}"></script>
@endsection
