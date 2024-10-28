<h2 class="text-center mb-4">Bid Analysis Comparison</h2>

<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                @foreach ($bidComparisons as $comparison)
                    <th colspan="2" class="text-center">
                        {{ $comparison->supplier_name }}<br>
                        <small>
                            Currency: {{ $comparison->currency }}<br>
                            Payment Term: {{ $comparison->payment_term }}<br>
                            Delivery Period: {{ $comparison->delivery_period }}
                        </small>
                    </th>
                @endforeach
            </tr>
            <tr>
                <th>Sl No</th>
                <th>VAT</th>
                <th>Item Name</th>
                <th>Unit</th>
                <th>Quantity</th>
                @foreach ($bidComparisons as $comparison)
                    <th>Unit Cost ({{ $comparison->currency }})</th>
                    <th>Total Cost ({{ $comparison->currency }})</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td><input type="checkbox" checked disabled></td>
                <td>ERP Product</td>
                <td>Number(1)</td>
                <td>{{ $qty }}</td>
                @foreach ($bidComparisons as $comparison)
                    <td class="base-amount {{ $comparison->unit_cost == $selectedBid->unit_cost ? 'highlight' : '' }}" data-id="{{ $comparison->id }}">
                        {{ number_format($comparison->unit_cost, 2) }}
                    </td>
                    @php $total_cost = $comparison->unit_cost * $qty; @endphp
                    @php $totalMinUnitCost = $selectedBid->unit_cost * $qty; @endphp
                    <td class="base-amount {{ $total_cost == $totalMinUnitCost ? 'highlight' : '' }}" data-id="{{ $comparison->id }}">
                        {{ number_format($total_cost, 2) }}
                    </td>
                @endforeach
            </tr>
            <tr>
                <td colspan="5" class="text-end">Net Total Value</td>
                @foreach ($bidComparisons as $comparison)
                    @php $net_total_value = $comparison->unit_cost * $qty; @endphp
                    <td colspan="2" class="text-end">{{ number_format($net_total_value, 2) }}</td>
                @endforeach
            </tr>
            <tr>
                <td colspan="5" class="text-end">Net Value of the Awarded Item</td>
                @foreach ($bidComparisons as $comparison)
                    @php $net_value_awarded = $comparison->unit_cost == $selectedBid->unit_cost ? $comparison->unit_cost * $qty : 0; @endphp
                    <td colspan="2" class="text-end">{{ number_format($net_value_awarded, 2) }}</td>
                @endforeach
            </tr>
            <tr>
                <td colspan="5" class="text-end">VAT for the Awarded Item</td>
                @foreach ($bidComparisons as $comparison)
                    @php $net_total_value = $comparison->unit_cost * $qty;
                    $vat = $comparison->unit_cost == $selectedBid->unit_cost ? $net_total_value * ($comparison->vat/100) : 0; @endphp
                    <td colspan="2" class="text-end">{{ number_format($vat, 2) }}</td>
                @endforeach
            </tr>
            <tr>
                <td colspan="5" class="text-end">Net Total Value of the Awarded Item</td>
                @foreach ($bidComparisons as $comparison)
                    @php
                    $net_total_value = $comparison->unit_cost * $qty;
                    $vat = $net_total_value * ($comparison->vat/100);
                    $net_total_value_awarded = $comparison->unit_cost == $selectedBid->unit_cost ? $net_total_value + $vat : 0;
                    @endphp
                    <td colspan="2" class="text-end">{{ number_format($net_total_value_awarded, 2) }}</td>
                @endforeach
            </tr>
            <tr>
                <td colspan="4" class="text-center">Supplier Name</td>
                <td colspan="7" class="text-center">Awarded Line</td>
            </tr>
            <tr>
                <td colspan="4" class="text-center">{{ $selectedBid->supplier_name }}</td>
                <td colspan="7" class="text-center">{{ $selectedBid->awarded_line }}</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="mt-4">
    <h4>Award Submission Recommendation</h4>
    @php
    $net_total_value = $selectedBid->unit_cost * $qty;
    $vat = $net_total_value * ($selectedBid->vat/100);
    $net_total_value_awarded = $net_total_value + $vat;
    @endphp
    <p>Items # ({{ $selectedBid->awarded_line }}) To M/S. {{ $selectedBid->supplier_name }} @ {{ $selectedBid->currency }} {{ number_format($net_total_value_awarded, 2) }}</p>
</div>

<div class="mt-3">
    <h4>Comment:</h4>
    <p>Save {{ $selectedBid->supplier_name }}</p>
</div>