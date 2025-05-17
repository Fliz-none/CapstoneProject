<link href="{{ asset('admin/css/bootstrap.css') }}" rel="stylesheet">
<link href="https://fonts.gstatic.com" rel="preconnect">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
   <table class="table table-striped table-hover">
    <tr>
        <th>Export ID</th>
        <th>Stock ID</th>
        <th>Import ID</th>
        <th>Product</th>
        <th>Export Note</th>
        <th>Export Date</th>
        <th>Exported By</th>
        <th>Quantity</th>
        <th>Converted</th>
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
        <td colspan="8">Total</td>
        <td>{{ $sum }}</td>
    </tr>
</table>
