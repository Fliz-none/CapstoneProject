<div class="p-2 bg-light text-dark web-rendered-data">
    @if (!empty($shop_info['company_name']))
        <strong>{{ $shop_info['company_name'] }}</strong><br>
    @endif

    @if (!empty($shop_info['company_address']))
        📍 {{ $shop_info['company_address'] }}<br>
    @endif

    @if (!empty($shop_info['company_hotline']))
        📞 {{ $shop_info['company_hotline'] }}<br>
    @endif

    @if (!empty($shop_info['company_email']))
        📧 {{ $shop_info['company_email'] }}<br>
    @endif
</div>
