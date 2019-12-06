@extends('template')

@section('title', 'Locations')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/vendor/parsleyjs/css/parsley.css') }}">
@endsection

@section('breadcrumb')
    <div class="col-md-6 col-sm-12">
        <h1>Edit Location</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Inventory</li>
                <li class="breadcrumb-item">Locations</li>
                <li class="breadcrumb-item active" aria-current="page">Edit Location</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <!-- CONTENT -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ action('SetupController@update_location', $location->location_id) }}" data-parsley-validate  method="post">
                    {{ csrf_field() }}
                    {{ method_field('put') }}
                <div class="actionBtn">
                    <button class="btn btn-success" type="submit">Save</button>
                    <a href="{{ route('setup.location.locations') }}" class="btn btn-danger" title="">Cancel</a>
                    <button class="btn btn-info" type="button">Reset</button>
                </div>
                <br>
                <div class="body">
                    <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" required value="{{ $location->name }}">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Abbreviation</label>
                                    <input type="text" class="form-control" name="abbreviation" value="{{ $location->abbreviation }}" data-parsley-maxlength="10">
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
                                    <select class="form-control" name="sublocation_id" value="{{ $location->name }}">
                                        <option value="">Select...</option>
                                        @foreach ($locations as $locationOption)
                                            @if ($locationOption->location_id == $location->sublocation_id)
                                                <option value="{{ $locationOption->location_id }}" selected>{{ $locationOption->name }}</option>
                                            @else
                                                <option value="{{ $locationOption->location_id }}">{{ $locationOption->name }}</option>
                                            @endif
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
                                    <input type="text" class="form-control" name="city" value="{{ $location->city }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>State</label>
                                    <input type="text" class="form-control" name="state" value="{{ $location->state }}">
                                </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Country</label>
                                    <select class="form-control" name="country_id" value="{{ $location->country_id }}">
                                        <option value="">Select...</option>
                                        @foreach ($countries as $country)
                                            @if ($country->country_id == $location->country_id)
                                                <option value="{{ $country->country_id }}" selected>{{ $country->name }}</option>
                                            @else
                                                <option value="{{ $country->country_id }}">{{ $country->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Zip Code</label>
                                    <input type="text" class="form-control" name="zip_code" value="{{ $location->zip_code }}">
                                </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Address 1</label>
                                    <textarea class="form-control" rows="3" cols="10" name="address_1" value="{{ $location->address_1 }}"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Address 2</label>
                                    <textarea class="form-control" rows="3" cols="10" name="address_2" value="{{ $location->address_2 }}"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Phone #</label>
                                    <input type="text" class="form-control" name="phone_no" value="{{ $location->phone_no }}" data-parsley-trigger="keyup" data-parsley-type="digits">
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
                                <div class="form-group">
                                    <label>Use Bins</label>
                                    <input type="checkbox" name="use_bins" value="1" {{ ($location->use_bins ? 'checked' : '') }}>
                                </div>
                            </div>
                          </div>
                         <div class="row">
                           <div class="col-lg-2">
                               <div class="form-group">
                                   <label>Idx</label>
                                   <input type="text" class="form-control" name="idx" required data-parsley-trigger="keyup" data-parsley-type="digits"  value="{{ $location->idx }}">
                               </div>
                           </div>
                         </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="actionBtn" style="margin-bottom: 5%;">
                    <button class="btn btn-success" type="submit">Save</button>
                    <a href="{{ route('setup.location.locations') }}" class="btn btn-danger" title="">Cancel</a>
                    <button class="btn btn-info" type="button">Reset</button>
                </div>
            </div>
        </form>
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
