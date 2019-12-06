<div id="salesCustomer">
    <table class="table table-bordered salesCustomer" id="printDatatable">
        <thead>
            <tr>
                <th>COUNTRY</th>
                <th>CUSTOMER</th>
                <th>FIRST SALES DATA</th>
                <th>ORDER DATE</th>
                <th>SALES (NET) ()</th>
                <th>% OF SALES (NET)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($salesCustomer as $sales)
                <tr class="oldTr">
                    <td></td>
                    <td>{{ $sales->customer_id }}</td>
                    <td>{{ $sales->so_date }}</td>
                    <td>{{ $sales->so_date }}</td>
                    <td>{{ $sales->gross_amount }}</td>
                    <td>{{ count($salesCustomer) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
