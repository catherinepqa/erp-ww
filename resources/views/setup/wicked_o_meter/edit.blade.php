@extends('template')

@section('title', 'Wicked-O-Meter')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/parsleyjs/css/parsley.css') }}">
@endsection

@section('breadcrumb')
    <div class="col-md-6 col-sm-12">
        <h1>Edit Wicked-O-Meter</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Setup</li>
                <li class="breadcrumb-item">Wicked-O-Meter</li>
                <li class="breadcrumb-item active" aria-current="page">Edit Wicked-O-Meter</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <!-- CONTENT -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ action('SetupController@update_wickedoMeter', $wickedoMeter->wicked_o_meter_id) }}"  data-parsley-validate enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                    {{ method_field('put') }}
                <div class="actionBtn">
                    <button class="btn btn-success" type="submit">Save</button>
                    <a href="{{ route('setup.wicked_o_meter.index') }}" class="btn btn-danger" title="">Cancel</a>
                    <button class="btn btn-info" type="button">Reset</button>
                </div>
                <br>
                <div class="body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" required value="{{ $wickedoMeter->name }}">
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label>Idx</label>
                                <input type="text" class="form-control" name="idx" required data-parsley-trigger="keyup" data-parsley-type="digits"  value="{{ $wickedoMeter->idx }}">
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
                <a href="{{ route('setup.wicked_o_meter.index') }}" class="btn btn-danger" title="">Cancel</a>
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
