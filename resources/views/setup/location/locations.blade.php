@extends('template')

@section('title', 'Locations')

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
    <div class="col-md-6 col-sm-12 text-right hidden-xs">
        <a href="{{ route('setup.location.new_location') }}" class="btn btn-sm btn-primary" title="">New Location</a>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="body">
               <div class="row">
                   <div class="col-lg-6">
                       <div class="row">
                           <div class="col-lg-1">
                               <label>View</label>
                           </div>
                           <div class="col-lg-6">
                               <select class="form-control">
                                   <option value="">Select...</option>
                               </select>
                           </div>
                           <div class="col-lg-3">
                               <button class="btn btn-default btn-block" type="button">Edit View</button>
                           </div>
                       </div>
                   </div>
               </div>

                <div class="row" style="margin-top: 3%;">
                    <div class="col-lg-12">
                        <ul class="accordion2">
                            <li class="accordion-item">
                                <h3 class="accordion-thumb"><span>Filter</span></h3>
                                <div class="accordion-panel" style="display: none;">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>Type</label>
                                                <select class="form-control">
                                                    <option value="">Select...</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>Location</label>
                                                <select class="form-control">
                                                    <option value="">Select...</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>Style</label>
                                                <select class="form-control">
                                                    <option value="">Select...</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <button class="btn btn-info pull-right" type="button">Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="row" style="margin-top: 3%;">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover dataTable js-exportable">
                                <thead>
                                <tr>
                                    <th>Actions</th>
                                    <th>Internal ID</th>
                                    <th>Name</th>
                                    <th>Abbreviation</th>
                                    <th>Sub-Location</th>
                                    <!-- <th>Location Type</th> -->
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Country</th>
                                    <th>ZIP Code</th>
                                    <th>Address 1</th>
                                    <th>Address 2</th>
                                    <th>Phone #</th>
                                    <!-- <th>Logo</th> -->
                                    <th>Use Bins</th>
                                    <th>Idx</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($locations))
                                        @foreach ($locations as $location)
                                            <tr>
                                                <th><a href="{{ route('setup.location.edit_location', $location->location_id) }}" title="">Edit</a> | <a href="{{ route('setup.location.view_location', $location->location_id) }}" title="">View</a></th>
                                                <td>{{ $location->location_id }}</td>
                                                <td>{{ $location->name }}</td>
                                                <td>{{ $location->abbreviation }}</td>
                                                @if (!$location->sublocations->isEmpty())
                                                    @foreach ($location->sublocations as $subloc)
                                                        <td>{{ $subloc->name }}</td>
                                                    @endforeach
                                                @else
                                                    <td></td>
                                                @endif
                                                <td>{{ $location->city }}</td>
                                                <td>{{ $location->state }}</td>
                                                <td>{{ $location->countries->name }}</td>
                                                <td>{{ $location->zip_code }}</td>
                                                <td>{{ $location->address_1 }}</td>
                                                <td>{{ $location->address_2 }}</td>
                                                <td>{{ $location->phone_no }}</td>
                                                <td>{{ $location->use_bins }}</td>
                                                <td>{{ $location->idx }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script src="{{ URL::asset('assets/js/pages/forms/setup.js') }}"></script>
@endsection
