<div class="p-2 bg-light text-dark web-rendered-data">
    @if (!empty($stock))
        <ul class="list-group list-group-flush">
            @foreach ($stock as $item)
                <li class="list-group-item">
                    <strong>{{ $item['product_name'] ?? '' }} - {{ $item['variable_name'] ?? '' }} </strong><br>
                    Giá: {{ number_format($item['unit_price'] ?? 0) }} {{ $config['currency'] }}<br>
                    Số lượng: {{ $item['total_base_unit'] ?? 0 }}- {{ $item['unit_term'] ?? '' }}
                </li>
            @endforeach
        </ul>
    @endif
</div>
