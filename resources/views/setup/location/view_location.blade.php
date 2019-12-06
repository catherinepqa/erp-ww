@extends('template')

@section('title', 'Location')

@section('css')

@endsection

@section('breadcrumb')
    <div class="col-md-6 col-sm-12">
        <h1>View Location</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Inventory</li>
                <li class="breadcrumb-item">Location</li>
                <li class="breadcrumb-item active" aria-current="page">View Location</li>
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
                    <a href="{{ route('setup.location.edit_location', $location->location_id) }}" class="btn btn-success" title="">Edit Location</a>
                    <a href="{{ route('setup.location.locations') }}" class="btn btn-info" title="">Back</a>
                </div>
                <br>
                <div class="body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" required value="{{ $location->name }}" disabled>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Abbreviation</label>
                                <input type="text" class="form-control" name="abbreviation" value="{{ $location->abbreviation }}" disabled>
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Sub-Location</label>
                                <select class="form-control" name="sublocation_id" value="{{ $location->name }}" disabled>
                                    @if ($locations->isNotEmpty())
                                        <option value="{{ $locations[0]->bname }}" selected>{{ $locations[0]->bname }}</option>
                                    @else
                                        <option value="">Select...</option>
                                    @endif
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
                                <input type="text" class="form-control" name="city" value="{{ $location->city }}" disabled>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>State</label>
                                <input type="text" class="form-control" name="state" value="{{ $location->state }}" disabled>
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Country</label>
                                <select class="form-control" name="country_id" value="{{ $location->country_id }}" disabled>
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
                                <input type="text" class="form-control" name="zip_code" value="{{ $location->zip_code }}" disabled>
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Address 1</label>
                                <textarea class="form-control" rows="3" cols="10" name="address_1" value="{{ $location->address_1 }}" disabled></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Address 2</label>
                                <textarea class="form-control" rows="3" cols="10" name="address_2" value="{{ $location->address_2 }}" disabled></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Phone #</label>
                                <input type="text" class="form-control" name="phone_no" value="{{ $location->phone_no }}" disabled>
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
                                <input type="checkbox" name="use_bins" value="1" {{ ($location->use_bins ? 'checked' : '') }} disabled>
                            </div>
                        </div>
                      </div>
                     <div class="row">
                       <div class="col-lg-2">
                           <div class="form-group">
                               <label>Idx</label>
                               <input type="text" class="form-control" name="idx" required data-parsley-trigger="keyup" data-parsley-type="digits"  value="{{ $location->idx }}" disabled>
                           </div>
                       </div>
                     </div>
                     <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Date Created</label>
                                <input type="text" id="dt_created" data-date-autoclose="true" value="{{ $location->dt_created }}" class="form-control datepicker" name="dt_created" disabled>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Created by </label>
                                <input type="text" id="created_by" data-date-autoclose="true" value="{{ $location->created_by }}" class="form-control datepicker" name="created_by" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="actionBtn" style="margin-bottom: 5%;">
                <a href="{{ route('setup.location.edit_location', $location->location_id) }}" class="btn btn-success" title="">Edit Location</a>
                <a href="{{ route('setup.location.locations') }}" class="btn btn-info" title="">Back</a>
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
    $('input[type="checkbox"]').change(function() {
        this.value = (Number(this.checked));
    });
</script>
@endsection
