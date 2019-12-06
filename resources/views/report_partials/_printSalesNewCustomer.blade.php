<div id="salesNewCustomer">
    <table class="table table-bordered salesNewCustomer" id="printDatatable">
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
            @foreach ($salesNew as $sales)
                <tr class="oldTr">
                    <td></td>
                    <td>{{ $sales->customer_id }}</td>
                    <td>{{ $sales->so_date }}</td>
                    <td>{{ $sales->so_date }}</td>
                    <td>{{ $sales->gross_amount }}</td>
                    <td>{{ count($salesNew) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
