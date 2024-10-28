<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Bid Analysis Comparison</title>

        <style>
            .highlight {
                background-color: yellow !important;
            }
        </style>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>

        <div class="container my-5">
        <div id="load_div">
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
                                <td class="base-amount {{ $comparison->unit_cost == $lowestBid->unit_cost ? 'highlight' : '' }}" data-id="{{ $comparison->id }}">
                                    {{ number_format($comparison->unit_cost, 2) }}
                                </td>
                                @php $total_cost = $comparison->unit_cost * $qty; @endphp
                                @php $totalMinUnitCost = $lowestBid->unit_cost * $qty; @endphp
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
                                @php $net_value_awarded = $comparison->unit_cost == $lowestBid->unit_cost ? $comparison->unit_cost * $qty : 0; @endphp
                                <td colspan="2" class="text-end">{{ number_format($net_value_awarded, 2) }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td colspan="5" class="text-end">VAT for the Awarded Item</td>
                            @foreach ($bidComparisons as $comparison)
                                @php $net_total_value = $comparison->unit_cost * $qty;
                                $vat = $comparison->unit_cost == $lowestBid->unit_cost ? $net_total_value * ($comparison->vat/100) : 0; @endphp
                                <td colspan="2" class="text-end">{{ number_format($vat, 2) }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td colspan="5" class="text-end">Net Total Value of the Awarded Item</td>
                            @foreach ($bidComparisons as $comparison)
                                @php
                                $net_total_value = $comparison->unit_cost * $qty;
                                $vat = $net_total_value * ($comparison->vat/100);
                                $net_total_value_awarded = $comparison->unit_cost == $lowestBid->unit_cost ? $net_total_value + $vat : 0;
                                @endphp
                                <td colspan="2" class="text-end">{{ number_format($net_total_value_awarded, 2) }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td colspan="4" class="text-center">Supplier Name</td>
                            <td colspan="7" class="text-center">Awarded Line</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-center">{{ $lowestBid->supplier_name }}</td>
                            <td colspan="7" class="text-center">{{ $lowestBid->awarded_line }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <h4>Award Submission Recommendation</h4>
                @php
                $net_total_value = $lowestBid->unit_cost * $qty;
                $vat = $net_total_value * ($lowestBid->vat/100);
                $net_total_value_awarded = $net_total_value + $vat;
                @endphp
                <p>Items # ({{ $lowestBid->awarded_line }}) To M/S. {{ $lowestBid->supplier_name }} @ {{ $lowestBid->currency }} {{ number_format($net_total_value_awarded, 2) }}</p>
            </div>

            <div class="mt-3">
                <h4>Comment:</h4>
                <p>Save {{ $lowestBid->supplier_name }}</p>
            </div>
        </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

        <script>
            $(document).ready(function() {

                $(document).on('click', '.base-amount', function(e) { 
                    e.preventDefault();
                    var id = $(this).data('id');   
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        type: 'POST',
                        dataType: 'JSON',
                        data: {id: id},
                        url : '{{ route('bid-comparison.updated-version') }}',
                        success: function(response){
                            $('#load_div').html('');
                            $('#load_div').html(response.success.html);
                        },
                        
                    });
                });
            });
        </script>
    </body>
</html>
