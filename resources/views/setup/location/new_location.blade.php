@extends('template')

@section('title', 'Locations')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/parsleyjs/css/parsley.css') }}">
@endsection

@section('breadcrumb')
    <div class="col-md-6 col-sm-12">
        <h1>Locations</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Setup</li>
                <li class="breadcrumb-item active" aria-current="page">Locations</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form action="{{ action('SetupController@store_location') }}" data-parsley-validate  method="post">
                {{ csrf_field() }}
                <div class="card">
                    <div class="actionBtn">
                        <button class="btn btn-success" type="submit">Save</button>
                        <a href="{{ route('setup.location.locations') }}" class="btn btn-danger" title="">Cancel</a>
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
                                    <label>Sub-Location</label>
                                    <select class="form-control" name="sublocation_id">
                                        <option value="">Select...</option>
                                        @foreach ($locations as $location)
                                            <option value="{{ $location->location_id }}">{{ $location->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row">
                          <div class="col-lg-6">
                              <div class="form-group">
                                  <label>Location Type</label>
                                  <select class="form-control">
                                      <option value="">Select...</option>
                                  </select>
                              </div>
                          </div>
                        </div> -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>City</label>
                                    <input type="text" class="form-control" name="city">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>State</label>
                                    <input type="text" class="form-control" name="state">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Country</label>
                                    <select class="form-control" name="country_id">
                                        <option value="">Select...</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->country_id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Zip Code</label>
                                    <input type="text" class="form-control" name="zip_code" data-parsley-maxlength="10">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Address 1</label>
                                    <textarea class="form-control" rows="3" cols="10" name="address_1"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Address 2</label>
                                    <textarea class="form-control" rows="3" cols="10" name="address_2"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Phone #</label>
                                    <input type="text" class="form-control" name="phone_no" data-parsley-trigger="keyup" data-parsley-type="digits">
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row">
                          <div class="col-lg-6">
                              <div class="form-group">
                                  <label>Logo</label>
                                  <input type="text" class="form-control" name="">
                              </div>
                          </div>
                        </div> -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group block">
                                    <label>Use Bins</label>
                                    <input type="checkbox" name="use_bins" value="1">
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
<script>
    $('input[type="checkbox"]').change(function() {
        this.value = (Number(this.checked));
    });
</script>
@endsection
