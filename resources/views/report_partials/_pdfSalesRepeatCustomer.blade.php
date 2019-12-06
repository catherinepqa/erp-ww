<table class="table table-bordered">
    <thead>
        <tr>
            <th>COUNTRY</th>
            <th>CUSTOMER</th>
            <th>FIRST SALES DATA</th>
            <th>ORDER DATE</th>
            <th>SALES (GROSS) ()</th>
            <th>NUMBER OF CUSTOMERS ()</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Phil</td>
        </tr>
        @foreach ($salesRepeat as $sales)
            <tr>
                <td></td>
                <td>{{ $sales->customer_id }}</td>
                <td>{{ $sales->so_date }}</td>
                <td>{{ $sales->so_date }}</td>
                <td>{{ $sales->gross_amount }}</td>
                <td>{{ count($salesRepeat) }}</td>
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
