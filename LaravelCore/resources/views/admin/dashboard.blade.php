    @extends('admin.layouts.app')
    @section('title')
        {{ $pageName }}
    @endsection
    @section('content')
        <div class="page-heading mb-0">
            <div class="page-title">
                <div class="row mb-3">
                    <div class="col-12 col-md-auto">
                        <h5 class="text-uppercase">{{ __('messages.dashboard') }}</h5>
                        <nav class="breadcrumb-header float-start" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active" aria-current="page">{{ __('messages.dashboard') }}</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-12 col-md-3 ms-auto">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="input-group input-daterange">
                                    <input class="form-control" id="daterange" name="daterange" type="text" placeholder="Range" size="25" />
                                    <button class="btn btn-outline-info btn-compare" type="button">
                                        <i class="bi bi-graph-up-arrow"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-12 mt-2">
                                <select class="form-select" id="main_branch" name="main_branch">
                                    @if (Auth::user()->main_branch)
                                        @php
                                            $mainBranch = Auth::user()->branches->firstWhere('id', Auth::user()->main_branch);
                                        @endphp
                                        <option value="{{ $mainBranch->id }}" selected>{{ $mainBranch->name }}</option>
                                    @endif

                                    @foreach (Auth::user()->branches as $branch)
                                        @if ($branch->id != Auth::user()->main_branch)
                                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endif
                                    @endforeach
                                    <option value="all" {{ Auth::user()->main_branch === null ? 'selected' : '' }}>All</option>
                                </select>

                            </div>
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
                            <div class="col-6 col-lg-4 col-md-6">
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
                                                    {{ __('messages.dashboard_revenue') }}
                                                    <i class="bi bi-eye cursor-pointer btn-show-money"></i>
                                                </h6>
                                                <input class="form-control fs-3 py-0 bg-transparent revenue-input form-control-plaintext" type="password" readonly>
                                                <h3 class="d-none revenue">0</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-4 col-md-6">
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
                                                    {{ __('messages.dashboard_sales') }}
                                                    <i class="bi bi-eye cursor-pointer btn-show-money"></i>
                                                </h6>
                                                <input class="form-control fs-3 py-0 bg-transparent sales-input form-control-plaintext" type="password" readonly>
                                                <h3 class="sales d-none">0</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-6 col-lg-4 col-md-6">
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
                                                                                                    {{ __('messages.dashboard_profit') }}
                                                                                                    <i class="bi bi-eye cursor-pointer btn-show-money"></i>
                                                                                                </h6>
                                                                                                <input
    class="form-control fs-3 py-0 bg-transparent profits-input form-control-plaintext" type="password" readonly>
                                                                                                <h3 class="d-none profits" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-html="true" data-bs-title="Sales: 0">0</h3>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div> -->
                            <div class="col-6 col-lg-4 col-md-6">
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
                                                    {{ __('messages.dashboard_orders') }}
                                                    <i class="bi bi-eye cursor-pointer btn-show-money"></i>
                                                </h6>
                                                <input class="form-control fs-3 py-0 bg-transparent orders-input form-control-plaintext" type="password" readonly>
                                                <h3 class="d-none orders">0</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-4 col-md-6">
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
                                                    {{ __('messages.dashboard_customers') }}
                                                    <i class="bi bi-eye cursor-pointer btn-show-money"></i>
                                                </h6>
                                                <input class="form-control fs-3 py-0 bg-transparent customers-input form-control-plaintext" type="password" readonly>
                                                <h3 class="d-none customers">0</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-4 col-md-6">
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
                                                    {{ __('messages.dashboard_exports') }}
                                                    <i class="bi bi-eye cursor-pointer btn-show-money"></i>
                                                </h6>
                                                <input class="form-control fs-3 py-0 bg-transparent products-input form-control-plaintext" type="password" readonly>
                                                <h3 class="d-none products">0</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-4 col-md-6">
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
                                                    {{ __('messages.dashboard_imports') }}
                                                    <i class="bi bi-eye cursor-pointer btn-show-money"></i>
                                                </h6>
                                                <input class="form-control fs-3 py-0 bg-transparent imports-input form-control-plaintext" type="password" readonly>
                                                <h3 class="d-none imports">0</h3>
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
                                        <h5 class="card-title font-weight-bolder">{{ __('messages.dashboard_orders') }}</h5>
                                    </div>
                                    <div class="col-8 mb-0 text-end">
                                        <form>
                                            <div class="btn-group" data-toggle="buttons" role="group">
                                                <input class="btn-check" id="orders-chart-date" name="timeframe" type="radio" value="day" autocomplete="off" checked>
                                                <label class="btn btn-outline-info" for="orders-chart-date">{{ __('messages.dashboard_canvas_day') }}</label>
                                                <input class="btn-check" id="orders-chart-week" name="timeframe" type="radio" value="week" autocomplete="off">
                                                <label class="btn btn-outline-info" for="orders-chart-week">{{ __('messages.dashboard_canvas_week') }}</label>
                                                <input class="btn-check" id="orders-chart-month" name="timeframe" type="radio" value="month" autocomplete="off">
                                                <label class="btn btn-outline-info" for="orders-chart-month">{{ __('messages.dashboard_canvas_month') }}</label>
                                                <input class="btn-check" id="orders-chart-quarter" name="timeframe" type="radio" value="quarter" autocomplete="off">
                                                <label class="btn btn-outline-info" for="orders-chart-quarter">{{ __('messages.dashboard_canvas_quarter') }}</label>
                                                <input class="btn-check" id="orders-chart-year" name="timeframe" type="radio" value="year" autocomplete="off">
                                                <label class="btn btn-outline-info" for="orders-chart-year">{{ __('messages.dashboard_canvas_year') }}</label>
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
                                        <h5 class="card-title font-weight-bolder">{{ __('messages.dashboard_sales') }}</h5>
                                    </div>
                                    <div class="col-8 mb-0 text-end">
                                        <form>
                                            <div class="btn-group" data-toggle="buttons" role="group">
                                                <input class="btn-check" id="sales-chart-date" name="timeframe" type="radio" value="day" autocomplete="off" checked>
                                                <label class="btn btn-outline-info" for="sales-chart-date">{{ __('messages.dashboard_canvas_day') }}</label>
                                                <input class="btn-check" id="sales-chart-week" name="timeframe" type="radio" value="week" autocomplete="off">
                                                <label class="btn btn-outline-info" for="sales-chart-week">{{ __('messages.dashboard_canvas_week') }}</label>
                                                <input class="btn-check" id="sales-chart-month" name="timeframe" type="radio" value="month" autocomplete="off">
                                                <label class="btn btn-outline-info" for="sales-chart-month">{{ __('messages.dashboard_canvas_month') }}</label>
                                                <input class="btn-check" id="sales-chart-quarter" name="timeframe" type="radio" value="quarter" autocomplete="off">
                                                <label class="btn btn-outline-info" for="sales-chart-quarter">{{ __('messages.dashboard_canvas_quarter') }}</label>
                                                <input class="btn-check" id="sales-chart-year" name="timeframe" type="radio" value="year" autocomplete="off">
                                                <label class="btn btn-outline-info" for="sales-chart-year">{{ __('messages.dashboard_canvas_year') }}</label>
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

                    <div class="col-md-6 d-flex">
                        <!-- Recent Orders -->
                        <div class="card card-table card-stats-product mb-3 flex-fill">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <h4 class="card-title">{{ __('messages.dashboard_customer_list') }}</h4>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <select class="form-control" id="user-select">
                                            <option value="revenue" selected>{{ __('messages.dashboard_highest_revenue') }}</option>
                                            <option value="quantity">{{ __('messages.dashboard_most_purchased') }}</option>
                                            <!-- <option value="debt">{{ __('messages.dashboard_highest_debt') }}</option> -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body px-4">
                                <div class="table-responsive">
                                    <table class="table table-hover table-center" id="user-table">
                                        <thead>
                                            <tr>
                                                <th>{{ __('messages.dashboard_table_name') }}</th>
                                                <th>{{ __('messages.dashboard_table_total') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody> <!-- Bảng sẽ được cập nhật thông qua AJAX -->
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /Recent Orders -->
                    </div>

                    <div class="col-md-6 d-flex">
                        <!-- Feed Activity -->
                        <div class="card card-table card-stats-product mb-3 flex-fill">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <h4 class="card-title">{{ __('messages.dashboard_product_list') }}</h4>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <select class="form-control" id="product-select">
                                            <option value="revenue" selected>{{ __('messages.dashboard_highest_revenue') }}</option>
                                            <option value="quantity">{{ __('messages.dashboard_most_purchased') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body px-4">
                                <div class="table-responsive">
                                    <table class="table table-hover table-center" id="product-table">
                                        <thead>
                                            <tr>
                                                <th>{{ __('messages.dashboard_table_name') }}</th>
                                                <th>{{ __('messages.dashboard_table_total') }}</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /Feed Activity -->
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
                            '{{ __('messages.daterange.today') }}': [moment(), moment()],
                            '{{ __('messages.daterange.yesterday') }}': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                            '{{ __('messages.daterange.last7days') }}': [moment().subtract(6, 'days'), moment()],
                            '{{ __('messages.daterange.last30days') }}': [moment().subtract(29, 'days'), moment()],
                            '{{ __('messages.daterange.this_month') }}': [moment().startOf('month'), moment().endOf('month')],
                            '{{ __('messages.daterange.last_month') }}': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                        },
                        "locale": {
                            "format": "DD/MM/YYYY",
                            "separator": " - ",
                            "applyLabel": "{{ __('messages.daterange.apply_label') }}",
                            "cancelLabel": "{{ __('messages.daterange.cancel_label') }}",
                            "fromLabel": "{{ __('messages.daterange.from_label') }}",
                            "toLabel": "{{ __('messages.daterange.to_label') }}",
                            "customRangeLabel": "{{ __('messages.daterange.custom_range_label') }}",
                            "weekLabel": "{{ __('messages.daterange.week_label') }}",
                            "daysOfWeek": [
                                "{{ __('messages.daterange.days.sun') }}",
                                "{{ __('messages.daterange.days.mon') }}",
                                "{{ __('messages.daterange.days.tue') }}",
                                "{{ __('messages.daterange.days.wed') }}",
                                "{{ __('messages.daterange.days.thu') }}",
                                "{{ __('messages.daterange.days.fri') }}",
                                "{{ __('messages.daterange.days.sat') }}"
                            ],
                            "monthNames": [
                                "{{ __('messages.daterange.months.jan') }}",
                                "{{ __('messages.daterange.months.feb') }}",
                                "{{ __('messages.daterange.months.mar') }}",
                                "{{ __('messages.daterange.months.apr') }}",
                                "{{ __('messages.daterange.months.may') }}",
                                "{{ __('messages.daterange.months.jun') }}",
                                "{{ __('messages.daterange.months.jul') }}",
                                "{{ __('messages.daterange.months.aug') }}",
                                "{{ __('messages.daterange.months.sep') }}",
                                "{{ __('messages.daterange.months.oct') }}",
                                "{{ __('messages.daterange.months.nov') }}",
                                "{{ __('messages.daterange.months.dec') }}"
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
                    });

                    loadAnalytics()
                    loadDataTables('user');
                    loadDataTables('product');

                    $('#product-select').on('change', function() {
                        loadDataTables('user');
                        loadDataTables('product');
                    })
                    $('#user-select').on('change', function() {
                        loadDataTables('user');
                        loadDataTables('product');
                    })

                    $('#main_branch').on('change', function() {
                        loadAnalytics()
                        loadDataTables('user');
                        loadDataTables('product');
                    })

                    function loadAnalytics() {
                        const range = [startDate.format('YYYY-MM-DD HH:mm:ss'), endDate.format('YYYY-MM-DD HH:mm:ss')],
                            rangeJson = moment(startDate).format('DD_MM_YYYY') + '__' + moment(endDate).format('DD_MM_YYYY'),
                            selectedBranch = $('#main_branch').val();
                        if (localStorage['tdp_stats_' + rangeJson]) {
                            showData(JSON.parse(localStorage['tdp_stats_' + rangeJson]));
                        } else {
                            $.get(`{{ route('admin.dashboard.analytics') }}`, {
                                range: JSON.stringify(range),
                                branch: selectedBranch
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
                            `Sales / Debt: <br/>
                                                                                                                                            ${number_format(data.cashSales) + 'đ'} / ${number_format(data.debtSales) + 'đ'}<br/>
                                                                                                                                            Products: <br/>
                                                                                                                                            ${number_format(data.productSales) + 'đ'}`).prev().val(data.allSales)

                        $('h3.revenue').html(number_format(data.allRevenue) + 'đ').attr('data-bs-title',
                            `Payment: ${number_format(data.cashRevenue) + 'đ'}<br/>
                                                                                                                                            Debt Collection: ${number_format(data.debtRevenue) + 'đ'}`).prev().val(data.allRevenue)

                        // $('h3.profits').html(number_format(data.allProfits) + 'đ').attr('data-bs-title',
                        //     `Products: ${number_format(data.productProfits)}đ<br/>
            //                                         Cost of Goods Sold: ${number_format(data.productCost)}đ<br/>`).prev().val(data.allProfits)

                        $('h3.orders').html(number_format(data.allOrders)).attr('data-bs-title',
                            `Collected: ${number_format(data.paidOrders)}<br/>Completed: ${number_format(data.completeOrders)}<br/>
                                                                                                                                            Canceled: ${number_format(data.cancelOrders)}`).prev().val(data.allOrders)

                        $('h3.customers').html(number_format(data.allCustomers)).attr('data-bs-title',
                            `New Customers: ${number_format(data.newCustomers)}<br/>Old Customers: ${number_format(data.oldCustomers)}`).prev().val(data.allCustomers)

                        $('h3.products').html(`${number_format(data.exportProducts)}`)
                            .attr('data-bs-title',
                                `New Products: ${number_format(data.newProducts)}<br/>Sale Products: ${number_format(data.oldProducts)}`).prev().val(data.allProducts * data.allVariables)

                        $('h3.imports').html(number_format(data.allStocks)).attr('data-bs-title',
                            `Sale Products: ${number_format(data.saleStocks)}<br/>Revenue/Cost: <br/>${number_format(data.revenueStocks)}/${number_format(data.costStocks)}`).prev().val(data.allStocks)
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

                        const groupedDataCurrent = groupDataByTimeFrame(data.current, timeFrame);

                        if (comparePrevious && data.previous) {
                            const groupedDataPrevious = groupDataByTimeFrame(data.previous, timeFrame);

                            // Đồng bộ độ dài giữa hai mảng
                            const minLength = Math.min(groupedDataCurrent.length, groupedDataPrevious.length);

                            // Nhãn trục X chung
                            const labels = Array.from({
                                length: minLength
                            }, (_, i) => `Ngày ${i + 1}`);

                            // Dữ liệu hiện tại
                            const totalsCurrent = groupedDataCurrent.slice(0, minLength).map(i => i.total);
                            const countsCurrent = groupedDataCurrent.slice(0, minLength).map(i => i.count);
                            const tooltipLabelsCurrent = groupedDataCurrent.slice(0, minLength).map(i => i.label); // Ví dụ: 14/07

                            // Dữ liệu trước đó
                            const totalsPrevious = groupedDataPrevious.slice(0, minLength).map(i => i.total);
                            const countsPrevious = groupedDataPrevious.slice(0, minLength).map(i => i.count);
                            const tooltipLabelsPrevious = groupedDataPrevious.slice(0, minLength).map(i => i.label); // Ví dụ: 12/07

                            if (window.sumChart) window.sumChart.destroy();
                            if (window.countChart) window.countChart.destroy();

                            window.sumChart = createLineChart(
                                sumCtx,
                                labels,
                                totalsCurrent,
                                '{{ __('messages.dashboard_canvas_current_amount') }}',
                                'rgba(54, 162, 235, 1)',
                                tooltipLabelsCurrent,
                                totalsPrevious,
                                '{{ __('messages.dashboard_canvas_previous_amount') }}',
                                'rgba(159, 251, 166, 1)',
                                tooltipLabelsPrevious
                            );

                            window.countChart = createLineChart(
                                countCtx,
                                labels,
                                countsCurrent,
                                '{{ __('messages.dashboard_canvas_current_orders') }}',
                                'rgba(75, 192, 192, 1)',
                                tooltipLabelsCurrent,
                                countsPrevious,
                                '{{ __('messages.dashboard_canvas_previous_orders') }}',
                                'rgba(159, 251, 166, 1)',
                                tooltipLabelsPrevious
                            );
                        } else {
                            // Không so sánh – chỉ hiển thị hiện tại
                            const labels = groupedDataCurrent.map(i => i.label);
                            const totals = groupedDataCurrent.map(i => i.total);
                            const counts = groupedDataCurrent.map(i => i.count);

                            if (window.sumChart) window.sumChart.destroy();
                            if (window.countChart) window.countChart.destroy();

                            window.sumChart = createLineChart(
                                sumCtx,
                                labels,
                                totals,
                                '{{ __('messages.dashboard_canvas_current_amount') }}',
                                'rgba(54, 162, 235, 1)',
                                labels // Tooltip hiện đúng ngày
                            );

                            window.countChart = createLineChart(
                                countCtx,
                                labels,
                                counts,
                                '{{ __('messages.dashboard_canvas_current_orders') }}',
                                'rgba(75, 192, 192, 1)',
                                labels // Tooltip hiện đúng ngày
                            );
                        }
                    }


                    function groupDataByTimeFrame(data, timeFrame) {
                        const grouped = data.reduce((acc, curr) => {
                            let labelForSort, labelDisplay;

                            switch (timeFrame) {
                                case 'day':
                                    labelForSort = moment(curr.created_at).format('YYYY-MM-DD');
                                    labelDisplay = moment(curr.created_at).format('DD/MM/YYYY');
                                    break;
                                case 'week':
                                    const week = moment(curr.created_at).isoWeek();
                                    const year = moment(curr.created_at).year();
                                    labelForSort = `${year}-W${week.toString().padStart(2, '0')}`;
                                    labelDisplay = `{{ __('messages.dashboard_week') }} ${week} - ${year
                                    }`;
                                    break;
                                case 'month':
                                    labelForSort = moment(curr.created_at).format('YYYY-MM');
                                    labelDisplay = moment(curr.created_at).format('MM/YYYY');
                                    break;
                                case 'quarter':
                                    const quarter = moment(curr.created_at).quarter();
                                    const qYear = moment(curr.created_at).year();
                                    labelForSort = `${qYear} -Q${quarter} `;
                                    labelDisplay = `{{ __('messages.dashboard_quarter') }} ${quarter} - ${qYear}`;
                                    break;
                                case 'year':
                                    labelForSort = moment(curr.created_at).format('YYYY');
                                    labelDisplay = moment(curr.created_at).format('YYYY');
                                    break;
                                default:
                                    labelForSort = moment(curr.created_at).format('YYYY-MM-DD');
                                    labelDisplay = moment(curr.created_at).format('DD/MM/YYYY');
                            }

                            const existing = acc.find(item => item._labelSort === labelForSort);
                            if (existing) {
                                existing.total += curr.total;
                                existing.count += curr.count;
                            } else {
                                acc.push({
                                    label: labelDisplay, // hiển thị cho người dùng
                                    _labelSort: labelForSort, // dùng để sắp xếp
                                    total: curr.total,
                                    count: curr.count
                                });
                            }

                            return acc;
                        }, []);

                        // 🟩 Thêm phần SẮP XẾP theo thời gian thực tế
                        grouped.sort((a, b) => {
                            if (a._labelSort < b._labelSort) return -1;
                            if (a._labelSort > b._labelSort) return 1;
                            return 0;
                        });

                        return grouped;
                    }

                    function createLineChart(
                        context,
                        labelsCurrent,
                        dataCurrent,
                        labelCurrent,
                        backgroundColorCurrent,
                        tooltipLabelsCurrent = [],
                        dataPrevious = [],
                        labelPrevious = '',
                        backgroundColorPrevious = '',
                        tooltipLabelsPrevious = []
                    ) {
                        const config = {
                            type: 'line',
                            data: {
                                labels: labelsCurrent,
                                datasets: [{
                                    label: labelCurrent,
                                    data: dataCurrent,
                                    backgroundColor: backgroundColorCurrent,
                                    borderColor: backgroundColorCurrent,
                                    fill: false,
                                    borderWidth: 2,
                                    tension: 0.2,
                                    pointRadius: 5,
                                    pointStyle: 'circle',
                                    pointBackgroundColor: backgroundColorCurrent
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    x: {
                                        display: true,
                                        grid: {
                                            display: true
                                        },
                                        ticks: {
                                            display: false
                                        }
                                    },
                                    y: {
                                        title: {
                                            display: true,
                                            text: '{{ __('messages.dashboard_canvas_value') }}'
                                        },
                                        beginAtZero: true,
                                        ticks: {
                                            precision: 0
                                        }
                                    }
                                },
                                plugins: {
                                    tooltip: {
                                        mode: 'index',
                                        intersect: false,
                                        callbacks: {
                                            title: function(tooltipItems) {
                                                const index = tooltipItems[0].dataIndex;

                                                const currentDate = tooltipLabelsCurrent?.[index];
                                                const previousDate = tooltipLabelsPrevious?.[index];

                                                const lines = [`{{ __('messages.dashboard_current') }} : ${currentDate}`];

                                                if (previousDate) {
                                                    lines.push(`{{ __('messages.dashboard_previous') }}  ${previousDate}`);
                                                }

                                                return lines;
                                            }
                                        }
                                    },
                                    legend: {
                                        position: 'top'
                                    }
                                }
                            }
                        };

                        if (dataPrevious.length > 0) {
                            config.data.datasets.push({
                                label: labelPrevious,
                                data: dataPrevious,
                                backgroundColor: backgroundColorPrevious,
                                borderColor: backgroundColorPrevious,
                                fill: false,
                                borderWidth: 2,
                                tension: 0.2,
                                pointRadius: 5,
                                pointStyle: 'circle',
                                pointBackgroundColor: backgroundColorPrevious
                            });
                        }

                        return new Chart(context, config);
                    }

                    // Xử lý sự kiện click nút 'Compare'
                    $('.btn-compare').on('click', function() {
                        const selectedTimeFrame = $('input[name="timeframe"]:checked').val();
                        const range = [startDate, endDate];
                        console.log(range);

                        const url = `{{ route('admin.dashboard.analytics') }}?key=compare&branch=${$('#main_branch').val()}&range=${encodeURIComponent(JSON.stringify(range))}`;

                        $.get(url, function(response) {
                            if (response.listOrders) {
                                console.log(response.listOrders);

                                buildChart(response.listOrders, selectedTimeFrame, true);
                            }
                        }).fail(function() {
                            alert('An error occurred while fetching data.');
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
                            dom: 'lftip',
                            processing: true,
                            serverSide: false,
                            orderCellsTop: true,
                            order: [
                                [1, 'desc']
                            ],
                            ajax: {
                                url: `{{ route('admin.dashboard.statistics') }}?model=${model}&branch=${$('#main_branch').val()}&type=${$(`#${model}-select`).val()}&range=${JSON.stringify(range)}`
                            },
                            columns: [{
                                    data: 'name',
                                    name: 'name',
                                    title: '{{ __('messages.dashboard_table_name') }}',
                                    sortable: false
                                },
                                {
                                    data: 'total',
                                    name: 'total',
                                    title: '{{ __('messages.dashboard_table_total') }}'
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
