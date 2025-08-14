<div class="p-2 bg-light text-dark web-rendered-data">
    @php
        use App\Models\Order;
        use App\Models\User;
        use Illuminate\Support\Facades\Auth;

        // Lấy đơn hàng
        $donhang = Order::with(['details.unit.variable.product', 'customer'])->firstWhere([
            'customer_id' => $order['customer_id'] ?? null,
            'id' => $order['id'] ?? null,
        ]);
    @endphp

    @if ($donhang)
        <div class="w-100">
            <p><strong>Mã đơn:</strong> {{ $donhang->code }}</p>
            <p><strong>Mã khách hàng:</strong> {{ $donhang->customer->code ?? 'N/A' }}</p>
            <p class="d-flex"><strong>Trạng thái:</strong>
                <span class="ms-1 text-{{ $donhang->statusStr['color'] ?? 'secondary' }}">
                    {{ $donhang->statusStr['string'] ?? 'Không rõ' }}
                </span>
            </p>
            <p>
                <strong>Địa chỉ giao hàng:</strong>
                {{ optional(json_decode($donhang->address))->address ?? 'Không có' }}
            </p>
            <p><strong>Tổng đơn:</strong> {{ number_format($donhang->total(), 0, '.', ',') }} đ</p>
            <p class="fw-bold">Chi tiết đơn hàng:</p>
        </div>

        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($donhang->details as $detail)
                    <tr>
                        <td>{{ $detail->unit->variable->full_name ?? '' }}</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>{{ number_format($detail->price, 0, '.', ',') }} đ</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p>Xem chi tiết <a class="link" href="{{ url('/tai-khoan#user-order') }}" target="_blank">tại đây</a></p>
    @else
        <p class="text-danger">Không tìm thấy đơn hàng</p>
    @endif
</div>
