<div id="salesRepeatCustomer">
    <table class="table table-bordered salesRepeatCustomer" id="printDatatable">
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
</div>
