<link href="{{ asset('admin/css/bootstrap.css') }}" rel="stylesheet">
<link href="https://fonts.gstatic.com" rel="preconnect">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <table class="table table-striped table-hover">
        @if ($variable_id)
            <tr>
                <th>ID nhập - Ngày</th>
                <th>Tên biến thể</th>
                <th>Số nhập</th>
                <th>Số xuất</th>
                <th>Số tồn</th>
                <th>Chênh lệch</th>
            </tr>
            @foreach ($variables->firstWhere('id', $variable_id)->import_details->filter(function ($import_detail) use ($warehouse_id) {
                return $import_detail->_import->warehouse_id == $warehouse_id;
            }) as $import_detail)
                @php
                    $sum_import = $import_detail->quantity * $import_detail->_unit->rate;
                    $sum_export = $import_detail->stock->export_details->sum(function ($export_detail) {
                        return $export_detail->quantity * $export_detail->_unit->rate;
                    });
                    $sum_stock = $import_detail->stock->quantity;
                @endphp
                <tr>
                    <td>{!! $import_detail->import->id !!} - {!! $import_detail->import->created_at->format('H:i d/m/Y') !!}</td>
                    <td>{!! $import_detail->variable->fullName !!}</td>
                    <td>{{ $sum_import }}</td>
                    <td><a href="{{ route('admin.export', ['check' => 1, 'variable_id' => $import_detail->variable_id, 'warehouse_id' => $warehouse_id, 'stock_id' => $import_detail->id]) }}">{{ $sum_export }}</a></td>
                    <td>{{ $sum_stock }}</td>
                    <td>{{ $sum_import - ($sum_export + $sum_stock) }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <th>ID biến thể</th>
                <th>Tên biến thể</th>
                <th>Tổng nhập</th>
                <th>Tổng xuất</th>
                <th>Tổng tồn</th>
                <th>Chênh lệch</th>
            </tr>
            @foreach ($variables as $variable)
                @php
                    $sum_import = $variable
                        ->import_details()
                        ->whereHas('import', function ($query) use ($warehouse_id) {
                            $query->where('warehouse_id', $warehouse_id);
                        })
                        ->get()
                        ->sum(function ($import_detail) {
                            return (float) $import_detail->_unit->rate * (float) $import_detail->quantity;
                        });
                    $sum_export = $variable
                        ->import_details()
                        ->whereHas('import', function ($query) use ($warehouse_id) {
                            $query->where('warehouse_id', $warehouse_id);
                        })
                        ->get()
                        ->sum(function ($import_detail) {
                            return $import_detail->stock->export_details->sum(function ($export_detail) {
                                return (float) $export_detail->_unit->rate * (float) $export_detail->quantity;
                            });
                        });
                    $sum_stock = $variable
                        ->import_details()
                        ->whereHas('import', function ($query) use ($warehouse_id) {
                            $query->where('warehouse_id', $warehouse_id);
                        })
                        ->get()
                        ->sum(function ($import_detail) {
                            return (float) $import_detail->stock->quantity;
                        });
                @endphp
                @if ($sum_import - $sum_export - $sum_stock != 0)
                    <tr>
                        <td>{!! $variable->id !!}</td>
                        <td>{!! $variable->fullName !!}</td>
                        <td><a href="{{ route('admin.import', ['check' => 1, 'variable_id' => $variable->id, 'warehouse_id' => $warehouse_id]) }}">{{ $sum_import }}</a></td>
                        <td><a href="{{ route('admin.export', ['check' => 1, 'variable_id' => $variable->id, 'warehouse_id' => $warehouse_id]) }}">{{ $sum_export }}</a></td>
                        <td><a href="{{ route('admin.stock', ['check' => 1, 'variable_id' => $variable->id, 'warehouse_id' => $warehouse_id]) }}">{{ $sum_stock }}</a></td>
                        <td>{{ $sum_import - ($sum_export + $sum_stock) }}</td>
                    </tr>
                @endif
            @endforeach
        @endif
    </table>