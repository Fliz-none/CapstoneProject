@php
    $columnTitles = [
        'name' => __('messages.product.product_name'),
        'price' => __('messages.product.price'),
        'sum_stock' => __('messages.product.total_stock'),
        'sku' => 'SKU',
        'quantity_sold' => __('messages.product.quantity_sold'),
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
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    @foreach ($product->variables as $variable)
                            <tr>
                                @foreach ($columns as $column)
                                    <td>
                                        @switch($column)
                                            @case('name')
                                                {{ $product->name }} {{ $variable->name ? '- ' . $variable->name : '' }}
                                            @break

                                            @case('price')
                                                {{ number_format($variable->units->sortBy('rate')->first()->price) }}
                                            @break

                                            @case('sum_stock')
                                                {{ number_format($variable->sumStocks()) }}
                                            @break

                                            @case('sku')
                                                {{ $product->sku }}
                                            @break

                                            @case('quantity_sold')
                                                {{ number_format($variable->quantitySold) }}
                                            @break

                                            @default
                                                {{ 'N/A' }}
                                        @endswitch
                                    </td>
                                @endforeach
                            </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
