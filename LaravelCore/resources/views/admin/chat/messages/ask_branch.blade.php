@foreach ($branches as $branch)
    @php
        $addressData = $branch['address'] ? json_decode($branch['address'], true) : null;
        $addressText = $addressData['address'] ?? 'Chưa có địa chỉ';
    @endphp
    <div class="mb-2 p-2 border rounded bg-light text-dark web-rendered-data">
        <div class="d-block">
            <strong>{{ $branch['name'] }}</strong><br>
            <small>📍 {{ $addressText }}</small><br>
            <small>📞 {{ $branch['phone'] ?? 'Chưa có số điện thoại' }}</small>
        </div>
    </div>
@endforeach
