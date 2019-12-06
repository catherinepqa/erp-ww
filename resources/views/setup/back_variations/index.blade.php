@extends('template')

@section('title', 'Back Variations')

@section('breadcrumb')
    <div class="col-md-6 col-sm-12">
        <h1>Back Variations</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Setup</li>
                <li class="breadcrumb-item active" aria-current="page">Back Variations</li>
            </ol>
        </nav>
    </div>
    <div class="col-md-6 col-sm-12 text-right hidden-xs">
        <a href="{{ route('setup.back_variations.new') }}" class="btn btn-sm btn-primary" title="">New Back Variations</a>
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
                                   <option disabled selected value>Select...</option>
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
                                                    <option disabled selected value>Select...</option>
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
                                                    <option disabled selected value>Select...</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>Back Variations</label>
                                                <select class="form-control">
                                                    <option disabled selected value>Select...</option>
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
                                    <th>Idx</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($backVariations))
                                        @foreach ($backVariations as $backVariation)
                                            <tr>
                                                <th><a href="{{ route('setup.back_variations.edit', $backVariation->back_variation_id) }}" title="">Edit</a> | <a href="{{ route('setup.back_variations.view', $backVariation->back_variation_id) }}" title="">View</a></th>
                                                <td>{{ $backVariation->back_variation_id }}</td>
                                                <td>{{ $backVariation->name }}</td>
                                                <td>{{ $backVariation->abbreviation }}</td>
                                                <td>{{ $backVariation->idx }}</td>
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
