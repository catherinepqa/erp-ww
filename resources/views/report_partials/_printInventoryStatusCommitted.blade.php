<div id="inventoryStatusCommitted">
    <table class="table table-bordered collageTable" id="printDatatable">
        <thead>
            <tr>
                <th colspan="2">ITEM</th>
                <th colspan="6">01 FINISHED GOODS</th>
                <th colspan="6">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>ITEM</td>
                <td>DESCRIPTION</td>

                <td>Current On Hand</td>
                <td>QTY Committed</td>
                <td>QTY on Work Order</td>
                <td>QTY on Back Order</td>
                <td>Total Needed</td>
                <td>Available SOH</td>


                <td>Current On Hand</td>
                <td>QTY Committed</td>
                <td>QTY on Work Order</td>
                <td>QTY on Back Order</td>
                <td>Total Needed</td>
                <td>Available SOH</td>
            </tr>
            <?php $name = null; ?>
            @foreach ($item_types as $item)
                @if ($name != $item->name)
                    <tr class="newTr loadedTr">
                        <td>{{ $item->name }}</td>
                    </tr>
                    <tr class="newTr loadedTr">
                        <td>{{ $item->item_name }}</td>
                        <td>{{ $item->item_description }}</td>
                        <td>{{ $item->qty_on_hand }}</td>
                        <td>{{ $item->qty_committed }}</td>
                        <td>{{ $item->qty_on_order }}</td>
                        <td>{{ $item->qty_back_ordered }}</td>
                        <td>0</td>
                        <td>0</td>

                        <td>{{ $item->qty_on_hand }}</td>
                        <td>{{ $item->qty_committed }}</td>
                        <td>{{ $item->qty_on_order }}</td>
                        <td>{{ $item->qty_back_ordered }}</td>
                        <td>0</td>
                        <td>{{ $item->qty_on_hand - $item->qty_committed }}</td>
                    </tr>
                @else
                    <tr class="newTr loadedTr">
                        <td>{{ $item->item_name }}</td>
                        <td>{{ $item->item_description }}</td>
                        <td>{{ $item->qty_on_hand }}</td>
                        <td>{{ $item->qty_committed }}</td>
                        <td>{{ $item->qty_on_order }}</td>
                        <td>{{ $item->qty_back_ordered }}</td>
                        <td>0</td>
                        <td>0</td>

                        <td>0</td>
                        <td>{{ $item->qty_on_hand }}</td>
                        <td>{{ $item->qty_committed }}</td>
                        <td>{{ $item->qty_on_order }}</td>
                        <td>{{ $item->qty_back_ordered }}</td>
                        <td>0</td>
                        <td>{{ $item->qty_on_hand - $item->qty_committed }}</td>
                    </tr>
                @endif
                <?php $name = $item->name; ?>
            @endforeach
        </tbody>
    </table>
</div>
