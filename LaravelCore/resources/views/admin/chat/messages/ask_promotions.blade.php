
@foreach ($promotions as $promo)
    <div class="mb-3 p-2 border rounded web-rendered-data">
        {{-- Tên chương trình + chi nhánh --}}
        <strong>{{ $promo['name'] }}</strong><br>
        <small>🏬 {{ $promo['branch_name'] }}</small><br>

        {{-- Loại khuyến mãi --}}
        @php
            $typeLabel = '';
            switch ($promo['type']) {
                case 0:
                    $typeLabel = "Giảm {$promo['value']}%";
                    break;
                case 1:
                    $typeLabel = "Giảm " . number_format($promo['value']) . "₫";
                    break;
                case 2:
                    $typeLabel = "Mua {$promo['buy_quantity']} tặng {$promo['get_quantity']}";
                    break;
            }
        @endphp
        <small>🎁 {{ $typeLabel }}</small><br>

        {{-- Thời gian áp dụng --}}
        @php
            $start = $promo['start_date'] ? \Carbon\Carbon::parse($promo['start_date'])->format('d/m/Y') : null;
            $end = $promo['end_date'] ? \Carbon\Carbon::parse($promo['end_date'])->format('d/m/Y') : 'Không giới hạn';
        @endphp
        <small>📅 {{ $start }} → {{ $end }}</small><br>

        {{-- Danh sách sản phẩm --}}
        @php
            $products = is_string($promo['products']) ? json_decode($promo['products'], true) : $promo['products'];
        @endphp
        @if (!empty($products))
            <small>📦 Sản phẩm áp dụng:</small>
            <ul class="mb-0">
                @foreach ($products as $prod)
                    <li>{{ $prod['product_name'] }} - {{ $prod['variable_name'] }} - {{ $prod['unit_name'] }}</li>
                @endforeach
            </ul>
        @endif
    </div>
@endforeach