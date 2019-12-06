@extends('template')

@section('title', 'Bins')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/parsleyjs/css/parsley.css') }}">
@endsection

@section('breadcrumb')
    <div class="col-md-6 col-sm-12">
        <h1>Edit Bin</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Setup</li>
                <li class="breadcrumb-item">Bins</li>
                <li class="breadcrumb-item active" aria-current="page">Edit Bin</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <!-- CONTENT -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ action('SetupController@update_bin', $bin->bin_id) }}"  method="post">
                    {{ csrf_field() }}
                    {{ method_field('put') }}
                <div class="actionBtn">
                    <button class="btn btn-success" type="submit">Save</button>
                    <a href="{{ route('setup.bins.index') }}" class="btn btn-danger" title="">Cancel</a>
                    <button class="btn btn-info" type="button">Reset</button>
                </div>
                <br>
                <div class="body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Bin #</label>
                                <input type="text" class="form-control" name="bin_no" value="{{ $bin->bin_no }}" required data-parsley-maxlength="20" data-parsley-trigger="keyup" data-parsley-type="digits">
                                @if ($errors->has('bin_no'))
                                    <span class="text-danger">{{ $errors->first('bin_no') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" rows="3" cols="10" name="description">{{ $bin->description }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Location</label>
                                <select class="form-control" name="location_id" value="{{ $bin->location_id }}" required>
                                    <option disabled selected value>Select...</option>
                                    @foreach ($locations as $location)
                                        @if ($location->location_id == $bin->location_id)
                                            <option value="{{ $location->location_id }}" selected>{{ $location->name }}</option>
                                        @else
                                            <option value="{{ $location->location_id }}">{{ $location->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('location_id'))
                                    <span class="text-danger">{{ $errors->first('location_id') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>Idx</label>
                                <input type="text" class="form-control" name="idx" required data-parsley-trigger="keyup" data-parsley-type="digits"  value="{{ $bin->idx }}">
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
                <a href="{{ route('setup.bins.index') }}" class="btn btn-danger" title="">Cancel</a>
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
