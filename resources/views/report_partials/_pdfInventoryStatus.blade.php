<table class="table table-bordered">
    <thead>
        <tr>
            <th colspan="2">ITEM</th>
            <th colspan="7">01 FINISHED GOODS</th>
            <th colspan="7">TOTAL</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>ITEM</td>
            <td>DESCRIPTION</td>

            <td>Reorder Pt.</td>
            <td>Preferred Stock Level</td>
            <td>QTY on Work Order</td>
            <td>Current On Hand</td>
            <td>QTY Committed</td>
            <td>QTY Transit</td>
            <td>QTY on Back Order</td>

            <td>Reorder Pt.</td>
            <td>Preferred Stock Level</td>
            <td>QTY on Work Order</td>
            <td>Current On Hand</td>
            <td>QTY Committed</td>
            <td>QTY Transit</td>
            <td>QTY on Back Order</td>
        </tr>
        <?php $name = null; ?>
        @foreach ($item_types as $item)
            @if ($name != $item->name)
                <tr class="newTr">
                    <td>{{ $item->name }}</td>
                </tr>
                <tr class="newTr loadedTr" >
                    <td>{{ $item->item_name }}</td>
                    <td>{{ $item->item_description }}</td>
                    <td>0</td>
                    <td>{{ $item->preferred_stock_level }}</td>
                    <td>{{ $item->qty_on_order }}</td>
                    <td>{{ $item->qty_on_hand }}</td>
                    <td>{{ $item->qty_committed }}</td>
                    <td>{{ $item->qty_in_transit }}</td>
                    <td>{{ $item->qty_back_ordered }}</td>

                    <td>0</td>
                    <td>{{ $item->preferred_stock_level }}</td>
                    <td>{{ $item->qty_on_order }}</td>
                    <td>{{ $item->qty_on_hand }}</td>
                    <td>{{ $item->qty_committed }}</td>
                    <td>{{ $item->qty_in_transit }}</td>
                    <td>{{ $item->qty_back_ordered }}</td>
                </tr>
            @else
                <tr class="newTr">
                    <td>{{ $item->item_name }}</td>
                    <td>{{ $item->item_description }}</td>
                    <td>0</td>
                    <td>{{ $item->preferred_stock_level }}</td>
                    <td>{{ $item->qty_on_order }}</td>
                    <td>{{ $item->qty_on_hand }}</td>
                    <td>{{ $item->qty_committed }}</td>
                    <td>{{ $item->qty_in_transit }}</td>
                    <td>{{ $item->qty_back_ordered }}</td>

                    <td>0</td>
                    <td>{{ $item->preferred_stock_level }}</td>
                    <td>{{ $item->qty_on_order }}</td>
                    <td>{{ $item->qty_on_hand }}</td>
                    <td>{{ $item->qty_committed }}</td>
                    <td>{{ $item->qty_in_transit }}</td>
                    <td>{{ $item->qty_back_ordered }}</td>
                </tr>
            @endif
            <?php $name = $item->name; ?>
        @endforeach
    </tbody>
</table>

<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        border: 1px solid #040404;
    }

    td, th {
        border: 1px solid black;
        text-align: center;
    }
</style>
