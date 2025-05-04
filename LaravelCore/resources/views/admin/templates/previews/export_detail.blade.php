<link href="{{ asset('admin/css/bootstrap.css') }}" rel="stylesheet">
<link href="https://fonts.gstatic.com" rel="preconnect">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <table class="table table-striped table-hover">
        <tr>
            <th>ID xuất</th>
            <th>ID tồn</th>
            <th>ID nhập</th>
            <th>Hàng hóa</th>
            <th>Nội dung xuất</th>
            <th>Ngày xuất</th>
            <th>Người xuất</th>
            <th>Số lượng</th>
            <th>Quy đổi</th>
        </tr>
        @php $sum = 0 @endphp
        @foreach ($export_details->sortBy('id')->filter(function ($export_detail) use ($stock_id) {
            if($stock_id) {
                return $export_detail->stock_id == $stock_id;
            }
            return true;
        }) as $export_detail)
        @php $sum += $export_detail->quantity * $export_detail->_unit->rate @endphp
            <tr>
                <td>{!! $export_detail->export_id !!}</td>
                <td>{!! $export_detail->stock_id !!}</td>
                <td>{!! $export_detail->stock->import_detail->import_id !!}</td>
                <td>{!! $export_detail->stock->import_detail->variable->fullName !!}</td>
                <td>{{ $export_detail->export->note }}</td>
                <td>{{ $export_detail->created_at->format('H:i d/m/Y') }}</td>
                <td>{{ $export_detail->export->user->name }}</td>
                <td>{{ $export_detail->quantity }} {{ $export_detail->_unit->term }}</td>
                <td>{{ $export_detail->quantity * $export_detail->_unit->rate }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="8">Tổng cộng</td>
            <td>{{ $sum }}</td>
        </tr>
    </table>
