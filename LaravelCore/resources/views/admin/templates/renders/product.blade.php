@php
    $columnTitles = [
        'name' => 'Product Name',
        'price' => 'Price',
        'sum_stock' => 'Total Stock',
        'stock_limit' => 'Stock Threshold',
        'created_at' => 'Created Date',
    ];
@endphp
<div id="render-container">
    <div>
        <table>
            <thead>
                <tr>
                    @foreach ($columns as $column)
                        <th>{{ $columnTitles[$column] ?? $column }}</th>
                    @endforeach
                    <th>unit_id</th>
                    <th>unit_created_at</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    @foreach ($product->variables as $variable)
                        @foreach ($variable->units as $unit)
                            <tr>
                                @foreach ($columns as $column)
                                    <td>
                                        @switch($column)
                                            @case('name')
                                                {{ $product->name }} {{ $variable->name ? '- ' . $variable->name : '' }}
                                            @break

                                            @case('price')
                                                {{ $unit->price }}
                                            @break

                                            @case('sum_stock')
                                                {{ $variable->sumStocks() }}
                                            @break

                                            @case('stock_limit')
                                                {{ $variable->stock_limit }}
                                            @break

                                            @case('created_at')
                                                {{ isset($unit->created_at) ? \Carbon\Carbon::parse($unit->created_at)->format('d/m/Y') : '' }}
                                            @break

                                            @default
                                                {{ 'N/A' }}
                                        @endswitch
                                    </td>
                                @endforeach
                                <td>
                                    {{ $unit->id }}
                                </td>
                                <td>
                                    {{ Hash::make($unit->created_at) }}
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
