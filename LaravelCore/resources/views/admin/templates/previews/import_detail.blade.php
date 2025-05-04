<link href="{{ asset('admin/css/bootstrap.css') }}" rel="stylesheet">
<link href="https://fonts.gstatic.com" rel="preconnect">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <table class="table table-striped table-hover">
        <tr>
            <th>ID nhập - ngày</th>
            <th>ID tồn</th>
            <th>Hàng hóa</th>
            <th>Nội dung nhập</th>
            <th>Ngày nhập</th>
            <th>Người nhập</th>
            <th>Số lượng</th>
            <th>Quy đổi</th>
        </tr>
        @php $sum = 0 @endphp
        @foreach ($import_details->sortBy('id') as $import_detail)
        @php $sum += $import_detail->quantity * $import_detail->_unit->rate @endphp
            <tr>
                <td>{!! $import_detail->import_id !!} - {!! $import_detail->created_at->format('H:i d/m/Y') !!}</td>
                <td>{!! $import_detail->id !!}</td>
                <td>{!! $import_detail->variable->fullName !!}</td>
                <td>{{ $import_detail->import->note }}</td>
                <td>{{ $import_detail->created_at->format('H:i d/m/Y') }}</td>
                <td>{{ $import_detail->import->user->name }}</td>
                <td>{{ $import_detail->quantity }} {{ $import_detail->_unit->term }}</td>
                <td>{{ $import_detail->quantity * $import_detail->_unit->rate }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="7">Tổng cộng</td>
            <td>{{ $sum }}</td>
        </tr>
    </table>