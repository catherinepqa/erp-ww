<table class="table table-bordered">
    <thead>
        <tr>
            <th>ACCOUNT</th>
            <th>TYPE</th>
            <th>DATE</th>
            <th>DOCUMENT NUMBER</th>
            <th>CUSTOMER</th>
            <th>MEMO</th>
            <th>PAYMENT METHOD</th>
            <th>INVOICE AMOUNT</th>
            <th>AMOUNT PAID</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dailySales as $sales)
            <tr>
                <td></td>
                <td>{{ $sales->customer_id }}</td>
                <td>{{ $sales->so_date }}</td>
                <td>{{ $sales->so_date }}</td>
                <td></td>
                <td>{{ count($dailySales) }}</td>
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
