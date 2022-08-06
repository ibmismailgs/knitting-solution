<table class="table table-bordered stripe" width="100%">
    <tr>
        <th>Order Number</th>
        <th>Febric Type</th>
        <th>Quantity In KG</th>
        <th>Rate</th>
        <th>Amount</th>
        <th>Note</th>
    </tr>
    @foreach ($bill_details as $key=>$bill)
    <tr>
        <td>{{ $collectPartyorder[$key]->party_order_no }}</td>
        <td>{{ $collectFabtype[$key]->fabric_type }}</td>
        <td>{{ $bill->quantity }}<input type="hidden" name="fab_delivery_id[]" value="{{ $bill->fab_delivery_id  }}"></td>
        <td>{{ $bill->rate }}</td>
        <td>{{ $bill->amount }}</td>
        <td><input type="text" name="note[]"></td>
    </tr>
    @endforeach
</table>
