<div id="dailySales">
    <table class="table table-bordered dailySales" id="printDatatable">
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
                <th>AMOUNT PAIDasd</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dailySales as $sales)
                <tr class="oldTr">
                    <td></td>
                    <td>{{ $sales->customer_id }}</td>
                    <td>{{ $sales->so_date }}</td>
                    <td>{{ $sales->so_date }}</td>
                    <td></td>
                    <!-- <td>{{ count($dailySales) }}</td> -->
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
