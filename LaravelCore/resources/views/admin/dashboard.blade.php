@extends('admin.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
    <div class="page-heading mb-0">
        <div class="page-title">
            <div class="row mb-3">
                <div class="col-12 col-md-auto">
                    <h5 class="text-uppercase">{{ $pageName }}</h5>
                    <nav class="breadcrumb-header float-start" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">{{ $pageName }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-12 col-md-3 ms-auto">
                    <div class="input-group input-daterange">
                        <input class="form-control" id="daterange" name="daterange" type="text" placeholder="Thời gian báo cáo" size="25" />
                        <button class="btn btn-outline-info btn-compare" type="button"><i class="bi bi-graph-up-arrow"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="row">
            @if (!empty(Auth::user()->can(App\Models\User::READ_DASHBOARD)))
                <div class="col-12 col-lg-12">
                    <div class="row">
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card mb-3">
                                <div class="card-body px-3 py-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon purple">
                                                <i class="bi bi-coin"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">
                                                Doanh thu
                                                <i class="bi bi-eye cursor-pointer btn-show-money"></i>
                                            </h6>
                                            <input class="form-control fs-3 py-0 bg-transparent revenue-input form-control-plaintext" type="password" readonly>
                                            <h3 class="d-none revenue" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-html="true" data-bs-title="Thu tiền: 0<br/>Công nợ: 0">0</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card mb-3">
                                <div class="card-body px-3 py-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon blue">
                                                <i class="bi bi-cash-stack"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">
                                                Doanh số
                                                <i class="bi bi-eye cursor-pointer btn-show-money"></i>
                                            </h6>
                                            <input class="form-control fs-3 py-0 bg-transparent sales-input form-control-plaintext" type="password" readonly>
                                            <h3 class="sales d-none" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-html="true" data-bs-title="Thu bán hàng: 1.500.000 / 2.300.000<br/>Thu công nợ: 0">0</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card mb-3">
                                <div class="card-body px-3 py-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon green">
                                                <i class="bi bi-cash-coin"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">
                                                Lợi nhuận gộp
                                                <i class="bi bi-eye cursor-pointer btn-show-money"></i>
                                            </h6>
                                            <input class="form-control fs-3 py-0 bg-transparent profits-input form-control-plaintext" type="password" readonly>
                                            <h3 class="d-none profits" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-html="true" data-bs-title="Bán hàng: 0<br/>Dịch vụ: 0">0</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card mb-3">
                                <div class="card-body px-3 py-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon red">
                                                <i class="bi bi-file-text-fill"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">
                                                Đơn hàng
                                                <i class="bi bi-eye cursor-pointer btn-show-money"></i>
                                            </h6>
                                            <input class="form-control fs-3 py-0 bg-transparent orders-input form-control-plaintext" type="password" readonly>
                                            <h3 class="d-none orders" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-html="true" data-bs-title="Hoàn thành: 0<br/>Thu đủ: 0<br/>Bị hủy: 0">0</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card mb-3">
                                <div class="card-body px-3 py-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon pink">
                                                <i class="bi bi-people-fill"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">
                                                Khách hàng
                                                <i class="bi bi-eye cursor-pointer btn-show-money"></i>
                                            </h6>
                                            <input class="form-control fs-3 py-0 bg-transparent customers-input form-control-plaintext" type="password" readonly>
                                            <h3 class="d-none customers" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-html="true" data-bs-title="Mới / Cũ<br/>0 / 0">0</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card mb-3">
                                <div class="card-body px-3 py-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon yellow">
                                                <i class="bi bi-github"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">
                                                Thú cưng
                                                <i class="bi bi-eye cursor-pointer btn-show-money"></i>
                                            </h6>
                                            <input class="form-control fs-3 py-0 bg-transparent pets-input form-control-plaintext" type="password" readonly>
                                            <h3 class="d-none pets" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-html="true" data-bs-title="Mới / Cũ<br/>0 / 0<br/>Khám chữa: 0<br/>Làm đẹp: 0<br/>Lưu trú: 0">0</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card mb-3">
                                <div class="card-body px-3 py-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon orange">
                                                <i class="bi bi-box-seam-fill"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">
                                                Sản phẩm
                                                <i class="bi bi-eye cursor-pointer btn-show-money"></i>
                                            </h6>
                                            <input class="form-control fs-3 py-0 bg-transparent products-input form-control-plaintext" type="password" readonly>
                                            <h3 class="d-none products" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-html="true" data-bs-title="Có bán / Nhập mới<br/>0 / 0">0/0</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card mb-3">
                                <div class="card-body px-3 py-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="stats-icon plum">
                                                <i class="bi bi-house-door-fill"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <h6 class="text-muted font-semibold">
                                                Nhập hàng
                                                <i class="bi bi-eye cursor-pointer btn-show-money"></i>
                                            </h6>
                                            <input class="form-control fs-3 py-0 bg-transparent imports-input form-control-plaintext" type="password" readonly>
                                            <h3 class="d-none imports" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-html="true" data-bs-title="Có bán: 32/34<br/>Doanh số/Giá vốn: 0/0">0</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <!-- Sales Chart -->
                    <div class="card card-chart mb-3">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <div class="col-4 mb-0">
                                    <h5 class="card-title font-weight-bolder">Đơn hàng</h5>
                                </div>
                                <div class="col-8 mb-0 text-end">
                                    <form>
                                        <div class="btn-group" data-toggle="buttons" role="group">
                                            <input class="btn-check" id="orders-chart-date" name="timeframe" type="radio" value="day" autocomplete="off" checked>
                                            <label class="btn btn-outline-info" for="orders-chart-date">Ngày</label>
                                            <input class="btn-check" id="orders-chart-week" name="timeframe" type="radio" value="week" autocomplete="off">
                                            <label class="btn btn-outline-info" for="orders-chart-week">Tuần</label>
                                            <input class="btn-check" id="orders-chart-month" name="timeframe" type="radio" value="month" autocomplete="off">
                                            <label class="btn btn-outline-info" for="orders-chart-month">Tháng</label>
                                            <input class="btn-check" id="orders-chart-quarter" name="timeframe" type="radio" value="quarter" autocomplete="off">
                                            <label class="btn btn-outline-info" for="orders-chart-quarter">Quý</label>
                                            <input class="btn-check" id="orders-chart-year" name="timeframe" type="radio" value="year" autocomplete="off">
                                            <label class="btn btn-outline-info" for="orders-chart-year">Năm</label>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="count-orders-chart" style="width: 100%; height: 300px;"></canvas>
                        </div>
                    </div>
                    <!-- /Sales Chart -->
                </div>
                <div class="col-md-12 col-lg-6">
                    <!-- Invoice Chart -->
                    <div class="card card-chart mb-3">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <div class="col-4 mb-0">
                                    <h5 class="card-title font-weight-bolder">Doanh số</h5>
                                </div>
                                <div class="col-8 mb-0 text-end">
                                    <form>
                                        <div class="btn-group" data-toggle="buttons" role="group">
                                            <input class="btn-check" id="sales-chart-date" name="timeframe" type="radio" value="day" autocomplete="off" checked>
                                            <label class="btn btn-outline-info" for="sales-chart-date">Ngày</label>
                                            <input class="btn-check" id="sales-chart-week" name="timeframe" type="radio" value="week" autocomplete="off">
                                            <label class="btn btn-outline-info" for="sales-chart-week">Tuần</label>
                                            <input class="btn-check" id="sales-chart-month" name="timeframe" type="radio" value="month" autocomplete="off">
                                            <label class="btn btn-outline-info" for="sales-chart-month">Tháng</label>
                                            <input class="btn-check" id="sales-chart-quarter" name="timeframe" type="radio" value="quarter" autocomplete="off">
                                            <label class="btn btn-outline-info" for="sales-chart-quarter">Quý</label>
                                            <input class="btn-check" id="sales-chart-year" name="timeframe" type="radio" value="year" autocomplete="off">
                                            <label class="btn btn-outline-info" for="sales-chart-year">Năm</label>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="sum-orders-chart" style="width: 100%; height: 300px;"></canvas>
                        </div>
                    </div>
                    <!-- /Invoice Chart -->
                </div>

                <div class="col-md-4 d-flex">
                    <!-- Recent Orders -->
                    <div class="card card-table card-stats-product mb-3 flex-fill">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <h4 class="card-title">Danh sách khách hàng</h4>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <select class="form-control" id="user-select">
                                        <option value="revenue" selected>Doanh số cao nhất</option>
                                        <option value="quantity">Mua nhiều hàng nhất</option>
                                        <option value="debt">Công nợ nhiều nhất</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-4">
                            <div class="table-responsive">
                                <table class="table table-hover table-center" id="user-table">
                                    <thead>
                                        <tr>
                                            <th>Tên khách hàng</th>
                                            <th>Tổng kết</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody> <!-- Bảng sẽ được cập nhật thông qua AJAX -->
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /Recent Orders -->
                </div>

                <div class="col-md-4 d-flex">
                    <!-- Feed Activity -->
                    <div class="card card-table card-stats-product mb-3 flex-fill">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <h4 class="card-title">Danh sách sản phẩm</h4>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <select class="form-control" id="product-select">
                                        <option value="revenue" selected>Doanh số cao nhất</option>
                                        <option value="quantity">Bán được nhiều nhất</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-4">
                            <div class="table-responsive">
                                <table class="table table-hover table-center" id="product-table">
                                    <thead>
                                        <tr>
                                            <th>Tên sản phẩm</th>
                                            <th>Tổng kết</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /Feed Activity -->
                </div>

                <div class="col-md-4 d-flex">
                    <!-- Service Activity -->
                    <div class="card card-table card-stats-product mb-3 flex-fill">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <h4 class="card-title">Danh sách dịch vụ</h4>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <select class="form-control" id="service-select">
                                        <option value="revenue" selected>Doanh số cao nhất</option>
                                        <option value="quantity">Được dùng nhiều nhất</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-4">
                            <div class="table-responsive">
                                <table class="table table-hover table-center" id="service-table">
                                    <thead>
                                        <tr>
                                            <th>Tên dịch vụ</th>
                                            <th>Tổng</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /Service Activity -->
                </div>
            @else
                @include('admin.includes.access_denied')
            @endif
        </div>
    </section>
@endsection

@push('scripts')
    @if (!empty(Auth::user()->can(App\Models\User::READ_DASHBOARD)))
        <script type="text/javascript">
            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                /* DATE RANGE PICKER */
                var now = new Date(),
                    startDate = moment().startOf('date'),
                    endDate = moment().endOf('date'),
                    chartData

                $('input[name="daterange"]').daterangepicker({
                    ranges: {
                        'Hôm nay': [moment(), moment()],
                        'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        '7 ngày trước': [moment().subtract(6, 'days'), moment()],
                        '30 ngày trước': [moment().subtract(29, 'days'), moment()],
                        'Tháng này': [moment().startOf('month'), moment().endOf('month')],
                        'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    "locale": {
                        "format": "DD/MM/YYYY",
                        "separator": " - ",
                        "applyLabel": "OK",
                        "cancelLabel": "Hủy",
                        "fromLabel": "Từ",
                        "toLabel": "Tới",
                        "customRangeLabel": "Tùy chọn",
                        "weekLabel": "W",
                        "daysOfWeek": [
                            "CN",
                            "T2",
                            "T3",
                            "T4",
                            "T5",
                            "T6",
                            "T7"
                        ],
                        "monthNames": [
                            "Tháng 1",
                            "Tháng 2",
                            "Tháng 3",
                            "Tháng 4",
                            "Tháng 5",
                            "Tháng 6",
                            "Tháng 7",
                            "Tháng 8",
                            "Tháng 9",
                            "Tháng 10",
                            "Tháng 11",
                            "Tháng 12"
                        ],
                        "firstDay": 1
                    },
                    autoApply: true,
                    alwaysShowCalendars: true,
                    startDate: startDate,
                    endDate: endDate,
                    opens: "left"
                }, function(start, end) {
                        startDate = start.startOf('date')
                        endDate = end.endOf('date')
                        console.log(startDate, endDate);
                        
                        loadAnalytics()
                        loadDataTables('user');
                        loadDataTables('product');
                        loadDataTables('service');
                });
                loadAnalytics()
                loadDataTables('user');
                loadDataTables('product');
                loadDataTables('service');

                function loadAnalytics() {
                    const range = [startDate.format('YYYY-MM-DD HH:mm:ss'), endDate.format('YYYY-MM-DD HH:mm:ss')],
                        rangeJson = moment(startDate).format('DD_MM_YYYY') + '__' + moment(endDate).format('DD_MM_YYYY')
                    if (localStorage['tdp_stats_' + rangeJson]) {
                        showData(JSON.parse(localStorage['tdp_stats_' + rangeJson]));
                    } else {
                        $.get(`{{ route('admin.dashboard.analytics') }}`, {
                            range: JSON.stringify(range)
                        }, function(result) {
                            showData(result)
                            let today = moment().format('YYYY-MM-DD HH:mm:ss')
                            if (today == startDate && today == endDate) {
                                try {
                                    if (e.name === 'QuotaExceededError' || e.name === 'NS_ERROR_DOM_QUOTA_REACHED') {
                                        const today = new Date();
                                        const day = today.getDate();
                                        if (day === 10 || day === 20 || day === 30) {
                                            clearLocalStorage('tdp_stats_');
                                        }
                                    }
                                    localStorage['tdp_stats_' + rangeJson] = JSON.stringify(result);
                                } catch (e) {
                                    clearLocalStorage('tdp_stats_');
                                }
                            }
                        });
                    }
                }

                function clearLocalStorage(prefix) {
                    // Lưu danh sách các key cần xóa
                    let keysToDelete = [];
                    // Lặp qua tất cả các key trong localStorage
                    for (let i = 0; i < localStorage.length; i++) {
                        let key = localStorage.key(i);
                        // Kiểm tra nếu key bắt đầu với prefix
                        if (key.startsWith(prefix)) {
                            keysToDelete.push(key);
                        }
                    }
                    // Xóa từng key trong danh sách
                    keysToDelete.forEach(function(key) {
                        localStorage.removeItem(key);
                    });
                }

                function showData(data) {
                    $('h3.sales').html(number_format(data.allSales) + 'đ').attr('data-bs-title',
                        `Bán hàng / Công nợ: <br/>
                            ${number_format(data.cashSales)+'đ'} / ${number_format(data.debtSales)+'đ'}<br/>
                            Sản phẩm / Dịch vụ: <br/>
                            ${number_format(data.productSales)+'đ'} / ${number_format(data.serviceSales)+'đ'}`).prev().val(data.allSales)

                    $('h3.revenue').html(number_format(data.allRevenue) + 'đ').attr('data-bs-title',
                        `Thanh toán: ${number_format(data.cashRevenue)+'đ'}<br/>
                            Thu nợ: ${number_format(data.debtRevenue)+'đ'}`).prev().val(data.allRevenue)

                    $('h3.profits').html(number_format(data.allProfits) + 'đ').attr('data-bs-title',
                        `Sản phẩm: ${number_format(data.productProfits)}đ<br/>
                            Giá vốn hàng bán: ${number_format(data.productCost)}đ<br/>
                            Dịch vụ: ${number_format(data.serviceProfits)}đ<br/>
                            Giá vốn dịch vụ: ${number_format(data.serviceCost)}đ`).prev().val(data.allProfits)

                    $('h3.orders').html(number_format(data.allOrders)).attr('data-bs-title',
                        `Đã thu đủ: ${number_format(data.paidOrders)}<br/>Đã hoàn thành: ${number_format(data.completeOrders)}<br/>
                            Bị hủy: ${number_format(data.cancelOrders)}`).prev().val(data.allOrders)

                    $('h3.customers').html(number_format(data.allCustomers)).attr('data-bs-title',
                        `Khách mới: ${number_format(data.newCustomers)}<br/>Khách cũ: ${number_format(data.oldCustomers)}`).prev().val(data.allCustomers)

                    $('h3.pets').html(number_format(data.allPets)).attr('data-bs-title',
                        `Khám lần đầu: ${number_format(data.newPets)}<br/>Quay lại: ${number_format(data.oldPets)}`).prev().val(data.allPets)

                    $('h3.products').html(`${number_format(data.allProducts)} &times; ${number_format(data.allVariables)}`).attr('data-bs-title',
                        `Có nhập: ${number_format(data.newCustomers)}<br/>Có bán: ${number_format(data.oldCustomers)}`).prev().val(data.allProducts * data.allVariables)

                    $('h3.imports').html(number_format(data.allStocks)).attr('data-bs-title',
                        `Có bán: ${number_format(data.saleStocks)}<br/>Doanh thu/Giá vốn: <br/>${number_format(data.revenueStocks)}/${number_format(data.costStocks)}`).prev().val(data.allStocks)
                    //Chart  
                    buildChart(data.listOrders);
                    chartData = data.listOrders
                }

                $('.btn-show-money').click(function() {
                    $(this).toggleClass('bi-eye').toggleClass('bi-eye-slash').parent().next().toggleClass('d-none').next().toggleClass('d-none')
                })

                function buildChart(data, timeFrame = 'day', comparePrevious = false) {
                    const sumCtx = $('#sum-orders-chart')[0].getContext('2d');
                    const countCtx = $('#count-orders-chart')[0].getContext('2d');

                    let labelsCurrent = [];
                    let totalsCurrent = [];
                    let countsCurrent = [];
                    let labelsPrevious = [];
                    let totalsPrevious = [];
                    let countsPrevious = [];

                    // Nhóm dữ liệu hiện tại theo khung thời gian đã chọn
                    const groupedDataCurrent = groupDataByTimeFrame(data.current, timeFrame);

                    // Nếu cần so sánh, nhóm dữ liệu trước đó
                    if (comparePrevious && data.previous) {
                        const groupedDataPrevious = groupDataByTimeFrame(data.previous, timeFrame);

                        // Gán dữ liệu hiện tại
                        groupedDataCurrent.forEach(item => {
                            labelsCurrent.push(item.label);
                            totalsCurrent.push(item.total);
                            countsCurrent.push(item.count);
                        });

                        // Gán dữ liệu so sánh
                        groupedDataPrevious.forEach(item => {
                            labelsPrevious.push(item.label);
                            totalsPrevious.push(item.total);
                            countsPrevious.push(item.count);
                        });

                        // Hủy biểu đồ cũ nếu tồn tại
                        if (window.sumChart) window.sumChart.destroy();
                        if (window.countChart) window.countChart.destroy();

                        // Tạo biểu đồ với dữ liệu hiện tại và trước đó
                        window.sumChart = createLineChart(
                            sumCtx,
                            labelsCurrent,
                            totalsCurrent,
                            'Số tiền (Hiện tại)',
                            'rgba(54, 162, 235, 1)',
                            labelsPrevious,
                            totalsPrevious,
                            'Số tiền (Trước đó)',
                            '#ccc'
                        );

                        window.countChart = createLineChart(
                            countCtx,
                            labelsCurrent,
                            countsCurrent,
                            'Số đơn (Hiện tại)',
                            'rgba(75, 192, 192, 1)',
                            labelsPrevious,
                            countsPrevious,
                            'Số đơn (Trước đó)',
                            '#ccc'
                        );
                    } else {
                        // Nếu không cần so sánh, chỉ hiển thị dữ liệu hiện tại
                        groupedDataCurrent.forEach(item => {
                            labelsCurrent.push(item.label);
                            totalsCurrent.push(item.total);
                            countsCurrent.push(item.count);
                        });

                        if (window.sumChart) window.sumChart.destroy();
                        if (window.countChart) window.countChart.destroy();

                        window.sumChart = createLineChart(
                            sumCtx,
                            labelsCurrent,
                            totalsCurrent,
                            'Số tiền',
                            'rgba(54, 162, 235, 1)'
                        );

                        window.countChart = createLineChart(
                            countCtx,
                            labelsCurrent,
                            countsCurrent,
                            'Số đơn',
                            'rgba(75, 192, 192, 1)'
                        );
                    }
                }

                function groupDataByTimeFrame(data, timeFrame) {
                    return data.reduce((acc, curr) => {
                        let label;
                        switch (timeFrame) {
                            case 'day':
                                label = moment(curr.created_at).format('DD/MM/YYYY');
                                break;
                            case 'week':
                                label = `Tuần ${moment(curr.created_at).isoWeek()} - ${moment(curr.created_at).year()}`;
                                break;
                            case 'month':
                                label = moment(curr.created_at).format('MM/YYYY');
                                break;
                            case 'quarter':
                                // Tính quý từ ngày
                                const quarter = moment(curr.created_at).quarter(); // Lấy quý
                                const year = moment(curr.created_at).year(); // Lấy năm
                                label = `Quý ${quarter} - ${year}`;
                                break;
                            case 'year':
                                label = moment(curr.created_at).format('YYYY');
                                break;
                            default:
                                label = moment(curr.created_at).format('DD/MM/YYYY');
                        }

                        const existing = acc.find(item => item.label === label);
                        if (existing) {
                            existing.total += curr.total;
                            existing.count += curr.count;
                        } else {
                            acc.push({
                                label,
                                total: curr.total,
                                count: curr.count
                            });
                        }

                        return acc;
                    }, []);
                }

                function createLineChart(
                    context,
                    labelsCurrent,
                    dataCurrent,
                    labelCurrent,
                    backgroundColorCurrent,
                    labelsPrevious = [],
                    dataPrevious = [],
                    labelPrevious = '',
                    backgroundColorPrevious = ''
                ) {
                    const config = {
                        type: 'line', // Loại biểu đồ
                        data: {
                            labels: labelsCurrent, // Nhãn gốc là chuỗi ngày đầy đủ (DD/MM/YYYY)
                            datasets: [{
                                label: labelCurrent,
                                data: dataCurrent,
                                backgroundColor: backgroundColorCurrent,
                                borderColor: backgroundColorCurrent,
                                fill: false,
                                borderWidth: 2,
                                borderCapStyle: 'round', // Bo tròn đầu đường vẽ
                                borderJoinStyle: 'round', // Bo tròn tại điểm nối
                                tension: 0.2, // Độ cong của đường (tăng giá trị để đường cong mềm mại hơn)
                                pointRadius: 5, // Bán kính của điểm (chấm) tại mỗi điểm dữ liệu
                                pointStyle: 'circle', // Kiểu điểm (có thể là 'circle', 'rect', 'star', ...)
                                pointBackgroundColor: backgroundColorCurrent // Màu sắc của điểm
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                x: {
                                    display: true, // Ẩn trục X
                                    grid: {
                                        display: true // Ẩn lưới của trục X
                                    },
                                    ticks: {
                                        display: false // Không hiển thị nhãn trên trục X
                                    }
                                },
                                y: {
                                    title: {
                                        display: true,
                                        text: 'Giá trị'
                                    },
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                tooltip: {
                                    mode: 'index',
                                    intersect: false,
                                    callbacks: {
                                        title: function(tooltipItems) {
                                            // Lấy ngày đầy đủ từ labelsCurrent và labelsPrevious
                                            const index = tooltipItems[0].dataIndex;
                                            let tooltipTitle = labelsCurrent[index]; // Hiển thị ngày đầy đủ cho labelsCurrent
                                            // Nếu có dữ liệu trước đó, thêm thông tin từ labelsPrevious
                                            if (labelsPrevious.length > 0) {
                                                tooltipTitle += ' | ' + labelsPrevious[index]; // Hiển thị ngày đầy đủ cho labelsPrevious
                                            }
                                            return tooltipTitle; // Trả về tiêu đề cho tooltip (ngày của cả hai dataset)
                                        }
                                    }
                                },
                                legend: {
                                    position: 'top'
                                }
                            }
                        }
                    };

                    // Nếu có dữ liệu so sánh, thêm dataset vào biểu đồ
                    if (dataPrevious.length > 0) {
                        config.data.datasets.push({
                            label: labelPrevious,
                            data: dataPrevious,
                            backgroundColor: backgroundColorPrevious,
                            borderColor: backgroundColorPrevious,
                            fill: false,
                            borderWidth: 2,
                            borderCapStyle: 'round', // Bo tròn đầu đường vẽ
                            borderJoinStyle: 'round', // Bo tròn tại điểm nối
                            tension: 0.2, // Độ cong của đường
                            pointRadius: 5, // Bán kính của điểm dữ liệu
                            pointStyle: 'circle', // Kiểu điểm
                            pointBackgroundColor: backgroundColorPrevious // Màu sắc của điểm
                        });
                    }

                    return new Chart(context, config);
                }

                // Xử lý sự kiện click nút 'Compare'
                $('.btn-compare').on('click', function() {
                    const selectedTimeFrame = $('input[name="timeframe"]:checked').val();
                    const range = [startDate, endDate];
                    $.get(`{{ route('admin.dashboard.analytics') }}?key=compare&range=${JSON.stringify(range)}`, function(response) {
                        if (response.listOrders) {
                            buildChart(response.listOrders, selectedTimeFrame, true);
                        }
                    }).error(function() {
                        alert('Đã xảy ra lỗi khi lấy dữ liệu');
                    });
                });

                // Xử lý sự kiện cho radio buttons
                $('input[name="timeframe"]').on('change', function() {
                    buildChart(chartData, $(this).val());
                });

                // Xử lý sự kiện cho nút so sánh kỳ trước
                $('#comparePrevious').on('click', function() {
                    buildChart(chartData, $('input[name="timeframe"]:checked').val(), true);
                });

                function loadDataTables(model) {
                    const target = `#${model}-table`;
                    const range = [startDate.format('YYYY-MM-DD HH:mm:ss'), endDate.format('YYYY-MM-DD HH:mm:ss')];
                    if ($.fn.dataTable.isDataTable(target)) {
                        $(target).DataTable().destroy();
                    }
                    const table = $(target).DataTable({
                        dom: 'ltip',
                        processing: true,
                        serverSide: false,
                        orderCellsTop: true,
                        order: [
                            [1, 'desc']
                        ],
                        ajax: {
                            url: `{{ route('admin.dashboard.statistics') }}?model=${model}&type=${$(`#${model}-select`).val()}&range=${JSON.stringify(range)}`
                        },
                        columns: [{
                                data: 'name',
                                name: 'name',
                                title: 'Tên',
                                sortable: false
                            },
                            {
                                data: 'total',
                                name: 'total',
                                title: 'Tổng'
                            },
                        ],
                        columnDefs: [{
                                targets: 0,
                                width: '50%', // Đặt chiều rộng cột "Tên" là 50%
                                render: function(data, type, row) {
                                    return `<span style="white-space: nowrap;">${data}</span>`; // Ngăn chặn xuống dòng
                                }
                            },
                            {
                                targets: 1,
                                width: '50%', // Đặt chiều rộng cột "Tổng cộng" là 50%
                                className: 'text-center' // Căn giữa nội dung trong cột "Tổng cộng"
                            }
                        ],
                        language: config.datatable.lang,
                        lengths: config.datatable.lengths,
                        pageLength: 10,
                        scrollY: false, // Không sử dụng thanh cuộn dọc
                        scrollX: false, // Không sử dụng thanh cuộn ngang
                    });

                    $(`#${model}-select`).change(function() {
                        const newDateRange = [startDate, endDate];
                        const newUrl = `{{ route('admin.dashboard.statistics') }}?model=${model}&type=${$(`#${model}-select`).val()}&range=${JSON.stringify(range)}`;
                        table.ajax.url(newUrl).load();
                    });
                    return table;
                }
            });
        </script>
    @endif
@endpush
