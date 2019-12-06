<table class="table table-bordered">
    <thead>
        <tr>
            <th>ITEM</th>
            <th>ITEM DESC</th>
            <th>QTY. SOLD</th>
            <th>NET REVENUE</th>
            <th>EST. GROSS PROFIT</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($totalSales as $sales)
            <tr>
                <td></td>
                <td>{{ $sales->customer_id }}</td>
                <td>{{ $sales->so_date }}</td>
                <td>{{ $sales->so_date }}</td>
                <td></td>
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
