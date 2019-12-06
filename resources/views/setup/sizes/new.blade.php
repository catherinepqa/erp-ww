@extends('template')

@section('title', 'Sizes')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/parsleyjs/css/parsley.css') }}">
@endsection

@section('breadcrumb')
    <div class="col-md-6 col-sm-12">
        <h1>Sizes</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Setup</li>
                <li class="breadcrumb-item active" aria-current="page">Sizes</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form action="{{ action('SetupController@store_size') }}"  data-parsley-validate enctype="multipart/form-data" method="post">
                {{ csrf_field() }}
                <div class="card">
                    <div class="actionBtn">
                        <button class="btn btn-success" type="submit">Save</button>
                        <a href="{{ route('setup.sizes.index') }}" class="btn btn-danger" title="">Cancel</a>
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
                              </div>
                          </div>
                          <div class="col-lg-6">
                              <div class="form-group">
                                  <label>Abbreviation</label>
                                  <input type="text" class="form-control" name="abbreviation" data-parsley-maxlength="10">
                              </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-2">
                              <div class="form-group">
                                  <label>Idx</label>
                                  <input type="text" class="form-control" name="idx" required data-parsley-trigger="keyup" data-parsley-type="digits" >
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
