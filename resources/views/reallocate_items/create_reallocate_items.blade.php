@extends('template')

@section('title', 'Reallocate Items')

@section('css')

@endsection

@section('breadcrumb')
    <div class="col-md-6 col-sm-12">
        <h1>Reallocate New Item</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">Inventory</li>
                <li class="breadcrumb-item">Reallocate Items</li>
                <li class="breadcrumb-item active" aria-current="page">Reallocate New Item</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
<!-- CONTENT -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <form class="" id="myform" action="{{ action('ReallocateItemsController@qtyCommitted') }}" enctype="multipart/form-data" method="post">
                {{ csrf_field() }}
                <div class="actionBtn">
                    <button class="btn btn-success" type="submit">Save</button>
                    <a href="{{ route('inventory.reallocate_item') }}" class="btn btn-danger" title="">Cancel</a>
                    <button class="btn btn-info" type="button">Reset</button>
                </div>
                <br>
                <div class="body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Items</label>
                                        <select class="form-control" name="item_id" id="item_id">
                                            <option id="option">Select item...</option>
                                            @foreach ($items as $item)
                                                <option value="{{ $item->item_id }}">{{ $item->item_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>Quantity Required</label>
                                            <p id="qty_required"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Locations</label>
                                        <select class="form-control" name="location" id="location_id" disabled onchange="getSalesOrder(this)">
                                            <option>Select location...</option>
                                            @foreach ($locations as $location)
                                                <option value="{{ $location->location_id }}">{{ $location->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>Quantity Picked</label>
                                            <p id="qty_picked"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Quantity On Hand</label>
                                        <p id="qty_on_hand"></p>
                                        <input type="hidden" name="" id="qty_on_hand_hdn" value="">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Quantity Committed</label>
                                        <p id="qty_committed"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row" id="sales_order">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover dataTable table-bordered">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" name="" value="" checked id="chckbox"></th>
                                            <th>Order Date</th>
                                            <th>Order No.</th>
                                            <th>Special Order</th>
                                            <th>Customer</th>
                                            <th>Quantity Ordered</th>
                                            <th>Quantity Remaining</th>
                                            <th>Quantity Received</th>
                                            <th>Commit</th>
                                            <th>Quantity Committed</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="hidden" id="hdnDiv">

                </div>
                <div class="actionBtn">
                    <button class="btn btn-success" type="submit">Save</button>
                    <a href="{{ route('inventory.reallocate_item') }}" class="btn btn-danger" title="">Cancel</a>
                    <button class="btn btn-info" type="button">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('js')
<script>
    $("#item_id").change(function(){
        $('#location_id').prop('disabled', false);
        $('#option').prop('disabled', true);
    });

    $("#chckbox").click(function(){
        $('.checkbox').prop('checked', $(this).prop('checked'));
    });

    function getSalesOrder(location) {
        var item_id = $('#item_id option:selected').val();
        var location_id = location.options[location.selectedIndex].value;

        $.ajax({
            url: "{{ action('ReallocateItemsController@getSalesOrderItems') }}",
            method: 'GET',
            dataType: "json",
            data: {'location_id': location_id, 'item_id': item_id},
            success: function (data) {
                $('#sales_order tbody').empty();
                var inputs = [];

                $('#qty_on_hand').html(data.item.inventory_items[0].qty_on_hand);
                $('#qty_on_hand_hdn').val(data.item.inventory_items[0].qty_on_hand);
                $('#qty_committed').html(data.item.inventory_items[0].qty_committed);

                $.each(data.sales, function(key, value) {
                    inputs.push('<tr>\n' +
                        '<td><input type="checkbox" class="chckbx" name="sales_order_items_id" class="checkbox" value="'+ value.system_id +'" checked id="'+ value.system_id +'"></td>\n' +
                        '<td>'+ value.dt_created +'</td>\n' +
                        '<td>'+ value.sales_order_id +'</td>\n' +
                        '<td></td>\n' +
                        '<td>'+ value.customer_id +'</td>\n' +
                        '<td>'+ value.qty_ordered +'</td>\n' +
                        '<td></td>\n' +
                        '<td>'+ value.qty_received +'</td>\n' +
                        '<td></td>\n' +
                        '<td><input type="text" name="" value="" class="'+ value.system_id +'" onkeyup="less_qty_hand(this);"></td>\n' +
                        '</tr>')

                    return
                });

                $('#sales_order tbody').append(inputs);
            },
            error: function () {
            }
        })
    }

    function less_qty_hand (data) {
        var currentVal = $('#qty_on_hand_hdn').val();
        var less = data.value;
        $('#qty_on_hand').html(currentVal - less);
    }

    $('#myform').submit(function(e) {
        var hdnInputs = [];

        $.each($('.chckbx'), function(key, value) {
            var qty_committed = $('.' + value.id).val();

            if ($('#' + value.id).prop('checked') == true && $('.' + value.id).val() != '') {
                $('#hdnDiv').append('<input type="hidden"  name="sales_order_items_id[]" value="'+ value.id +'">' +
                '<input type="hidden" name="qty_committed[]" value="'+ qty_committed +'">');
            } else {
                alert('Please fill up required fields');
                e.preventDefault();
            }
        });
    });

</script>
@endsection
