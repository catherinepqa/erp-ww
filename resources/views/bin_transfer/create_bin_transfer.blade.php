@extends('template')

@section('title', 'Bin Transfer')

@section('css')

@endsection

@section('breadcrumb')
    <div class="col-md-6 col-sm-12">
        <h1>Edit Bin Transfer Transaction</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Inventory</li>
                <li class="breadcrumb-item">Bin Transfer</li>
                <li class="breadcrumb-item active" aria-current="page">Edit Bin Transfer Transaction</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <!-- CONTENT -->
    <div class="row">
        <form action="{{ action('BinTransferController@update', $bin_transfer->bin_transfer_id) }}" enctype="multipart/form-data" method="post">
            {{ csrf_field() }}
            {{ method_field('put') }}
            <div class="col-lg-12">
                <div class="card">
                    <div class="actionBtn">
                        <button class="btn btn-success" type="submit">Save</button>
                        <a href="{{ route('inventory.bin_transfer') }}" class="btn btn-danger" title="">Cancel</a>
                        <button class="btn btn-info" type="button">Reset</button>
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
                                    <select class="form-control" name="location" id="location_id" onchange="checkLocationItems(this)">
                                        @foreach ($locations as $location)
                                            @if ($location->location_id == $bin_transfer->location_id)
                                                <option value="{{ $location->location_id }}" selected>{{ $location->name }}</option>
                                            @else
                                                <option value="{{ $location->location_id }}">{{ $location->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Transfer Date <span class="required">*</span> </label>
                                    <input type="text" id="date" data-date-autoclose="true" class="form-control datepicker" name="transfer_date" value="{{ $bin_transfer->transferred_date }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Memo</label>
                                    <input type="text" class="form-control" name="memo" value="{{ $bin_transfer->memo }}">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="tab-pane show active" id="bin">
                            <div class="table-responsive">
                                <table id="adjTbl" class="table table-hover js-basic-example dataTable table-custom spacing5">
                                    <thead>
                                    <tr>
                                        <th>Item <span class="required">*</span></th>
                                        <th>Description</th>
                                        <th>Preferred Bin</th>
                                        <th>Units</th>
                                        <th>Quantity <span class="required">*</span></th>
                                        <th>Inventory Detail</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <br>
                            <button class="btn btn-outline-info addBtn" type="button">Add Data</button>
                            <div class="hidden_values" style="display: none"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="actionBtn" style="margin-bottom: 5%;">
                    <button class="btn btn-success" type="submit">Save</button>
                    <a href="{{ route('inventory.bin_transfer') }}" class="btn btn-danger" title="">Cancel</a>
                    <button class="btn btn-info" type="button">Reset</button>
                </div>
            </div>
        </form>
    </div>
    <!-- INVENTORY DETAIL MODALS -->
    <div class="modal fade intdetail_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="actionBtn col-md-12">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Inventory Details</h4>
                    </div>

                </div>
                <div class="modal-body">
                    <div class="actionBtn">
                        <button class="btn btn-success" type="submit">Save</button>
                        |
                        <button class="btn btn-info" type="button">Reset</button>
                    </div>
                    <br>
                    <div class="body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>ITEM</label>
                                    <strong><p class="item_name intDetail"></p></strong>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>QUANTITY</label>
                                    <strong><p class="item_qty intDetail"></p></strong>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>DESCRIPTION</label>
                                    <strong><p class="item_desc intDetail"></p></strong>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>UNITS</label>
                                    <strong><p class="item_unit intDetail"></p></strong>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane">
                            <div class="table-responsive">
                                <table id="table" class="table table-hover js-basic-example dataTable table-custom spacing5">
                                    <thead>
                                        <tr>
                                            <th>From Bins <span class="required">*</span></th>
                                            <th>To Bins <span class="required">*</span></th>
                                            <th>Available</th>
                                            <th>Quantity <span class="required">*</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select class="form-control from_bin_id intDetailTo" name="from_bin_id">
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control to_bin_id intDetailFrom" name="to_bin_id">
                                                </select>
                                            </td>
                                            <td><input type="text" name="available" value="" class="intDetail" disabled id="available"> </td>
                                            <td><input type="text" class="bin_quantity intDetailQty intDetail" name="quantity" value="" id="quantity"> </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="actionBtn">
                        <button class="btn btn-success intBtnSave" type="button" onClick="saveInventoryDetail(this);">Save</button>
                        |
                        <button class="btn btn-info" type="button">Reset</button>
                    </div>
                </div>
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

    var count = 0;

    $( document ).ready(function() {
        checkLocationItems();
        checkItemBin([], $('#location_id').val());
    });

    function checkLocationItems() {
        var location_id   = $('#location_id').val();
        $.ajax({
            url: "{{ action('BinTransferController@checkLocationItems') }}",
            method: 'GET',
            dataType: "json",
            data: {'location_id': location_id},
            success: function (data) {
                $('.activeSelect').empty();
                $('.activeSelect').append($("<option></option>").text('Select item'));
                $.each(data.data, function(key, value) {
                    $('.activeSelect')
                        .append($("<option></option>")
                        .attr("value", value.item_name)
                        .attr("dataid", value.item_id)
                        .attr("locationid", location_id)
                        .text(value.item_name));

                });
            },
            error: function () {
            }
        })
    }


    function checkItemBin(data = 0, locId = 0) {
        var item_id = null;
        if (data != 0) {
            var item_id = data.options[data.selectedIndex].getAttribute('dataid');
            var location_id = data.options[data.selectedIndex].getAttribute('locationid');
            var selectid = data.getAttribute('selectid');
        }

        if (locId != 0) {
            var location_id = locId;
        }

        $('#btn' + selectid).val(item_id);

        $.ajax({
            url: "{{ action('BinTransferController@checkItemBin') }}",
            method: 'GET',
            dataType: "json",
            data: {'location_id': location_id, 'item_id': item_id},
            success: function (data) {
                addRowOnLoad(data);
            },
            error: function () {
            }
        })
    }



    function inventoryDetail(data) {
        var location_id   = $('#location_id').val();
        var item_id = data.value;

        $.ajax({
            url: "{{ action('BinTransferController@inventoryDetailForm') }}",
            method: 'GET',
            dataType: "json",
            data: {'location_id': location_id, 'item_id': item_id},
            success: function (data) {
                var item_id = data.item.item_id;

                $('.item_name').html(data.item.item_name);
                $('.item_desc').html(data.item.item_description);
                $('.item_qty').html(data.item.stock_unit);
                $('.item_unit').html(data.item.stock_unit);
                $('.intBtnSave').val(item_id);

                $('.to_bin_id').empty();
                $('.from_bin_id').empty();

                $.each(data.toBins, function(key, value) {
                    $('.to_bin_id')
                        .append($("<option></option>")
                        .attr("value", value.bin_no)
                        .attr("dataid", value.bin_id)
                        .attr("to_bin_item", value.bin_id)
                        .text(value.bin_no));
                });

                $('.from_bin_id')
                    .append($("<option></option>")
                    .attr("value", data.fromBins.bins.bin_no)
                    .attr("dataid", data.fromBins.bins.bin_id)
                    .text(data.fromBins.bins.bin_no));

                if ($('.intDetailTo' + item_id).length != 0) {
                    $('.to_bin_id').val($('.intDetailTo'+ item_id).attr('dataname'));
                    $('.from_bin_id').val($('.intDetailFrom'+ item_id).attr('dataname'));
                    $('.intDetailQty').val($('.intDetailQty'+ item_id).val());
                } else {
                    $('.intDetailQty').val('');
                }
            },
            error: function () {
            }
        })
    }

    function saveInventoryDetail(data) {
        if ($('.intDetailTo' + data.value).length == 0) {
            var inputToForm =
                '<input type="hidden" class="intDetailTo'+ data.value+'" name="to_bin_id['+ [data.value] +']" dataname="'+ $('.to_bin_id option:selected').val() +'" value="'+ $('.to_bin_id option:selected').attr('dataid') +'">' +
                '<input type="hidden" class="intDetailFrom'+ data.value+'" name="from_bin_id['+ [data.value] +']" dataname="'+ $('.from_bin_id option:selected').val() +'" value="'+ $('.from_bin_id option:selected').attr('dataid') +'">' +
                '<input type="hidden" class="intDetailQty'+ data.value+'" name="bin_quantity['+ [data.value] +']" value="'+ $('.bin_quantity').val() +'">'
            $('#hdnDiv').append(inputToForm);
        } else {
            $('.intDetailTo' + data.value).val($('.to_bin_id option:selected').attr('dataid'));
            $('.intDetailFrom' + data.value).val($('.from_bin_id option:selected').attr('dataid'));

            $('.intDetailTo' + data.value).attr("dataname", $('.to_bin_id option:selected').val());
            $('.intDetailFrom' + data.value).attr("dataname", $('.from_bin_id option:selected').val());

            $('.intDetailQty' + data.value).val($('.bin_quantity').val());
        }

        if (!$('.bin_quantity').val()) {
            alert("All fields are required!")
            return false;
        }
        $('.intdetail_modal').modal('hide');
        count++;
    }

</script>
@endsection
