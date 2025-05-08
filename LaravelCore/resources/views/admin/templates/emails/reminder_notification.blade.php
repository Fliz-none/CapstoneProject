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

        .btn-group>.btn-group:not(:last-child)>.btn,
        .btn-group>.btn:not(:last-child):not(.dropdown-toggle) {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
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
    </style>
</head>

<body>
    @php
        $booking = $data['data'];
        $settings = cache()->get('settings');
    @endphp
    @if ($booking)
        <div class="header">
                <p style="margin-bottom: 2rem">Xin chào{!! isset($booking->_customer) ? ' ' . $booking->_customer->name . ' <small>(' . ($booking->_customer->phone ?? 'Không có SDT') . ')</small>' : '' !!},</p>
        </div>
        <div class="container">
            <div class="main">
                <h3 class="fw-bold">{{ $booking->description }}</h3>
                <h3 class="fw-bold" style="margin-bottom: 0">{!! isset($booking->_doctor) ? 'Với BS: ' . $booking->_doctor->name : '' !!}</h3>
                <h3 class="fw-bold" style="margin-bottom: 0">Giờ hẹn: {{ \Carbon\Carbon::parse($booking->appointment_at)->format('H:i \n\g\à\y d/m/Y') }}</h3>
            </div>
            <div class="footer">
                <p>
                    <span class="fw-bold">Hotline:</span> 
                </p>
                <p>
                    <span class="fw-bold">Địa chỉ:</span> 
                </p>
                <p>
                    &copy; {{ \Carbon\Carbon::now()->format('YYYY') }}
                </p>
            </div>
        </div>
    @else
        <p style="text-align: center;" colspan="4">Không có dữ liệu.</p>
    @endif
</body>

</html>
<script></script>
