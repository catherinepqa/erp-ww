@extends('template')

@section('title', 'Sizes')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/parsleyjs/css/parsley.css') }}">
@endsection

@section('breadcrumb')
    <div class="col-md-6 col-sm-12">
        <h1>Edit Size</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Setup</li>
                <li class="breadcrumb-item">Sizes</li>
                <li class="breadcrumb-item active" aria-current="page">Edit Size</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <!-- CONTENT -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ action('SetupController@update_size', $size->size_id) }}"  method="post">
                    {{ csrf_field() }}
                    {{ method_field('put') }}
                <div class="actionBtn">
                    <button class="btn btn-success" type="submit">Save</button>
                    <a href="{{ route('setup.sizes.index') }}" class="btn btn-danger" title="">Cancel</a>
                    <button class="btn btn-info" type="button">Reset</button>
                </div>
                <br>
                <div class="body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" required value="{{ $size->name }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Abbreviation</label>
                                <input type="text" class="form-control" name="abbreviation" value="{{ $size->abbreviation }}" data-parsley-maxlength="10">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>Idx</label>
                                <input type="text" class="form-control" name="idx" required data-parsley-trigger="keyup" data-parsley-type="digits"  value="{{ $size->idx }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="actionBtn" style="margin-bottom: 5%;">
                <button class="btn btn-success" type="submit">Save</button>
                <a href="{{ route('setup.sizes.index') }}" class="btn btn-danger" title="">Cancel</a>
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
