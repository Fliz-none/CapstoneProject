<!doctype html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>{{ $subject }}</title>
    <style>
        @media (min-width: 768px) {
            .py-md-3 {
                padding-top: 1rem !important;
                padding-bottom: 1rem !important;
            }
        }

        .header {
            padding: .25rem !important;
        }

        @media (min-width: 768px) {
            .header {
                padding-top: 1rem !important;
                padding-bottom: 1rem !important;
            }
        }

        .bg-info {
            background-color: #3fa3db;
        }

        .c-info {
            color: #3fa3db;
        }

        .fw-bold {
            font-weight: bold;
        }

        body {
            background-color: #f6f6f6;
            font-family: sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
            line-height: 1.4;
        }

        .container {
            display: block;
            margin: 0 auto;
            max-width: 580px;
            padding: 10px;
            width: 100%;
        }

        .main {
            background: #ffffff;
            border-radius: 3px;
            width: 100%;
            padding: 20px;
        }

        .footer {
            padding-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #777777;
        }

        .footer p {
            margin: 0;
            padding: 5px 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin: 20px 0;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        thead th {
            background-color: #3fa3db;
            color: #ffffff;
            padding: 6px;
            text-align: left;
            border: 2px solid #3fa3db;
            font-weight: bold;
        }

        tbody tr:nth-child(even) {
            background-color: #cfcfcf;
        }

        tbody tr:hover {
            background-color: #e0f7fa;
        }

        table,
        th,
        td {
            border: 1px solid #3fa3db;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="header">
        <h3 class="fw-bold">{{ $subject }}</h3>
    </div>
    <div class="container">
        <div class="main">
            @php
                $settings = cache()->get('settings_' . Auth::user()->company_id);
            @endphp
            <h4 class="fw-bold">Các sản phẩm sắp hết hạn sử dụng
                {{ isset($settings['expired_notification_frequency']) ? $settings['expired_notification_frequency'] . ' ngày tới' : '' }}
            </h4>
            <table>
                <thead>
                    <tr>
                        <th>Mã tồn kho</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Ngày hết hạn</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($data)
                        @foreach ($data as $stock)
                            <tr>
                                <td data-label="Mã tồn kho">{{ $stock->code }}</td>
                                <td data-label="Tên sản phẩm">{{ $stock->product_name }}</td>
                                <td data-label="Số lượng">{{ $stock->import_detail->_variable->convertUnit($stock->quantity) }}</td>
                                <td data-label="Ngày hết hạn">
                                    {{ \Carbon\Carbon::parse($stock->expired)->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" style="text-align: center;">Không có dữ liệu.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="footer">
            <p>
                <span class="fw-bold">Hotline:</span> {{ isset($settings['company_hotline']) ? $settings['company_hotline'] : ''}}
            </p>
            <p>
                <span class="fw-bold">Địa chỉ:</span> {{ isset($settings['company_address']) ? $settings['company_address'] : ''}}
            </p>
            <p>
                &copy; {{ \Carbon\Carbon::now()->format('YYYY') - isset($settings['company_name']) ? $settings['company_name'] : ''}}
            </p>
        </div>
    </div>
</body>

</html>
<script></script>
