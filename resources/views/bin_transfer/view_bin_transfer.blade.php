@extends('template')

@section('title', 'Bin Transfer')

@section('css')

@endsection

@section('breadcrumb')
    <div class="col-md-6 col-sm-12">
        <h1>View Bin Transfer Transaction</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Inventory</li>
                <li class="breadcrumb-item">Bin Transfer</li>
                <li class="breadcrumb-item active" aria-current="page">View Bin Transfer Transaction</li>
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
                    <a href="{{ route('bintransfer.edit', $bin_transfer->bin_transfer_id) }}" class="btn btn-success" title="">Edit Transfer</a>
                    <a href="{{ route('inventory.bin_transfer') }}" class="btn btn-info" title="">Back</a>
                </div>
                <br>
                <div class="body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Bin Transfer #</label>
                                <p>{{ $bin_transfer->reference_no }}</p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Location</label>
                                <select class="form-control" name="location" disabled>
                                    <option value="{{ $bin_transfer->location_id }}">{{ $bin_transfer->location_id }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Transfer Date</label>
                                <input type="text" id="date" data-date-autoclose="true" value="{{ $bin_transfer->transferred_date }}" class="form-control datepicker" name="transfer_date" disabled>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Memo</label>
                                <input type="text" class="form-control" name="memo" value="{{ $bin_transfer->memo }}" disabled>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Date Created</label>
                                <input type="text" id="dt_created" data-date-autoclose="true" value="{{ $bin_transfer->dt_created }}" class="form-control datepicker" name="dt_created" disabled>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Created by </label>
                                <input type="text" id="created_by" data-date-autoclose="true" value="{{ $bin_transfer->created_by }}" class="form-control datepicker" name="created_by" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="actionBtn" style="margin-bottom: 5%;">
                <a href="{{ route('bintransfer.edit', $bin_transfer->bin_transfer_id) }}" class="btn btn-success" title="">Edit Transfer</a>
                <a href="{{ route('inventory.bin_transfer') }}" class="btn btn-info" title="">Back</a>
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
</script>
@endsection
