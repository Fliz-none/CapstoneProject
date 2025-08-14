@php
    $firstImage = collect(explode('|', $product['gallery'] ?? ''))
        ->skip(1)
        ->first();
    $image = $firstImage && Storage::exists("public/$firstImage") ? asset(env('FILE_STORAGE', '/storage') . "/$firstImage") : asset('admin/images/placeholder_key.png');
    $url = url('/product') . '/' . $product['catalogue_slug'] . '/' . $product['slug'];
    if (Auth::user()->can(App\Models\User::READ_PRODUCT)) {
        $url = route('admin.product') . '/' . $product['id'];
    }
@endphp
<div class="p-2 bg-light text-dark web-rendered-data">
    <a href="{{ $url }}" target="_blank">
        <div class="mb-0 p-1 d-block">
            <strong>{{ $product['name'] }}</strong>
            <img class="ms-3 h-auto object-fit-cover" style="width: 4rem;" src="{{ $image }}" alt="{{ $product['name'] }}" />
        </div>
    </a>
</div>
