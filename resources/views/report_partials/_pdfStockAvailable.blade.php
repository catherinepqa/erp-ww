<table class="table table-bordered">
    <thead>
        <tr>
            <th>EXTERNAL ID</th>
            <th>DISPLAY NAME</th>
            <th>LOCATION AVAILABLE</th>
            <th>LOCATION PREFERRED STOCK LEVEL</th>
            <th>OVERSELL</th>
            <th>DISPLAY IN WEBSITE</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($stocks as $stock)
            <tr>
                <td>{{ $stock->system_id }}</td>
                <td>{{ $stock->items->item_name }}</td>
                <td>{{ $stock->qty_on_hand }}</td>
                <td>{{ $stock->preferred_stock_level }}</td>
                <td>Yes</td>
                <td>No</td>
            </tr>
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
