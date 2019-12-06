<div id="totalSales">
    <table class="table table-bordered totalSales" id="printDatatable">
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
                <tr class="oldTr">
                    <td></td>
                    <td>{{ $sales->customer_id }}</td>
                    <td>{{ $sales->so_date }}</td>
                    <td>{{ $sales->so_date }}</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
