@extends('template')

@section('title', 'Trouser Length')

@section('breadcrumb')
    <div class="col-md-6 col-sm-12">
        <h1>Trouser Length</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Setup</li>
                <li class="breadcrumb-item active" aria-current="page">Trouser Length</li>
            </ol>
        </nav>
    </div>
    <div class="col-md-6 col-sm-12 text-right hidden-xs">
        <a href="{{ route('setup.trouser_length.new') }}" class="btn btn-sm btn-primary" title="">New Trouser Length</a>
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
                                                <label>Trouser Length</label>
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
                                    <th>Idx</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($trouserLengths))
                                        @foreach ($trouserLengths as $trouserLength)
                                            <tr>
                                                <th><a href="{{ route('setup.trouser_length.edit', $trouserLength->trouser_length_id) }}" title="">Edit</a> | <a href="{{ route('setup.trouser_length.view', $trouserLength->trouser_length_id) }}" title="">View</a></th>
                                                <td>{{ $trouserLength->trouser_length_id }}</td>
                                                <td>{{ $trouserLength->name }}</td>
                                                <td>{{ $trouserLength->abbreviation }}</td>
                                                <td>{{ $trouserLength->idx }}</td>
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
