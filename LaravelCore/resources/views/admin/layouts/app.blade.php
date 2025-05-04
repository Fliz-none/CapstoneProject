<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        {{-- CSRF Token --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title> @yield('title') - {{ config('app.name') }}</title>

        {{-- Thẻ favicon --}}
        <link type="image/x-icon" href="{{ asset('admin/images/logo/favicon_key.png') }}" rel="shortcut icon">
        {{-- Định nghĩa web app --}}
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        {{-- Tên và màu nền của web app --}}
        <meta name="apple-mobile-web-app-title" content="{{ cache()->get('settings_' . Auth::user()->company_id)['company_name'] }}">
        <meta name="apple-mobile-web-app-status-bar-style" content="white">

        {{-- Mô tả của web app --}}
        <meta name="apple-mobile-web-app-description" content="Ứng dụng quản lý vận hành của {{ cache()->get('settings_' . Auth::user()->company_id)['company_name'] }}">
        {{-- Ảnh hiển thị khi thêm vào màn hình Home --}}
        <link href="{{ asset('admin/images/logo/favicon.svg') }}" rel="apple-touch-icon">

        {{-- CSRF Token --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="https://fonts.gstatic.com" rel="preconnect">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
        @php
            $version_name = cache()->get('version_' . Auth::user()->company_id)->name;
        @endphp
        <link href="{{ asset('admin/css/bootstrap.css') }}?v={{ $version_name }}" rel="stylesheet">
        <link href="{{ asset('admin/css/work.css') }}?v={{ $version_name }}" rel="stylesheet">

        <link href="{{ asset('admin/vendors/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet">
        <link href="{{ asset('admin/vendors/bootstrap-icons/bootstrap-icons.css') }}?v={{ $version_name }}" rel="stylesheet">
        <link href="{{ asset('admin/css/app.css') }}?v={{ $version_name }}" rel="stylesheet">
        <link href="{{ asset('admin/css/key.css') }}?v={{ $version_name }}" rel="stylesheet">
        <link href="{{ asset('admin/vendors/jqueryui-1.13.2/jquery-ui.css') }}" rel="stylesheet">

        <script src="{{ asset('admin/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
        <script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('admin/vendors/jquery/jquery-3.6.3.min.js') }}"></script>
        <script src="{{ asset('admin/vendors/jqueryui-1.13.2/jquery-ui.js') }}"></script>

        {{-- input image JSCompressor --}}
        <script src="{{ asset('admin/vendors/compressorjs/compressor.min.js') }}"></script>
        {{-- Include Select2 CSS --}}
        <link href="{{ asset('admin/vendors/select2/css/select2-bootstrap-5-theme.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('admin/vendors/select2/css/select2.min.css') }}" rel="stylesheet" />
        {{-- Toastify --}}
        <link href="{{ asset('admin/vendors/toastify/toastify.css') }}" rel="stylesheet">
        {{-- ChartJS --}}
        <link href="{{ asset('admin/vendors/chartjs/Chart.min.css') }}" rel="stylesheet">
        {{-- Include sweetalert2 --}}
        <link href="{{ asset('admin/vendors/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
        {{-- Print JS --}}
        <link href="{{ asset('admin/vendors/print/print.min.css') }}" rel="stylesheet">
        {{-- Include Summernote Editor --}}
        <link href="{{ asset('admin/vendors/summernote/summernote-lite.min.css') }}" rel="stylesheet">
        {{-- daterangepicker --}}
        <link type="text/css" href="{{ asset('admin/vendors/daterangepicker/daterangepicker.css') }}" rel="stylesheet" />

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register(`{{ asset('js/service-worker.js') }}`).then(function(registration) {
                    // console.log('ServiceWorker registration successful with scope: ', registration.scope);
                }, function(err) {
                    // console.error('ServiceWorker registration failed: ', err);
                });
            });
        }
        $(document).ready(function() {
            $(window).on('offline', function() {
                $('.loading').removeClass('d-none');
                Swal.fire("Thông báo!", 'Bạn bị mất kết nối internet', "info");
            });
            // Bắt sự kiện khi có mạng trở lại
            $(window).on('online', function() {
                $('.loading').addClass('d-none');
                Swal.close();
            });
        })
    </script>
</head>

<body>
    <div id="app">
        @include('admin.includes.sidebar')
        <div class='layout-navbar' id="main">
            @include('admin.includes.header')
            <div id="main-content">
                @yield('content')
                @include('admin.includes.footer')
            </div>
            @include('admin.includes.partials.modal_sort')
            @if (!isset($order) && Request::path() != 'quantri/order/new')
                @include('admin.includes.partials.modal_order')
            @endif
            @include('admin.includes.partials.modal_import_detail')
            @include('admin.includes.partials.modal_export_detail')
            @include('admin.includes.partials.modal_import')
            @include('admin.includes.partials.modal_export')
            @if (!isset($product) && Request::path() != 'quantri/product/new')
                @include('admin.includes.partials.modal_product')
            @endif
            @include('admin.includes.partials.modal_catalogue')
            @include('admin.includes.partials.modal_variable')
            @if (!isset($service) && Request::path() != 'quantri/service/new')
                @include('admin.includes.partials.modal_service')
            @endif
            @include('admin.includes.partials.modal_barcode')
            @include('admin.includes.partials.modal_major')
            @include('admin.includes.partials.modal_category')
            @include('admin.includes.partials.modal_attribute')
            @include('admin.includes.partials.modal_branch')
            @include('admin.includes.partials.modal_log')
            @if (!isset($info) && Request::path() != 'quantri/info/new')
                @include('admin.includes.partials.modal_prescription')
            @endif
            @include('admin.includes.partials.modal_quicktest')
            @include('admin.includes.partials.modal_role')
            @include('admin.includes.partials.modal_stock')
            @include('admin.includes.partials.modal_supplier')
            @include('admin.includes.partials.modal_surgery')
            @include('admin.includes.partials.modal_timekeeping')
            @include('admin.includes.partials.modal_transaction')
            @include('admin.includes.partials.modal_accommodation')
            @include('admin.includes.partials.modal_room_list')
            @include('admin.includes.partials.modal_room')
            @include('admin.includes.partials.modal_tracking')
            @include('admin.includes.partials.modal_ultrasound')
            @include('admin.includes.partials.modal_microscope')
            @include('admin.includes.partials.modal_beauty')
            @include('admin.includes.partials.modal_biochemical')
            @include('admin.includes.partials.modal_bloodcell')
            @include('admin.includes.partials.modal_booking')
            @include('admin.includes.partials.modal_user')
            @include('admin.includes.partials.modal_warehouse')
            @include('admin.includes.partials.modal_xray')
            @include('admin.includes.partials.modal_criterial')
            @include('admin.includes.partials.modal_animal')
            @include('admin.includes.partials.modal_local')
            @include('admin.includes.partials.modal_symptom')
            @include('admin.includes.partials.modal_disease')
            @include('admin.includes.partials.modal_medicine')
            @include('admin.includes.partials.modal_expense')
            @include('admin.includes.partials.modal_company')
            @if (Request::path() != 'quantri/image')
                <div class="modal fade" id="quick_images-modal" aria-labelledby="quick_images-label" tabindex="-1">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            @include('admin.includes.quick_images')
                        </div>
                    </div>
                </div>
            @endif
            @include('admin.includes.partials.modal_image')
            @include('admin.includes.partials.modal_version')
            @include('admin.includes.partials.modal_login')
            @include('admin.includes.partials.modal_detail')
            @include('admin.includes.partials.modal_preview')
            @include('admin.includes.partials.modal_info')
            @include('admin.includes.partials.modal_pet')
        </div>
    </div>
    <div class="d-none" id="print-wrapper"></div>
    <div class="d-none" id="render-wrapper"></div>
    <div class="loading d-none">
        <div class="spinner card">Đang xử lý...</div>
    </div>
</body>
<script script src="{{ asset('admin/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
{{-- DataTables --}}
<script src="{{ asset('admin/vendors/datatables/datatables2.0.8.min.js') }}"></script>
<script src="{{ asset('admin/vendors/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/vendors/datatables/dataTables.bootstrap5.min.js') }}"></script>
<link href="{{ asset('admin/vendors/datatables/datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/vendors/datatables/button/buttons.bootstrap5.css') }}" rel="stylesheet">
<link href="{{ asset('admin/vendors/datatables/button/buttons.dataTables.css') }}" rel="stylesheet">
<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="{{ asset('admin/vendors/datatables/button/pdfmake.min.js') }}"></script>
<script src="{{ asset('admin/vendors/datatables/button/vfs_fonts.js') }}"></script>
{{-- Include ChartJS --}}
<script src="{{ asset('admin/vendors/chartjs/Chart.js') }}"></script>
{{-- Include Toastify --}}
<script src="{{ asset('admin/vendors/toastify/toastify.js') }}"></script>
{{-- Include MomentJS --}}
<script src="{{ asset('admin/vendors/momentjs/moment.min.js') }}"></script>
<script src="{{ asset('admin/vendors/momentjs/moment-with-locales.js') }}"></script>
{{-- Include sweetalert2 --}}
<script src="{{ asset('admin/vendors/sweetalert2/sweetalert2.all.min.js') }}"></script>
{{-- Include select2 --}}
<script src="{{ asset('admin/vendors/select2/js/select2.full.js') }}"></script>
<script src="{{ asset('admin/vendors/select2/js/i18n/vi.js') }}"></script>
{{-- Include Summernote Editor --}}
<script src="{{ asset('admin/vendors/summernote/summernote-lite.min.js') }}"></script>
{{-- input mask js --}}
<script src="{{ asset('admin/vendors/jquery-mask/jquery.mask.js') }}"></script>
{{-- scanner-detection --}}
<script src="{{ asset('admin/vendors/onscanjs/onscan.js') }}"></script>
{{-- Print JS --}}
<script src="{{ asset('admin/vendors/print/print.min.js') }}"></script>
{{-- Barcode JS --}}
<script src="{{ asset('admin/vendors/BarcodeJS/JsBarcode.all.min.js') }}"></script>
{{-- XLSX Xử lý excel --}}
<script src="{{ asset('admin/vendors/xlsx/xlsx.full.min.js') }}"></script>
{{-- daterangepicker --}}
<script type="text/javascript" src="{{ asset('admin/vendors/daterangepicker/daterangepicker.min.js') }}"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/eruda"></script>
<script>
    eruda.init();
</script> --}}
<script>
    moment.locale('vi');
    let config = {
        routes: {
            login: "{{ route('login.auth') }}",
            local: "{{ URL::to('locals') }}",
            storage: "{{ asset(env('FILE_STORAGE', '/storage')) }}",
            placeholder: "{{ asset('admin/images/placeholder_key.png') }}",
            getImage: "{{ route('admin.image') }}",
            uploadImage: "{{ route('admin.image.upload') }}",
            updateImage: "{{ route('admin.image.update') }}",
            deleteImage: "{{ route('admin.image.delete') }}",
        },
        datatable: {
            lang: {
                "sProcessing": "Đang xử lý...",
                "sLengthMenu": "_MENU_ dòng / trang",
                "sZeroRecords": "Không có nội dung.",
                "sInfo": "Từ _START_ đến _END_ của _TOTAL_ mục",
                "sInfoEmpty": "Không có mục nào",
                "sInfoFiltered": "(được lọc từ _MAX_ mục)",
                'searchPlaceholder': "Tìm kiếm dữ liệu",
                "sInfoPostFix": "",
                "sSearch": "",
                "sUrl": "",
                "oPaginate": {
                    "sFirst": "&laquo;",
                    "sPrevious": "&lsaquo;",
                    "sNext": "&rsaquo;",
                    "sLast": "&raquo;",
                },
            },
            columns: {
                checkboxes: {
                    data: 'checkboxes',
                    name: 'checkboxes',
                    sortable: false,
                    searchable: false
                },
                id: {
                    data: 'id',
                    name: 'id'
                },
                code: {
                    data: 'code',
                    name: 'code',
                    searchable: true
                },
                order: {
                    data: 'order',
                    name: 'order',
                },
                sort: {
                    data: 'sort',
                    name: 'sort',
                    searchable: false,
                },
                avatar: {
                    data: 'avatar',
                    name: 'avatar',
                    sortable: false,
                    searchable: false,
                },
                quantity: {
                    data: 'quantity',
                    name: 'quantity',
                    searchable: true,
                },
                price: {
                    data: 'price',
                    name: 'price',
                    className: 'text-end',
                },
                name: {
                    data: 'name',
                    name: 'name',
                },
                customer: {
                    data: 'customer',
                    name: 'customer'
                },
                note: {
                    data: 'note',
                    name: 'note'
                },
                status: {
                    data: 'status',
                    name: 'status',
                    className: 'text-center',
                    searchable: true,
                },
                created_at: {
                    data: 'created_at',
                    name: 'created_at',
                    searchable: true,
                    render: function(data, type, row) {
                        return (type == 'display') ? ((data != null) ? moment(data).format("DD/MM/YYYY H:mm") :
                            '') : data;
                    }
                },
                action: {
                    data: 'action',
                    name: 'action',
                    className: 'text-end',
                    sortable: false,
                    searchable: false
                },
            },
            columnDefines: [{
                    target: $(".dataTable thead tr th").length - 2,
                    sortable: false,
                    searchable: false
                },
                {
                    target: $(".dataTable thead tr th").length - 1,
                    sortable: false,
                    searchable: false,
                },
            ],
            pageLength: 20,
            lengths: [
                [5, 10, 20, 50, 100, 300],
                [5, 10, 20, 50, 100, 300],
            ],
        },
        sweetAlert: {
            confirm: {
                title: "Lưu ý!",
                text: "Hãy xác nhận trước khi tiếp tục?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "var(--bs-danger)",
                cancelButtonColor: "var(--bs-primary)",
                confirmButtonText: "Xác nhận",
                cancelButtonText: "Quay lại",
                reverseButtons: false
            },
            delay: {
                title: "Vẫn đang hoạt động...",
                text: "Thao tác của bạn cần nhiều thời gian hơn để xử lý. Xin hãy kiên nhẫn!",
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                allowOutsideClick: false,
                willOpen: () => {
                    Swal.showLoading();
                },
            },
        },
        select2: {
            ajax: {
                processResults: function(data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data,
                        pagination: {
                            more: false
                        }
                    }
                },
                cache: 1000,
                delay: 300,
            },
            language: "vi",
            theme: "bootstrap-5",
            width: '100%',
            allowClear: false,
            closeOnSelect: true,
            scrollOnSelect: false,
        }
    }

    /**
     * Xử lý thêm
     */
    $(document).on('click', '.btn-select-stock', function() {
        const stockQuantity = JSON.parse($(this).attr('data-stock-quantity')),
            tab = $('#order-modal').hasClass('show') ? $('#order-modal') : $('#export-modal').hasClass('show') ? $('#export-modal') : $('.tab-pane.active'),
            stock = {
                stockId: $(this).attr('data-stock-id'),
                stockExpired: $(this).attr('data-expired'),
                productName: $(this).attr('data-product-name'),
                productSku: $(this).attr('data-product-sku'),
                stockQuantity: stockQuantity[0],
                stockConvertQuantity: stockQuantity[1],
                variableId: $(this).attr('data-variable-id'),
                productUnit: JSON.parse($(this).attr('data-unit')),
                productUnits: JSON.parse($(this).attr('data-units'))
            }
        let availableStock = false,
            availableUnit = false;

        tab.find(`[name='stock_ids[]'][value=${stock.stockId}]`).each(function() {
            const card = $(this).closest('.detail'),
                unitId = card.find(`[name='unit_ids[]']`).val(),
                orderQuantity = parseInt(card.find(`[name='quantities[]']`).val())
            if (unitId == stock.productUnit.id) {
                card.find(`[name='quantities[]']`).val(orderQuantity + 1);
                availableUnit = true
                if (validateQuantity(card)) {
                    tab.find('.order-receipt').length ? totalOrder() : null
                    availableStock = true
                    return false;
                } else {
                    pushToastify("Gói tồn kho không đủ hàng, vui lòng chọn gói khác bổ sung.", 'danger')
                }
            }
        })
        if (!availableUnit) {
            tab.find('.export-receipt').length ? addCardToExport(stock) : addCardToOrder(stock)
            let card = tab.find('div.detail').first();
            availableUnit = true
            if (validateQuantity(card)) {
                tab.find('.order-receipt').length ? totalOrder() : null
                availableStock = true
            } else {
                card.remove();
                pushToastify("Gói tồn kho không đủ hàng, vui lòng chọn gói khác bổ sung.", 'danger')
            }
        }
        if (!availableUnit && !availableStock) {
            tab.find('.export-receipt').length ? addCardToExport(stock) : addCardToOrder(stock)
        }
    })
    
    $(document).on('click', '.btn-select-service', function(e) {
            e.preventDefault()
            const id = $(this).attr('data-id'),
                name = $(this).attr('data-name'),
                price = $(this).attr('data-price'),
                major = $(this).attr('data-major'),
                ticket = $(this).attr('data-ticket'),
                unit = $(this).attr('data-unit')

            $('#order-form .order-services').prepend(`
        <div class="card border shadow-none mb-2 p-3 detail service order-detail">
            <div class="row">
                <div class="col 12 col-lg-7">
                    <p class="card-title mb-0">
                        ${name}
                        <input class="order_detail-service_id" name="service_ids[]" type="hidden" value="${id}" />
                        <input name="service_tickets[]" type="hidden" value="${ticket}" />
                        <!-- <a class="btn btn-link btn-order_detail-service_info rounded-pill p-0" data-id="${id}" type="button">
                            <i class="bi bi-info-circle"></i>
                        </a> -->
                    </p>
                </div>
                <div class="col-12 col-lg-5">
                    <div class="row">
                        <div class="col-7 col-lg-4 d-flex justify-content-between position-relative">
                            <input class="order_detail-price" name="prices[]" type="hidden" value="${price}">
                            <span class="position-absolute top-100 start-50 mt-2 translate-middle badge"></span>
                            <input class="form-control form-control-plaintext form-control-lg order_detail-discounted_price text-end money" name="discounted_price[]" type="text" value="${price}"
                                onclick="this.select()" inputmode="numeric" placeholder="Giá dịch vụ">
                            <input class="order_detail-discount" name="discounts[]" type="hidden" value="0">
                            <button class="btn btn-link rounded-pill btn-price-order_detail" type="button"><i class="bi bi-info-circle"></i></button>
                        </div>
                        <div class="col-5 col-lg-2 d-flex align-items-center">
                            <span class="card-title mb-0">${unit}</span>
                        </div>
                        <div class="col-6 col-lg-3 d-flex justify-content-between">
                            ${ticket !== '' ? `<input class="form-control form-control-plaintext form-control-lg text-center order_detail-quantity text-end bg-transparent" name="quantities[]" type="text" value="1" readonly>`
                                        : `<button type="button" class="btn btn-link btn-sm rounded-pill btn-quantity-detail btn-dec"><i class="bi bi-dash-circle fs-5 fw-bold"></i></button>
                                        <input class="form-control form-control-plaintext form-control-lg text-center order_detail-quantity text-end bg-transparent" name="quantities[]" type="text" value="1">
                                        <button type="button" class="btn btn-link btn-sm rounded-pill btn-quantity-detail btn-inc"><i class="bi bi-plus-circle fs-5 fw-bold"></i></button>`
                            }
                        </div>
                        <div class="col-6 col-lg-3">
                            <input class="form-control-plaintext form-control-lg order_detail-total text-end money" type="text" value="${price}" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <p class="card-text fw-bold fs-5 text-end"></p>
                    <input type="hidden" name="notes[]" class="form-control form-control-plaintext bg-transparent order_detail-note" value="" readonly/>
                </div>
            </div>
            <div class="dropstart btn-group position-absolute top-0 end-0">
                <button class="btn btn-link mb-0 px-2 py-1" data-bs-toggle="dropdown" type="button" aria-expanded="false">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu shadow-lg p-2" style="z-index: 9999">
                    <li><a class="dropdown-item btn-note-detail_stock" href="#">Ghi chú dịch vụ</a></li>
                    <hr class="dropdown-divider" />
                    <li>
                        <input type="hidden" class="order_detail-id" name="ids[]">
                        <input type="hidden" class="order_detail-export_id" name="export_ids[]">
                        <a class="dropdown-item btn btn-remove-detail remove-card">
                            Xóa khỏi đơn hàng
                        </a>
                    </li>
                </ul>
            </div>
        </div>`)
            totalOrder()
        })

        $(document).on('click', '.btn-select-service', function(e) {
            e.preventDefault()
            const id = $(this).attr('data-id'),
                name = $(this).attr('data-name'),
                price = $(this).attr('data-price'),
                major = $(this).attr('data-major'),
                ticket = $(this).attr('data-ticket'),
                unit = $(this).attr('data-unit')

            $('#order-form .order-services').prepend(`
        <div class="card border shadow-none mb-2 p-3 detail service order-detail">
            <div class="row">
                <div class="col 12 col-lg-7">
                    <p class="card-title mb-0">
                        ${name}
                        <input class="order_detail-service_id" name="service_ids[]" type="hidden" value="${id}" />
                        <input name="service_tickets[]" type="hidden" value="${ticket}" />
                        <!-- <a class="btn btn-link btn-order_detail-service_info rounded-pill p-0" data-id="${id}" type="button">
                            <i class="bi bi-info-circle"></i>
                        </a> -->
                    </p>
                </div>
                <div class="col-12 col-lg-5">
                    <div class="row">
                        <div class="col-7 col-lg-4 d-flex justify-content-between position-relative">
                            <input class="order_detail-price" name="prices[]" type="hidden" value="${price}">
                            <span class="position-absolute top-100 start-50 mt-2 translate-middle badge"></span>
                            <input class="form-control form-control-plaintext form-control-lg order_detail-discounted_price text-end money" name="discounted_price[]" type="text" value="${price}"
                                onclick="this.select()" inputmode="numeric" placeholder="Giá dịch vụ">
                            <input class="order_detail-discount" name="discounts[]" type="hidden" value="0">
                            <button class="btn btn-link rounded-pill btn-price-order_detail" type="button"><i class="bi bi-info-circle"></i></button>
                        </div>
                        <div class="col-5 col-lg-2 d-flex align-items-center">
                            <span class="card-title mb-0">${unit}</span>
                        </div>
                        <div class="col-6 col-lg-3 d-flex justify-content-between">
                            ${ticket !== '' ? `<input class="form-control form-control-plaintext form-control-lg text-center order_detail-quantity text-end bg-transparent" name="quantities[]" type="text" value="1" readonly>`
                                        : `<button type="button" class="btn btn-link btn-sm rounded-pill btn-quantity-detail btn-dec"><i class="bi bi-dash-circle fs-5 fw-bold"></i></button>
                                        <input class="form-control form-control-plaintext form-control-lg text-center order_detail-quantity text-end bg-transparent" name="quantities[]" type="text" value="1">
                                        <button type="button" class="btn btn-link btn-sm rounded-pill btn-quantity-detail btn-inc"><i class="bi bi-plus-circle fs-5 fw-bold"></i></button>`
                            }
                        </div>
                        <div class="col-6 col-lg-3">
                            <input class="form-control-plaintext form-control-lg order_detail-total text-end money" type="text" value="${price}" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <p class="card-text fw-bold fs-5 text-end"></p>
                    <input type="hidden" name="notes[]" class="form-control form-control-plaintext bg-transparent order_detail-note" value="" readonly/>
                </div>
            </div>
            <div class="dropstart btn-group position-absolute top-0 end-0">
                <button class="btn btn-link mb-0 px-2 py-1" data-bs-toggle="dropdown" type="button" aria-expanded="false">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu shadow-lg p-2" style="z-index: 9999">
                    <li><a class="dropdown-item btn-note-detail_stock" href="#">Ghi chú dịch vụ</a></li>
                    <hr class="dropdown-divider" />
                    <li>
                        <input type="hidden" class="order_detail-id" name="ids[]">
                        <input type="hidden" class="order_detail-export_id" name="export_ids[]">
                        <a class="dropdown-item btn btn-remove-detail remove-card">
                            Xóa khỏi đơn hàng
                        </a>
                    </li>
                </ul>
            </div>
        </div>`)
            totalOrder()
        })

        $(document).on('click', '.btn-mark-notification', function(e) {
            e.preventDefault()
            const id = $(this).attr('data-id'),
                form = $(`<form action="{{ route('admin.notification.mark') }}" method="POST">@csrf<input type="hidden" name="id" value="${id}"></form>`)
            submitForm(form).done(function(response) {
                $('.nav-notifications').html(response.template)
            })
        })

        $(document).on('click', '.btn-send-zns', function(e) {
            e.preventDefault()
            const id = $(this).attr('data-id'),
                url = $(this).attr('data-url'),
                phone = $(this).attr('data-phone'),
                template = $(this).attr('data-template'),
                form = $(`
            <form action="${url}" method="POST">
                @csrf
                <input type="hidden" name="id" value="${id}">
                <input type="hidden" name="template" value="372721">
                <input type="hidden" name="phone" value="${phone}">
            </form>`)
            submitForm(form)
        })

        /**
         * PROFILE
         */
        $('.btn-change-branch').on('click', function() {
            Swal.fire({
                title: 'Chọn chi nhánh',
                html: `
                <select id="main_branch" class="form-select" name="main_branch">
                    @foreach (Auth::user()->branches as $branch)
                        <option value="{{ $branch->id }}"{{ Auth::user()->main_branch == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                    @endforeach
                </select>
            `,
                showCancelButton: true,
                confirmButtonText: 'Lưu',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Gửi AJAX request để lưu dữ liệu
                    $.ajax({
                        url: "{{ route('admin.profile.change_branch') }}",
                        type: 'POST',
                        data: {
                            main_branch: $('[name=main_branch]').val(),
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            pushToastify(response.msg, response.status)
                            $('nav.navbar .user-name small').text(response.main_branch)
                        },
                        error: function(error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Đã có lỗi xảy ra',
                                text: 'Xin hãy thử lại.',
                            });
                        }
                    });
                }
            });
        });

        /**
         * MAJOR PROCESS
         */
        $(document).on('click', '.btn-create-major', function(e) {
            e.preventDefault();
            const form = $('#major-form')
            resetForm(form)
            form.find('[name=status]').prop('checked', true);
            form.find('[name=color][value=blue]').prop('checked', true);
            form.attr('action', `{{ route('admin.major.create') }}`)
            form.find('.modal').modal('show').find('.modal-title').text('Danh mục mới')
        })

        $(document).on('click', '.btn-update-major', function(e) {
            e.preventDefault();
            const id = $(this).attr('data-id'),
                form = $('#major-form');
            resetForm(form)
            $.get(`{{ route('admin.major') }}/${id}`, function(major) {
                form.find('[name=id]').val(major.id)
                form.find('[name=name]').val(major.name)
                form.find('[name=note]').val(major.note)
                form.find('[name=avatar]').val(major.avatar).change()
                form.find('[name=parent_id]').val(major.parent_id)
                form.find('[name=status]').prop('checked', major.status)
                form.find(`[name=color][value=${major.color}]`).prop('checked', true)
                form.attr('action', `{{ route('admin.major.update') }}`)
                if (major.ticket) {
                    form.find(`[name=ticket] option[value=${major.ticket}]`).attr('selected', true)
                }
                if (major.deleted_at != null) {
                    form.find('.btn[type=submit]:last-child').addClass('d-none')
                }
                form.find('.modal').modal('show').find('.modal-title').text(major.name)
            })
        })
        // =========== END MAJOR ===========


        /**
         * PRODUCT PROCESS
         */
        $(document).on('click', '.btn-create-product', function(e) {
            e.preventDefault();
            initCreateProduct()
        })

        function initCreateProduct() {
            const form = $('#product-form')
            resetForm(form)
            form.find(`.card-variables`).addClass('d-none')
            form.find(`[name='status']`).val(1)
            form.attr('action', `{{ route('admin.product.create') }}`)
            form.find('.modal').modal('show').find('.modal-title').text('Sản phẩm mới')
        }

        $(document).on('click', '.btn-update-product', function(e) {
            e.preventDefault();
            const id = $(this).attr('data-id');
            $.get(`{{ route('admin.product') }}/${id}`, function(product) {
                initUpdateProduct(product)
            })
        })

        function initUpdateProduct(product) {
            const form = $('#product-form')
            resetForm(form)
            form.find('[name=id]').val(product.id)
            form.find('[name=name]').val(product.name)
            form.find('[name=barcode]').val(product.barcode)
            form.find('[name=sku]').val(product.sku)
            form.find('[name=unit]').val(product.unit)
            form.find('[name=status]').val(product.status)
            form.find('[name=avatar]').prev().find('img').attr('src', product.avatarUrl)
            $.each(product.catalogues, function(i, catalogue) {
                $(`input[type=checkbox][value=${catalogue.id}]`).prop('checked', true)
            })
            sortCheckedInput(form)
            showVariables(product.id)
            if (product.deleted_at != null) {

                form.find('.btn[type=submit]:last-child').addClass('d-none')
            }
            form.attr('action', `{{ route('admin.product.update') }}`).find('.modal').modal('show').find('.modal-title').text(product.name);
        }

        $(document).on('click', '.btn-create-variable', function(e) {
            e.preventDefault();
            const form = $('#variable-form')
            resetForm(form)
            $('#variable-units').empty()
            $('.btn-append-variable').trigger('click')
            form.find(`[name='status']`).prop('checked', true)
            form.find(`[name=stock_limit]`).val(0)
            form.find(`[name='product_id']`).val($(this).attr('data-product'))
            form.attr('action', `{{ route('admin.variable.create') }}`)
            form.find('.modal').modal('show').find('.modal-title').text('Biến thể mới')
        })

        $(document).on('click', '.btn-update-variable', function(e) {
            e.preventDefault();
            const id = $(this).attr('data-id');
            $.get(`{{ route('admin.variable') }}/${id}`, function(variable) {
                initUpdateVariable(variable)
            })
        })

        function initUpdateVariable(variable) {
            const form = $('#variable-form');
            resetForm(form)
            form.find('#variable-modal-label').text(variable.name)
            form.find('[name=id]').val(variable.id)
            form.find('[name=name]').val(variable.name)
            form.find('[name=description]').val(variable.description)
            form.find('[name=stock_limit]').val(variable.stock_limit)
            form.find(`[name='status']`).prop('checked', variable.status)
            form.find(`[name='product_id']`).val(variable.product_id)
            if (variable.deleted_at != null) {
                form.find('.btn[type=submit]:last-child').addClass('d-none')
            }
            $.each(variable.attributes, function(index, attribute) {
                form.find(`#variable-attribute-${attribute.id}`).prop('checked', true);
            })
            form.find('#variable-units').empty()
            $.each(variable.units, function(index, unit) {
                form.find('#variable-units').append(`
                <tr class="variable-unit">
                    <td><input class="form-control" name="unit_barcode[]" type="text" value="${unit.barcode ? unit.barcode : ''}" placeholder="Mã vạch"></td>
                    <td><input class="form-control" name="unit_term[]" type="text" value="${unit.term}" placeholder="Tên" required></td>
                    <td><input class="form-control money" name="unit_price[]" type="text" value="${unit.price}" placeholder="Giá" required></td>
                    <td><input class="form-control bg-white" name="unit_rate[]" type="text" value="${unit.rate}" placeholder="Tỷ lệ quy đổi" required disabled></td>
                    <td>
                        <input name="unit_id[]" value="${unit.id}" type="hidden">
                        <form action="{{ route('admin.unit.remove') }}" method="post" class="save-form">
                            @csrf
                            <input type="hidden" name="choices[]" value="${unit.id}"/>
                            <button class="btn btn-link text-decoration-none btn-remove-unit">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>
                    </td>
                </tr>`);
            })
            form.attr('action', `{{ route('admin.variable.update') }}`)
            form.find('.modal').modal('show').find('.modal-title').text(variable.name != null ? variable.name : variable.id)
        }

        $(document).on('change', '.variable-attribute', function() {
            $(this).closest('.accordion-body').find('.variable-attribute').not(this).prop('checked', false)
            const text = $(this).closest('.accordion').find('.variable-attribute:checked').map(function() {
                return $(this).next().text()
            }).get().join(' - ')
            $(this).closest('.modal').find('#variable-name').val(text)
        })

        $(document).on('click', '.btn-append-unit', function(e) {
            e.preventDefault();
            const form = $('#variable-form');
            const str = `
                    <tr class="variable-unit">
                        <td><input class="form-control" name="unit_barcode[]" type="text" placeholder="Mã vạch"></td>
                        <td><input class="form-control" name="unit_term[]" type="text" placeholder="Tên" required></td>
                        <td><input class="form-control money" name="unit_price[]" type="text" placeholder="Giá" required></td>
                        <td><input class="form-control" name="unit_rate[]" type="text" placeholder="Tỷ lệ quy đổi" required></td>
                        <td>
                            <input name="unit_id[]" type="hidden">
                            <form action="{{ route('admin.unit.remove') }}" method="post" class="save-form">
                                @csrf
                                <input type="hidden" name="choices[]" value=""/>
                                <button class="btn btn-link text-decoration-none btn-remove-unit">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </td>
                    </tr>`
            form.find('#variable-units').append(str);
        })

        $(document).on('click', '.btn-remove-unit', function(e) {
            e.preventDefault();
            const btn = $(this);
            if ($('.variable-unit').length > 1) {
                if (btn.prev().val()) {
                    const form = btn.closest('form');
                    Swal.fire(config.sweetAlert.confirm).then((result) => {
                        if (result.isConfirmed) {
                            submitForm(form).done(function(response) {
                                if (response.status == 'success') {
                                    btn.closest('.variable-unit').remove();
                                }
                            })
                        }
                    });
                } else {
                    btn.parents('.variable-unit').remove();
                }
            } else {
                pushToastify('Phải có ít nhất một đơn vị tính!', 'danger')
            }
        })
        // =========== END PRODUCT =========


        /**
         * IN BARCODE - MÃ VẠCH
         */
        $('body').on('click', '.btn-barcode-product', function() {
            var form = $(this).closest('section').find('.batch-form'),
                modal = $('#barcode-modal');
            var checkedValues = JSON.stringify(form.find('input[name="choices[]"]:checked').map(function() {
                return $(this).val();
            }).get());
            $.get(config.routes.get + '/barcode?ids=' + checkedValues, function(products) {
                let str = ``
                $.each(products, function(i, product) {
                    let variables = ``,
                        units = ``
                    $.each(product.variables, function(j, variable) {
                        $.each(variable.units, function(k, unit) {
                            units += `<option value="${ unit.barcode }" data-variable="${ unit.variable_id }" data-price="${ unit.price }" data-term="${ unit.term }" ${j ? 'hidden' : ''}>${ unit.term }</option>`
                        })
                        variables += `<option value="${ variable.id }">${ variable.name != null ? variable.name : variable.id }</option>`
                    })
                    str += `
                <div class="col-12 col-lg-4">
                    <div class="card card-barcode">
                        <div class="ratio ratio-1x1">
                            <img src="${ product.avatarUrl }" class="card-img-top object-fit-cover p-1">
                        </div>
                        <div class="card-body p-2">
                        <label class="form-label" for="variable-${i}">Chọn biến thể</label>
                            <select id="variable-${i}" class="form-control form-control-sm mb-1 barcode-variable" placeholder="Chọn biến thể" autocomplete="off" required>
                                ${variables}
                            </select>
                            <label class="form-label" for="unit-${i}">Chọn đơn vị tính</label>
                            <select id="unit-${i}" class="form-control form-control-sm mb-1 barcode-unit" placeholder="Chọn đơn vị tính" autocomplete="off" required>
                                ${units}
                            </select>
                            <input type="hidden" class="barcode-product-name" value="${product.name}">
                            <label class="form-label" for="quantity-${i}">Số lượng in</label>
                            <input class="form-control form-control-sm barcode-quantity" id="quantity-${i}" placeholder="Nhập số lượng tem" type="text" value="2" autocomplete="off" inputmode="numeric" required>
                        </div>
                    </div>
                </div>`
                })
                modal.find('#barcode-products').html(str)
                modal.modal('show')
            })
        })

        $(document).on('click', '.btn-print-barcode', function() {
            let str = ``
            $('#barcode-modal').find('.barcode-unit').each(function() {
                let card = $(this).closest('.card-barcode'),
                    qtt = parseInt(card.find('.barcode-quantity').val()),
                    product = card.find('.barcode-product-name').val(),
                    price = $(this).find(`option[value='${$(this).val()}']`).attr('data-price'),
                    selectVariable = $(this).closest('.card-barcode').find('select.barcode-variable'),
                    variable = selectVariable.find(`option[value='${selectVariable.val()}']`).text(),
                    term = $(this).find(`option[value='${$(this).val()}']`).attr('data-term'),
                    barcode = $(this).val()
                for (let i = 0; i < qtt; i++) {
                    if (barcode != 'null') {
                        str += `
                        <div class="col-6 py-0 m-0 ps-0 pe-2" style="width: 36mm; height: 22mm">
                            <div class="d-flex align-items-center justify-content-start" style="height: 10.5mm; overflow: hidden;">
                                <svg id="barcode-${barcode}"></svg>
                                <input type="hidden" class="barcode-value" value="${barcode}">
                            </div>
                            <h6 class="overflow-hidden text-center mb-0 ellipsis-two-lines" style="font-size: 7.5pt">${product}-${variable}-${term}</h6>
                            <h5 class="fw-bold text-center mb-0" style="font-size: 8pt">${number_format(price)}đ</h5>
                        </div>`
                    }
                }
            })
            $('#print-wrapper').html(`
            <div id="print-container" style="color: #000000">
                <div class="container-fluid print-template">
                    <div class="row p-0 m-0" style="width: 72mm">
                        ${str}
                    </div>
                </div>
            </div>`)
            $('#print-wrapper').find('.barcode-value').each(function() {
                JsBarcode('#' + $(this).prev().attr('id'), $(this).val(), {
                    format: "CODE128",
                    lineColor: "#000000",
                    fontSize: 32,
                    width: 3,
                    height: 75,
                    margin: 2,
                    textPosition: "top",
                    flat: true,
                    displayValue: true
                });
            })
            printJS({
                printable: 'print-container',
                type: 'html',
                css: [`{{ asset('admin/css/bootstrap.css') }}`, `{{ asset('admin/css/key.css') }}`],
                targetStyles: ['*'],
                showModal: false,
            });
        })

        $(document).on('change', '.barcode-variable', function() {
            const id = $(this).val()
            $(this).closest('.card-barcode').find('.barcode-unit').each(function() {
                let set = false;
                $(this).find('option').prop('hidden', false).prop('selected', false).each(function() {
                    if ($(this).attr('data-variable') != id) {
                        $(this).prop('hidden', true)
                    } else {
                        if (!set) {
                            $(this).prop('selected', true)
                            set = true
                        }
                    }
                })
            })
        })

        /**
         * BARCODE ONSCAN
         */
        $(document).ready(function() {
            onScan.attachTo(document, {
                suffixKeyCodes: [13], // Enter-key expected at the end of a scan
                reactToPaste: false, // Compatibility to built-in scanners in paste-mode (as opposed to keyboard-mode)
                onScan: function(sCode, iQty) {
                    // console.log('Barcode scanned: ' + sCode); // Check if this runs
                    $('input:focus').val('')
                    if ($('#product-modal').hasClass('show')) {
                        $.get(`{{ route('admin.variable') }}/scan?barcode=${sCode}`, function(variable) {
                            if (variable) {
                                pushToastify("Mã vạch đã tồn tại!", 'danger')
                            } else {
                                let available = true;
                                $(`[name='barcode[]']`).each(function(i, input) {
                                    if (input.value == sCode) {
                                        available = false;
                                        return false;
                                    }
                                })
                                if (available) {
                                    $('.btn-append-variable').trigger('click')
                                    $(`[name='barcode[]']`).last().val(sCode)
                                } else {
                                    pushToastify("Mã vạch đã tồn tại!", 'danger')
                                }
                            }
                        })
                    } else if ($('#import-modal').hasClass('show')) {
                        let btn = $('.btn-create-stock'),
                            existVariable = false
                        btn.prop("disabled", true).html('<span class="spinner-border spinner-border-sm" id="spinner-form" role="status"></span>');
                        $.get(`{{ route('admin.unit') }}/scan?barcode=${sCode}`, function(unit) {
                            if (unit) {
                                $('.import_detail-unit_id').each(function(i, input) {
                                    if (input.value == unit.id) {
                                        existVariable = true
                                        let input = $(this).closest('tr').find(`[name='quantities[]']`)
                                        input.val(parseInt(input.val()) + 1)
                                        return false
                                    }
                                })
                                if (!existVariable) {
                                    htmlImportVariable(unit)
                                }
                            } else {
                                pushToastify("Không tìm thấy sản phẩm này!", 'danger')
                            }
                            btn.prop("disabled", false).html('<i class="bi bi-plus-circle"></i> Thêm');
                        })
                    } else if ('{{ Request::path() }}' == 'quantri/order/new' || $('#order-modal').hasClass('show') || $('#export-modal').hasClass('show')) {
                        if ($('#export-modal').hasClass('show')) {
                            $('#export-search-input').val(sCode).change().focus()
                        } else {
                            $.get(`{{ route('admin.stock') }}/scan?barcode=${sCode}&action=export`, function(stocks) {
                                let scanUnit,
                                    availableStock = false,
                                    tab = $('#order-modal').hasClass('show') ? $('#order-modal') : $('#export-modal').hasClass('show') ? $('#export-modal') : $('.tab-pane.active')
                                if (stocks.length) {
                                    $.each(stocks, function(index, stock) {
                                        $.each(stock.import_detail._variable.units, function(index, unit) {
                                            if (unit.barcode === sCode) {
                                                scanUnit = unit
                                            }
                                        });
                                    });
                                    $.each(stocks, function(i, stock) {
                                        var nextLoops = true,
                                            availableUnit = false,
                                            newCard = {
                                                stockId: stock.id,
                                                stockExpired: stock.expired,
                                                productName: stock.import_detail._variable._product.name + (stock.import_detail._variable.name != undefined ? ' - ' + stock.import_detail._variable.name : ''),
                                                productSku: stock.import_detail._variable._product.sku,
                                                stockQuantity: stock.quantity,
                                                stockConvertQuantity: stock.convertQuantity,
                                                variableId: stock.import_detail._variable.id,
                                                productUnit: scanUnit,
                                                productUnits: stock.import_detail._variable.units
                                            };
                                        if (tab.find(`[name='stock_ids[]'][value=${stock.id}]`).length) {
                                            tab.find(`[name='stock_ids[]'][value=${stock.id}]`).each(function(i, detail) {
                                                const card = $(this).closest('.detail'),
                                                    unitId = card.find(`[name='unit_ids[]']`).val(),
                                                    orderQuantity = parseInt(card.find(`[name='quantities[]']`).val())
                                                if (unitId == scanUnit.id) {
                                                    availableUnit = true
                                                    card.find(`[name='quantities[]']`).val(orderQuantity + 1);
                                                    if (validateQuantity(card)) {
                                                        totalOrder()
                                                        nextLoops = false
                                                        availableStock = true
                                                        return false;
                                                    }
                                                }
                                            })
                                            if (!availableUnit) {
                                                $('#export-modal').hasClass('show') ? addCardToExport(newCard) : addCardToOrder(newCard)
                                                let card = tab.find('div.detail').first();
                                                if (validateQuantity(card)) {
                                                    availableStock = true
                                                    return false
                                                } else {
                                                    card.remove();
                                                }
                                            }
                                        } else {
                                            $('#export-modal').hasClass('show') ? addCardToExport(newCard) : addCardToOrder(newCard)
                                            availableStock = true
                                            return false
                                        }
                                        return nextLoops
                                    })
                                }
                                if (!availableStock) {
                                    pushToastify("Sản phẩm này đã hết hàng trên hệ thống!", 'danger')
                                }
                            })
                        }
                    } else {
                        $('.dataTables_filter').find('input').val(sCode).change().focus()
                    }
                },
                onKeyDetect: function(iKeyCode) {
                    // console.log('Pressed: ' + iKeyCode); // Debugging
                },
                onKeyProcess: function(sChar, oEvent) {
                    // console.log('Processed character: ' + sChar); // Debugging
                },
                onScanError: function(oDebug) {
                    // console.log('Scan error: ', oDebug); // Debugging
                }
            });

            // Additional debug: Check if scanner is attached
            if (onScan.isAttachedTo(document)) {
                // console.log('Scanner detection attached successfully');
            } else {
                // console.log('Scanner detection failed to attach');
            }

            // Check keydown and keypress events
            document.addEventListener('keydown', function(event) {
                // console.log('Keydown event:', event);
            });

            document.addEventListener('keypress', function(event) {
                // console.log('Keypress event:', event);
            });
        });

        /**
         * CATALOGUE PROCESS
         */
        $(document).on('click', '.btn-create-catalogue', function(e) {
            e.preventDefault();
            const form = $('#catalogue-form')
            resetForm(form)
            form.addClass($(this).hasClass('btn-single') ? 'single' : '')
            form.find(`[name='status']`).prop('checked', true)
            form.attr('action', `{{ route('admin.catalogue.create') }}`)
            form.find('.modal').modal('show').find('.modal-title').text('Danh mục mới')
        })

        $('.btn-refresh-catalogue').click(function() {
            const btn = $(this)
            $.get(`{{ route('admin.catalogue') }}/tree`, function(html) {
                btn.parents('form').find('.catalogue-select .list-group').html(html);
            })
        })

        $(document).on('click', '.btn-update-catalogue', function(e) {
            e.preventDefault();
            const id = $(this).attr('data-id'),
                form = $('#catalogue-form');
            resetForm(form)
            $.get(`{{ route('admin.catalogue') }}/${id}`, function(catalogue) {
                form.find('[name=id]').val(catalogue.id)
                form.find('[name=name]').val(catalogue.name)
                form.find('[name=note]').val(catalogue.note)
                form.find('[name=avatar]').val(catalogue.avatar).change()
                if (catalogue.parent_id != null) {
                    var option = new Option(catalogue._parent.name, catalogue._parent.id, true, true);
                    form.find('[name=parent_id]').append(option).trigger({
                        type: 'select2:select'
                    });
                } else {
                    form.find('[name=parent_id]').val(null).trigger("change")
                }
                form.find('[name=status]').prop('checked', catalogue.status)
                form.attr('action', `{{ route('admin.catalogue.update') }}`)
                if (catalogue.deleted_at != null) {
                    form.find('.btn[type=submit]:last-child').addClass('d-none')
                }
                form.find('.modal').modal('show').find('.modal-title').text(catalogue.name)
            })
        })
        // =========== END CATALOGUE ===========

    /**
     * CRITERIAL PROCESS
     */
    $(document).on('click', '.btn-create-criterial', function(e) {
        e.preventDefault();
        const form = $('#criterial-form');
        resetForm(form);
        form.attr('action', `{{ route('admin.criterial.create') }}`);
        form.find('.modal').modal('show').find('.modal-title').text('Tiêu chí mới');
        form.find('#criterial-normal_indexes').empty();
        $('#criterial-normal_indexes').append(appendRowForCriterial());
    });

    function appendRowForCriterial(normal_index = null) {
        const index = $('.criterial-row').length;
        return `
            <tr class="criterial-row">
                <td>
                    <select class="form-control form-control-plaintext" name="normal_index[${index}][specie]">
                        <option value="">Chọn loài</option>
                        @php
                            $species = \App\Models\Animal::select('specie')->distinct()->pluck('specie');
                        @endphp
                        @foreach ($species as $specie)
                            <option value="{{ $specie }}" ${normal_index && normal_index['specie'] === '{{ $specie }}' ? 'selected' : ''}>{{ $specie }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input class="form-control form-control-plaintext" value="${normal_index ? (normal_index['age_max'] ?? '') : ''}" name="normal_index[${index}][age_max]"
                        placeholder="Nhập giá trị độ tuổi tối đa" autocomplete="off">
                </td>
                <td>
                    <input class="form-control form-control-plaintext" value="${normal_index ? (normal_index['min_max'][0] ?? '') : ''}" name="normal_index[${index}][min_max][0]"
                        placeholder="Nhập giá trị tối thiểu" autocomplete="off">
                </td>
                <td>
                    <input class="form-control form-control-plaintext" value="${normal_index ? (normal_index['min_max'][1] ?? '') : ''}" name="normal_index[${index}][min_max][1]"
                        placeholder="Nhập giá trị tối đa" autocomplete="off">
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-link text-decoration-none btn-remove-detail">
                        <i class="bi bi-trash text-danger"></i>
                    </button>
                </td>
            </tr>`;
    }
    // =========== END ===========

        /**
         * CATEGORY PROCESS
         */
        $(document).on('click', '.btn-create-category', function(e) {
            e.preventDefault();
            const form = $('#category-form')
            resetForm(form)
            form.find('[name=status]').prop('checked', true);
            form.attr('action', `{{ route('admin.category.create') }}`)
            form.find('.modal').modal('show').find('.modal-title').text('Chuyên mục mới')
        })

        $(document).on('click', '.btn-update-category', function(e) {
            e.preventDefault();
            const id = $(this).attr('data-id'),
                form = $('#category-form');
            resetForm(form)
            $.get(`{{ route('admin.category') }}/${id}`, function(category) {
                form.find('[name=id]').val(category.id)
                form.find('[name=name]').val(category.name)
                form.find('[name=note]').val(category.note)
                form.find('[name=status]').prop('checked', category.status)
                form.attr('action', `{{ route('admin.category.update') }}`)
                if (category.deleted_at != null) {
                    form.find('.btn[type=submit]:last-child').addClass('d-none')
                }
                form.find('.modal').modal('show').find('.modal-title').text(category.name)
            })
        })
        // =========== END CATEGORY ===========


        /**
         * USER PROCESS
         */
        $(document).on('click', '.btn-create-user', function(e) {
            e.preventDefault();
            const form = $('#user-form')
            resetForm(form)
            if ($(this).attr('data-phone')) {
                form.find('[name=phone]').val($(this).attr('data-phone'))
            }
            if ($(this).attr('data-email')) {
                form.find('[name=email]').val($(this).attr('data-email'))
            }
            if ($(this).attr('data-name')) {
                form.find('[name=name]').val($(this).attr('data-name'))
            }
            form.find('[name=status]').prop('checked', true);
            form.attr('action', `{{ route('admin.user.create') }}`)
            form.find('.modal').modal('show').find('.modal-title').text('Tài khoản mới')
        })

        $(document).on('click', '.btn-update-user', function(e) {
            e.preventDefault();
            const id = $(this).attr('data-id'),
                form = $('#user-form');
            resetForm(form);
            $.get(`{{ route('admin.user') }}/${id}`, function(user) {
                form.find('[name=id]').val(user.id)
                form.find('[name=name]').val(user.name)
                form.find('[name=phone]').val(user.phone)
                form.find('[name=email]').val(user.email)
                form.find('[name=scores]').val(user.scores)
                form.find('[name=birthday]').val(user.birthday)
                form.find('[name=note]').val(user.note)
                form.find('[name=address]').val(user.address)
                form.find(`[name=gender][value="${user.gender}"]`).prop('checked', true);
                form.find(`[name='status']`).prop('checked', user.status)
                form.attr('action', `{{ route('admin.user.update') }}`)
                form.find('[name=password]').removeAttr('required')
                form.find('.modal').modal('show').find('.modal-title').text(user.name)
                if (user.deleted_at != null) {
                    form.find('.btn[type=submit]:last-child').addClass('d-none')
                }
                $('#user-avatar-preview').attr('src', user.avatarUrl)
                $('.btn-customer_orders').attr('href', `{{ route('admin.order') }}?customer_id=${user.id}`)
                if (user.local_id != null) {
                    var option = new Option(user.local.district + ', ' + user.local.city, user.local.id);
                    $('select#user-local_id').append(option).trigger({
                        type: 'select2:select'
                    });
                    form.find('[name=local_id]').val(user.local_id).change()
                }
            })
        })

        $('#user-local_city').change(function() {
            $.get(`{{ route('admin.local') }}/districts?city=${$(this).val()}`, function(locals) {
                let options = ''
                $.each(locals, function(i, local) {
                    options += `<option value="${local.id}">${local.text}</option>`;
                });
                $('select#user-local_id').html(options).trigger({
                    type: 'select2:select'
                });
            })
        })

        $('#user-local_id').change(function() {
            $.get(`{{ route('admin.local') }}/${$(this).val()}`).then(function(local) {
                var option = new Option(local.city);
                $('select#user-local_city').html(option).trigger({
                    type: 'select2:select'
                });
            });
        })

        $(document).on('click', '.select-avatar', function(e) {
            e.preventDefault();
            $(this).parent().find('input[type="file"]').click();
        })

        $(document).on('change', '#user-avatar', function(e) {
            e.preventDefault();
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#user-avatar-preview').attr('src', e.target.result).show();
                }
                reader.readAsDataURL(this.files[0]);
            }
        })

        $(document).on('click', '.btn-update-user_role', function() {
            const id = $(this).attr('data-id'),
                form = $('#user_role-form');
            resetForm(form)
            $.get(`{{ route('admin.user') }}/${id}`).done(function(user) {
                form.attr('action', `{{ route('admin.user.update.role') }}`);
                form.find('#user_role-modal-label').text('Thiết lập vai trò cho ' + user.name)
                $.each(user.roles, function(i, role) {
                    $('input[name="role_id[]"][value="' + role.id + '"]').prop('checked', true);
                });
                $.each(user.branches, function(i, branch) {
                    $('input[name="branch_id[]"][value="' + branch.id + '"]').prop('checked', true);
                });
                $.each(user.warehouses, function(i, warehouse) {
                    $('input[name="warehouse_id[]"][value="' + warehouse.id + '"]').prop('checked', true);
                });

                if (user.deleted_at != null) {
                    form.find('.btn[type=submit]:last-child').addClass('d-none')
                }
                form.find(`[name='id']`).val(id)
                form.find('.modal').modal('show')
            })
        })

        $(document).on('click', '.btn-update-user_password', function() {
            const id = $(this).attr('data-id'),
                form = $('#user_password-form');
            resetForm(form)
            form.attr('action', `{{ route('admin.user.update.password') }}`)
            form.find(`[name='id']`).val(id)
            form.find('.modal').modal('show')
        })
        // =========== END USER ===========

        /**
         * WAREHOUSE PROCESS
         */
        $(document).on('click', '.btn-create-warehouse', function(e) {
            e.preventDefault();
            const form = $('#warehouse-form')
            resetForm(form)
            form.find('[name=status]').prop('checked', true);
            form.attr('action', `{{ route('admin.warehouse.create') }}`)
            form.find('.modal').modal('show').find('.modal-title').text('Kho hàng mới')
        })

        $(document).on('click', '.btn-update-warehouse', function(e) {
            e.preventDefault();
            const id = $(this).attr('data-id'),
                form = $('#warehouse-form');
            resetForm(form)
            $.get(`{{ route('admin.warehouse') }}/${id}`, function(warehouse) {
                form.find('[name=name]').val(warehouse.name)
                form.find('[name=id]').val(warehouse.id)
                form.find('[name=note]').val(warehouse.note)
                form.find('[name=address]').val(warehouse.address)
                form.find(`[name='status']`).prop('checked', warehouse)
                if (warehouse.branch_id) {
                    const branch = new Option(warehouse._branch.name, warehouse._branch.id, true, true)
                    form.find(`[name='branch_id']`).html(branch).trigger({
                        type: 'select2:select'
                    });
                }
                $.each(warehouse.permissions, function(index, permission) {
                    form.find(`#permission-${permission.id}`).prop('checked', true)
                })
                if (warehouse.deleted_at != null) {
                    form.find('.btn[type=submit]:last-child').addClass('d-none')
                }
                form.attr('action', `{{ route('admin.warehouse.update') }}`)
                form.find('.modal').modal('show').find('.modal-title').text(warehouse.name)
            })
        })
        // =========== END WAREHOUSE ===========

        /**
         * BRANCH PROCESS
         */
        $(document).on('click', '.btn-create-branch', function(e) {
            e.preventDefault();
            const form = $('#branch-form')
            resetForm(form)
            form.find(`[name='status']`).prop('checked', true)
            form.attr('action', `{{ route('admin.branch.create') }}`)
            form.find('.modal').modal('show').find('.modal-title').text('Chi nhánh mới')
        })

        $(document).on('click', '.btn-update-branch', function(e) {
            e.preventDefault();
            const id = $(this).attr('data-id'),
                form = $('#branch-form');
            resetForm(form)
            $.get(`{{ route('admin.branch') }}/${id}`, function(branch) {
                form.find('[name=id]').val(branch.id)
                form.find('[name=name]').val(branch.name)
                form.find('[name=phone]').val(branch.phone)
                form.find('[name=email]').val(branch.email)
                form.find('[name=address]').val(branch.address)
                form.find('[name=organ]').val(branch.organ)
                form.find('[name=note]').val(branch.note)
                form.find(`[name='status']`).prop('checked', branch.status)
                if (branch.deleted_at != null) {
                    form.find('.btn[type=submit]:last-child').addClass('d-none')
                }
                form.attr('action', `{{ route('admin.branch.update') }}`)
                form.find('.modal').modal('show').find('.modal-title').text(branch.name)
            })
        })
        // =========== END BRANCH ===========

        /**
         * PET PROCESS
         */
        $(document).on('click', '.btn-create-pet', function(e) {
            e.preventDefault();
            const form = $('#pet-form')
            resetForm(form)
            if ($(this).attr('data-customer')) {
                $.get(`{{ route('admin.user') }}/${$(this).attr('data-customer')}`, function(user) {
                    let option = new Option(user.name + ' - ' + user.phone, user.id, true, true)
                    $('[name=customer_id]').html(option).trigger({
                        type: 'select2:select'
                    });
                })
            }
            form.find(`[name='status']`).prop('checked', true)
            form.attr('action', `{{ route('admin.pet.create') }}`)
            form.find('.modal').modal('show').find('.modal-title').text('Thú cưng mới')
        })

        $('#pet-specie').change(function() {
            $.get(`{{ route('admin.animal') }}/lineages?specie=${$(this).val()}`, function(lineages) {
                let options = ''
                $.each(lineages, function(i, lineage) {
                    options += `<option value="${lineage.id}">${lineage.text}</option>`;
                })
                $('select#pet-animal_id').html(options).trigger({
                    type: 'select2:select'
                });
            })
        })

        $('#pet-animal_id').change(function(params) {
            $.get(`{{ route('admin.animal') }}/${$(this).val()}`).then(function(animal) {
                var option = new Option(animal.specie);
                $('select#pet-specie').html(option).trigger({
                    type: 'select2:select'
                });
            });
        })

        $(document).on('click', '.btn-remove-vaccination', function() {
            $('.pet-stat-list-vaccination').find('.list-group-item:first-child').remove()
        })

        $(document).on('click', '.btn-create-vaccination', function() {
            let i = $('.pet-stat-list-vaccination').find('.list-group-item').length
            $('.pet-stat-list-vaccination').prepend(`
            <li class="list-group-item">
                <input type="date" name="vaccination[${i}][date]" class="form-control form-control-sm" placeholder="Ngày tiêm chủng">
                <input type="text" name="vaccination[${i}][service]" class="form-control" placeholder="Gói tiêm chủng">
            </li>`)
        })

        $(document).on('click', '.btn-update-pet', function(e) {
            e.preventDefault();
            const id = $(this).attr('data-id'),
                form = $('#pet-form');
            resetForm(form)
            $.get(`{{ route('admin.pet') }}/${id}`, function(pet) {
                form.find('[name=id]').val(pet.id)
                form.find('[name=name]').val(pet.name)
                $('#pet-avatar-preview').attr('src', pet.avatarUrl);
                if (pet.avatar) {
                    form.find(`[name=avatar]`).next().find('.btn').removeClass('d-none')
                }
                form.find('[name=birthday]').val(pet.age)
                form.find('[name=fur_color]').val(pet.fur_color)
                form.find('[name=fur_type]').val(pet.fur_type)
                form.find(`[name="gender"][value="${pet.gender}"]`).prop('checked', true)
                form.find(`[name="neuter"][value="${pet.neuter}"]`).prop('checked', true)
                form.find('[name=note]').val(pet.note)
                form.find('#pet-created_at').text(moment(pet.created_at).format("DD/MM/YYYY"))
                form.find(`[name='status']`).prop('checked', pet.status)
                var option = new Option(pet._customer.name + ' - ' + pet._customer.phone, pet._customer.id);
                $('select#pet-customer_id').append(option).trigger({
                    type: 'select2:select'
                });
                form.find('[name=customer_id]').val(pet.customer_id).change()
                var option = new Option(pet.animal.lineage, pet.animal.id);
                $('select#pet-animal_id').append(option).trigger({
                    type: 'select2:select'
                });
                form.find('[name=animal_id]').val(pet.animal_id).change()
                if (pet.deleted_at != null) {
                    form.find('.btn[type=submit]:last-child').addClass('d-none')
                }
                const vaccination = pet.vaccination ? JSON.parse(pet.vaccination) : []
                form.find('.pet-stat-list-vaccination').html(vaccination.reverse().map(function(item, i) {
                    return `<li class="list-group-item">
                    <small class="text-secondary">
                        <em>${moment(item.date).format('DD/MM/YYYY')}</em>
                    </small><br/>
                    <input type="hidden" name="vaccination[${i}][date]" value="${item.date}">
                    <input type="hidden" name="vaccination[${i}][service]" value="${item.service}">
                    ${item.service}</li>`
                }).join(''))
                form.find('.pet-stat-list-diag').html(pet.infos.reverse().map(function(info, i) {
                    return `<li class="list-group-item">
                    <small class="text-secondary">
                        <em>${moment(info.created_at).format('DD/MM/YYYY')}</em>
                    </small><br/>
                    ${info.final_diag ? info.final_diag.join('<br>') : ''}</li>`
                }).join(''))

                form.find('.pet-stat-list-indication').html(pet.infos.reverse().map(function(info, i) {
                    let listItem = `<li class="list-group-item">
                                        <small class="text-secondary">
                                            <em>${moment(info.created_at).format('DD/MM/YYYY')}</em>
                                        </small><br/>`;

                    $.each(info.indications, function(key, indication) {
                        let ticketDetails = [];
                        $.each(indication, function(index, ticket) {
                            ticketDetails.push(ticket.detail._service.name);
                        });
                        listItem += ticketDetails.join('<br>') + '<br>';
                    });

                    listItem += `</li>`;
                    return listItem;
                }).join(''))
                form.attr('action', `{{ route('admin.pet.update') }}`)
                form.find('.modal').modal('show').find('.modal-title').text(pet.name)
            })
        })
        // =========== END PET ===========

        /**
         * IMPORT PROCESS
         */
        $(document).on('click', '.btn-create-import', function(e) {
            e.preventDefault();
            const form = $('#import-form')
            resetForm(form)
            form.find('[name=status][value=1]').prop('checked', true)
            form.find('[name=supplier_id]').closest('.form-group').removeClass('d-none')
            form.find('#import-stocks').empty()
            form.attr('action', `{{ route('admin.import.create') }}`)
            form.find('.btn-print.print-import').addClass('d-none').removeAttr('data-id')
            form.find('.modal').modal('show').find('.modal-title').text('Nhập hàng mới')
        })

        $(document).on('click', '.btn-select-variable', function() {
            let unit = JSON.parse($(this).find('input').val()),
                existVariable = false;

            $('.import_detail-unit_id').each(function(i, select) {
                if (select.value == unit.id) {
                    existVariable = true
                    let quantityInput = $(this).closest('tr').find(`[name='quantities[]']`)
                    quantityInput.val(parseInt(quantityInput.val()) + 1)
                    totalImport()
                    return false
                }
            })
            if (!existVariable) {
                htmlImportVariable(unit);
            }
            $(this).closest('.search-result').removeClass('show');
        })

        function htmlImportVariable(unit) {
            let options = ``
            $.each(unit._variable.units, function(i, item) {
                options += `<option value="${item.id}" data-rate="${item.rate}" data-price="${item.price}" ${item.rate == unit.rate ? 'selected' : ''}>${item.term}</option>`
            })
            const str = `
            <tr class="border import-detail">
                <td>
                    <p class="text-dark fs-5 mb-0">${unit._variable._product.name}${unit._variable.name != null ? ' - ' + unit._variable.name : ''}</p><small>${unit._variable._product.sku != null ? unit._variable._product.sku : ''}</small>
                    <input type="hidden" class="form-control import_detail-variable_id bg-white" name="variable_ids[]" value="${unit.variable_id}" required readonly />
                    <input type="hidden" class="import_detail-current_unit_id" name="current_unit_ids[]" value="${unit.id}">
                </td>
                <td>
                    <select class="form-control form-control-plaintext text-center import_detail-unit_id" name="unit_ids[]">${options}</select>
                </td>
                <td>
                    <div class="input-group quantity-group">
                        <button type="button" class="btn btn-outline-primary rounded-circle mt-1 btn-dec"><i class="bi bi-dash"></i></button>
                        <input type="text" name="quantities[]" class="form-control-plaintext import_detail-quantity fs-5 text-center" onclick="this.select()" placeholder="Số" value="1" inputmode="numeric" required/>
                        <button type="button" class="btn btn-outline-primary rounded-circle mt-1 btn-inc"><i class="bi bi-plus"></i></button>
                    </div>
                </td>
                <td><input type="text" name="prices[]" class="form-control form-control-plaintext border-bottom fs-5 money text-end" list="unit_prices-${unit.id}" value="0" onclick="this.select()" placeholder="Giá nhập" inputmode="numeric" required></td>
                <td><input type="text" name="lots[]" class="form-control form-control-plaintext border-bottom fs-5" onclick="this.select()" placeholder="Lô hàng"></td>
                <td><input type="date" name="expireds[]" class="form-control form-control-plaintext border-bottom fs-5" min="{{ date('Y-m-d') }}" inputmode="numeric" placeholder="Hạn sử dụng"></td>
                <td>
                    <datalist id="unit_prices-${unit.id}">
                        ${ Object.values(unit.import_prices).map(price => `<option>${number_format(price)}</option>`).join('') }
                    </datalist>
                    <input type="hidden" name="import_detail_ids[]" />
                    <input type="hidden" name="stock_ids[]"/>
                    <button type="submit" class="btn btn-link px-0 btn-remove-detail import">
                        <i class="bi bi-trash" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Xóa"></i>
                    </button>
                </td>
            </tr>`
            $('#import-stocks').append(str)
            totalImport()
        }

        $(document).on('change', `.import_detail-unit_id[name='unit_ids[]']`, function() {
            const newUnit = parseInt($(this).val()),
                current = $(this).closest('tr').find(`[name='current_unit_ids[]']`),
                count = $(".import_detail-unit_id[name='unit_ids[]']").filter(function() {
                    return $(this).val() == newUnit;
                }).length;
            if (count > 1) {
                pushToastify('Đã có đơn vị tính này trong một hàng khác', 'danger')
                $(this).val(current.val())
            } else {
                current.val(newUnit)
                totalImport()
            }
        })

        $(document).on('change', `#import-form [name='prices[]'], #import-form [name='quantities[]']`, function() {
            totalImport()
        })

        function totalImport() {
            const totalImport = $('#import-form').find(`.import-detail`).map(function() {
                var price = parseFloat($(this).find(`[name='prices[]']`).val().split(',').join('')) || 0;
                var quantity = parseFloat($(this).find(`[name='quantities[]']`).val().split(',').join('')) || 1;
                return price * quantity;
            }).get().reduce(function(total, value) {
                return total + value;
            }, 0);
            $('#import-summary').val(totalImport)
        }

        $(document).on('click', '.btn-update-import', function() {
            const id = $(this).attr('data-id');

            $.get(` {{ route('admin.import') }}/${id}`, function(obj) {
                const form = $('#import-form');
                resetForm(form)
                $('#import-form').attr('action', `{{ route('admin.import.update') }}`)
                form.find(`[name='id']`).val(obj.id)
                form.find('.btn-print.print-import').removeClass('d-none').attr('data-id', obj.id)
                form.find(`[name='created_at']`).val(moment(obj.created_at).format('YYYY-MM-DD HH:MM'))
                if (obj._warehouse.id) {
                    var warehouse = new Option(obj._warehouse.name, obj._warehouse.id, true, true);
                    form.find('[name=warehouse_id]').html(warehouse).trigger({
                        type: 'select2:select'
                    });
                }

                if (obj.supplier_id) {
                    var supplier = new Option(obj._supplier.name, obj._supplier.id, true, true);
                    form.find('[name=supplier_id]').html(supplier).removeClass('d-none').trigger({
                        type: 'select2:select'
                    });
                } else {
                    form.find('[name=supplier_id]').closest('.form-group').addClass('d-none')
                }

                form.find(`[name='status'][value=${obj.status}]`).prop('checked', true)
                form.find(`[name='note']`).val(obj.note).prop('disabled', true)
                $('#import-stocks').empty()
                obj.import_details.forEach(import_detail => {
                    let str = htmlImportStock(import_detail)
                    $('#import-stocks').append(str)
                });
                if (obj.deleted_at != null) {
                    form.find('.btn[type=submit]:last-child').addClass('d-none')
                }
                totalImport()
                form.find('.modal').modal('show').find('.modal-title').text(obj.code)
            })
        })

        function htmlImportStock(detail) {
            return `
        <tr class="border import-detail">
            <td>
                <p class="text-dark fs-5 mb-0">${detail._variable._product.name} - ${detail._variable.name}</p><small>${detail._variable._product.sku}</small>
                <input type="hidden" class="form-control import_detail-variable_id bg-white" name="variable_ids[]" value="${detail._variable.id}" required readonly />
                    <input type="hidden" class="import_detail-current_id" name="current_unit_ids[]" value="${detail._unit.id}">
            </td>
            <td>
                <select class="form-control form-control-plaintext text-center import_detail-unit_id" name="unit_ids[]">
                    <option value="${detail._unit.id}" data-rate="${detail._unit.rate}" data-price="${detail._unit.price}" selected>${detail._unit.term}</option>
                </select>
            </td>
            <td>
                <div class="input-group quantity-group">
                    <button type="button" class="btn btn-outline-primary rounded-circle mt-1 btn-dec"><i class="bi bi-dash"></i></button>
                    <input type="text" name="quantities[]" class="form-control-plaintext fs-5 text-center" onclick="this.select()" placeholder="Số" value="${number_format(detail.quantity)}" inputmode="numeric" required/>
                    <button type="button" class="btn btn-outline-primary rounded-circle mt-1 btn-inc"><i class="bi bi-plus"></i></button>
                </div>
            </td>
            <td><input type="text" name="prices[]" class="form-control form-control-plaintext border-bottom fs-5 money text-end" list="unit_prices-${detail.unit_id}" value="${detail.price}" onclick="this.select()" placeholder="Giá nhập" inputmode="numeric" required></td>
            <td><input type="text" name="lots[]" class="form-control form-control-plaintext border-bottom fs-5" value="${detail.stock.lot ? detail.stock.lot : ''}" onclick="this.select()" placeholder="Lô hàng"></td>
            <td><input type="date" name="expireds[]" class="form-control form-control-plaintext border-bottom fs-5" value="${detail.stock.expired != null ? detail.stock.expired : ''}" inputmode="numeric" placeholder="Hạn sử dụng"></td>
            <td>
                <datalist id="unit_prices-${detail.unit_id}">
                    ${ Object.values(detail.import_prices).map(price => `<option>${number_format(price)}</option>`).join('') }
                </datalist>
                <input type="hidden" name="import_detail_ids[]" value="${detail.id}" />
                <input type="hidden" name="stock_ids[]" value="${detail.stock.id}" />
                <a class="btn btn-link px-0 btn-remove-detail import" data-id="${detail.id}" data-url="{{ getPath(route('admin.import_detail.remove')) }}">
                    <i class="bi bi-trash"></i>
                </a>
            </td>
        </tr>`;
    }


    $(document).on('click', '.btn-view-import_detail', function() {
        const product_id = $(this).data('id')
        resetModalDataTable('import_detail-table');
        showImportDetails(product_id)
        $('#import_detail-table').css('width', '100%');
        initDataTable('import_detail-table'); 
        $('#import_detail-modal').modal('show');
    });

    function resetModalDataTable(tableId) {
        $(`#${tableId}`).DataTable().destroy();
        $(`#${tableId} thead tr`).not(':first').remove();
        $(`#${tableId} tbody`).empty();
    }

    // $('.load_datatable_modal').on('hidden.bs.modal', function() {
    //     $('#import_detail-table').DataTable().destroy();
    //     $('#import_detail-table thead tr').not(':first').remove();
    //     $('#import_detail-table tbody').empty(); 
    // });

    $(document).on('click', '.btn-view-export_detail', function() {
        const product_id = $(this).data('id');
        resetModalDataTable('export_detail-table');
        showExportDetails(product_id);
        $('#export_detail-table').css('width', '100%');
        initDataTable('export_detail-table');
        $('#export_detail-modal').modal('show');
    });

    /* ===================== END IMPORT ==================== */

        /**
         * SUPPLIER PROCESS
         */
        $(document).on('click', '.btn-create-supplier', function(e) {
            e.preventDefault();
            const form = $('#supplier-form')
            resetForm(form)
            form.find(`[name='status']`).prop('checked', true)
            form.attr('action', `{{ route('admin.supplier.create') }}`)
            form.find('.modal').modal('show')
        })

        $(document).on('click', '.btn-update-supplier', function(e) {
            e.preventDefault();
            const id = $(this).attr('data-id'),
                form = $('#supplier-form');
            resetForm(form)
            $.get(`{{ route('admin.supplier') }}/${id}`, function(supplier) {
                form.find('[name=id]').val(supplier.id)
                form.find('[name=name]').val(supplier.name)
                form.find('[name=phone]').val(supplier.phone)
                form.find('[name=email]').val(supplier.email)
                form.find('[name=address]').val(supplier.address)
                form.find('[name=organ]').val(supplier.organ)
                form.find('[name=note]').val(supplier.note)
                form.find(`[name='status']`).prop('checked', supplier.status)
                form.attr('action', `{{ route('admin.supplier.update') }}`)
                form.find('.modal').modal('show')
            })
        })
        /* =================== END SUPPLIER ================== */

        /**
         * EXPORT PROCESS
         */
        $(document).on('click', '.btn-create-export', function(e) {
            e.preventDefault();
            initCreateExport()
        })

        $(document).on('click', '.btn-submit-export', function(e) {
            e.preventDefault();
            const btn = $(this)
            if ($(this).hasClass('is-invalid')) {
                Swal.fire({
                    title: 'Lưu ý!',
                    html: "Phát hiện việc nhập số lượng không hợp lệ gần đây.<br>Bạn có muốn kiểm tra lại không?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Xác nhận',
                    cancelButtonText: 'Kiểm tra lại',
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.isConfirmed) {
                        btn.removeClass('is-invalid').closest('form').submit()
                    } else {
                        btn.removeClass('is-invalid')
                    }
                });
            } else {
                $(this).closest('form').submit();
            }
        })

        function initCreateExport() {
            const form = $('#export-form')
            resetForm(form)
            form.find('.btn.btn-submit-export').removeClass('is-invalid')
            $('.export-details').empty()
            form.attr('action', `{{ route('admin.export.create') }}`)
            $('[name=status][value=1]').prop('checked', true)
            form.find(`[name='date']`).val(moment().format('YYYY-MM-DD'))
            form.find('.btn-print.print-export').addClass('d-none').removeAttr('data-id')
            form.find('.modal').modal('show').find('.modal-title').text('Xuất hàng mới')
        }

        function addCardToExport(stock) {
            let tab = $('#export-modal'),
                units = stock.productUnits.map((item) => {
                    return `<option value="${item.id}" data-rate="${item.rate}" data-price="${item.price}" ${item.id == stock.productUnit.id ? 'selected' : ''}>${item.term}</option>`
                }).join('')
            if (!units.length) {
                units = `<option value="${stock.productUnit.id}" data-rate="${stock.productUnit.rate}" data-price="${stock.productUnit.price}" selected>${stock.productUnit.term}</option>`
            }
            tab.find('.export-details').prepend(`
            <div class="card border shadow-none mb-2 p-3 detail export-detail">
                <div class="row">
                    <div class="col 12 col-lg-9">
                        <p class="card-title mb-0">
                            ${stock.productName}
                            <input type="hidden" class="export_detail-stock_id" name="stock_ids[]" value="${stock.stockId}"/>
                            <a class="btn btn-link btn-export_detail-product_info rounded-pill p-0" data-id="${stock.stockId}" type="button">
                                <i class="bi bi-info-circle"></i>
                            </a>
                        </p>
                        <div class="badge bg-light-info">${stock.productSku}</div>
                        ${stock.stockExpired == null || stock.stockExpired == '' ? '' : `<div class="badge bg-light-info">HSD ${moment(stock.stockExpired).format('DD/MM/YYYY')}</div>`}
                        <div class="badge bg-light-info">
                            Tồn kho ${stock.stockConvertQuantity}
                            <input type="hidden" class="export_detail-stock_quantity" name="stock_quantities[]" value="${stock.stockQuantity}"/>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="row">
                            <div class="col-6">
                                <select name="unit_ids[]" class="form-control form-control-lg form-control-plaintext bg-transparent export_detail-unit">${units}</select>
                                <input type="hidden" class="export_detail-current_unit_id" name="current_unit_ids[]" value="${stock.productUnit.id}">
                                <input type="hidden" class="export_detail-current-quantity" name="current_quantities[]" value="1">
                            </div>
                            <div class="col-6 d-flex justify-content-between">
                                <button type="button" class="btn btn-link btn-sm rounded-pill btn-quantity-detail btn-dec"><i class="bi bi-dash-circle fs-5 fw-bold"></i></button>
                                <input class="form-control-plaintext form-control-lg export_detail-quantity text-center" name="quantities[]" type="text" value="1" onclick="this.select()">
                                <button type="button" class="btn btn-link btn-sm rounded-pill btn-quantity-detail btn-inc"><i class="bi bi-plus-circle fs-5 fw-bold"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="text" name="notes[]" class="form-control form-control-lg form-control-plaintext export_detail-note" placeholder="Ghi chú món hàng"/>
                    </div>
                </div>
                <div class="dropstart btn-group position-absolute top-0 end-0">
                    <button class="btn btn-link mb-0 px-2 py-1" data-bs-toggle="dropdown" type="button" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu shadow-lg p-2" style="z-index: 9999">
                        <hr class="dropdown-divider d-none" />
                        <li>
                            <input type="hidden" class="export_detail-id" name="ids[]" value="">
                            <a class="dropdown-item btn btn-remove-detail remove-card">
                                Xóa khỏi đơn xuất
                            </a>
                        </li>
                    </ul>
                </div>
            </div>`)
        }

        $(document).on('click', '.btn-update-export', function() {
            const id = $(this).attr('data-id')
            $.get(` {{ route('admin.export') }}/${id}`, function(obj) {
                const form = $('#export-form');
                resetForm(form)
                form.find('.btn.btn-submit-export').removeClass('is-invalid')
                $('#export-form').attr('action', `{{ route('admin.export.update') }}`)
                form.find(`[name='id']`).val(obj.id)
                form.find(`[name='note']`).val(obj.note)
                form.find(`[name='date']`).val(obj.date)
                form.find(`[name='status'][value=${obj.status}]`).prop('checked', true)
                if (obj.receiver_id != null) {
                    var receiver = new Option(obj._receiver.name, obj._receiver.id, true, true);
                    form.find('[name=receiver_id]').html(receiver).trigger({
                        type: 'select2:select'
                    });
                }
                if (obj.to_warehouse_id != null) {
                    var to_warehouse = new Option(obj._to_warehouse.name, obj.to_warehouse_id, true, true);
                    form.find('[name=to_warehouse_id]').html(to_warehouse).trigger({
                        type: 'select2:select'
                    });
                }
                $.each(obj.export_details, function(index, export_detail) {
                    export_detail.totalExportQuantity = obj.export_details.reduce((sum, item) => {
                        if (export_detail.stock_id == item.stock_id) {
                            return sum += item.quantity * item._unit.rate;
                        } else {
                            return sum;
                        }
                    }, 0)
                })

                $('.export-details').empty()
                obj.export_details.forEach(export_detail => {
                    let str = htmlExportDetail(export_detail)
                    $('.export-details').append(str)
                });
                if (obj.deleted_at != null) {
                    form.find('.btn[type=submit]:last-child').addClass('d-none')
                }
                form.find('.btn-print.print-export').removeClass('d-none').attr('data-id', obj.id)
                form.find('.modal').modal('show').find('.modal-title').text(obj.code)
            })
        })

        function htmlExportDetail(export_detail) {
            return `<div class="card border shadow-none mb-2 p-3 detail export-detail">
                <div class="row">
                    <div class="col 12 col-lg-9">
                        <p class="card-title mb-0">
                            ${export_detail._stock.import_detail._variable._product.name + (export_detail._stock.import_detail._variable.name != null ? ' - ' + export_detail._stock.import_detail._variable.name : '') + ' - ' + export_detail._unit.term}
                            <input type="hidden" class="export_detail-stock_id" name="stock_ids[]" value="${export_detail.stock_id}"/>
                            <a class="btn btn-link btn-export_detail-product_info rounded-pill p-0" data-id="${export_detail.stock_id}" type="button">
                                <i class="bi bi-info-circle"></i>
                            </a>
                        </p>
                        <div class="badge bg-light-info">${export_detail._stock.import_detail._variable._product.sku}</div>
                        ${export_detail.expired == null || export_detail.expired == '' ? '' : `<div class="badge bg-light-info">HSD ${moment(export_detail.expired).format('DD/MM/YYYY')}</div>`}
                        <div class="badge bg-light-info">
                            Tồn kho ${export_detail._stock.convertQuantity}
                            <input type="hidden" class="export_detail-stock_quantity" name="stock_quantities[]" value="${export_detail._stock.quantity + export_detail.totalExportQuantity}"/>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="row">
                            <div class="col-6">
                                <select name="unit_ids[]" class="form-control form-control-lg form-control-plaintext bg-transparent export_detail-unit">
                                    ${'<option value="' + export_detail._unit.id + '" data-rate="' + export_detail._unit.rate + '" data-price="' + export_detail._unit.price + '">' + export_detail._unit.term + '</option>'}
                                </select>
                                <input type="hidden" class="export_detail-current_unit_id" name="current_unit_ids[]" value="${export_detail._unit.id}">
                                <input type="hidden" class="export_detail-current-quantity" name="current_quantities[]" value="${export_detail.quantity}">
                            </div>
                            <div class="col-6 d-flex justify-content-between">
                                <button type="button" class="btn btn-link btn-sm rounded-pill btn-quantity-detail btn-dec"><i class="bi bi-dash-circle fs-5 fw-bold"></i></button>
                                <input class="form-control-plaintext form-control-lg export_detail-quantity text-center" name="quantities[]" type="text" value="${number_format(export_detail.quantity)}" onclick="this.select()">
                                <button type="button" class="btn btn-link btn-sm rounded-pill btn-quantity-detail btn-inc"><i class="bi bi-plus-circle fs-5 fw-bold"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="text" name="notes[]" class="form-control form-control-lg form-control-plaintext export_detail-note" placeholder="Ghi chú món hàng" value="${export_detail.note != null ? export_detail.note : ''}"/>
                    </div>
                </div>
                <div class="dropstart btn-group position-absolute top-0 end-0">
                    <button class="btn btn-link mb-0 px-2 py-1" data-bs-toggle="dropdown" type="button" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu shadow-lg p-2" style="z-index: 9999">
                        <li><a class="dropdown-item btn-history-detail_stock" data-variable-id="${export_detail._stock.variable_id}" href="#">Lịch sử bán hàng</a></li>
                        <hr class="dropdown-divider">
                        <li>
                            <input type="hidden" class="export_detail-id" name="ids[]" value="${export_detail.id}">
                            <a class="dropdown-item btn btn-remove-detail remove-card" data-id="${export_detail.id}" data-url="{{ getPath(route('admin.export_detail.remove')) }}">
                                Xóa khỏi đơn xuất
                            </a>
                        </li>
                    </ul>
                </div>
            </div>`;
        }

        $(document).on('change', '[name=export_warehouse]', function() {
            const input = $(this).closest('.modal').find('.search-input')
            input.attr('data-url', '{{ route('admin.stock') }}?key=search&action=export&warehouse_id=' + $(this).val())
            const debouncedFunction = debounce(function() {
                handleSearch(input);
            }, 300);
            debouncedFunction();
        })
        /* =================== END EXPORT =================== */

        /**
         * ORDER PROCESS
         */
        $(document).on('click', '.btn-create-order', function(e) {
            e.preventDefault();
            const form = $('#order-form')
            resetForm(form)
            form.find(`.order-sum`).html(0)
            form.find(`.transaction-sum`).html(0)
            form.find(`.btn-create-transaction`).removeAttr('data-order')
            form.find('.order-details').add('.customer-suggestions').empty()
            form.find('#order-transactions').empty()
            form.find('.card-transactions').add('.card-services').find('.order-services').empty()
            form.find('.btn-print.print-order').addClass('d-none').removeAttr('data-id')
            form.find('[name=customer_id]').empty()
            form.find(`[name='branch_name']`).val($('nav.navbar .user-name small').text())
            form.attr('action', `{{ route('admin.order.create') }}`)
            $('[name=status][value=1]').prop('checked', true)
            $('#order-modal').modal('show').find('.modal-title').text('Đơn hàng mới')
        })

        function addCardToOrder(stock) {
            let tab = $('#order-modal').hasClass('show') ? $('#order-modal') : $('.tab-pane.active'),
                units = stock.productUnits.map((item) => {
                    return `<option value="${item.id}" data-rate="${item.rate}" data-price="${item.price}" ${item.rate == stock.productUnit.rate ? 'selected' : ''}>${item.term}</option>`
                }).join('')
            if (!units.length) {
                units = `<option value="${stock.productUnit.id}" data-rate="${stock.productUnit.rate}" data-price="${stock.productUnit.price}" selected>${stock.productUnit.term}</option>`
            }
            tab.find('.order-details').prepend(`
            <div class="card border shadow-none mb-2 p-3 detail order-detail">
                <div class="row">
                    <div class="col 12 col-lg-7">
                        <p class="card-title mb-0">
                            ${stock.productName}
                            <input type="hidden" class="order_detail-stock_id" name="stock_ids[]" value="${stock.stockId}"/>
                            <a class="btn btn-link btn-order_detail-product_info rounded-pill p-0" data-id="${stock.stockId}" type="button">
                                <i class="bi bi-info-circle"></i>
                            </a>
                        </p>
                        <div class="badge bg-light-info">${stock.productSku}</div>
                        ${stock.stockExpired == null || stock.stockExpired == '' ? '' : `<div class="badge bg-light-info">HSD ${moment(stock.stockExpired).format('DD/MM/YYYY')}</div>`}
                        <div class="badge bg-light-info">
                            Tồn kho ${stock.stockConvertQuantity}
                            <input type="hidden" class="order_detail-stock_quantity" name="stock_quantities[]" value="${stock.stockQuantity}"/>
                        </div>
                    </div>
                    <div class="col-12 col-lg-5">
                        <div class="row">
                            <div class="col-7 col-md-4 d-flex justify-content-between position-relative">
                                <input class="order_detail-price" name="prices[]" type="hidden" value="${stock.productUnit.price}">
                                <span class="position-absolute top-100 start-50 mt-2 translate-middle badge bg-danger d-none"></span>
                                <input class="form-control form-control-plaintext form-control-lg order_detail-discounted_price text-end money" name="discounted_price[]" onclick="this.select()" type="text" value="${stock.productUnit.price}" inputmode="numeric" placeholder="Giá bán">
                                <input class="order_detail-discount" name="discounts[]" type="hidden" value="0">
                                <button type="button" class="btn btn-link rounded-pill btn-price-order_detail"><i class="bi bi-info-circle"></i></button>
                            </div>
                            <div class="col-5 col-md-2">
                                <select name="unit_ids[]" class="form-control form-control-lg form-control-plaintext order_detail-unit_id">${units}</select>
                                <input type="hidden" class="order_detail-current_unit_id" name="current_unit_ids[]" value="${stock.productUnit.id}">
                                <input type="hidden" class="order_detail-current-quantity" name="current_quantities[]" value="1">
                            </div>
                            <div class="col-6 col-md-3 d-flex justify-content-between">
                                <button type="button" class="btn btn-link btn-sm rounded-pill btn-quantity-detail btn-dec"><i class="bi bi-dash-circle fs-5 fw-bold"></i></button>
                                <input class="form-control-plaintext form-control-lg order_detail-quantity text-center" name="quantities[]" type="text" value="1" onclick="this.select()">
                                <button type="button" class="btn btn-link btn-sm rounded-pill btn-quantity-detail btn-inc"><i class="bi bi-plus-circle fs-5 fw-bold"></i></button>
                            </div>
                            <div class="col-6 col-md-3">
                                <input class="form-control-plaintext form-control-lg order_detail-total text-end money" type="text" value="${stock.productUnit.price}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <p class="card-text fw-bold fs-5 text-end"></p>
                        <input type="hidden" name="notes[]" class="order_detail-note"/>
                    </div>
                </div>
                <div class="dropstart btn-group position-absolute top-0 end-0">
                    <button class="btn btn-link mb-0 px-2 py-1" data-bs-toggle="dropdown" type="button" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu shadow-lg p-2" style="z-index: 9999">
                        <li><a class="dropdown-item btn-history-detail_stock" data-variable-id="${stock.variableId}" href="#">Lịch sử bán hàng</a></li>
                        <li><a class="dropdown-item btn-note-detail_stock" data-variable-id="${stock.variableId}" href="#">Ghi chú món hàng</a></li>
                        <hr class="dropdown-divider" />
                        <li>
                            <input type="hidden" class="order_detail-id" name="ids[]">
                            <input type="hidden" class="order_detail-export_id" name="export_ids[]">
                            <a class="dropdown-item btn btn-remove-detail remove-card">
                                Xóa khỏi đơn hàng
                            </a>
                        </li>
                    </ul>
                </div>
            </div>`)
            totalOrder()
        }

        $(document).on('click', '.btn-quantity-detail', function() {
            const card = $(this).closest('.detail'),
                quantity = parseInt(card.find(`[name='quantities[]']`).val().split(',').join(''))
            if ($(this).hasClass('btn-dec')) {
                if (quantity > 1) {
                    card.find(`[name='quantities[]']`).val(quantity - 1).change()
                } else {
                    card.find(`[name='quantities[]']`).val(1).change()
                }
            } else {
                card.find(`[name='quantities[]']`).val(quantity + 1).change()
            }
            $(this).closest('.order-receipt').length ? totalOrder() : null
        })

        $(document).on('click', '.btn-update-order', function() {
            const id = $(this).attr('data-id')
            $.get(` {{ route('admin.order') }}/${id}`, function(obj) {
                const form = $('#order-form');
                resetForm(form)
                form.find('.order-details').add('.customer-suggestions').empty()
                form.find('.card-services').removeClass('d-none')
                $('#order-form').attr('action', `{{ route('admin.order.update') }}`)
                form.find(`[name='id']`).val(obj.id)
                form.find(`[name='note']`).val(obj.note)
                form.find(`[name='discount']`).val(obj.discount)
                form.find(`[name='branch_name']`).val(obj._branch.name)
                form.find(`[name='created_at']`).val(moment(obj.created_at).format('YYYY-MM-DD HH:MM'))
                form.find('.card-transactions').add('.btn-print.print-order').removeClass('d-none').attr('data-id', obj.id)
                form.find(`.btn-create-transaction`).attr('data-order', obj.id)
                form.find(`.btn-create-info`)
                    .attr('data-order_id', obj.id)
                    .attr('data-customer_id', obj.customer_id)
                    .attr(`href`, `{{ route('admin.info', ['key' => 'new']) }}?order_id=${obj.id}`)
                form.find(`[name='status'][value=${obj.status}]`).prop('checked', true)
                showTransactions(obj.id)
                if (obj.customer_id != null) {
                    var option = new Option(obj._customer.name, obj._customer.id, true, true);
                    form.find('[name=customer_id]').html(option).trigger({
                        type: 'select2:select'
                    }).change();
                } else {
                    form.find('[name=customer_id]').empty()
                }
                $.each(obj.details, function(index, detail) {
                    if (detail.stock_id != null) {
                        detail.totalSaleQuantity = obj.details.reduce((sum, item) => {
                            if (detail.stock_id == item.stock_id) {
                                return sum + item.quantity * item._unit.rate;
                            } else {
                                return sum
                            }
                        }, 0)
                    }
                })
                $('.order-services').empty()
                obj.details.forEach(detail => {
                    if (detail.stock_id != null) {
                        let str = htmlOrderDetail(detail)
                        form.find('.order-details').append(str)
                    } else {
                        let str = htmlOrderService(detail)
                        form.find('.card-services').find('.order-services').append(str)
                    }
                });
                if (obj.deleted_at != null) {
                    form.find('.btn[type=submit]:last-child').addClass('d-none')
                }
                totalOrder()
                form.find('.modal').modal('show').find('.modal-title').text('Đơn hàng ' + obj.code)
            })
        })

        function htmlOrderDetail(detail) {
            let className, number, discountedPrice
            if (detail.discount == null || detail.discount == 0) {
                className = 'd-none bg-danger'
                number = 0
                discountedPrice = detail.price
            } else {
                if (detail.discount > 0) {
                    className = 'bg-danger'
                    if (detail.discount > 100) {
                        number = '-' + Math.abs(detail.discount)
                        discountedPrice = detail.price - detail.discount
                    } else {
                        number = '-' + detail.discount + '%'
                        discountedPrice = detail.price - detail.discount * detail.price / 100
                    }
                } else {
                    className = 'bg-success'
                    number = '+' + Math.abs(detail.discount)
                    discountedPrice = detail.price - detail.discount
                }
            }
            return `
            <div class="card border shadow-none mb-2 p-3 detail order-detail">
                <div class="row">
                    <div class="col 12 col-lg-7">
                        <p class="card-title mb-0">
                            ${detail._stock.import_detail._variable._product.name}${(detail._stock.import_detail._variable.name) ? ' - ' + detail._stock.import_detail._variable.name : ''}
                            <input type="hidden" class="order_detail-stock_id" name="stock_ids[]" value="${detail._stock.id}"/>
                            <!-- <a class="btn btn-link btn-order_detail-product_info rounded-pill p-0" data-id="${detail._stock.id}" type="button">
                                <i class="bi bi-info-circle"></i>
                            </a> -->
                        </p>
                        <div class="badge bg-light-info">${detail._stock.import_detail._variable._product.sku}</div>
                        ${detail._stock.expired != null ? '<div class="badge bg-light-info">HSD ' + moment(detail._stock.expired).format('DD/MM/YYYY') + '</div>' : ''}
                        <div class="badge bg-light-info">
                            Tồn kho ${detail._stock.quantity}
                            <input type="hidden" class="order_detail-stock_quantity" name="stock_quantities[]" value="${parseInt(detail.totalSaleQuantity) + parseInt(detail._stock.quantity)}"/>
                        </div>
                    </div>
                    <div class="col-12 col-lg-5">
                        <div class="row">
                            <div class="col-7 col-md-4 d-flex justify-content-between position-relative">
                                <input class="order_detail-price" name="prices[]" type="hidden" value="${detail.price}">
                                <span class="position-absolute top-100 start-50 mt-2 translate-middle badge ${className}">${number}</span>
                                <input class="form-control form-control-plaintext form-control-lg order_detail-discounted_price text-end money" name="discounted_price[]" onclick="this.select()" type="text" value="${discountedPrice}" inputmode="numeric" placeholder="Giá bán">
                                <input class="order_detail-discount" name="discounts[]" type="hidden" value="${detail.discount}">
                                <button type="button" class="btn btn-link rounded-pill btn-price-order_detail"><i class="bi bi-info-circle"></i></button>
                            </div>
                            <div class="col-5 col-md-2">
                                <select name="unit_ids[]" class="form-control form-control-lg form-control-plaintext order_detail-unit_id">
                                    <option value="${detail._unit.id}" data-rate="${detail._unit.rate}" data-price="${detail._unit.price}" selected>${detail._unit.term}</option>
                                </select>
                                <input type="hidden" class="order_detail-current_unit_id" name="current_unit_ids[]" value="${detail._unit.id}">
                                <input type="hidden" class="order_detail-current-quantity" name="current_quantities[]" value="${detail.quantity}">
                            </div>
                            <div class="col-6 col-md-3 d-flex justify-content-between">
                                <button type="button" class="btn btn-link btn-sm rounded-pill btn-quantity-detail btn-dec"><i class="bi bi-dash-circle fs-5 fw-bold"></i></button>
                                <input class="form-control-plaintext form-control-lg order_detail-quantity text-center" name="quantities[]" type="text" value="${number_format(detail.quantity)}" onclick="this.select()">
                                <button type="button" class="btn btn-link btn-sm rounded-pill btn-quantity-detail btn-inc"><i class="bi bi-plus-circle fs-5 fw-bold"></i></button>
                            </div>
                            <div class="col-6 col-md-3">
                                <input class="form-control-plaintext form-control-lg order_detail-total text-end money" type="text" value="" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <p class="card-text fw-bold fs-5 text-end"></p>
                        <input type="hidden" name="notes[]" class="order_detail-note"/>
                    </div>
                </div>
                <div class="dropstart btn-group position-absolute top-0 end-0">
                    <button class="btn btn-link mb-0 px-2 py-1" data-bs-toggle="dropdown" type="button" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu shadow-lg p-2" style="z-index: 9999">
                        <li><a class="dropdown-item btn-history-detail_stock" data-variable-id="${stock.variableId}" href="#">Lịch sử bán hàng</a></li>
                        <li><a class="dropdown-item btn-note-detail_stock" data-variable-id="${stock.variableId}" href="#">Ghi chú món hàng</a></li>
                        <hr class="dropdown-divider" />
                        <li>
                            <input type="hidden" class="order_detail-id" name="ids[]" value="${detail.id}">
                            <input type="hidden" class="order_detail-export_id" name="export_ids[]" value="${detail.export_detail != null ? detail.export_detail.export_id : ''}">
                            <a class="dropdown-item btn btn-remove-detail remove-card" data-id="${detail.id}" data-url="{{ getPath(route('admin.detail.remove')) }}">
                                Xóa khỏi đơn hàng
                            </a>
                        </li>
                    </ul>
                </div>
            </div>`
        }

        function htmlOrderService(detail) {
            const info_str = detail._info ? `
                    <div class="badge bg-light-info">${detail._info._doctor ? 'BS khám ' + detail._info._doctor.name : ''}</div>
                    <div class="badge bg-light-info">${detail._info._pet ? 'Thú cưng ' + detail._info._pet.name : ''}</div>
                    <div class="badge bg-light-info">${detail._info.code}</div>` : '',
                quicktest_str = detail.quicktest ? `
                    <div class="badge bg-light-info">${detail.quicktest._technician ? '<div class="badge bg-light-info">KTV: ' + detail.quicktest._technician.name + '</div>' : ''}</div>
                    <div class="badge bg-light-info">${detail.quicktest.statusStr}</div>
                    <div class="badge bg-light-info">${detail.quicktest.code}</div>` : '',
                microscope_str = detail.microscope ? `
                    <div class="badge bg-light-info">${detail.microscope._technician ? '<div class="badge bg-light-info">KTV: ' + detail.microscope._technician.name + '</div>' : ''}</div>
                    <div class="badge bg-light-info">${detail.microscope.statusStr}</div>
                    <div class="badge bg-light-info">${detail.microscope.code}</div>` : '',
                bloodcell_str = detail.bloodcell ? `
                    <div class="badge bg-light-info">${detail.bloodcell._technician ? '<div class="badge bg-light-info">KTV: ' + detail.bloodcell._technician.name + '</div>' : ''}</div>
                    <div class="badge bg-light-info">${detail.bloodcell.statusStr}</div>
                    <div class="badge bg-light-info">${detail.bloodcell.code}</div>` : '',
                biochemical_str = detail.biochemical ? `
                    <div class="badge bg-light-info">${detail.biochemical._technician ? '<div class="badge bg-light-info">KTV: ' + detail.biochemical._technician.name + '</div>' : ''}</div>
                    <div class="badge bg-light-info">${detail.biochemical.statusStr}</div>
                    <div class="badge bg-light-info">${detail.biochemical.code}</div>` : '',
                ultrasound_str = detail.ultrasound ? `
                    <div class="badge bg-light-info">${detail.ultrasound._technician ? '<div class="badge bg-light-info">KTV: ' + detail.ultrasound._technician.name + '</div>' : ''}</div>
                    <div class="badge bg-light-info">${detail.ultrasound.statusStr}</div>
                    <div class="badge bg-light-info">${detail.ultrasound.code}</div>` : '',
                xray_str = detail.xray ? `
                    <div class="badge bg-light-info">${detail.xray._technician ? '<div class="badge bg-light-info">KTV: ' + detail.xray._technician.name + '</div>' : ''}</div>
                    <div class="badge bg-light-info">${detail.xray.statusStr}</div>
                    <div class="badge bg-light-info">${detail.xray.code}</div>` : '',
                surgery_str = detail.surgery ? `
                    <div class="badge bg-light-info">${detail.surgery._surgeon ? '<div class="badge bg-light-info">BS: ' + detail.surgery._surgeon.name + '</div>' : ''}</div>
                    <div class="badge bg-light-info">${detail.surgery.statusStr}</div>
                    <div class="badge bg-light-info">${detail.surgery.code}</div>` : '',
                prescription_str = detail.prescription ? `
                    <div class="badge bg-light-info">${detail.prescription._pharmacist ? '<div class="badge bg-light-info">DS: ' + detail.prescription._pharmacist.name + '</div>' : ''}</div>
                    <div class="badge bg-light-info">${detail.prescription.statusStr}</div>
                    <div class="badge bg-light-info">${detail.prescription.code}</div>` : '',
                beauty_str = detail.beauty ? `
                    <div class="badge bg-light-info">${detail.beauty._technician ? '<div class="badge bg-light-info">KTV: ' + detail.beauty._technician.name + '</div>' : ''}</div>
                    <div class="badge bg-light-info">${detail.beauty.statusStr}</div>
                    <div class="badge bg-light-info">${detail.beauty.code}</div>` : '',
                accommodation_str = detail.accommodation ? `
                    <div class="badge bg-light-info">${detail.accommodation._assistant ? '<div class="badge bg-light-info">NV: ' + detail.accommodation._assistant.name + '</div>' : ''}</div>
                    <div class="badge bg-light-info">${detail.accommodation.statusStr}</div>
                    <div class="badge bg-light-info">${detail.accommodation.code}</div>` : '',
                info = detail._info ? detail._info : null,
                accommodation = detail.accommodation ? detail.accommodation : null
            let className, number, discountedPrice
            if (detail.discount == null || detail.discount == 0) {
                className = 'd-none bg-danger'
                number = 0
                discountedPrice = detail.price
            } else {
                if (detail.discount > 0) {
                    className = 'bg-danger'
                    if (detail.discount > 100) {
                        number = '-' + Math.abs(detail.discount)
                        discountedPrice = detail.price - detail.discount
                    } else {
                        number = '-' + detail.discount + '%'
                        discountedPrice = detail.price - detail.discount * detail.price / 100
                    }
                } else {
                    className = 'bg-success'
                    number = '+' + Math.abs(detail.discount)
                    discountedPrice = detail.price - detail.discount
                }
            }

            return `
        <div class="card border shadow-none mb-2 p-3 detail service order-detail">
            <div class="row">
                <div class="col 12 col-lg-7">
                    <p class="card-title mb-0">
                        ${detail._service.name}
                        <input class="order_detail-service_id" name="service_ids[]" type="hidden" value="${detail.service_id}" />
                        <input name="service_tickets[]" type="hidden" value="${info_str != '' ? 'info' : accommodation_str != '' ? 'accommodation' : ''}">
                        <!-- <a class="btn btn-link btn-order_detail-service_info rounded-pill p-0" data-id="${detail.service_id}" type="button">
                            <i class="bi bi-info-circle"></i>
                        </a> -->
                    </p>
                    ${info_str}
                    ${quicktest_str}
                    ${microscope_str}
                    ${bloodcell_str}
                    ${biochemical_str}
                    ${ultrasound_str}
                    ${xray_str}
                    ${surgery_str}
                    ${prescription_str}
                    ${beauty_str}
                    ${accommodation_str}
                </div>
                <div class="col-12 col-lg-5">
                    <div class="row">
                        <div class="col-7 col-lg-4 d-flex justify-content-between position-relative">
                            <input class="order_detail-price" name="prices[]" type="hidden" value="${detail.price}">
                            <span class="position-absolute top-100 start-50 mt-2 translate-middle badge ${className}">${number}</span>
                            <input class="form-control form-control-plaintext form-control-lg order_detail-discounted_price text-end money" name="discounted_price[]" type="text" value="${discountedPrice}"
                                onclick="this.select()" inputmode="numeric" placeholder="Giá dịch vụ">
                            <input class="order_detail-discount" name="discounts[]" type="hidden" value="${detail.discount}">
                            <button class="btn btn-link rounded-pill btn-price-order_detail" type="button"><i class="bi bi-info-circle"></i></button>
                        </div>
                        <div class="col-5 col-lg-2 d-flex align-items-center">
                            <span class="card-title mb-0">${detail._service.unit ? detail._service.unit : 'ĐVT'}</span>
                        </div>
                        <div class="col-6 col-lg-3 d-flex justify-content-between">
                            ${detail._service.ticket !== null ? `<input class="form-control form-control-plaintext form-control-lg text-center order_detail-quantity text-end bg-transparent" name="quantities[]" type="text" value="${detail.quantity}" readonly>`
                                        :`<button type="button" class="btn btn-link btn-sm rounded-pill btn-quantity-detail btn-dec"><i class="bi bi-dash-circle fs-5 fw-bold"></i></button>
                                            <input class="form-control form-control-plaintext form-control-lg text-center order_detail-quantity text-end bg-transparent" name="quantities[]" type="text" value="${detail.quantity}">
                                        <button type="button" class="btn btn-link btn-sm rounded-pill btn-quantity-detail btn-inc"><i class="bi bi-plus-circle fs-5 fw-bold"></i></button>`
                            }
                        </div>
                        <div class="col-6 col-lg-3">
                            <input class="form-control-plaintext form-control-lg order_detail-total text-end money" type="text" value="${detail._service.price}" readonly>
                            <input class="order_detail-id" name="ids[]" type="hidden" value="${detail.id}">
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <p class="card-text fw-bold fs-5 text-end"></p>
                    <input type="${detail.note != 'null' && detail.note != null ? 'text' : 'hidden'}" name="notes[]" class="form-control form-control-plaintext bg-transparent order_detail-note" value="${detail.note ?? ''}" readonly/>
                </div>
            </div>
            <div class="dropstart btn-group position-absolute top-0 end-0">
                <button class="btn btn-link mb-0 px-2 py-1" data-bs-toggle="dropdown" type="button" aria-expanded="false">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu shadow-lg p-2" style="z-index: 9999">
                    ${ info && {{ Auth::user()->can(App\Models\User::READ_INFO) }} ? `<li><a class="dropdown-item btn-update-info" data-info_id="${info.id}" href="{{ route('admin.info') }}/${info.id}">Xem phiếu</a></li>
                                                                                                                <li>
                                                                                                                    <a class="dropdown-item btn-print print-info" data-id="${info.id}" data-url="{{ getPath(route('admin.info')) }}">In phiếu</a>
                                                                                                                </li>` : ''}
                    ${ accommodation && {{ Auth::user()->can(App\Models\User::READ_ACCOMMODATION) }} ? `<li><a class="dropdown-item btn btn-update-accommodation" data-id="${accommodation.id}">Xem phiếu</a></li>
                                                                                                                <li>
                                                                                                                    <a class="dropdown-item btn btn-print print-accommodation" data-id="${accommodation.id}" data-url="{{ getPath(route('admin.accommodation')) }}">In phiếu</a>
                                                                                                                </li>` : ''}

                    <li><a class="dropdown-item btn-note-detail_stock" href="#">Ghi chú dịch vụ</a></li>
                    <li>
                        <a class="dropdown-item btn btn-remove-detail remove-card" data-id="${detail.id}" data-url="{{ getPath(route('admin.detail.remove')) }}">
                            Xóa khỏi đơn hàng
                        </a>
                    </li>
                </ul>
            </div>
        </div>`
        }

        $(document).on('click', '.btn-note-detail_stock', function(event) {
            event.preventDefault();
            var card = $(this).closest('.order-detail, .order-services');

            Swal.fire({
                title: 'Ghi chú món hàng',
                input: 'textarea',
                inputLabel: 'Nhập ghi chú',
                inputValue: card.find('.order_detail-note').val(),
                inputPlaceholder: 'Nhập ghi chú ở đây...',
                inputAttributes: {
                    'aria-label': 'Nhập ghi chú ở đây'
                },
                showCancelButton: true,
                confirmButtonText: 'Lưu',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    var note = result.value;
                    card.find('.order_detail-note').val(note).prev().text('Ghi chú: ' + note);
                }
            });
        });

        $(document).on('click', '.btn-price-order_detail', function() {
            const inputPrice = $(this).parent().find(`[name='prices[]']`),
                inputDiscount = $(this).parent().find(`[name='discounts[]']`),
                inputDiscountedPrice = $(this).parent().find(`[name='discounted_price[]']`),
                badge = $(this).parent().find('.badge')

            Swal.fire({
                title: 'Giảm giá hàng hóa',
                html: `
            <input id="order_detail-amount" class="form-control form-control-lg mb-3 text-end" onclick="this.select()" placeholder="Nhập số tiền hoặc phần trăm">`,
                showCancelButton: true,
                confirmButtonText: 'Lưu',
                cancelButtonText: 'Hủy',
                focusConfirm: false,
                didOpen: () => {
                    detailAmount = Swal.getPopup().querySelector('#order_detail-amount');
                    detailAmount.value = inputDiscount.val()
                    detailAmount.select();
                    detailAmount.addEventListener('input', function() {
                        $(this).val($(this).val().replace(/(?!^-)[^0-9]/g, ''));
                    });
                    detailAmount.addEventListener('keyup', (event) => event.key === 'Enter' && Swal.clickConfirm());
                },
                preConfirm: () => {
                    const amount = parseInt(detailAmount.value)
                    // Kiểm tra xem cả hai trường đều được nhập và trường số tiền chỉ chứa giá trị số
                    if (!amount || isNaN(parseFloat(amount)) || amount < 0) {
                        Swal.showValidationMessage(`Dữ liệu không hợp lệ!`);
                    } else {
                        let d = 0,
                            price = parseInt(inputPrice.val())
                        if (amount != 0) {
                            if (amount != 0 && amount <= 100) {
                                d = price - amount / 100 * price
                                inputDiscount.val(amount)
                                badge.text(`-${number_format(amount)}%`).removeClass('d-none')
                            } else {
                                d = price - amount
                                inputDiscount.val(amount)
                                badge.text(`-${number_format(amount)}`).removeClass('d-none')
                            }
                            inputDiscountedPrice.val(d)
                        } else {
                            inputDiscountedPrice.val(price)
                            inputDiscount.val(d)
                            badge.text('').addClass('d-none')
                        }
                    }
                    totalOrder()
                }
            });
        })

        $(document).on('change', '.order-discount', function() {
            totalOrder()
        })

        $(document).on('change', `[name='discounted_price[]']`, function() {
            let badge = $(this).parent().find('.badge'),
                inputDiscount = $(this).parent().find(`[name='discounts[]']`),
                discountedPrice = parseInt($(this).val().split(',').join('')),
                originalPrice = parseInt($(this).parent().find(`[name='prices[]']`).val().split(',').join(''))
            inputDiscount.val(originalPrice - discountedPrice)
            if (originalPrice > discountedPrice) {
                badge.removeClass('bg-success').addClass('bg-danger').text(`-${number_format(originalPrice - discountedPrice)}`).removeClass('d-none')
            } else if (originalPrice < discountedPrice) {
                badge.removeClass('bg-danger').addClass('bg-success').text(`+${number_format(discountedPrice - originalPrice)}`).removeClass('d-none')
            } else {
                badge.removeClass('bg-success').addClass('bg-danger').empty().addClass('d-none')
            }
            totalOrder()
        })

        $(document).on('change', `.detail [name='quantities[]'], .detail [name='unit_ids[]']`, function() {
            const card = $(this).closest('.detail'),
                thisUnit = card.find(`[name='unit_ids[]']`).val(),
                thisStock = card.find(`[name='stock_ids[]']`).val(),
                currentUnit = card.find(`[name='current_unit_ids[]']`).val(),
                countCheck = $(this).closest('form').find('.detail').filter(function() {
                    var loopUnit = $(this).find(`[name='unit_ids[]']`).val(),
                        loopStock = $(this).find(`[name='stock_ids[]']`).val();
                    return loopUnit == thisUnit && loopStock == thisStock;
                }).length
            if (countCheck > 1 && !card.hasClass('service')) {
                pushToastify("Đã có đơn vị tính này trong hàng khác của đơn hàng", 'danger')
                card.find(`[name='unit_ids[]']`).val(currentUnit)
            } else if (!validateQuantity(card)) {
                pushToastify("Gói tồn kho không đủ hàng, vui lòng chọn gói khác bổ sung.", 'danger')
                $('#export-form .btn-submit-export').addClass('is-invalid')
            } else {
                card.closest('.order-receipt').length ? totalOrder() : null
            }
        })

        function validateQuantity(card) {
            if (!card.hasClass('service')) {
                const tab = card.closest('form'),
                    stockQuantity = parseInt(card.find(`[name='stock_quantities[]']`).val().split(',').join('')),
                    stockId = card.find(`[name='stock_ids[]']`),
                    currentUnit = card.find(`[name='current_unit_ids[]']`),
                    currentQuantity = card.find(`[name='current_quantities[]']`),
                    newUnit = card.find(`[name='unit_ids[]']`),
                    newQuantity = card.find(`[name='quantities[]']`),
                    unit_price = card.find(`[name='unit_ids[]'] option:selected`).attr('data-price'),
                    totalQuantity = tab.find(`[name='stock_ids[]'][value=${parseInt(stockId.val())}]`).map(function() {
                        var rate = parseFloat($(this).closest('.detail').find(`[name='unit_ids[]'] option:selected`).attr('data-rate')) || 0;
                        var quantity = parseFloat($(this).closest('.detail').find(`[name='quantities[]']`).val()) || 0;
                        return rate * quantity;
                    }).get().reduce(function(total, value) {
                        return total + value;
                    }, 0);
                if (stockQuantity < totalQuantity) {
                    newQuantity.val(parseInt(currentQuantity.val()))
                    newUnit.val(parseInt(currentUnit.val()))
                    return false;
                } else {
                    currentQuantity.val(parseInt(newQuantity.val()))
                    currentUnit.val(parseInt(newUnit.val()))
                    if (tab.hasClass('order-receipt')) {
                        card.find(`[name='prices[]']`).val(unit_price).change()
                        card.find(`[name='discounted_price[]']`).val(unit_price).change()
                    }
                    return true;
                }
            } else {
                return true;
            }
        }

        function totalOrder() {
            let tab = '{{ Request::path() }}' == 'quantri/order/new' ? $('.tab-pane.active') : $('#order-form'),
                summary = 0,
                total = 0,
                pay = $('.order-amount').map(function() {
                    return parseFloat($(this).val().split(',').join('')) || 0;
                }).get().reduce(function(sum, value) {
                    return sum + value;
                }, 0),
                count = 0,
                discount = 0
            tab.find('.order-detail').each(function() {
                const quantity = parseInt($(this).find(`.order_detail-quantity`).val().split(',').join('')),
                    price = parseInt($(this).find(`.order_detail-discounted_price`).val().split(',').join(''))
                let sum = quantity * price
                $(this).find('.order_detail-total').val(sum)
                total += sum
                count += parseInt($(this).find(`.order_detail-quantity`).val().split(',').join(''))
            })
            tab.find('.order-count').text(count)
            tab.find('.order-total').val(total)

            const discountInput = tab.find('.order-discount'),
                d = parseInt(discountInput.val().split(',').join(''))
            if (!isNaN(d) && d != 0) {
                if (d <= 100) {
                    discount = d / 100 * total
                    discountInput.parent().prev().html('Giảm giá<br/>phần trăm')
                } else {
                    discount = d
                    discountInput.parent().prev().html('Giảm giá<br/>tiền mặt')
                }
            }

            summary = total - discount
            tab.find('.order-summary').val(summary).change()
            tab.find('.order-due').val(summary - pay).change()
        }

        $(document).on('click', '.btn-print', function() {
            const id = $(this).attr('data-id'),
                url = $(this).attr('data-url'),
                template = $(this).attr('data-template')

            $.get(`${url}/${id}/print?template=${template}`, function(template) {
                $('#print-wrapper').html(template)
                $('#print-wrapper').find('.barcode-value').each(function() {
                    JsBarcode('#' + $(this).prev().attr('id'), $(this).val(), {
                        format: "CODE128",
                        lineColor: "#000000",
                        fontSize: 32,
                        width: 3,
                        height: 75,
                        margin: 2,
                        textPosition: "bottom",
                        flat: true,
                        displayValue: false
                    });
                })
                printJS({
                    printable: 'print-container',
                    type: 'html',
                    css: [`{{ asset('admin/css/bootstrap.css') }}`, `{{ asset('admin/css/key.css') }}?v={{ $version_name }}`],
                    targetStyles: ['*'],
                    showModal: false,
                });
            })
        })

        /**
         * Xử lý thời gian thực
         */
        $(document).on('change', 'form', function() {
            const id = $(this).find('[name=id]').val()
            if (!id) {
                $(this).find('[name=created_at]').val(moment().format('YYYY-MM-DD HH:mm'));
            }
        })

        /**
         * Xử lý khách hàng
         */
        $(document).on('change', '[name=customer_id]', function() {
            fillCustomerSuggestions($(this).val())
        })
        /*==================== END ORDER ====================*/

        /**
         *  TRANSACTION PROCESS
         */
        $(document).on('click', '.btn-create-transaction', function(e) {
            e.preventDefault();
            const form = $('#transaction-form'),
                order_id = $(this).attr('data-order'),
                customer_id = $(this).attr('data-customer'),
                amount = $(this).attr('data-amount')
            let note = ''
            resetForm(form)
            if (order_id) {
                $.get(`{{ route('admin.order') }}/${order_id}`).then(function(order) {
                    if (order) {
                        if (order._customer) {
                            var option = new Option(order._customer.name, order._customer.id, true, true);
                            form.find('[name=customer_id]').html(option).trigger({
                                type: 'select2:select'
                            });
                        }
                        if (order.total < order.paid) {
                            form.find('[name=status][value=refund]').prop('checked', true)
                            note += 'Hoàn tiền'
                        } else {
                            form.find('[name=status][value=pay]').prop('checked', true)
                            note += 'Thanh toán'
                        }
                        form.find('.modal-title').text('Thêm giao dịch')
                        form.find('[name=amount]').val(Math.abs(order.total - order.paid))
                        form.find(`[name='order_id']`).val(order_id)
                        form.find('[name=status]').closest('.form-group').removeClass('d-none')
                        form.find('[name=note]').val(note + ' đơn hàng ' + order_id)
                    } else {
                        pushToastify('Không tìm thấy đơn hàng', 'danger')
                    }
                });
            } else {
                if (customer_id) {
                    $.get(`{{ route('admin.user') }}/${customer_id}`, function(customer) {
                        var option = new Option(customer.name, customer.id, true, true);
                        form.find('[name=customer_id]').html(option).trigger({
                            type: 'select2:select'
                        });
                    })
                }
                if (amount) {
                    form.find('[name=amount]').val(amount)
                }
                form.find('[name=status][value=pay]').prop('checked', true).closest('.form-group').addClass('d-none')
                form.find('[name=note]').val('Thanh toán công nợ')
            }
            form.find('.btn-print.print-transaction').addClass('d-none').removeAttr('data-id')
            form.find('.send-zns-btns').empty()
            form.find('[name=cashier_id]').val(`{{ Auth::id() }}`)
            form.attr('action', `{{ route('admin.transaction.create') }}`)
            form.find('.modal').modal('show').find('.modal-title').text('Giao dịch mới')
        })

    $(document).on('click', '.btn-update-transaction', function() {
        const id = $(this).attr('data-id'),
            customer_id = $(this).attr('data-customer_id')
        const form = $('#transaction-form');
        resetForm(form)
        form.attr('action', `{{ route('admin.transaction.update') }}`)
        $.get(` {{ route('admin.transaction') }}/${id}`, function(transaction) {
            if (transaction.customer_id != null) {
                var option = new Option(transaction._customer.name, transaction._customer.id, true, true);
                form.find('[name=customer_id]').html(option).trigger({
                    type: 'select2:select'
                });
            }
            form.find(`[name='id']`).val(id);
            form.find('.modal-title').text('Giao dịch ' + transaction.code)
            form.find(`[name='order_id']`).val(transaction.order_id);
            form.find(`[name='cashier_id']`).val(transaction.cashier_id)
            if (transaction.amount < 0) {
                form.find(`[name='amount'][status='refund']`).prop('checked', true)
            } else {
                form.find(`[name='amount'][status='pay']`).prop('checked', true)
            }
            form.find(`[name='amount']`).val(Math.abs(transaction.amount))
            form.find(`[name='note']`).val(transaction.note)
            form.find(`[name='payment']`).val(transaction.payment)
            form.find(`[name='status'][value = '${transaction.amount > 0 ? 1 : 0}']`).prop('checked',
                true)
            form.find('.btn-print.print-transaction').removeClass('d-none').attr('data-id', transaction
                .id)
            if (transaction.deleted_at != null) {
                form.find('.btn[type=submit]:last-child').addClass('d-none')
            }
            form.find('.send-zns-btns').html(transaction.customer_id ?
                `<a class="btn btn-outline-info btn-send-zns send-transaction" data-id="${transaction.id}" data-url="{{ getPath(route('admin.transaction.send_zns')) }}" data-phone="${transaction._customer.phone}">Gửi Zalo KH</a>` : '')
            form.find('.modal').modal('show').find('.modal-title').text('Giao dịch ' + transaction.code)
        })
    })

    $(document).on('click', '.btn-convert-scores', function() {
        const user_scores = $('[name=scores]'),
            original_scores = $('[name=original_scores]'),
            order_discount = $('[name=discount]')
        user_scores.val(original_scores.val())
        order_discount.val(0)
        Swal.fire({
            title: 'Đổi điểm giảm giá',
            html: `
            <input id="convert-scores" class="form-control form-control-lg mb-3 text-end" onclick="this.select()" placeholder="Nhập số điểm cần đổi">`,
            showCancelButton: true,
            confirmButtonText: 'Lưu',
            cancelButtonText: 'Hủy',
            focusConfirm: false,
            didOpen: () => {
                convert_scores = Swal.getPopup().querySelector('#convert-scores');
                convert_scores.value = user_scores.val()
                convert_scores.select();
                convert_scores.addEventListener('input', function() {
                    $(this).val($(this).val().replace(/(?!^-)[^0-9]/g, ''));
                });
                convert_scores.addEventListener('keyup', (event) => event.key === 'Enter' && Swal
                    .clickConfirm());
            },
            preConfirm: () => {
                const scores = parseInt(convert_scores.value)
                // Kiểm tra xem cả hai trường đều được nhập và trường số tiền chỉ chứa giá trị số
                if (scores === "" || isNaN(parseFloat(scores)) || scores < 0) {
                    Swal.showValidationMessage(`Dữ liệu không hợp lệ!`);
                } else if (scores > user_scores.val()) {
                    Swal.showValidationMessage(`Số điểm quy đổi phải ít hơn số điểm hiện có`);
                } else if (parseFloat(scores) % 1000 != 0) {
                    Swal.showValidationMessage(`Số điểm phải chia hết cho 1000`);
                } else {
                    user_scores.val(user_scores.val() - scores)
                    user_scores.prev().find('span').text(number_format(parseInt(original_scores
                        .val()) - scores))
                    order_discount.val(scores)
                }
                totalOrder()
            }
        });
    })

    function fillCustomerSuggestions(id) {
        if (!id) return;
        $.get(`{{ route('admin.user') }}/${id}/suggestions`, function(suggest) {
            let str = `<span class="badge bg-secondary me-2 mb-2">Tài khoản từ ${moment(suggest.created_at).format('DD/MM/YYYY')}</span>`
            if (suggest.countOrders) {
                str += `<span class="badge bg-secondary me-2 mb-2">Đã mua hàng <span class="text-white fw-bold fs-5">${number_format(suggest.countOrders)}</span> lần</span>`
                if (suggest.countPayments) {
                    str += `<span class="badge bg-secondary me-2 mb-2">Số lượt thanh toán trung bình trên mỗi đơn hàng là <span class="text-white fw-bold fs-5">${number_format(suggest.countPayments)} lần</span></span>`
                }
            } else {
                str += `<span class="badge bg-secondary me-2 mb-2">Chưa mua hàng lần nào</span>`
            }
            if (suggest.scores) {
                if (suggest.scores > 1000) {
                    str += `<span class="badge bg-success btn-convert-scores cursor-pointer me-2 mb-2">Đang có <span class="text-white fw-bold fs-5">${number_format(suggest.scores)}</span> điểm</span>
                    <input type="hidden" name="scores" value="${suggest.scores}"><input type="hidden" name="original_scores" value="${suggest.scores}">`
                } else {
                    str += `<span class="badge bg-secondary me-2 mb-2">Đang có <span class="text-white fw-bold fs-5">${number_format(suggest.scores)}</span> điểm</span>`
                }
            }
            if (suggest.debt) {
                $format = suggest.debt > 0 ? {
                    'color': 'danger',
                    'sign': '-',
                    'string': 'Đang nợ'
                } : {
                    'color': 'success',
                    'sign': '+',
                    'string': 'Đang có'
                }
                str += `<span class="badge bg-${$format['color']} me-2 mb-2">${$format['string']} <span class="text-white fw-bold fs-5">${$format['sign']}${number_format(Math.abs(suggest.debt))}đ</span></span>`
            }
            if (suggest.averagePaymentDelay) {
                str += `<span class="badge bg-secondary me-2 mb-2">Công nợ trung bình <span class="text-white fw-bold fs-5">${number_format(suggest.averagePaymentDelay)} </span> ngày</span>`
            }
            $('.customer-suggestions').html(str)
            $('.customer-information').val(suggest.name + (suggest.phone ? ' - ' + suggest.phone : ''))
        })
    }

        /**
         * MEDICINE PROCESS
         */
        $(document).on('click', '.btn-create-medicine', function(e) {
            e.preventDefault();
            const form = $('#medicine-form')
            resetForm(form)
            form.find('#medicine-product_id').val(null).trigger('change');;
            form.find('.medicine-variables').empty().parent().addClass('d-none')
            form.find('#dosages').empty()
            form.attr('action', `{{ route('admin.medicine.create') }}`).find('.modal').modal('show')
        })

        $(document).on('click', '.btn-update-medicine', function(e) {
            e.preventDefault();
            const id = $(this).attr('data-id'),
                form = $('#medicine-form');
            resetForm(form)
            form.find('#dosages').empty()
            form.find('.medicine-variables').empty()
            $.get(`{{ route('admin.medicine') }}/${id}`, function(medicine) {
                var option = new Option(medicine._variable._product.sku + ' - ' + medicine._variable._product.name, medicine._variable._product.id, true, true);
                $('select#medicine-product_id').html(option).trigger({
                    type: 'select2:select'
                });
                variables = medicine._variable._product.variables.map((variable) => {
                    const unit = variable.units.find((unit) => {
                        return unit.rate == 1;
                    })
                    return `<option value="${variable.id}" data-unit="${unit.term}" ${variable.id == medicine.variable_id ? 'selected' : ''}>${variable.name}</option>`;
                })
                form.find(`[name=variable_id]`).html(variables).parent().removeClass('d-none')
                form.find(`[name='id']`).val(medicine.id)
                form.find(`[name='name']`).val(medicine.name)
                form.find(`[name='contraindications']`).val(medicine.contraindications)
                form.find(`[name='sample_dosages']`).val(medicine.sample_dosages)

                $.each(medicine.symptoms, function(index, symptom) {
                    form.find(`input[name='symptoms[]'][value='${symptom.id}`).prop('checked', true)
                })

                $.each(medicine.diseases, function(index, disease) {
                    form.find(`input[name='diseases[]'][value='${disease.id}`).prop('checked', true)
                })

                sortCheckedInput(form)
                const unit = medicine._variable.units.find((unit) => {
                    return unit.rate == 1;
                })
                $.each(medicine.dosages, function(index, dosage) {
                    const options = `@foreach (cache()->get('animals_' . Auth::user()->company_id) as $key => $animal)
                                <option value="{{ $animal }}">{{ $animal }}</option>
                            @endforeach`,
                        str = `
            <tr class="dosage">
                <td>
                    <div class="input-group">
                        <input class="form-control" name="dosage_dosages[]" type="text" placeholder="Liều dùng/lần" value="${dosage.dosage}" autocomplete="off" required>
                        <span class="input-group-text medicine-dosage">${unit.term}/kg</span>
                    </div>
                </td>
                <td>
                    <input class="form-control" name="dosage_frequencies[]" type="text" placeholder="Số lần/ngày" value="${dosage.frequency}" autocomplete="off" required>
                </td>
                <td>
                    <div class="input-group">
                        <input class="form-control" name="dosage_quantities[]" type="text" placeholder="Số ngày" value="${dosage.quantity}" autocomplete="off" required>
                    </div>
                </td>
                <td>
                    <input class="form-control" list="medicine-routes" name="dosage_routes[]" type="text" placeholder="Đường cấp" value="${dosage.route}" autocomplete="off" required>
                </td>
                <td style="width: 150px">
                    <select class="form-select text-dark" name="dosage_species[]" value="${dosage.specie}" required>${options}</select>
                </td>
                <td>
                    <div class="input-group">
                    <input class="form-control" name="dosage_ages[]" type="text" placeholder="Tuổi" value="${dosage.age}" autocomplete="off">
                    <span class="input-group-text">tháng</span>
                    </div>
                </td>
                    <input name="dosage_ids[]" value="${dosage.id}" type="hidden">
                    <form action="{{ route('admin.dosage.remove') }}" method="post" class="save-form">
                        @csrf
                        <input type="hidden" name="choice" value="${dosage.id}"/>
                        <button class="btn btn-link text-decoration-none btn-remove-dosage">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </form>
                </td>
            </tr>`;
                    $('#dosages').append(str).find('.dosage').last().find(`[name='dosage_species[]']`).val(dosage.specie);
                })
            })
            form.attr('action', `{{ route('admin.medicine.update') }}`).find('.modal').modal('show')
        })

        $(document).on('change', '#medicine-product_id', function(e) {
            if ($(this).val() != null) {
                e.preventDefault();
                const id = $(this).val();
                $.get(`{{ route('admin.product') }}/${id}`, function(product) {
                    const str = product.variables.map((variable) => {
                        var min_unit = variable.units.find(function(unit) {
                            return unit.rate === 1;
                        });
                        return `<option value="${variable.id}" data-unit="${min_unit.term}"}>${variable.name}</option>`
                    }).join('')
                    $('#medicine-form').find(`[name='variable_id']`).html(str).parent().removeClass('d-none');
                    setUnit()
                })
            }
        })

        $(document).on('click', '.btn-append-dosage', function(e) {
            e.preventDefault();
            const options = `@foreach (cache()->get('animals_' . Auth::user()->company_id) as $key => $animal)
                            <option value="{{ $animal }}">{{ $animal }}</option>
                    @endforeach`,
                str = ` <tr class="dosage">
                    <td>
                        <div class="input-group">
                            <input class="form-control" name="dosage_dosages[]" type="text" placeholder="Liều dùng" autocomplete="off" required>
                            <span class="input-group-text medicine-dosage">${$('#medicine-variable_id').find('option:selected').attr('data-unit') ?? 'đ.vị'}/kg</span>
                        </div>
                    </td>
                    <td>
                        <input class="form-control" name="dosage_frequencies[]" type="text" placeholder="Số lần/ngày" autocomplete="off" required>
                    </td>
                    <td>
                        <div class="input-group">
                            <input class="form-control" name="dosage_quantities[]" type="text" placeholder="Số ngày" autocomplete="off" required>
                        </div>
                    </td>
                    <td>
                        <input class="form-control" list="medicine-routes" name="dosage_routes[]" type="text" placeholder="Chọn" autocomplete="off" required>
                    </td>
                    <td style="width:150px">
                        <select class="form-select text-dark" name="dosage_species[]" autocomplete="off" required >
                            <option disabled hidden selected>Chọn loài</option>
                            ${options}
                        </select>
                    </td>
                    <td>
                        <div class="input-group">
                            <input class="form-control" name="dosage_ages[]" type="text" placeholder="Tuổi" autocomplete="off">
                            <span class="input-group-text">tháng</span>
                        </div>
                    </td>
                    <td>
                        <input name="dosage_ids[]" type="hidden">
                        <form class="save-form">
                            @csrf
                            <input type="hidden"name="choice" value=""/>
                            <button class="btn btn-link text-decoration-none btn-remove-dosage"><i class="bi bi-trash3"></i></button>
                        </form>
                    </td >
                </tr>`;
            $('#dosages').append(str);
        });

        $(document).on('change', '#medicine-variable_id', function() {
            setUnit()
        });

        $(document).on('click', '.btn-remove-dosage', function(e) {
            e.preventDefault();
            const btn = $(this),
                form = $(this).closest('form'),
                str = `<i class="bi bi-trash3"></i>`;
            if (form.find(`[name='choice']`).val() !== '') {

                Swal.fire(config.sweetAlert.confirm).then((result) => {
                    if (result.isConfirmed) {
                        btn.prop("disabled", true).html(
                            '<span class="spinner-border spinner-border-sm" id="spinner-form" role="status"></span>'
                        );
                        $.ajax({
                            data: new FormData(form[0]),
                            url: form.attr("action"),
                            method: form.attr("method"),
                            contentType: false,
                            processData: false,
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name = "csrf-token"]').attr(
                                    "content"),
                            },
                            success: function success(response) {
                                // Swal.close();
                                if (response.status == "success") {
                                    pushToastify(response.msg, response.status)
                                    btn.parents('.dosage').remove();
                                } else {
                                    Swal.fire(
                                        "THẤT BẠI!",
                                        response.msg,
                                        response.status
                                    );
                                    btn.prop("disabled", false).html(str);
                                }
                            },
                            error: function error(errors) {
                                btn.prop("disabled", false).html(str);
                                if (errors.status == 419 || errors.status == 401) {
                                    window.location.href = config.routes.login;
                                } else {
                                    pushToastify(
                                        "Lỗi không xác định. Vui lòng liên hệ nhà phát triển phần mềm để khắc phục.", 'danger')
                                }
                            },
                        })
                    }
                })
            } else {
                btn.parents('.dosage').remove();
            }
        });

        function setUnit() {
            const unit = $('#medicine-variable_id').find('option:selected').attr('data-unit')
            $('span.medicine-dosage').text(unit + '/kg');
        }

        /* =================== END MEDICINE =================== */

    /**
     * DATATABLES
     */
    function showVariables(product_id = null) {
        $('#variables-datatable').closest('.card-variables').removeClass('d-none').find('.btn-create-variable').attr('data-product', product_id)
        const table = $('#variables-datatable').DataTable({
            dom: 'rt',
            bStateSave: true,
            stateSave: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: `{{ route('admin.variable') }}?product_id=${product_id}`
            },
            columns: [
                config.datatable.columns.name,
                config.datatable.columns.status,
                config.datatable.columns.action,
            ],
            aLengthMenu: -1,
            language: config.datatable.lang,
        })
    }

    function showImportDetails(product_id = null) {
        if (!$.fn.dataTable.isDataTable('#import_detail-table')) {
            table = $('#import_detail-table').DataTable({
                bStateSave: true,
                stateSave: true,
                serverSide: true,
                orderCellsTop: true,
                ajax: {
                    url: `{{ route('admin.import_detail') }}?product_id=${product_id}`
                },
                columns: [
                    config.datatable.columns.code,
                    config.datatable.columns.note,
                    {
                        data: 'user',
                        name: 'user',
                    },
                    {
                        data: 'supplier',
                        name: 'supplier'
                    },
                    {
                        data: 'warehouse',
                        name: 'warehouse'
                    },
                    {
                        data: 'variable',
                        name: 'variable',
                        searchable: true
                    },
                    {
                        data: 'quantity',
                        name: 'quantity',
                        searchable: true
                    },
                    {
                        data: 'price',
                        name: 'price',
                        searchable: true
                    }
                ],
                language: config.datatable.lang,
                pageLength: config.datatable.pageLength,
                aLengthMenu: config.datatable.lengths,
                columnDefs: config.datatable.columnDefines,
                order: [
                    [0, 'DESC']
                ]
            });
        } else {
            table.ajax.url(`{{ route('admin.import_detail') }}?product_id=${product_id}`).load();
        }
    }
    function showExportDetails(product_id = null) {
        if (!$.fn.dataTable.isDataTable('#export_detail-table')) {
            table = $('#export_detail-table').DataTable({
                bStateSave: true,
                stateSave: true,
                serverSide: true,
                orderCellsTop: true,
                ajax: {
                    url: `{{ route('admin.export_detail') }}?product_id=${product_id}`
                },
                columns: [
                    config.datatable.columns.code,
                    config.datatable.columns.note,
                    {
                        data: 'user',
                        name: 'user',
                    },
                    {
                        data: 'receiver',
                        name: 'receiver'
                    },
                    {
                        data: 'variable',
                        name: 'variable',
                        searchable: true
                    },
                    {
                        data: 'quantity',
                        name: 'quantity',
                        searchable: true
                    }
                ],
                language: config.datatable.lang,
                pageLength: config.datatable.pageLength,
                aLengthMenu: config.datatable.lengths,
                columnDefs: config.datatable.columnDefines,
                order: [
                    [0, 'DESC']
                ]
            });
        } else {
            table.ajax.url(`{{ route('admin.export_detail') }}?product_id=${product_id}`).load();
        }
    }


    function showProducts() {
        const table = $('#products-datatable').DataTable({
            bStateSave: true,
            stateSave: true,
            processing: true,
            serverSide: true,
            orderCellsTop: true,
            ajax: {
                url: `{{ route('admin.product') }}`
            },
            columns: [
                config.datatable.columns.code, {
                    data: 'avatar',
                    name: 'avatar'
                },
                config.datatable.columns.name, {
                    data: 'catalogues',
                    name: 'catalogues'
                }, {
                    data: 'variables',
                    name: 'variables'
                },
                config.datatable.columns.status,
                config.datatable.columns.sort,
                config.datatable.columns.action,
                config.datatable.columns.checkboxes,
            ],
            pageLength: config.datatable.pageLength,
            aLengthMenu: config.datatable.lengths,
            language: config.datatable.lang,
            columnDefs: config.datatable.columnDefines,
            order: [
                [$("#products-datatable thead tr th").length - 3, 'ASC']
            ]
        })
    }

    function showTransactions(order_id) {
        const table = $('#transactions-datatable').DataTable({
            dom: 't',
            bStateSave: true,
            stateSave: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: `{{ route('admin.transaction') }}?order_id=${order_id}`,
                dataSrc: function(json) {
                    const totalOrder = json.totalOrder;
                    const totalAmount = json.totalAmount;
                    const transactionRemain = totalAmount - totalOrder;
                    $('.order-sum').text(number_format(totalOrder) + 'đ');
                    $('.transaction-sum').text(number_format(totalAmount) + 'đ');
                    $('.transaction-remain')
                        .html(transactionRemain < 0 ? `<span class="text-danger">${number_format(transactionRemain) + 'đ'}</span>` :
                            transactionRemain > 0 ? `<span class="text-success">${number_format(transactionRemain) + 'đ'}</span>` :
                            number_format(transactionRemain) + 'đ')
                        .prev().text(transactionRemain < 0 ? `Còn thiếu` : transactionRemain > 0 ? `Còn thừa` : `Trả đủ`)
                    return json.data;
                }
            },
            columns: [
                config.datatable.columns.code,
                config.datatable.columns.note, {
                    data: 'payment',
                    name: 'payment',
                },
                config.datatable.columns.customer, {
                    data: 'cashier',
                    name: 'cashier',
                }, {
                    data: 'amount',
                    name: 'amount',
                    className: 'text-end',
                },
                config.datatable.columns.action,
            ],
            aLengthMenu: -1,
            language: config.datatable.lang
        })
    }

        /**
         *  EXPENSE PROCESS
         */
        $(document).on('click', '.btn-create-expense', function(e) {
            e.preventDefault();
            const form = $('#expense-form')
            resetForm(form)
            form.attr('action', `{{ route('admin.expense.create') }}`)
            form.find('.modal').modal('show')
        })

    $(document).on('click', '.btn-update-expense', function(e) {
        e.preventDefault();
        const id = $(this).attr('data-id'),
            form = $('#expense-form');
        resetForm(form)
        $.get(`{{ route('admin.expense') }}/${id}`, function(expense) {
            form.find('[name=id]').val(expense.id)
            form.attr('action', `{{ route('admin.expense.update') }}`)
            form.find('.modal').modal('show')
            if (expense.receiver_id != null) {
                var option = new Option(expense.receiver.name, expense.receiver_id, true, true);
                form.find('[name=receiver_id]').append(option).trigger({
                    type: 'select2:select'
                });
            } else {
                form.find('[name=receiver_id]').val(null).trigger("change")
            }
            form.find(`[name=payment][value="${expense.payment}"]`).prop('checked', true)
            form.find(`[name=amount]`).val(Math.abs(expense.amount))
            form.find(`[name=note]`).val(expense.note)
            form.find(`[name='status']`).prop('checked', expense.status);
            $('#expense-avatar-preview').attr('src', expense.avatarUrl)
            form.find('.modal').modal('show').find('.modal-title').text(expense.code)
        })
    })
    // ===================== END EXPENSE ==================

        /**
         * BOOKING TICKET PROCESS
         */
        $(document).on('click', '.btn-create-booking', function(e) {
            e.stopImmediatePropagation();
            const form = $('#booking-form');

            resetForm(form)
            console.log(form.find('[name=frequency]').html());
            form.find('.search-result').empty()
            form.find('[name=status][value=1]').prop('checked', true);
            form.attr('action', `{{ route('admin.booking.create') }}`)
            form.find('.modal').modal('show').find('.modal-title').text('Đặt lịch hẹn')
            form.find('[name="appointment_date"]').val($(this).attr('data-date'))
            form.find('.send-zns-btns').empty()
            if ($(this).attr('data-service_id')) {
                $.get(`{{ route('admin.service') }}/${$(this).attr('data-service_id')}`, function(service) {
                    var option = new Option(service.name, service.id, true, true);
                    form.find('[name=service_id]').append(option).trigger({
                        type: 'select2:select'
                    }).change();
                })
            } else {
                form.find('[name=service_id]').val(null).trigger("change")
            }
            if ($(this).attr('data-pet_id')) {
                $.get(`{{ route('admin.pet') }}/${$(this).attr('data-pet_id')}`, function(pet) {
                    form.find('#booking-pet_id').closest('.ajax-search').find('.search-result')
                        .html(`<li class="list-group-item border border-0 pb-0">
                        <input type="radio" name="pet_id" id="pet-${pet.id}" class="form-check-input me-1" value="${pet.id}" checked>
                                            <label class="form-check-label d-inline" for="pet-${pet.id}">${pet.fullName}<br><strong class="ps-4">${pet._customer.name + (pet._customer.phone ? ' - ' + pet._customer.phone : '')}</strong></label>
                    </li>`);
                })
            }
            if ($(this).attr('data-doctor_id')) {
                $.get(`{{ route('admin.user') }}/${$(this).attr('data-doctor_id')}`, function(doctor) {
                    form.find('#booking-doctor_id').closest('.ajax-search').find('.search-result')
                        .html(`<li class="list-group-item border border-0 pb-0">
                        <input type="radio" name="doctor_id" id="doctor-${doctor.id}" class="form-check-input me-1" value="${doctor.id}" checked>
                        <label class="form-check-label d-inline" for="doctor-${doctor.id}"><span class="text-primary">${doctor.name}</span> - ${doctor.phone || ''}</label>
                    </li>`);
                })
            }
            form.find('[name="service_id"]').val($(this).attr('data-date'))
            form.find('[name="pet_id"]').val($(this).attr('data-date'))
            form.find('[name="doctor_id"]').val($(this).attr('data-date'))
        })

    $(document).on('click', '.btn-update-booking', function() {
        const form = $('#booking-form');
        resetForm(form)
        form.find('.search-result').empty()
        $.get(`{{ route('admin.booking') }}/${$(this).attr('data-id')}`, function(booking) {
            form.find('[name=id]').val(booking.id)
            form.find('[name=name]').val(booking.name)
            form.find('[name=description]').val(booking.description)
            form.find('[name=note]').val(booking.note)
            form.find(`[name=appointment_hour][value="${moment(booking.appointment_at).format('HH:mm')}"]`).prop('checked', true)
            form.find('[name=appointment_date]').val(moment(booking.appointment_at).format('YYYY-MM-DD'))
            form.find('[name=frequency]').val(booking.frequency)
            form.find('[name=type]').val(booking.type)
            form.find('[name=remind_at]').val(moment(booking.appointment_at).diff(moment(booking.remind_at), 'minutes')).change();
            form.find(`[name="status"][value="${booking.status}"]`).prop('checked', true);
            form.attr('action', `{{ route('admin.booking.update') }}`)
            booking._pet ? form.find('#booking-pet_id').closest('.ajax-search').find('.search-result')
                .html(`<li class="list-group-item border border-0 pb-0">
                        <input type="radio" name="pet_id" id="pet-${booking.pet_id}" class="form-check-input me-1" value="${booking.pet_id}" checked>
                        <label class="form-check-label d-inline" for="pet-${booking.pet_id}">${booking._pet.fullName} <a class="btn-update-pet" data-id="${booking._pet.id}"><i class="bi bi-info-circle"></i></a> (${booking._pet.animal.specie} ${booking._pet.genderStr}</span> ${booking._pet.neuterIcon})<br><strong class="ps-4">${booking._pet._customer.name + (booking._pet._customer.phone ? ` - <a href="tel:${booking._pet._customer.phone}">${booking._pet._customer.phone}</a>` : '')}</strong> <a class="btn-update-pet" data-id="${booking._pet.customer_id}"><i class="bi bi-info-circle"></i></a></label>
                    </li>`) : '';
                booking._doctor ? form.find('#booking-doctor_id').closest('.ajax-search').find('.search-result')
                    .html(`<li class="list-group-item border border-0 pb-0">
                        <input type="radio" name="doctor_id" id="doctor-${booking.doctor_id}" class="form-check-input me-1" value="${booking.doctor_id}" checked>
                        <label class="form-check-label d-inline" for="doctor-${booking.doctor_id}"><span class="text-primary">${booking._doctor.name}</span> - ${booking._doctor.phone || ''}</label>
                    </li>`) : '';
                form.find('.send-zns-btns').html(`
                        ${booking._pet ? `<a class="btn btn-outline-info btn-send-zns send-booking" data-id="${booking.id}" data-url="{{ getPath(route('admin.booking.send_zns')) }}" data-phone="${booking._pet._customer.phone}">Gửi Zalo KH</a>` : ''}
                        ${booking._doctor ? `<a class="btn btn-outline-info btn-send-zns send-booking" data-id="${booking.id}" data-url="{{ getPath(route('admin.booking.send_zns')) }}" data-phone="${booking._doctor.phone}">Gửi Zalo BS</a>` : ''}`)
                if (booking.service_id != null) {
                    var option = new Option(booking._service.name, booking.service_id, true, true);
                    form.find('[name=service_id]').append(option).trigger({
                        type: 'select2:select'
                    });
                } else {
                    form.find('[name=service_id]').val(null).trigger("change")
                }
                form.find('.modal').modal('show').find('.modal-title').text(booking.name)
            })
        })

        //Đổi text của desc nếu người dùng chọn dịch vụ
        $(document).on('change', '[name="service_id"]', function(e) {
            const serviceTxt = $(this).find('option:selected').text();
            $(this).closest('form').find('[name="description"]').val('Bạn đã đặt hẹn dịch vụ ' + serviceTxt)
        });

    $(document).on("click", ".btn-delete-booking", function(e) {
        e.stopPropagation();
        let btn = $(this)
        Swal.fire({
            title: "Xác nhận?",
            text: "Vui lòng xác nhận trước khi tiếp tục!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "var(--bs-danger)",
            cancelButtonColor: "var(--bs-primary)",
            confirmButtonText: "OK, xoá đi!",
            cancelButtonText: "Quay lại",
        }).then((result) => {
            if (result.isConfirmed) {
                submitForm(btn.parents("form")).done(function() {
                    const date = btn.attr('data-date-selected');
                    fillData(date + ' - ' + date)
                });
            }
        });
    });
    /* ====================== END BOOKING TICKET ====================== */

    /**
     * WORK PROCESS
     */

    //Sắp lịch lấy thứ hai tuần sau
    let nextMonday = moment().endOf('week').add(1, 'days'); // Thứ hai tuần sau

    $(document).on('change', '.btn-change-schedule', function() {
        const element = $(this),
            user_id = $(this).attr('data-user_id'),
            main_branch = $(this).attr('data-main_branch'),
            dayOfWeek = $(this).attr('data-date'), // 0 (Monday), 1 (Tuesday), ..., 6 (Sunday)
            shift = $(this).attr('data-shift'),
            date = nextMonday.clone().add(dayOfWeek, 'days').format('YYYY-MM-DD');

        const form =
            $(`<form action="{{ route('admin.work.schedule') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="${user_id}">
                <input type="hidden" name="main_branch" value="${main_branch}">
                <input type="hidden" name="shift" value="${shift}">
                <input type="hidden" name="date" value="${date}">
            </form>`);
        submitForm(form).catch(function(errors) {
            element.prop("checked", false);
        });
    })

    /**
     * WORK PROCESS
     */
    $(document).ready(function() {
        moment.locale('vi');
        $(document).on('click', '.btn-update-work', function(e) {
            e.preventDefault();
            const id = $(this).attr('data-id'),
                form = $('#timekeeping-form');
            resetForm(form)
            $.get(`{{ route('admin.work') }}/${id}`, function(work) {
                form.find('[name="sign_checkin"]').val(moment(work.sign_checkin).format(
                    'HH:mm'))
                form.find('[name="sign_checkout"]').val(moment(work.sign_checkout).format(
                    'HH:mm'))
                form.find('[name="real_checkin"]').val(work.real_checkin ? moment(work
                    .real_checkin).format('HH:mm') : '')
                form.find('[name="real_checkout"]').val(work.real_checkout ? moment(work
                    .real_checkout).format('HH:mm') : '')
                form.find('[name=id]').val(work.id)
                form.attr('action', `{{ route('admin.work.update') }}`)
                form.find('.modal').modal('show').find('.modal-title').text(
                    `${work.user.name} • ${moment(work.sign_checkin).format('DD/MM')}  • ${work.shift_name}`
                )
            })
        })

        //Tự sắp lịch
        $(document).on('click', '.btn-self-schedule', function(e) {
            e.preventDefault();
            const modal = $('#self-schedule-modal');
            renderSchedule(nextMonday, $('#self-schedule-table thead'));
            $('#self-schedule-table').find('.btn-change-schedule').prop('checked', false);
            fillSchedule();
            modal.modal('show').find('.modal-title').text(
                `Sắp lịch làm việc (${nextMonday.format('DD/MM')} - ${nextMonday.clone().add(6, 'days').format('DD/MM')})`
            );
        })
    });


    function renderSchedule(monday, target) {
        const days = Array.from({
            length: 7
        }, (_, i) => monday.clone().add(i, 'days'));
        let html = `<tr class="tr-head">
                        <th style="min-width: 210px">Tên</th>
                        ${days.map((day, index) => {
                            const dayName = day.format('ddd');
                            const date = day.format('DD/MM/YYYY');
                            const dayClass = index === 5
                                    ? 'text-success'
                                    : index === 6
                                        ? 'text-danger'
                                        : '';
                            return `<th class="text-center ${dayClass}">${dayName}<br><span class="fw-normal ${dayClass}">${date}</span></th>`;
                        }).join('')}
                    </tr>`;
        target.html(html);
    }

    //Fill lịch cho modal chấm đăng ký lịch
    function fillSchedule() {
        $.get(`{{ route('admin.work', ['key' => 'schedule']) }}`, function(works) {
            //4-1611-4-6
            $.each(works, function(index, work) {
                const classComponent = `${work.branch_id}-${work.user_id}-${work.index}-${work.date}`;
                $('#schedule-modal').find(`.${classComponent}`).prop('checked', true);
                $('#self-schedule-modal').find(`.${classComponent}`).prop('checked', true);
            })
        })
    }

    /* ====================== END WORK ====================== */


        /**
         *  DISEASE PROCESS
         */
        $(document).on('click', '.btn-create-diseases', function(e) {
            e.preventDefault();
            const name = $(this).attr('data-name')
            initCreateDisease(name)
        })

        function initCreateDisease(name) {
            const form = $('#diseases-form')
            resetForm(form)
            form.attr('action', `{{ route('admin.disease.create') }}`)
            form.find('[name=name]').val(name)
            form.find('.modal').modal('show')
        }

        $(document).on('click', '.btn-update-disease', function(e) {
            e.preventDefault();
            const id = $(this).attr('data-id'),
                name = $(this).attr('data-name');
            if (id) {
                $.get(`{{ route('admin.disease') }}/${id}`, function(disease) {
                    initUpdateDisease(disease)
                })
            } else if (name) {
                $.get(`{{ route('admin.disease') }}/find?q=${name}`)
                    .done(function(disease) {
                        if (disease) {
                            initUpdateDisease(disease);
                        } else {
                            initCreateDisease(name);
                        }
                    })
            } else {
                pushToastify('Không tìm thấy dữ liệu truy vấn', 'danger')
            }
        })

        function initUpdateDisease(disease) {
            const form = $('#diseases-form')
            resetForm(form)
            form.find(`[name='id']`).val(disease.id)
            form.find(`[name='name']`).val(disease.name)
            form.find(`[name='infection_chain']`).val(disease.infection_chain)
            form.find(`[name='counsel']`).val(disease.counsel)
            form.find(`[name='complication']`).val(disease.complication)
            form.find(`[name='prevention']`).val(disease.prevention)
            form.find(`[name='advice']`).val(disease.advice)
            form.find(`[name='prognosis']`).val(disease.prognosis)
            $.each(disease.symptoms, function(index, symptom) {
                form.find(`input[name='symptoms[]'][value='${symptom.id}']`).prop('checked', true);
            })
            $.each(disease.services, function(index, service) {
                form.find(`input[name='services[]'][value='${service.id}']`).prop('checked', true);
            })
            $.each(disease.medicines, function(index, medicine) {
                form.find(`input[name='medicines[]'][value='${medicine.id}']`).prop('checked', true);
            })
            sortCheckedInput(form)
            form.attr('action', `{{ route('admin.disease.update') }}`)
            form.find('.modal').modal('show')
        }
        /*===================== END DISEASE ======================*/

    /**
     * INFO PROCESS
     */
    // $(document).on('click', '.btn-create-info', function(e) {
    //     e.preventDefault();
    //     const form = $('#info-form')
    //     resetForm(form)
    //     form.attr('action', `{{ route('admin.info.create') }}`)
    //     form.find('.modal').modal('show')
    // })

    $(document).on('click', '.btn-expand-info', function() {
        const form = $(this).closest('form');
        form.attr('action', `{{ route('admin.info.expand') }}`).removeClass('save-form').off('submit')
            .submit();
    })

    $(document).on('click', '.btn-indication-export', function() {
        const form = $('#export-form'),
            id = $(this).attr('data-id')
        @php
            $warehouses = cache()
                ->get('warehouses_' . Auth::user()->company_id)
                ->where('branch_id', Auth::user()->main_branch)
                ->whereIn('id', Auth::user()->warehouses->pluck('id'))
                ->where('status', 1)
                ->pluck('name', 'id');
        @endphp

            var option = ``;
            $.each(@json($warehouses), function(id, name) {
                option += `<option value="${id}">${name}</option>`;
            })

            form.find(`[name=export_warehouse]`).html(option)
            const warehouse_id = form.find(`[name=export_warehouse]`).val()
            $('#export-search-input').attr('data-url', `{{ route('admin.stock') }}?key=search&warehouse_id=${warehouse_id}&action=export`)

            $.get(`{{ route('admin.detail') }}/${id}/export`, function(indication) {
                if (indication) {
                    initCreateExport();
                    const doctor = indication.info._doctor
                    form.find(`[name="note"]`).val('Xuất theo chỉ định ' + indication.code)
                    form.find(`[name="receiver_id"]`).attr('readonly', true).html(
                        `<option value="${doctor.id}">${doctor.name} - ${doctor.phone}</option>`
                    )
                    form.find(`[name=order_id]`).val(indication.detail.order_id)
                    form.find(`[name=detail_id]`).val(indication.detail.id)
                    form.find(`[name=to_warehouse_id]`).closest('.form-group').addClass('d-none')

                    const consumables = JSON.parse(indication.detail._service.consumables);

                    $.each(consumables, function(index, consumable) {
                        var quantity = consumable.quantity * consumable.unit_rate;
                        $.each(consumable.stocks, function(index, stock) {
                            if (stock.quantity < quantity) {
                                var export_quantity = stock.quantity
                                quantity -= stock.quantity
                            } else {
                                var export_quantity = quantity
                            }

                            const str = `<div class="card border shadow-none mb-2 p-3 detail export-detail">
                                        <div class="row">
                                            <div class="col 12 col-lg-9">
                                                <p class="card-title mb-0">
                                                    ${stock.productName}
                                                    <input type="hidden" class="export_detail-stock_id" name="stock_ids[]" value="${stock.id}"/>
                                                    <a class="btn btn-link btn-export_detail-product_info rounded-pill p-0" data-id="${stock.id}" type="button">
                                                        <i class="bi bi-info-circle"></i>
                                                    </a>
                                                </p>
                                                <div class="badge bg-light-info">${stock.import_detail._variable._product.sku}</div>
                                                ${stock.stockExpired == null || stock.stockExpired == '' ? '' : `<div class="badge bg-light-info">HSD ${moment(stock.stockExpired).format('DD/MM/YYYY')}</div>`}
                                                <div class="badge bg-light-info">
                                                    Tồn kho ${stock.stockConvertQuantity}
                                                    <input type="hidden" class="export_detail-stock_quantity" name="stock_quantities[]" value="${stock.quantity}"/>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-3">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <select name="unit_ids[]" class="form-control form-control-lg form-control-plaintext export_detail-unit ps-3 bg-white" readonly>
                                                            <option value="${stock.unit.id}" data-rate="${stock.unit.rate}" data-price="${stock.unit.price}" selected hidden>${stock.unit.term}</option>
                                                        </select>
                                                        <input type="hidden" class="export_detail-current_unit_id bg-white" name="current_unit_ids[]" value=${stock.unit.id}">
                                                        <input type="hidden" class="export_detail-current-quantity" name="current_quantities[]" value="${export_quantity}">
                                                    </div>
                                                    <div class="col-6 d-flex justify-content-between">
                                                        <input class="form-control-plaintext form-control-lg export_detail-quantity text-center money bg-white" name="quantities[]" type="text" value="${number_format(export_quantity)}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" name="notes[]" class="form-control form-control-lg form-control-plaintext export_detail-note" placeholder="Ghi chú món hàng"/>
                                            </div>
                                        </div>
                                    </div>`
                            form.find('.export-details').append(str)
                        })
                    })
                } else {
                    pushToastify('Số vật tư trong kho hiện không đủ!', `danger`)
                }
            })
        })

        $(document).on('click', '.btn-select-user', function() {
            const customer_id = $(this).attr('data-id'),
                customer_name = $(this).text();
            fillCustomer(customer_id, customer_name)
            fillListPet(customer_id)
        })


        function fillListPet(customerId, petId = null) {
            $('.pet-slider').empty()
            $.get(`{{ route('admin.user') }}/${customerId}`, function(user) {
                $.each(user.pets, function(index, pet) {
                    const str = `<div class="col-6 col-md-4 col-lg-3 my-2">
                                        <input class="d-none choice" id="pet-choice-${pet.id}" name="choices[]"
                                            data-name="${pet.name}" data-specie="${pet.animal.specie}" type="radio" value="${pet.id}">
                                        <label class="d-block choice-label h-100" for="pet-choice-${pet.id}">
                                            <div class="card card-image mb-2 h-100">
                                                <div class="ratio ratio-16x9">
                                                    <img class="card-img-top object-fit-cover p-1" src="${pet.avatarUrl}" alt="${pet.name}">
                                                </div>
                                                <div class="p-3">
                                                    <p class="card-title d-inline-block fw-bold">
                                                        <small data-bs-toggle="tooltip" data-bs-title="${pet.name}">${pet.name}</small>
                                                        <span class="badge bg-light-info">
                                                            <small>${pet.animal.specie} ${pet.genderStr} ${ pet.neuterIcon }</small>
                                                        </span>
                                                    </p>
                                                    <p class="text-body-secondary mb-0 fs-6"><small>Tuổi: ${pet.birthday != null ? pet.age : 'Không rõ'}</small></p>
                                                    <p class="d-none pet-history">${ pet.infos ? pet.infos.map((info) => { return JSON.parse(info.diags).final_diag }).join('\r\n• ') : '' }</p>
                                                </div>
                                                <div class="d-grid mb-2 mt-auto">
                                                    <div class="btn-group">
                                                        <a class="btn btn-link btn-update-pet btn-sm" data-id="${pet.id}">Thông tin</a>
                                                        <a class="btn btn-link btn-sm" data-id="${pet.id}">Bệnh án</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>`
                    $('.pet-slider').append(str)
                })
                const str = `<div class="col-6 col-md-4 col-lg-3 my-2">
                                    <a class="btn-create-pet cursor-pointer" data-customer="${ customerId }">
                                        <div class="card card-image add-gallery ratio ratio-1x1 rounded-3 mb-2 h-100">
                                            <i class="bi bi-plus"></i>
                                        </div>
                                    </a>
                                </div>`
                $('.pet-slider').prepend(str)
                if (petId) {
                    $(`#pet-choice-${petId}`).prop('checked', true).change()
                } else {
                    $(`.pet-slider .choice:first`).prop('checked', true).change()
                }
            })
        }

        function fillCustomer(id, name) {
            $('.customer-search').val(name);
            $('.list-customer-suggest').empty();
            fillCustomerSuggestions(id)
            $('#info-form').find(`[name='customer_id']`).val(id)
            $('#info-form').find(`[name='pet_id']`).val('').attr('data-specie', '')
        }

        $(document).on('change', '.pet-slider .choice', function() {
            const form = $(this).closest('.section').find('form')
            form.find(`[name='pet_id']`).val($(this).val()).attr('data-specie', $(this).attr('data-specie'));
            form.find(`[name='history']`).val($(this).next().find('.pet-history').text())
        })

        // Trượt slider pets
        $('.pet-slider').on('wheel', function(event) {
            const petSlider = $('.pet-slider');

            // Kiểm tra xem thanh trượt ngang có xuất hiện hay không
            if (petSlider[0].scrollWidth > petSlider[0].clientWidth) {
                // Gắn sự kiện wheel khi có thanh trượt ngang
                petSlider.on('wheel', function(event) {
                    if (event.originalEvent.deltaY !== 0) {
                        event.preventDefault();
                        $(this).scrollLeft($(this).scrollLeft() + event.originalEvent.deltaY);
                    }
                });
            }
        });

        $(document).on('keyup focus', '.customer-search', function(e) {
            const input = $(this),
                form = $(this).closest('.section').find('form')
            if (e.key === 'Escape') {
                input.val('');
            }
            if (e.type === 'keyup') {
                const strPet = `<div class="col-6 col-md-4 col-lg-3 my-2">
                                <a class="btn-empty cursor-pointer">
                                    <div class="card card-image add-gallery ratio ratio-1x1 rounded-3 mb-2 h-100">
                                        <i class="bi bi-plus"></i>
                                    </div>
                                </a>
                            </div>`;
                $('.pet-slider').html(strPet);
                $('.customer-suggestions').empty();
                form.find('[name="customer_id"]').val(null);
                form.find('[name="pet_id"]').val(null).attr('data-specie', null);
            }
        });

        $(document).on('click', '.btn-empty', function() {
            Swal.fire({
                title: "Lưu ý!",
                text: "Vui lòng chọn khách hàng để thực hiện thao tác!",
                icon: "warning",
                confirmButtonText: "OK",
                confirmButtonColor: "var(--bs-primary)",
            })
        });

        /* ====================== END INFO ===================== */

        /**
         *  PRESCRIPTION PROCESS
         */
        $(document).on('click', '.btn-update-prescription', function(e) {
            e.preventDefault();
            const id = $(this).attr('data-id'),
                form = $('#prescription-form');
            resetForm(form);
            $.get(`{{ route('admin.prescription') }}/${id}`, function(prescription) {
                var str = ``;
                $.each(prescription.prescription_details, function(index, prescription_detail) {
                    const unit = prescription_detail._medicine._variable.units.find(function(unit) {
                        return unit.rate === 1;
                    })
                    str += `<tr class="medicine-row">
                                <td class="fw-bold">
                                    ${ prescription_detail._medicine.name }
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input class="form-control form-control-plaintext border-bottom" name="dosages[]" value="${ prescription_detail.dosage }" placeholder="Nhập số" autocomplete="off">
                                        <span class="input-group-text">${ unit.term }/lần</span>
                                    </div>
                                </td>
                                <td>
                                    <input class="form-control form-control-plaintext border-bottom rounded-0 px-2 prescription-frequency bg-transparent" name="frequencies[]" type="text" value="${ prescription_detail.frequency }"
                                        placeholder="Nhập số" autocomplete="off">
                                </td>
                                <td>
                                    <input class="form-control form-control-plaintext border-bottom bg-transparent prescription-quantity" name="quantities[]" type="text" value="${ prescription_detail.quantity }"
                                        placeholder="Nhập số" autocomplete="off">
                                </td>
                                <td>
                                    <input class="form-control form-control-plaintext border-bottom rounded-0 px-2 prescription-route bg-transparent" name="routes[]" type="text" value="${ prescription_detail.route }"
                                        placeholder="Chọn" autocomplete="off">
                                </td>
                                <td>
                                    <input class="form-control form-control-plaintext px-3 bg-transparent border-bottom" name="notes[]" type="text" value="${ prescription_detail.note ?? '' }" placeholder="Ghi chú" autocomplete="off">
                                </td>
                                <td>
                                    <input name="medicine_ids[]" type="hidden" value="${ prescription_detail.medicine_id }" />
                                    <input name="prescription_detail_ids[]" type="hidden" value="${ prescription_detail.id }">
                                    @if (Auth::user()->can(App\Models\User::UPDATE_PRESCRIPTION))
                                        ${
                                            !prescription_detail.export_id ? `
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <a class="btn btn-link text-decoration-none btn-remove-detail" data-id="${ prescription_detail.id }" data-url="{{ getPath(route('admin.prescription_detail.remove')) }}">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <i class="bi bi-trash3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Xóa"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </a>` : ''
                                        }
                                    @endif
                                </td>
                            </tr>`
                })
                form.attr('action', `{{ route('admin.prescription.update') }}`).find('.modal').modal('show').find('tbody').html(str);
                form.find('[name="id"]').val(prescription.id)
                form.find('.prescription-name').text(prescription.name ?? prescription.code)
                form.find('.btn-print').attr('data-id', prescription.id)
                form.find('.btn-create-booking').attr('data-doctor_id', prescription.info.doctor_id).attr('data-pet_id', prescription.info.pet_id)
                form.find('[name="order_id"]').val(prescription.detail.order_id)
                form.find('[name="info_id"]').val(prescription.info_id)
                form.find('[name="name"]').val(prescription.name)
                form.find('[name="message"]').text(prescription.message)
            })
        })

        $(document).on('click', '.btn-prescription-export', function() {
            const form = $('#export-form'),
                id = $(this).attr('data-id')

            form.find(`#export-search-input`).closest('.row').remove()

            $.get(`{{ route('admin.prescription') }}/${id}/export`, function(prescription) {
                if (prescription) {
                    initCreateExport();
                    const doctor = prescription.info._doctor
                    form.find(`[name="note"]`).val('Xuất theo đơn thuốc ' + prescription.code)
                    form.find(`[name="receiver_id"]`).attr('readonly', true).html(
                        `<option value="${doctor.id}">${doctor.name} - ${doctor.phone}</option>`
                    )
                    form.find('[name="prescription_id"]').val(prescription.id)
                    form.find('[name="order_id"]').val(prescription.detail.order_id)
                    form.find(`[name=to_warehouse_id]`).closest('.form-group').addClass('d-none')
                    $.each(prescription.prescription_details, function(index, prescription_detail) {
                        var quantity = prescription_detail.quantity * prescription_detail.dosage * prescription_detail.frequency;
                        $.each(prescription_detail.stocks, function(e, stock) {
                            if (stock.quantity < quantity) {
                                var export_quantity = stock.quantity
                                quantity -= stock.quantity
                            } else {
                                var export_quantity = quantity
                            }

                            const str = `<div class="card border shadow-none mb-2 p-3 detail export-detail">
                                        <div class="row">
                                            <div class="col 12 col-lg-9">
                                                <p class="card-title mb-0">
                                                    ${stock.productName}
                                                    <input type="hidden" class="export_detail-stock_id" name="stock_ids[]" value="${stock.id}"/>
                                                    <a class="btn btn-link btn-export_detail-product_info rounded-pill p-0" data-id="${stock.id}" type="button">
                                                        <i class="bi bi-info-circle"></i>
                                                    </a>
                                                </p>
                                                <div class="badge bg-light-info">${stock.import_detail._variable._product.sku}</div>
                                                ${stock.stockExpired == null || stock.stockExpired == '' ? '' : `<div class="badge bg-light-info">HSD ${moment(stock.stockExpired).format('DD/MM/YYYY')}</div>`}
                                                <div class="badge bg-light-info">
                                                    Tồn kho ${stock.stockConvertQuantity}
                                                    <input type="hidden" class="export_detail-stock_quantity" name="stock_quantities[]" value="${stock.quantity}"/>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-3">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <select name="unit_ids[]" class="form-control form-control-lg form-control-plaintext bg-transparent export_detail-unit ps-3" disabled>
                                                            <option value="${stock.unit.id}" data-rate="${stock.unit.rate}" data-price="${stock.unit.price}" selected hidden>${stock.unit.term}</option>
                                                        </select>
                                                        <input type="hidden" class="export_detail-current_unit_id" name="current_unit_ids[]" value=${stock.unit.id}">
                                                        <input type="hidden" class="export_detail-current-quantity" name="current_quantities[]" value="${parseFloat(export_quantity).toFixed(2)}">
                                                    </div>
                                                    <div class="col-6 d-flex justify-content-between">
                                                        <input class="form-control-plaintext form-control-lg export_detail-quantity text-center money" name="quantities[]" type="text" value="${parseFloat(export_quantity).toFixed(2)}" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" name="notes[]" class="form-control form-control-lg form-control-plaintext export_detail-note" value="${prescription_detail.note ?? ''}" placeholder="Ghi chú món hàng"/>
                                            </div>
                                        </div>
                                    </div>`

                            form.find('.export-details').append(str)
                        })
                    })
                } else {
                    form.find('.modal').modal('hide')
                    pushToastify('Số thuốc trong kho hiện không đủ!', `danger`)
                }
            })
        })

        // Chỉ cho phép nhập số vào ô input và thực hiện so sánh min/max
        $(document).on("keyup", ".criterial-result", function() {
            const value = parseFloat($(this).val()),
                row = $(this).closest("tr"),
                min = parseFloat(row.attr('data-min')),
                max = parseFloat(row.attr('data-max')),
                review = row.find(`.criterial-review`);

            if (isNaN(value)) {
                review.val('');
                return;
            }

            if (!isNaN(min) && !isNaN(max)) {
                if (value < min) {
                    review.val('Thấp');
                } else if (value > max) {
                    review.val('Cao');
                } else {
                    review.val('Đạt');
                }
            }
        });

        /**
         * bloodcell VÀ Biochemical
         */

        $(document).on('click', '.btn-remove-criterial', function() {
            const table = $(this).closest('table');
            $(this).closest('tr').remove();

            table.find('tbody tr').each(function(index) {
                $(this).find('input').each(function() {
                    const name = $(this).attr('name');
                    if (name) {
                        const updatedName = name.replace(/\[([0-9]+)\]/, `[${index}]`);
                        $(this).attr('name', updatedName);
                    }
                });
            });
        });

        $(document).on("keyup", ".criterial-result", function() {
            const value = parseFloat($(this).val()),
                row = $(this).closest("tr"),
                min = parseFloat(row.attr('data-min')),
                max = parseFloat(row.attr('data-max')),
                review = row.find(`[name="criterial_reviews[]"]`);


            if (isNaN(value)) {
                review.val('');
                return;
            }

            if (!isNaN(min) && !isNaN(max)) {
                if (value < min) {
                    review.val('Thấp');
                } else if (value > max) {
                    review.val('Cao');
                } else {
                    review.val('Đạt');
                }
            }
        });

        // Ràng buộc chỉ cho phép nhập số, bao gồm số thập phân
        $(document).on("keypress", ".criterial-result", function(e) {
            const charCode = e.which;
            const currentValue = $(this).val();

            if ((charCode < 48 || charCode > 57) && charCode !== 46) {
                e.preventDefault();
            } else if (charCode === 46 && currentValue.includes(".")) {
                e.preventDefault();
            }
        });


        /**
         * Xử lý sự kiện hiện thị modal các phiếu con
         */

        // Ultrasound
        $(document).on('click', '.btn-update-ultrasound', function(e) {
            e.preventDefault();
            const id = $(this).attr('data-id'),
                form = $('#ultrasound-form');
            resetForm(form);
            $.get(`{{ route('admin.ultrasound') }}/${id}`, function(ultrasound) {
                const info = ultrasound.info,
                    pet = info._pet,
                    customer = pet._customer,
                    weight = info.weight;

                form.attr('action', `{{ route('admin.ultrasound.update') }}`).find('[name="id"]').val(ultrasound.id)
                form.find('.ultrasound-code').text(ultrasound.code)
                form.find('.btn-print').attr('data-id', ultrasound.id)
                form.find('img.ultrasound-pet-image').attr('src', pet.avatarUrl).attr('alt', pet.name)
                form.find('span.ultrasound-pet-name').attr('data-bs-title', pet.name).text(pet.name)
                const petInfor = `<small>${pet.animal.specie} ${pet.genderStr} ${pet.neuterIcon}</small>`;
                form.find('span.ultrasound-pet-infor').html(petInfor);
                form.find('span.ultrasound-pet-age').text(pet.age ? pet.age : "Không rõ")
                form.find('span.ultrasound-pet-lineage').text(pet.animal.lineage)
                form.find('span.ultrasound-pet-weight').text(weight + " kg")
                form.find('span.ultrasound-customer-name').text(customer.name)
                form.find('span.ultrasound-customer-gender small').text(customer.genderStr)
                const customerInfor = `${customer.phone ?? ''} <br/> ${customer.address ?? ''}`

                form.find('small.ultrasound-customer-infor').html(customerInfor)
                form.find('span.ultrasound-info-doctor').text(info._doctor.name)
                form.find('span.ultrasound-info-requirements').text(info.requirements.join(', '))
                form.find('span.ultrasound-info-prelim_diag').text(info.prelim_diag)
                form.find('span.ultrasound-info-technician').text(ultrasound.technician_id ? ultrasound._technician.name : '')
                form.find('span.ultrasound-service-name').text(ultrasound.detail._service.name)
                form.find(`[name="status"][value=${ultrasound.status}]`).prop('checked', true);
                form.find(`[name="conclusion"]`).val(ultrasound.conclusion)

                form.find('.ultrasound-list').empty()
                form.find('.ultrasound-details').empty();
                $.each(ultrasound.detail._service.criterials, function(index, criterial) {
                    const str = `<li class="list-group-item list-group-item-action rounded-3 border-0 cursor-pointer ultrasound-criterial p-1 py-2" data-name="${criterial.name}" data-description="${criterial.description ?? ''}" data-id="${criterial.id}">
                                        <label>${criterial.name}</label>
                                    </li>`
                    form.find('.ultrasound-list').append(str);
                });
                if (ultrasound.details) {
                    $.each(JSON.parse(ultrasound.details), function(index, detail) {

                        var str = ``;

                        $.each(ultrasound.galleryUrl[index], function(e, gallery) {
                            str += `<div class="col-6 col-lg-2 mt-2">
                                        <div class="card card-image mb-1">
                                            <div class="ratio ratio-1x1">
                                                <img src="${gallery}" class="thumb img-fluid object-fit-cover cursor-pointer rounded">
                                            </div>
                                        </div>
                                    </div>`
                        })
                        const newCard = `
                                <div class="card border shadow-none mb-2 detail ultrasound-detail" data-criterial-id="${detail.id}">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-12 col-lg-6">
                                                <div class="input-group justify-content-between">
                                                    <label class="input-group-text border-0 bg-transparent" for="ultrasound-criterial-${detail.id}">${detail.name}</label>
                                                    <button class="btn btn-link text-decoration-none btn-remove-detail remove-card remove-criterial" type="button"><i class="bi bi-trash"></i></button>
                                                </div>
                                                <input type="hidden" name="ultrasound_detail[${index}][id]" value="${detail.id}">
                                                <input type="hidden" name="ultrasound_detail[${index}][name]" value="${detail.name}">
                                                <div class="row align-items-center border border-light-subtle rounded-1 m-0" data-gallery="ultrasound-${detail.id}">
                                                    <div class="col-6 col-lg-2 mt-2">
                                                        <a class="btn-upload-images cursor-pointer" data-id="ultrasound-${detail.id}">
                                                            <div class="card text-primary add-gallery object-fit-cover ratio ratio-1x1 mb-2">
                                                                <i class="bi bi-plus"></i>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    ${str}
                                                </div>
                                                <input class="d-none image-array" data-id="ultrasound-${detail.id}" type="file" name="ultrasound_detail[${index}][images][]" accept="image/*" multiple>
                                            </div>
                                            <div class="col-12 col-lg-6 mb-2">
                                                <textarea class="form-control" id="ultrasound-criterial-${detail.id}" name="ultrasound_detail[${index}][note]" rows="3" placeholder="Mô tả kết quả" autocomplete="off">${detail.note ?? ''}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
                        form.find('.ultrasound-details').append(newCard);
                    })
                }
                form.find('.modal').modal('show')
            })
        })


        $(document).on('click', '.ultrasound-criterial', function() {
            const criterialId = $(this).attr('data-id'),
                name = $(this).attr('data-name'),
                description = $(this).attr('data-description'),
                form = $('#ultrasound-form'),
                i = $('.ultrasound-detail').length;

            if (!form.find(`.ultrasound-details [data-criterial-id="${criterialId}"]`).length) {
                const newCard = `
                        <div class="card border shadow-none mb-2 detail ultrasound-detail" data-criterial-id="${criterialId}">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <div class="input-group justify-content-between">
                                            <label class="input-group-text border-0 bg-transparent" for="ultrasound-criterial-${criterialId}">${name}</label>
                                            <button class="btn btn-link text-decoration-none btn-remove-detail remove-card remove-criterial" type="button"><i class="bi bi-trash"></i></button>
                                        </div>
                                        <input type="hidden" name="ultrasound_detail[${i}][id]" value="${criterialId}">
                                        <input type="hidden" name="ultrasound_detail[${i}][name]" value="${name}">
                                        <div class="row align-items-center border border-light-subtle rounded-1 m-0" data-gallery="ultrasound-${criterialId}">
                                            <div class="col-6 col-lg-2 mt-2">
                                                <a class="btn-upload-images cursor-pointer" data-id="ultrasound-${criterialId}">
                                                    <div class="card text-primary add-gallery object-fit-cover ratio ratio-1x1 mb-2">
                                                        <i class="bi bi-plus"></i>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <input class="d-none image-array" data-id="ultrasound-${criterialId}" type="file" name="ultrasound_detail[${i}][images][]" accept="image/*" multiple>
                                    </div>
                                    <div class="col-12 col-lg-6 mb-2">
                                        <textarea class="form-control" id="ultrasound-criterial-${criterialId}" name="ultrasound_detail[${i}][note]" rows="6" placeholder="Mô tả kết quả" autocomplete="off">${description ?? ''}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                form.find('.ultrasound-details').append(newCard);
            } else {
                pushToastify(`${name} đã được thêm!`, `danger`);
            }
        });

        // Xray
        $(document).on('click', '.btn-update-xray', function(e) {
            e.preventDefault();
            const id = $(this).attr('data-id'),
                form = $('#xray-form');
            resetForm(form);
            $.get(`{{ route('admin.xray') }}/${id}`, function(xray) {
                const info = xray.info,
                    pet = info._pet,
                    customer = pet._customer,
                    weight = info.weight;

                form.attr('action', `{{ route('admin.xray.update') }}`).find('[name="id"]').val(xray.id)
                form.find('.xray-code').text(xray.code)
                form.find('.btn-print').attr('data-id', xray.id)
                form.find('img.xray-pet-image').attr('src', pet.avatarUrl).attr('alt', pet.name)
                form.find('span.xray-pet-name').attr('data-bs-title', pet.name).text(pet.name)
                const petInfor = `<small>${pet.animal.specie} ${pet.genderStr} ${pet.neuterIcon}</small>`;
                form.find('span.xray-pet-infor').html(petInfor);
                form.find('span.xray-pet-age').text(pet.age ? pet.age : "Không rõ")
                form.find('span.xray-pet-lineage').text(pet.animal.lineage)
                form.find('span.xray-pet-weight').text(weight + " kg")
                form.find('span.xray-customer-name').text(customer.name)
                form.find('span.xray-customer-gender small').text(customer.genderStr)
                const customerInfor = `${customer.phone ?? ''} <br/> ${customer.address ?? ''}`

                form.find('small.xray-customer-infor').html(customerInfor)
                form.find('span.xray-info-doctor').text(info._doctor.name)
                form.find('span.xray-info-requirements').text(info.requirements.join(', '))
                form.find('span.xray-info-prelim_diag').text(info.prelim_diag)
                form.find('span.xray-info-technician').text(xray.technician_id ? xray._technician.name : '')
                form.find('span.xray-service-name').text(xray.detail._service.name)
                form.find(`[name="status"][value=${xray.status}]`).prop('checked', true);
                form.find(`[name="conclusion"]`).val(xray.conclusion)

                form.find('.xray-list').empty()
                form.find('.xray-details').empty();
                $.each(xray.detail._service.criterials, function(index, criterial) {
                    const str = `<li class="list-group-item list-group-item-action rounded-3 border-0 cursor-pointer xray-criterial p-1 py-2" data-name="${criterial.name}" data-description="${criterial.description ?? ''}" data-id="${criterial.id}">
                                        <label>${criterial.name}</label>
                                    </li>`
                    form.find('.xray-list').append(str);
                });
                if (xray.details) {
                    $.each(JSON.parse(xray.details), function(index, detail) {
                        var str = ``;
                        $.each(xray.galleryUrl[index], function(e, gallery) {
                            str += `<div class="col-6 col-lg-2 mt-2">
                                        <div class="card card-image mb-1">
                                            <div class="ratio ratio-1x1">
                                                <img src="${gallery}" class="thumb img-fluid object-fit-cover cursor-pointer rounded">
                                            </div>
                                        </div>
                                    </div>`
                        })
                        const newCard = `
                                <div class="card border shadow-none mb-2 detail xray-detail" data-criterial-id="${detail.id}">
                                    <div class="card-body p-3">
                                        <div class="row">
                                            <div class="col-12 col-lg-6">
                                                <div class="input-group justify-content-between">
                                                    <label class="input-group-text border-0 bg-transparent" for="xray-criterial-${detail.id}">${detail.name}</label>
                                                    <button class="btn btn-link text-decoration-none btn-remove-detail remove-card remove-criterial" type="button"><i class="bi bi-trash"></i></button>
                                                </div>
                                                <input type="hidden" name="xray_detail[${index}][id]" value="${detail.id}">
                                                <input type="hidden" name="xray_detail[${index}][name]" value="${detail.name}">
                                                <div class="row align-items-center border border-light-subtle rounded-1 m-0" data-gallery="xray-${detail.id}">
                                                    <div class="col-6 col-lg-2 mt-2">
                                                        <a class="btn-upload-images cursor-pointer" data-id="xray-${detail.id}">
                                                            <div class="card text-primary add-gallery object-fit-cover ratio ratio-1x1 mb-2">
                                                                <i class="bi bi-plus"></i>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    ${str}
                                                </div>
                                                <input class="d-none image-array" data-id="xray-${detail.id}" type="file" name="xray_detail[${index}][images][]" accept="image/*" multiple>
                                            </div>
                                            <div class="col-12 col-lg-6 mb-2">
                                                <textarea class="form-control" id="xray-criterial-${detail.id}" name="xray_detail[${index}][note]" rows="3" placeholder="Mô tả kết quả" autocomplete="off">${detail.note ?? ''}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
                        form.find('.xray-details').append(newCard);
                    })
                }
                form.find('.modal').modal('show')
            })
        })

        $(document).on('click', '.xray-criterial', function() {
            const criterialId = $(this).attr('data-id'),
                name = $(this).attr('data-name'),
                description = $(this).attr('data-description'),
                form = $('#xray-form'),
                i = $('.xray-detail').length;

            if (!form.find(`.xray-details [data-criterial-id="${criterialId}"]`).length) {
                const newCard = `
                        <div class="card border shadow-none mb-2 detail xray-detail " data-criterial-id="${criterialId}">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <div class="input-group justify-content-between">
                                            <label class="input-group-text border-0 bg-transparent" for="xray-criterial-${criterialId}">${name}</label>
                                            <button class="btn btn-link text-decoration-none btn-remove-detail remove-card remove-criterial" type="button"><i class="bi bi-trash"></i></button>
                                        </div>
                                        <input type="hidden" name="xray_detail[${i}][id]" value="${criterialId}">
                                        <input type="hidden" name="xray_detail[${i}][name]" value="${name}">
                                        <div class="row align-items-center border border-light-subtle rounded-1 m-0" data-gallery="xray-${criterialId}">
                                            <div class="col-6 col-lg-2 mt-2">
                                                <a class="btn-upload-images cursor-pointer" data-id="xray-${criterialId}">
                                                    <div class="card text-primary add-gallery object-fit-cover ratio ratio-1x1 mb-2">
                                                        <i class="bi bi-plus"></i>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <input class="d-none image-array" data-id="xray-${criterialId}" type="file" name="xray_detail[${i}][images][]" accept="image/*" multiple>
                                    </div>
                                    <div class="col-12 col-lg-6 mb-2">
                                        <textarea class="form-control" id="xray-criterial-${criterialId}" name="xray_detail[${i}][note]" rows="6" placeholder="Mô tả kết quả" autocomplete="off">${description ?? ''}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                form.find('.xray-details').append(newCard);
            } else {
                pushToastify(`${name} đã được thêm!`, `danger`);
            }
        });

        // Microscope
        $(document).on('click', '.btn-update-microscope', function(e) {
            e.preventDefault();
            const id = $(this).attr('data-id'),
                form = $('#microscope-form');
            resetForm(form);
            $.get(`{{ route('admin.microscope') }}/${id}`, function(microscope) {
                const info = microscope.info,
                    pet = info._pet,
                    customer = pet._customer,
                    weight = info.weight;
                form.find('[data-gallery="microscope-images"]').children().not(':first').remove();

                form.attr('action', `{{ route('admin.microscope.update') }}`).find('[name="id"]').val(microscope.id)
                form.find('.microscope-code').text(microscope.code)
                form.find('.btn-print').attr('data-id', microscope.id)
                form.find('img.microscope-pet-image').attr('src', pet.avatarUrl).attr('alt', pet.name)
                form.find('span.microscope-pet-name').attr('data-bs-title', pet.name).text(pet.name)
                const petInfor = `<small>${pet.animal.specie} ${pet.genderStr} ${pet.neuterIcon}</small>`;
                form.find('span.microscope-pet-infor').html(petInfor);
                form.find('span.microscope-pet-age').text(pet.age ? pet.age : "Không rõ")
                form.find('span.microscope-pet-lineage').text(pet.animal.lineage)
                form.find('span.microscope-pet-weight').text(weight + " kg")
                form.find('span.microscope-customer-name').text(customer.name)
                form.find('span.microscope-customer-gender small').text(customer.genderStr)
                const customerInfor = `${customer.phone ?? ''} <br/> ${customer.address ?? ''}`

                form.find('small.microscope-customer-infor').html(customerInfor)
                form.find('span.microscope-info-doctor').text(info._doctor.name)
                form.find('span.microscope-info-requirements').text(info.requirements.join(', '))
                form.find('span.microscope-info-prelim_diag').text(info.prelim_diag)
                form.find('span.microscope-info-technician').text(microscope.technician_id ? microscope._technician.name : '')
                form.find('span.microscope-service-name').text(microscope.detail._service.name)

                form.find('[name="sample"]').val(microscope.sample)
                form.find('[name="method"]').val(microscope.method)
                form.find('[name="recommendation"]').val(microscope.recommendation)
                form.find('[name="conclusion"]').val(microscope.conclusion)
                form.find(`[name="status"][value="${microscope.status}"]`).prop('checked', true)

                $.each(microscope.galleryUrl, function(index, imagePath) {
                    const id = 'microscope-images',
                        gallery = $(`div[data-gallery="${id}"]`),
                        imageName = imagePath.split('/').pop(),
                        imageDiv = $(`<div class="col-6 col-lg-2 mt-2">
                                                <div class="card card-image mb-1">
                                                    <div class="ratio ratio-1x1">
                                                        <img src="${imagePath}" class="thumb img-fluid object-fit-cover cursor-pointer rounded" alt="microscope-images">
                                                    </div>
                                                </div>
                                            </div>`);

                    gallery.append(imageDiv);
                });
            })
            form.find('.modal').modal('show')
        })

        // Quick test
        $(document).on('click', '.btn-update-quicktest', function(e) {
            e.preventDefault();
            const id = $(this).attr('data-id'),
                form = $('#quicktest-form');
            resetForm(form);
            $.get(`{{ route('admin.quicktest') }}/${id}`, function(quicktest) {
                const info = quicktest.info,
                    pet = info._pet,
                    customer = pet._customer,
                    weight = info.weight;

                form.find('[data-gallery="quicktest-images"]').children().not(':first').remove();
                form.attr('action', `{{ route('admin.quicktest.update') }}`).find('[name="id"]').val(quicktest.id)
                form.find('.quicktest-code').text(quicktest.code)
                form.find('.btn-print').attr('data-id', quicktest.id)
                form.find('img.quicktest-pet-image').attr('src', pet.avatarUrl).attr('alt', pet.name)
                form.find('span.quicktest-pet-name').attr('data-bs-title', pet.name).text(pet.name)
                const petInfor = `<small>${pet.animal.specie} ${pet.genderStr} ${pet.neuterIcon}</small>`;
                form.find('span.quicktest-pet-info').html(petInfor);
                form.find('span.quicktest-pet-age').text(pet.age ? pet.age : "Không rõ")
                form.find('span.quicktest-pet-lineage').text(pet.animal.lineage)
                form.find('span.quicktest-pet-weight').text(weight + " kg")
                form.find('span.quicktest-customer-name').text(customer.name)
                form.find('span.quicktest-customer-gender small').text(customer.genderStr)
                const customerInfor = `${customer.phone ?? ''} <br/> ${customer.address ?? ''}`

                form.find('small.quicktest-customer-info').html(customerInfor)
                form.find('span.quicktest-info-doctor').text(info._doctor.name)
                form.find('span.quicktest-info-requirements').text(info.requirements.join(', '))
                form.find('span.quicktest-info-prelim_diag').text(info.prelim_diag)
                form.find('span.quicktest-info-technician').text(quicktest.technician_id ? quicktest._technician.name : '')
                form.find('span.quicktest-service-name').text(quicktest.detail._service.name)

                form.find('[name="sample"]').val(quicktest.sample)
                form.find('[name="method"]').val(quicktest.method)
                form.find('[name="recommendation"]').val(quicktest.recommendation)
                form.find('[name="conclusion"]').val(quicktest.conclusion)
                form.find(`[name="status"][value="${quicktest.status}"]`).prop('checked', true)

                $.each(quicktest.galleryUrl, function(index, imagePath) {
                    const id = 'quicktest-images',
                        gallery = $(`div[data-gallery="${id}"]`),
                        imageName = imagePath.split('/').pop(),
                        imageDiv = $(`<div class="col-6 col-lg-2 mt-2">
                                                <div class="card card-image mb-1">
                                                    <div class="ratio ratio-1x1">
                                                        <img src="${imagePath}" class="thumb img-fluid object-fit-cover cursor-pointer rounded" alt="quicktest-images">
                                                    </div>
                                                </div>
                                            </div>`);
                    gallery.append(imageDiv);
                });
                form.find('.modal').modal('show')
            })
        })

        // Biochemical test
    $(document).on('click', '.btn-add-all', function() {
        $(this).closest('.search-container').next().find('.search-list li').each(function() {
            $(this).trigger('click');
        })
    })

        $(document).on('click', '.btn-update-biochemical', function(e) {
            e.preventDefault();
            const id = $(this).attr('data-id'),
                form = $('#biochemical-form');
            resetForm(form);
            $.get(`{{ route('admin.biochemical') }}/${id}`, function(biochemical) {
                const info = biochemical.info,
                    pet = info._pet,
                    customer = pet._customer,
                    weight = info.weight;

                form.find('[data-gallery="biochemical-images"]').children().not(':first').remove();
                form.attr('action', `{{ route('admin.biochemical.update') }}`).find('[name="id"]').val(biochemical.id)
                form.find('.biochemical-code').text(biochemical.code)
                form.find('.btn-print').attr('data-id', biochemical.id)
                form.find('img.biochemical-pet-image').attr('src', pet.avatarUrl).attr('alt', pet.name)
                form.find('span.biochemical-pet-name').attr('data-bs-title', pet.name).text(pet.name)
                const petInfor = `<small>${pet.animal.specie} ${pet.genderStr} ${pet.neuterIcon}</small>`;
                form.find('span.biochemical-pet-infor').html(petInfor);
                form.find('span.biochemical-pet-age').text(pet.age ? pet.age : "Không rõ")
                form.find('span.biochemical-pet-lineage').text(pet.animal.lineage)
                form.find('span.biochemical-pet-weight').text(weight + " kg")
                form.find('span.biochemical-customer-name').text(customer.name)
                form.find('span.biochemical-customer-gender small').text(customer.genderStr)
                const customerInfor = `${customer.phone ?? ''} <br/> ${customer.address ?? ''}`
                form.find('small.biochemical-customer-infor').html(customerInfor)
                form.find('span.biochemical-info-doctor').text(info._doctor.name)
                form.find('span.biochemical-info-requirements').text(info.requirements.join(', '))
                form.find('span.biochemical-info-prelim_diag').text(info.prelim_diag)
                form.find('span.biochemical-info-technician').text(biochemical.technician_id ? biochemical._technician.name : '')
                form.find('span.biochemical-service-name').text(biochemical.detail._service.name)
                form.find(`[name="status"][value=${biochemical.status}]`).prop('checked', true);
                form.find(`[name="conclusion"]`).val(biochemical.conclusion)
                form.find(`[name="recommendation"]`).val(biochemical.recommendation)

                form.find('.biochemical-list').empty()
                form.find('.biochemical-details').empty();
                $.each(biochemical.detail._service.criterials, function(index, criterial) {
                    const normalIndex = JSON.parse(criterial.normal_index);
                    if (normalIndex) {
                        const specieIndices = normalIndex.filter(item => item.specie === pet.animal
                            .specie);
                        let matchedSpecie = null;
                        if (specieIndices.length > 0 && pet.age !== null) {
                            const petAgeText = pet.age;
                            const yearMatch = petAgeText.match(/(\d+)\s*tuổi/);
                            const monthMatch = petAgeText.match(/(\d+)\s*tháng/);

                            const ageInYears = (parseInt(yearMatch?.[1] || 0, 10)) + (parseInt(
                                monthMatch?.[1] || 0, 10) / 12);

                            matchedSpecie = specieIndices.find(item => ageInYears <= item
                                .age_max) || null;
                        }
                        const min = matchedSpecie?.min_max[0] ?? '';
                        const max = matchedSpecie?.min_max[1] ?? '';
                        const str = `<li class="list-group-item list-group-item-action rounded-3 border-0 cursor-pointer biochemical-criterial p-1 py-2"
                                        data-min="${min}" data-max="${max}" data-unit="${criterial.unit ?? ''}" data-name="${criterial.name}"
                                        data-description="${criterial.description ?? ''}" data-id="${criterial.id}">
                                        <label>${criterial.name}</label>
                                    </li>`;
                        form.find('.biochemical-list').append(str);
                    }
                });
                if (biochemical.details) {
                    $.each(JSON.parse(biochemical.details), function(index, detail) {
                        const normal_index = JSON.parse(detail.normal_index),
                            min = normal_index ? normal_index[0] : '',
                            max = normal_index ? normal_index[1] : '',
                            newCard = `<tr class="biochemical-detail" data-criterial-id="${detail.id}" data-min="${min}" data-max="${max}">
                                            <td><strong>${detail.name}</strong>${(min !== '' && max !== '') ? ` • ${min} - ${max}` : ''} ${detail.unit ? `(${detail.unit})` : ''}
                                                <br /><small>${detail.description ?? ''}</small>
                                                <input type="hidden" name="biochemical_detail[${index}][id]" value="${detail.id}">
                                                <input type="hidden" name="biochemical_detail[${index}][normal_index]" value="${(min !== '' && max !== '') ? '[' + min + ','+ max + ']' : ''}">
                                                <input type="hidden" name="biochemical_detail[${index}][unit]" value="${detail.unit ?? ''}">
                                                <input type="hidden" name="biochemical_detail[${index}][name]" value="${detail.name ?? ''}">
                                                <input type="hidden" name="biochemical_detail[${index}][description]" value="${detail.description ?? ''}">
                                            </td>
                                            <td>
                                                <input type="text" name="biochemical_detail[${index}][result]" value="${detail.result ?? ''}" class="form-control form-control-plaintext text-center criterial-result" placeholder="Nhập kết quả" autocomplete="off">
                                            </td>
                                            <td>
                                                <input type="text" name="biochemical_detail[${index}][review]" value="${detail.review ?? ''}" class="form-control bg-transparent border-0 text-center criterial-review" readonly>
                                            </td>
                                            <td>
                                                <button class="btn btn-link text-decoration-none btn-remove-criterial">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </td>
                                        </tr>`;
                        form.find('.biochemical-details').append(newCard);
                    })
                }
                $.each(biochemical.galleryUrl, function(e, gallery) {
                    const str = `<div class="col-6 col-lg-2 mt-2">
                                        <div class="card card-image mb-1">
                                            <div class="ratio ratio-1x1">
                                                <img src="${gallery}" class="thumb img-fluid object-fit-cover cursor-pointer rounded" alt="quicktest-images">
                                            </div>
                                        </div>
                                    </div>`
                    form.find(`[data-gallery="biochemical-images"]`).append(str)
                })
                form.find('.modal').modal('show')
            })
        })

        $(document).on('click', '.biochemical-criterial', function() {
            const name = $(this).attr('data-name'),
                description = $(this).attr('data-description'),
                min = $(this).attr('data-min'),
                max = $(this).attr('data-max'),
                unit = $(this).attr('data-unit'),
                id = $(this).attr('data-id'),
                form = $('#biochemical-form'),
                i = $('.biochemical-detail').length;

            if (!form.find(`.biochemical-details [data-criterial-id="${id}"]`).length) {
                const newRow = `<tr class="biochemical-detail" data-criterial-id="${id}" data-min="${min}" data-max="${max}">
                                    <td><strong>${name}</strong>${(min !== '' && max !== '') ? ` • ${min} - ${max}` : ''} ${unit ? `(${unit})` : ''}
                                        <br /><small>${description ?? ''}</small>
                                        <input type="hidden" name="biochemical_detail[${i}][id]" value="${id}">
                                        <input type="hidden" name="biochemical_detail[${i}][normal_index]" value="${(min !== '' && max !== '') ? '[' + min + ','+ max + ']' : ''}">
                                        <input type="hidden" name="biochemical_detail[${i}][unit]" value="${unit}">
                                        <input type="hidden" name="biochemical_detail[${i}][name]" value="${name}">
                                        <input type="hidden" name="biochemical_detail[${i}][description]" value="${description}">
                                    </td>
                                    <td>
                                        <input type="text" name="biochemical_detail[${i}][result]" class="form-control form-control-plaintext text-center criterial-result" placeholder="Nhập kết quả" autocomplete="off">
                                    </td>
                                    <td>
                                        <input type="text" name="biochemical_detail[${i}][review]" class="form-control bg-transparent border-0 text-center criterial-review" readonly>
                                    </td>
                                    <td>
                                        <button class="btn btn-link text-decoration-none btn-remove-criterial">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </td>
                                </tr>`;
                form.find('.biochemical-details').append(newRow);
            } else {
                pushToastify(`${name} đã được thêm!`, `danger`);
            }
        });

        // Bloodcell test
        $(document).on('click', '.btn-update-bloodcell', function(e) {
            e.preventDefault();
            const id = $(this).attr('data-id'),
                form = $('#bloodcell-form');
            resetForm(form);
            $.get(`{{ route('admin.bloodcell') }}/${id}`, function(bloodcell) {
                const info = bloodcell.info,
                    pet = info._pet,
                    customer = pet._customer,
                    weight = info.weight;
                form.find('[data-gallery="bloodcell-images"]').children().not(':first').remove();
                form.attr('action', `{{ route('admin.bloodcell.update') }}`).find('[name="id"]').val(bloodcell.id)
                form.find('.bloodcell-code').text(bloodcell.code)
                form.find('.btn-print').attr('data-id', bloodcell.id)
                form.find('img.bloodcell-pet-image').attr('src', pet.avatarUrl).attr('alt', pet.name)
                form.find('span.bloodcell-pet-name').attr('data-bs-title', pet.name).text(pet.name)
                const petInfor = `<small>${pet.animal.specie} ${pet.genderStr} ${pet.neuterIcon}</small>`;
                form.find('span.bloodcell-pet-infor').html(petInfor);
                form.find('span.bloodcell-pet-age').text(pet.age ? pet.age : "Không rõ")
                form.find('span.bloodcell-pet-lineage').text(pet.animal.lineage)
                form.find('span.bloodcell-pet-weight').text(weight + " kg")

                form.find('span.bloodcell-customer-name').text(customer.name)
                form.find('span.bloodcell-customer-gender small').text(customer.genderStr)
                const customerInfor = `${customer.phone ?? ''} <br/> ${customer.address ?? ''}`
                form.find('small.bloodcell-customer-infor').html(customerInfor)

                form.find('span.bloodcell-info-doctor').text(info._doctor.name)
                form.find('span.bloodcell-info-requirements').text(info.requirements.join(', '))
                form.find('span.bloodcell-info-prelim_diag').text(info.prelim_diag)
                form.find('span.bloodcell-info-technician').text(bloodcell.technician_id ? bloodcell._technician.name : '')
                form.find('span.bloodcell-service-name').text(bloodcell.detail._service.name)
                form.find(`[name="status"][value=${bloodcell.status}]`).prop('checked', true);
                form.find(`[name="conclusion"]`).val(bloodcell.conclusion)
                form.find(`[name="recommendation"]`).val(bloodcell.recommendation)

                form.find('.bloodcell-list').empty()
                form.find('.bloodcell-details').empty();
                $.each(bloodcell.detail._service.criterials, function(index, criterial) {
                    const normalIndex = JSON.parse(criterial.normal_index);
                    if (normalIndex) {
                        const specieIndices = normalIndex.filter(item => item.specie === pet.animal
                            .specie);
                        let matchedSpecie = null;
                        if (specieIndices.length > 0 && pet.age !== null) {
                            const petAgeText = pet.age;
                            const yearMatch = petAgeText.match(/(\d+)\s*tuổi/);
                            const monthMatch = petAgeText.match(/(\d+)\s*tháng/);

                            const ageInYears = (parseInt(yearMatch?.[1] || 0, 10)) + (parseInt(
                                monthMatch?.[1] || 0, 10) / 12);

                            matchedSpecie = specieIndices.find(item => ageInYears <= item
                                .age_max) || null;
                        }
                        const min = matchedSpecie?.min_max[0] ?? '';
                        const max = matchedSpecie?.min_max[1] ?? '';
                        const str = `<li class="list-group-item list-group-item-action rounded-3 border-0 cursor-pointer bloodcell-criterial p-1 py-2"
                                        data-min="${min}" data-max="${max}" data-unit="${criterial.unit ?? ''}" data-name="${criterial.name}"
                                        data-description="${criterial.description ?? ''}" data-id="${criterial.id}">
                                        <label>${criterial.name}</label>
                                    </li>`;
                        form.find('.bloodcell-list').append(str);
                    }
                });
                if (bloodcell.details) {
                    $.each(JSON.parse(bloodcell.details), function(index, detail) {
                        const normal_index = detail.normal_index ? JSON.parse(detail.normal_index) : '',
                            min = normal_index ? normal_index[0] : '',
                            max = normal_index ? normal_index[1] : '',
                            newCard = `<tr class="bloodcell-detail" data-criterial-id="${detail.id}" data-min="${min}" data-max="${max}">
                                                <td><strong>${detail.name}</strong>${(min !== '' && max !== '') ? ` • ${min} - ${max}` : ''} ${detail.unit ? `(${detail.unit})` : ''}
                                                    <br /><small>${detail.description ?? ''}</small>
                                                    <input type="hidden" name="bloodcell_detail[${index}][id]" value="${detail.id}">
                                                    <input type="hidden" name="bloodcell_detail[${index}][normal_index]" value="${(min !== '' && max !== '') ? '[' + min + ','+ max + ']' : ''}">
                                                    <input type="hidden" name="bloodcell_detail[${index}][unit]" value="${detail.unit ?? ''}">
                                                    <input type="hidden" name="bloodcell_detail[${index}][name]" value="${detail.name ?? ''}">
                                                    <input type="hidden" name="bloodcell_detail[${index}][description]" value="${detail.description ?? ''}">
                                                </td>
                                                <td>
                                                    <input type="text" name="bloodcell_detail[${index}][result]" value="${detail.result ?? ''}" class="form-control form-control-plaintext text-center criterial-result" placeholder="Nhập kết quả" autocomplete="off">
                                                </td>
                                                <td>
                                                    <input type="text" name="bloodcell_detail[${index}][review]" value="${detail.review ?? ''}" class="form-control bg-transparent border-0 text-center criterial-review" readonly>
                                                </td>
                                                <td>
                                                    <button class="btn btn-link text-decoration-none btn-remove-criterial">
                                                        <i class="bi bi-trash3"></i>
                                                    </button>
                                                </td>
                                            </tr>`;
                        form.find('.bloodcell-details').append(newCard);
                    })
                }
                $.each(bloodcell.galleryUrl, function(e, gallery) {
                    const str = `<div class="col-6 col-lg-2 mt-2">
                                <div class="card card-image mb-1">
                                    <div class="ratio ratio-1x1">
                                        <img src="${gallery}" class="thumb img-fluid object-fit-cover cursor-pointer rounded" alt="quicktest-images">
                                    </div>
                                </div>
                            </div>`
                    form.find(`[data-gallery="bloodcell-images"]`).append(str)
                })
                form.find('.modal').modal('show')
            })
        })

        $(document).on('click', '.bloodcell-criterial', function() {
            const name = $(this).attr('data-name'),
                description = $(this).attr('data-description'),
                min = $(this).attr('data-min'),
                max = $(this).attr('data-max'),
                unit = $(this).attr('data-unit'),
                id = $(this).attr('data-id'),
                form = $('#bloodcell-form'),
                i = $('.bloodcell-detail').length;

            if (!form.find(`.bloodcell-details [data-criterial-id="${id}"]`).length) {
                const newRow = `<tr class="bloodcell-detail" data-criterial-id="${id}" data-min="${min}" data-max="${max}">
                                        <td><strong>${name}</strong>${(min !== '' && max !== '') ? ` • ${min} - ${max}` : ''} ${unit ? `(${unit})` : ''}
                                            <br /><small>${description ?? ''}</small>
                                            <input type="hidden" name="bloodcell_detail[${i}][id]" value="${id}">
                                            <input type="hidden" name="bloodcell_detail[${i}][normal_index]" value="${(min !== '' && max !== '') ? '[' + min + ','+ max + ']' : ''}">
                                            <input type="hidden" name="bloodcell_detail[${i}][unit]" value="${unit}">
                                            <input type="hidden" name="bloodcell_detail[${i}][name]" value="${name}">
                                            <input type="hidden" name="bloodcell_detail[${i}][description]" value="${description}">
                                        </td>
                                        <td>
                                            <input type="text" name="bloodcell_detail[${i}][result]" class="form-control form-control-plaintext text-center criterial-result" placeholder="Nhập kết quả" autocomplete="off">
                                        </td>
                                        <td>
                                            <input type="text" name="bloodcell_detail[${i}][review]" class="form-control bg-transparent border-0 text-center criterial-review" readonly>
                                        </td>
                                        <td>
                                            <button class="btn btn-link text-decoration-none btn-remove-criterial">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </td>
                                    </tr>`;
            form.find('.bloodcell-details').append(newRow);
        } else {
            pushToastify(`${name} đã được thêm!`, `danger`);
        }
    });

    // Service

    $(document).on('click', '.btn-update-service', function(e) {
        e.preventDefault();
        const id = $(this).attr('data-id'),
            form = $('#service-form')
        $.get(`{{ route('admin.service') }}/${id}`, function(service) {
            resetForm(form)
            form.find(`[name=id]`).val(service.id)
            form.find(`[name=name]`).val(service.name)
            form.find(`[name=unit]`).val(service.unit)
            form.find(`[name=price]`).val(service.price)
            form.find(`[name=commission]`).val(service.commission)
            form.find(`[name=major_id]`).val(service.major_id)
            form.find(`[name=ticket]`).val(service.ticket)
            form.find(`[name=status]`).val(service.status)
            form.find(`[name=is_indicated]`).prop('checked', service.is_indicated)
            form.find(`[type=checkbox][name=commitment_required]`).prop('checked', service
                .commitment_required);
            form.find(`[name=commitment_note]`).val(service.commitment_note || '');
            toggleCommitment();
            if (service.major_id) {
                const major = new Option(service.major.name, service.major.id, true, true)
                $(`[name='major_id']`).html(major).trigger({
                    type: 'select2:select'
                });
            }
            let options = ``
            service.criterials.forEach(criterial => {
                options +=
                    `<option value="${criterial.id}" selected>${criterial.name}</option>`
            });
            $(`[name='criterial[]']`).html(options).trigger({
                type: 'select2:select'
            });
            form.attr('action', `{{ route('admin.service.save') }}`)
            form.find('.modal').modal('show')
        })
    })

    function toggleCommitment() {
        var isChecked = $('#service-commitment_required').is(':checked');
        $('#commitment-container').toggle(isChecked);
        if (isChecked) {
            $('#commitment').attr('name', 'commitment');
        } else {
            $('#commitment').removeAttr('name');
        }
    }
    $('#service-commitment_required').on('change', toggleCommitment);

        // Surgery
        $(document).on('click', '.btn-update-surgery', function(e) {
            e.preventDefault();
            const id = $(this).attr('data-id'),
                form = $('#surgery-form');
            resetForm(form);

            $.get(`{{ route('admin.surgery') }}/${id}`, function(surgery) {
                const info = surgery.info,
                    pet = info._pet,
                    customer = pet._customer,
                    weight = info.weight;

            form.attr('action', `{{ route('admin.surgery.update') }}`).find('[name="id"]').val(surgery
                .id)
            form.find('.surgery-gallery').each(function() {
                $(this).children().not(':first').remove();
            })
            form.find('.surgery-code').text(surgery.code)
            form.find('.btn-print.print-surgery').attr('data-id', surgery.id)
            form.find('.btn-print.print-commitment').attr('data-id', surgery._detail
                .service_id)
            form.find('img.surgery-pet-image').attr('src', pet.avatarUrl).attr('alt', pet.name)
            form.find('span.surgery-pet-name').attr('data-bs-title', pet.name).text(pet.name)
            const petInfor = `<small>${pet.animal.specie} ${pet.genderStr} ${pet.neuterIcon}</small>`;
            form.find('span.surgery-pet-infor').html(petInfor);
            form.find('span.surgery-pet-age').text(pet.age ? pet.age : "Không rõ")
            form.find('span.surgery-pet-lineage').text(pet.animal.lineage)
            form.find('span.surgery-pet-weight').text(weight + " kg")
            form.find('span.surgery-customer-name').text(customer.name)
            form.find('span.surgery-customer-gender small').text(customer.genderStr)
            const customerInfor = `${customer.phone ?? ''} <br/> ${customer.address ?? ''}`

                form.find('small.surgery-customer-infor').html(customerInfor)
                form.find('span.surgery-info-doctor').text(info._doctor.name)
                form.find('span.surgery-info-requirements').text(info.requirements.join(', '))
                form.find('span.surgery-info-prelim_diag').text(info.prelim_diag)
                form.find('span.surgery-service-name').text(surgery.detail._service.name)
                form.find(`[name="status"][value=${surgery.status}]`).prop('checked', true);

                var doctor_str = '<option selected disabled hidden>Chọn bác sĩ thực hiện</option>';
                $.each(surgery.doctor, function(index, doctor) {
                    doctor_str += `<option value = "${doctor.id}"> ${doctor.name} </option>`
                })
                form.find('.surgery-doctor').html(doctor_str)
                form.find(`[name=surgical_method]`).val(surgery.surgical_method)
                form.find(`[name=anesthesia_method]`).val(surgery.anesthesia_method)
                form.find(`[name=surgeon_id]`).find(`option[value="${surgery.surgeon_id}"]`).attr('selected', true)
                form.find(`[name=assistant_id]`).find(`option[value="${surgery.assistant_id}"]`).attr('selected', true)
                form.find(`[name=anesthetist_id]`).find(`option[value="${surgery.anesthetist_id}"]`).attr('selected', true)
                form.find(`[name="advice"]`).val(surgery.advice)

                if (surgery.begin_at) {
                    $('[name=begin_at]').val(surgery.begin_at.split(' ')[0] + 'T' + surgery.begin_at.split(' ')[1].substring(0, 5));
                }
                if (surgery.complete_at) {
                    $('[name=complete_at]').val(surgery.complete_at.split(' ')[0] + 'T' + surgery.complete_at.split(' ')[1].substring(0, 5));
                }
                form.find('table.surgery-details thead tr').html(surgery.table_details.head);
                form.find('table.surgery-details tbody').html(surgery.table_details.body)
                createEmptyCell()

                form.find('.surgery-diagrams').empty()
                if (surgery.diagram) {
                    $.each(JSON.parse(surgery.diagram), function(index, diagram) {
                        const newRow = `<tr class="surgery-diagram">
                                                <td>
                                                    <input class="form-control" name="diagram[${index}][0]" type="time" value="${diagram[0]}">
                                                </td>
                                                <td>
                                                    <input class="form-control form-control-plaintext text-star" name="diagram[${index}][1]" type="text" value="${diagram[1] ?? ''}" placeholder="Nhập nội dung" autocomplete="off">
                                                </td>
                                                <td>
                                                    <button class="btn btn-link text-decoration-none btn-remove-diagram"><i class="bi bi-trash3"></i></button>
                                                </td>
                                            </tr>`;
                        form.find('.surgery-diagrams').append(newRow);
                    })
                }

                if (surgery.galleryUrl.before) {
                    $.each(surgery.galleryUrl.before, function(index, imagePath) {
                        const gallery = $(`div[data-gallery="surgery-images_before"]`),
                            imageName = imagePath.split('/').pop(),
                            imageDiv = $(`<div class="col-6 col-lg-2 mt-2">
                                                <div class="card card-image mb-1">
                                                    <div class="ratio ratio-1x1">
                                                        <img src="${imagePath}" class="thumb img-fluid object-fit-cover cursor-pointer rounded" alt="quicktest-images">
                                                    </div>
                                                </div>
                                            </div>`);
                        gallery.append(imageDiv);
                    });

                }

                if (surgery.galleryUrl.after) {
                    $.each(surgery.galleryUrl.after, function(index, imagePath) {
                        const gallery = $(`div[data-gallery="surgery-images_after"]`),
                            imageName = imagePath.split('/').pop(),
                            imageDiv = $(`<div class="col-6 col-lg-2 mt-2">
                                                <div class="card card-image mb-1">
                                                    <div class="ratio ratio-1x1">
                                                        <img src="${imagePath}" class="thumb img-fluid object-fit-cover cursor-pointer rounded" alt="quicktest-images">
                                                    </div>
                                                </div>
                                            </div>`);
                        gallery.append(imageDiv);
                    });
                }
                form.find('.modal').modal('show')
            })
        })

        $(document).on('click', '.btn-create-diagram', function() {
            var index = $('#surgery-form').find('tr.surgery-diagram').length;
            const newRow = `<tr class="surgery-diagram">
                            <td>
                                <input class="form-control" name="diagram[${index}][0]" type="time">
                            </td>
                            <td>
                                <input class="form-control form-control-plaintext text-star" name="diagram[${index}][1]" type="text" placeholder="Nhập nội dung" autocomplete="off">
                            </td>
                            <td>
                                <button class="btn btn-link text-decoration-none btn-remove-diagram"><i class="bi bi-trash3"></i></button>
                            </td>
                        </tr>`;
            $('.surgery-diagrams').append(newRow);
        });

        $(document).on('click', '.btn-remove-diagram', function() {
            const table = $(this).closest('table');
            $(this).closest('tr').remove();

            table.find('tbody tr').each(function(index) {
                $(this).find('input').each(function() {
                    const name = $(this).attr('name');
                    if (name) {
                        const updatedName = name.replace(/\[([0-9]+)\]/, `[${index}]`);
                        $(this).attr('name', updatedName);
                    }
                });
            });
        });

        $(document).on('click', '.btn-remove-detail-row', function() {
            $(this).closest('tr').addClass('bg-light-secondary');

            Swal.fire(config.sweetAlert.confirm).then((result) => {
                if (result.isConfirmed) {
                    table = $(this).closest('table');
                    $(this).closest('tr').remove()
                    renameSurgeryDetails(table);
                } else {
                    $(this).closest('tr').removeClass('bg-light-secondary')
                }
            });
        })

        $(document).on('click', '.btn-remove-detail-column', function() {
            const columnIndex = $(this).closest('th').index();
            $("table.surgery-details tr").each(function() {
                $(this).find("td, th").eq(columnIndex).attr('style', 'background: #e6eaee');
            });

            Swal.fire(config.sweetAlert.confirm).then((result) => {
                $("table.surgery-details tr").each(function() {
                    const cell = $(this).find("td, th").eq(columnIndex);
                    if (result.isConfirmed) {
                        table = cell.closest('table');
                        cell.remove();
                        renameSurgeryDetails(table)
                    } else {
                        cell.removeAttr('style');
                    }
                });
            });
        })

        $(document).on('keyup', '.create-empty-cell', function() {
            const keyup_cell = $(this).parent()

            if ($(this).hasClass('create-row')) {
                const row_number = $('#surgery-form table.surgery-details tbody').find('tr').length,
                    btn = `<a class="btn btn-transparent btn-remove-detail-row position-absolute p-0" style="top: 0; right: 0">
                                <i class="bi bi-x"></i>
                            </a>`
                $(this).removeClass('create-empty-cell create-row').attr('name', `details_row[${row_number - 1}]`)
                    .parent().append(btn)
                $(this).closest('tbody').find('tr').each(function(rowIndex) {
                    $(this).find('td input:disabled').not(':last').each(function(colIndex) {
                        $(this).prop('disabled', false).attr('name', `details_content[${rowIndex}][${colIndex}]`);
                    });
                });
                createEmptyCell("row");
            } else {
                const table = $(this).closest('table'),
                    colIndex = table.find('thead th').length,
                    btn = `<a class="btn btn-transparent btn-remove-detail-column position-absolute p-0" style="top: 0; right: 0">
                                <i class="bi bi-x"></i>
                            </a>`
                $(this).removeClass('create-empty-cell create-column').attr('name', `details_column[${colIndex - 2}]`)
                    .parent().append(btn)
                $(this).closest('table').find('tbody tr').not(':last').each(function(rowIndex) {
                    $(this).find('td input:disabled').prop('disabled', false).attr('name', `details_content[${rowIndex}][${colIndex - 2}]`);
                })
                createEmptyCell("column")
            }
        })

        function createEmptyCell(key = null) {
            const cell = `<input class="form-control form-control-plaintext text-center" type="text" autocomplete="off" disabled>`;

            if (key === "row" || key == null) {
                const numberOfColumn = $('table.surgery-details thead tr th').length;
                let newRow = `<tr>
                                <td class="position-relative">
                                    <input class="form-control form-control-plaintext text-center create-empty-cell create-row" type="text" autocomplete="off" placeholder="Thông số">
                                </td>`
                for (let i = 1; i < numberOfColumn; i++) {
                    newRow += `<td>${cell}</td>`;
                }
                newRow += `</tr>`;
                $('table.surgery-details tbody').append(newRow);
            }
            if (key === 'column' || key == null) {
                const table_head = `<th class="position-relative">
                                        <input class="form-control form-control-plaintext text-center create-empty-cell create-column" type="text" autocomplete="off" placeholder="Mốc thời gian">
                                    </th>`
                $('table.surgery-details thead tr').append(table_head)
                $('table.surgery-details tbody tr').append(`<td>${cell}</td>`)
            }
        }

        function renameSurgeryDetails(table) {
            table.find('thead tr').each(function(index) {
                $(this).find('input').each(function() {
                    const name = $(this).attr('name'),
                        column_index = $(this).parent().index();

                    if (name) {
                        const updatedName = name.replace(/\[([0-9]+)\]/, `[${column_index - 1}]`);
                        $(this).attr('name', updatedName);
                    }
                });
            })

            table.find('tbody tr').each(function(index) {
                $(this).find('input').each(function() {
                    const name = $(this).attr('name'),
                        row_index = $(this).closest('tr').index(),
                        column_index = $(this).parent().index();

                    if (name) {
                        if (column_index == 0) {
                            const updatedName = name.replace(/\[([0-9]+)\]/, `[${row_index}]`);
                            $(this).attr('name', updatedName);
                        } else {
                            $(this).attr('name', `details_content[${row_index}][${column_index - 1}]`);
                        }
                    }
                });
            });
        }



    /*********************************** Phiếu khám **************************************/
    const infoForm = $('#info-form');

    $(document).ready(function() {
        $(document).on('click', '.btn-empty', function() {
            Swal.fire({
                title: "Lưu ý!",
                text: "Vui lòng chọn khách hàng để thực hiện thao tác!",
                icon: "warning",
                confirmButtonText: "OK",
                confirmButtonColor: "var(--bs-primary)",
            })
        });

        /************************************* Thiết lập chung ***********************************/
        $(document).on('keyup focus', '#info-customer_search', function(e) {
            if (e.key === 'Escape') {
                $('#info-customer_search').val('');
            }
            if (e.type === 'keyup') {
                const strPet = `<div class="col-6 col-md-4 col-lg-3 my-2">
                            <a class="btn-empty cursor-pointer">
                                <div class="card card-image add-gallery ratio ratio-1x1 rounded-3 mb-2 h-100">
                                    <i class="bi bi-plus"></i>
                                </div>
                            </a>
                        </div>`;
                $('#pet-slider').html(strPet);
                $('.customer-suggestions').empty();
                infoForm.find('[name="customer_id"]').val(null);
                infoForm.find('[name="pet_id"]').val(null).attr('data-specie', null);
            }
        });

        $(document).on('click', '.btn-select-user', function() {
            const customer_id = $(this).attr('data-id'),
                customer_name = $(this).text();
            fillCustomer(customer_id, customer_name)
            fillListPet(customer_id)
        })

        $(document).on('click', '.btn-refresh-list-pet', function(e) {
            e.preventDefault()
            const customer_id = infoForm.find('[name="customer_id"]').val(),
                pet_id = $(this).attr('data-check');
            if (customer_id) {
                fillListPet(customer_id, pet_id)
            }
        })

        $(document).on('change', '#pet-slider .choice', function() {
            infoForm.find(`[name='pet_id']`).val($(this).val()).attr('data-specie', $(this).attr(
                'data-specie'));
            infoForm.find(`[name='history']`).val($(this).next().find('.pet-history').text())
        })

        // Trượt slider pets
        $('#pet-slider').on('wheel', function(event) {
            const petSlider = $('#pet-slider');

            // Kiểm tra xem thanh trượt ngang có xuất hiện hay không
            if (petSlider[0].scrollWidth > petSlider[0].clientWidth) {
                // Gắn sự kiện wheel khi có thanh trượt ngang
                petSlider.on('wheel', function(event) {
                    if (event.originalEvent.deltaY !== 0) {
                        event.preventDefault();
                        $(this).scrollLeft($(this).scrollLeft() + event.originalEvent.deltaY);
                    }
                });
            }
        });

        /**
         * KHÁM THEO QUY TRÌNH
         */

        $(document).on('click', '.save-info', function(e) {
            e.preventDefault();
            $(this).prop("disabled", true).html(
                '<span class="spinner-border spinner-border-sm" id="spinner-form" role="status"></span>'
            );
            infoForm.submit()
        });

        /******************************************* Dịch vụ ************************************/
        // Thêm dịch vụ
        $(document).on('click', '.info-service', function() {
            const service = $(this),
                serviceName = service.text().trim(),
                serviceId = service.data('id'),
                servicePrice = service.data('price');

            if (!$('#info-indications').find(`#info-service-${serviceId}`).length) {
                const newRow = `
                    <tr id="info-service-${serviceId}">
                        <td>
                            ${serviceName}
                            <input type="hidden" name="service_prices[]" value="${servicePrice}">
                            <input type="hidden" name="service_names[]" value="${serviceName}">
                            <input type="hidden" name="service_ids[]" value="${serviceId}"/>
                        </td>
                        <td class="text-end">
                            <input type="hidden" name="indication_has_booking[]">
                            <input type="hidden" name="indication_ids[]"/>
                            <a class="btn btn-link text-decoration-none btn-remove-detail">
                                <i class="bi bi-trash3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Xóa"></i>
                            </a>
                        </td>
                    </tr>`;
                $('#info-indications').append(newRow);
            } else {
                pushToastify('Dịch vụ đã được thêm!', 'danger');
            }
        });
    })

    function fillListPet(customerId, petId = null) {
        $('#pet-slider').empty()
        $.get(`{{ route('admin.user') }}/${customerId}`, function(user) {
            $.each(user.pets, function(index, pet) {
                const str = `<div class="col-6 col-md-4 col-lg-3 my-2">
                                    <input class="d-none choice" id="pet-choice-${pet.id}" name="choices[]"
                                        data-name="${pet.name}" data-specie="${pet.animal.specie}" type="radio" value="${pet.id}">
                                    <label class="d-block choice-label h-100" for="pet-choice-${pet.id}">
                                        <div class="card card-image mb-2 h-100">
                                            <div class="ratio ratio-16x9">
                                                <img class="card-img-top object-fit-cover p-1" src="${pet.avatarUrl}" alt="${pet.name}">
                                            </div>
                                            <div class="p-3">
                                                <p class="card-title d-inline-block fw-bold">
                                                    <small data-bs-toggle="tooltip" data-bs-title="${pet.name}">${pet.name}</small>
                                                    <span class="badge bg-light-info">
                                                        <small>${pet.animal.specie} ${pet.genderStr} ${ pet.neuterIcon }</small>
                                                    </span>
                                                </p>
                                                <p class="text-body-secondary mb-0 fs-6"><small>Tuổi: ${pet.birthday != null ? pet.age : 'Không rõ'}</small></p>
                                                <p class="d-none pet-history">${ pet.infos ? pet.infos.map((info) => { return JSON.parse(info.diags).final_diag }).join('\r\n• ') : '' }</p>
                                            </div>
                                            <div class="d-grid mb-2 mt-auto">
                                                <div class="btn-group">
                                                    <a class="btn btn-link btn-update-pet btn-sm" data-id="${pet.id}">Thông tin</a>
                                                    <a class="btn btn-link btn-sm" data-id="${pet.id}">Bệnh án</a>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>`
                $('#pet-slider').append(str)
            })
            const str = `<div class="col-6 col-md-4 col-lg-3 my-2">
                                <a class="btn-create-pet cursor-pointer" data-customer="${ $('input[name="customer_id"]').val() }">
                                    <div class="card card-image add-gallery ratio ratio-1x1 rounded-3 mb-2 h-100">
                                        <i class="bi bi-plus"></i>
                                    </div>
                                </a>
                            </div>`
            $('#pet-slider').prepend(str)
            if (petId) {
                $(`#pet-choice-${petId}`).prop('checked', true).change()
            } else {
                $(`#pet-slider .choice:first`).prop('checked', true).change()
            }
        })
    }

    function fillCustomer(id, name) {
        $('#info-customer_search').val(name);
        $('.list-customer-suggest').empty();
        fillCustomerSuggestions(id)
        infoForm.find(`[name='customer_id']`).val(id)
        infoForm.find(`[name='pet_id']`).val('').attr('data-specie', '')
    }

        // Accommodation

        $(document).on('click', '.btn-update-accommodation', function(e) {
            e.preventDefault();
            const form = $('#accommodation-form'),
                modal = form.closest('.modal'),
                id = $(this).attr('data-id');
            resetForm(form)
            $('.customer-search').trigger('keyup').change()
            form.find('.accessory-list').empty()
            modal.find('input.customer-search').val('')
            modal.find('.customer-suggestions').empty()
            form.attr('action', `{{ route('admin.accommodation.update') }}`)
            $.get(`{{ route('admin.accommodation') }}/${id}`, function(accommodation) {
                loadRoomList(accommodation.room_id, accommodation.detail.order.branch_id)
                if (accommodation._pet != null) {
                    const pet = accommodation._pet,
                        customer = pet._customer;
                    fillCustomerSuggestions(customer.id)
                    $('.customer-search').attr('disabled', true)
                    $('.pet-slider').html(`<div class="col-6 col-md-4 col-lg-3 my-2">
                                                <input class="d-none choice" id="pet-choice-${pet.id}" name="choices[]"
                                                data-name="${pet.name}" data-specie="${pet.animal.specie}" type="radio" value="${pet.id}" checked>
                                                <label class="d-block choice-label h-100" for="pet-choice-${pet.id}">
                                                    <div class="card card-image mb-2 h-100">
                                                        <div class="ratio ratio-16x9">
                                                            <img class="card-img-top object-fit-cover p-1" src="${pet.avatarUrl}" alt="${pet.name}">
                                                        </div>
                                                        <div class="p-3">
                                                            <p class="card-title d-inline-block fw-bold">
                                                                <small data-bs-toggle="tooltip" data-bs-title="${pet.name}">${pet.name}</small>
                                                                <span class="badge bg-light-info">
                                                                    <small>${pet.animal.specie} ${pet.genderStr} ${ pet.neuterIcon }</small>
                                                                </span>
                                                            </p>
                                                            <p class="text-body-secondary mb-0 fs-6"><small>Tuổi: ${pet.birthday != null ? pet.age : 'Không rõ'}</small></p>
                                                            <p class="d-none pet-history">${ pet.infos ? pet.infos.map((info) => { return JSON.parse(info.diags).final_diag }).join('\r\n• ') : '' }</p>
                                                        </div>
                                                        <div class="d-grid mb-2 mt-auto">
                                                            <div class="btn-group">
                                                                <a class="btn btn-link btn-update-pet btn-sm" data-id="${pet.id}">Thông tin</a>
                                                                <a class="btn btn-link btn-sm" data-id="${pet.id}">Bệnh án</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>`)
                } else {
                    const customer = accommodation.detail.order._customer
                    fillCustomerSuggestions(customer.id)
                    fillListPet(customer.id)
                    form.closest('.modal').find('.customer-search').prop('disabled', true)
                    form.closest('.modal').find('.list-customer-suggest').empty()
                }
                $.each(JSON.parse(accommodation.accessories), function(index, accessory) {
                    form.find('.accessory-list').append(`<li class="list-group-item mb-3 border-0">
                                                                <div class="row">
                                                                    <div class="col-9">
                                                                        <input class="form-control accessory-detail" name="accessories[${index}][name]" value="${accessory.name ?? ''}" placeholder="Vật dụng đi kèm" autocomplete="off" data-input_name="name"></input>
                                                                    </div>
                                                                    <div class="col-2 px-0">
                                                                        <input class="form-control accessory-detail" name="accessories[${index}][quantity]" value="${accessory.quantity ?? ''}" placeholder="Số lượng" autocomplete="off" data-input_name="quantity"></input>
                                                                    </div>
                                                                    <div class="col-1 d-flex align-items-center">
                                                                        <a class="btn btn-remove-accessory-detail text-danger-hover fw-bold p-0">&#10006</a>
                                                                    </div>
                                                                </div>
                                                            </li>`)
                })
                appendAccessory()
                if (accommodation.details != null) {
                    const details = JSON.parse(accommodation.details);
                    $('input[name^="details["], textarea[name^="details["]').each(function() {
                        const name = $(this).attr('name');
                        const x = name.match(/details\[(.*?)\]/)[1];

                        $(this).val(details[x]);
                    });
                }

                form.find('[name=checkin_at]').val(accommodation.checkin_at ? accommodation.checkin_at.replace(' ', 'T').slice(0, 16) : '')
                form.find('[name=estimate_checkout_at]').val(accommodation.estimate_checkout_at ? accommodation.estimate_checkout_at.replace(' ', 'T').slice(0, 16) : '')
                form.find('[name=real_checkout_at]').val(accommodation.real_checkout_at ? accommodation.real_checkout_at.replace(' ', 'T').slice(0, 16) : '')
                form.find(`[name=room_id][value=${accommodation.room_id}]`).prop('checked', true)
                form.find('.accommodation-trackings').empty()
                form.find('#accommodation-tracking-datalist').empty()
                if (accommodation.detail._service.criterials) {
                    $.each(accommodation.detail._service.criterials, function(index, criterial) {
                        form.find('#accommodation-tracking-datalist').append(`<option>${criterial.name}</option>`)
                    })
                }
                if (accommodation.tracking_groups) {
                    fillTracking(accommodation.tracking_groups)
                }
                form.find(`[name=status][value=${accommodation.status}]`).prop('checked', true)
                form.find('[name=pet_id]').val(accommodation.pet_id)
                form.find('[name=id]').val(accommodation.id)
                modal.modal('show').find('.modal-title').text(accommodation.detail._service.name)
            })
        })

        $(document).on('keyup', '.accessory-input-empty', function(e) {
            e.preventDefault();
            const form = $('#accommodation-form')
            form.find('.accessory-input-empty').removeClass('accessory-input-empty').addClass('accessory-detail')
            form.find('.btn-remove-accessory-detail').removeClass('d-none')
            renameAccessories()
            appendAccessory()
        })

        $(document).on('click', '.btn-remove-accessory-detail', function(e) {
            e.preventDefault();
            Swal.fire(config.sweetAlert.confirm).then((result) => {
                if (result.isConfirmed) {
                    $(this).closest('li').remove();
                    renameAccessories()
                }
            })
        })

        $(document).on('click', '.btn-remove-tracking', function() {
            const id = $(this).attr('data-id'),
                btn = $(this),
                table = btn.closest('table')
            Swal.fire(config.sweetAlert.confirm).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: `{{ route('admin.tracking.remove') }}`,
                        data: {
                            id: id
                        },
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name = "csrf-token"]').attr("content"),
                        },
                        success: function(response) {
                            btn.closest('tr').remove();

                            if (table.find('tbody tr').length == 0) {
                                table.closest('.accordion-item').remove()
                            }
                        }
                    });
                }
            })
        })

        // Room

        $(document).on('click', '.btn-read-rooms', function() {
            fillGridRoomList(`{{ route('admin.room') }}` + window.location.search);
        })

        $(document).on('click', '.btn-create-room', function(e) {
            e.preventDefault();
            const form = $('#room-form')
            resetForm(form)
            form.find('[name=status]').prop('checked', true);
            form.attr('action', `{{ route('admin.room.create') }}`).find('.modal').modal('show')
        })

        $(document).on('click', '.btn-update-room', function(e) {
            e.preventDefault();
            const form = $('#room-form'),
                id = $(this).attr('data-id');
            resetForm(form)
            $.get(`{{ route('admin.room') }}/${id}`, function(room) {
                form.find('[name=id]').val(room.id);
                form.find('[name=name]').val(room.name);
                form.find('[name=note]').val(room.note);
                form.find('[name=status]').prop('checked', room.status);
                form.attr('action', `{{ route('admin.room.update') }}`).find('.modal').modal('show')
            })
        })

        // Tracking

        $(document).on('click', '.btn-create-tracking', function(e) {
            e.preventDefault();
            const form = $('#tracking-form')
            resetForm(form)
            form.find('[name=accommodation_id]').val($(this).closest('form').find('[name=id]').val())
            form.find('[data-gallery="tracking-images"]').children().not(':first').remove();
            form.find('tbody').empty()
            appendTrackingParam()
            form.attr('action', `{{ route('admin.tracking.create') }}`).find('.modal').modal('show').find('.modal-title').text('Thêm phiếu theo dõi')
        })

        $(document).on('click', '.btn-update-tracking', function(e) {
            e.preventDefault();
            const form = $('#tracking-form'),
                id = $(this).attr('data-id')
            resetForm(form)
            $.get(`{{ route('admin.tracking') }}/${id}`, function(tracking) {
                form.find('[name=id]').val(tracking.id)
                form.find('[name=accommodation_id]').val(tracking.accommodation_id)
                form.find(`[name=score][value=${tracking.score}]`).prop('checked', true)
                form.find('[name=note]').val(tracking.note)
                form.find('.tracking-details').empty()
                if (tracking.parameters) {
                    var str = '';
                    $.each(JSON.parse(tracking.parameters), function(index, parameter) {
                        str += (`<tr>
                                    <td><input class="form-control tracking-detail" name="parameters[${index}][target]" value="${parameter.target ?? ''}"" data-input_name="target" type="text" placeholder="Chỉ tiêu" list="accommodation-tracking-datalist" autocomplete="off"></td>
                                    <td><input class="form-control tracking-detail" name="parameters[${index}][result]" value="${parameter.result ?? ''}"" data-input_name="result" type="text" placeholder="Kết quả" autocomplete="off"></td>
                                    <td>
                                        <button class="btn btn-link text-decoration-none btn-remove-parameter">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </td>
                                </tr> `)
                    })
                    form.find('.tracking-details').append(str)
                }
                appendTrackingParam()
                form.find('[data-gallery="tracking-images"]').children().not(':first').remove();
                if (tracking.images) {
                    var gallery = tracking.galleryUrl.map((url, index) => {
                        return `<div class="col-6 col-lg-2 mt-2">
                                                <div class="card card-image mb-1">
                                                    <div class="ratio ratio-1x1">
                                                        <img src="${url}" class="thumb img-fluid object-fit-cover cursor-pointer rounded">
                                                    </div>
                                                </div>
                                            </div>`;
                    }).join('');
                    form.find('[data-gallery="tracking-images"]').append(gallery)
                }
                form.attr('action', `{{ route('admin.tracking.update') }}`).find('.modal').modal('show').find('.modal-title').text('Thêm phiếu theo dõi')
            })
        })

        $(document).on('keyup', '.tracking-input-empty', function(e) {
            e.preventDefault();
            const form = $('#tracking-form')
            form.find('.tracking-input-empty').removeClass('tracking-input-empty').addClass('tracking-detail')
            form.find('.btn-remove-parameter').removeClass('d-none')
            appendTrackingParam()
            renameTrackingDetails()
        })


        $(document).on('click', '.btn-remove-parameter', function(e) {
            e.preventDefault();
            Swal.fire(config.sweetAlert.confirm).then((result) => {
                if (result.isConfirmed) {
                    $(this).closest('tr').remove();
                    renameTrackingDetails();
                }
            })
        })

        $('.room-list-branches').change(function() {
            fillGridRoomList(`{{ route('admin.room') }}?branch_id=${$(this).val()}`);
        })

        // Trượt slider accommodation_cages
        $('.scrollSlider').on('wheel', function(event) {
            const scrollSlider = $(this);

            // Kiểm tra nếu phần tử có thể cuộn ngang
            if (scrollSlider[0].scrollWidth > scrollSlider[0].clientWidth) {
                event.preventDefault();

                const delta = event.originalEvent.deltaY;
                const scrollAmount = delta * 0.5; // Điều chỉnh giá trị này để điều chỉnh tốc độ cuộn

                // Sử dụng setInterval để cuộn dần theo thời gian
                let interval = setInterval(function() {
                    scrollSlider.scrollLeft(scrollSlider.scrollLeft() + scrollAmount);
                }, 10); // Mỗi 10ms cuộn 1 chút

                // Dừng lại khi cuộn hết
                setTimeout(function() {
                    clearInterval(interval);
                }, 100);
            }
        });

        function appendAccessory() {
            $('#accommodation-form').find('.accessory-list').append(`<li class="list-group-item mb-3 border-0">
                                                        <div class="row">
                                                            <div class="col-9">
                                                                <input class="form-control accessory-input-empty" placeholder="Vật dụng đi kèm" autocomplete="off" data-input_name="name"></input>
                                                            </div>
                                                            <div class="col-2 px-0">
                                                                <input class="form-control accessory-input-empty" placeholder="Số lượng" autocomplete="off" data-input_name="quantity"></input>
                                                            </div>
                                                            <div class="col-1 d-flex align-items-center">
                                                                <a class="btn btn-remove-accessory-detail d-none text-danger-hover fw-bold p-0">&#10006</a>
                                                            </div>
                                                        </div>
                                                    </li>`)
        }

        function appendTrackingParam() {
            $('#tracking-form').find('tbody').append(`<tr>
                                            <td><input class="form-control tracking-input-empty" data-input_name="target" type="text" placeholder="Chỉ tiêu" list="accommodation-tracking-datalist" autocomplete="off"></td>
                                            <td><input class="form-control tracking-input-empty" data-input_name="result" type="text" placeholder="Kết quả" autocomplete="off"></td>
                                            <td>
                                                <button class="btn btn-link text-decoration-none btn-remove-parameter d-none">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </td>
                                        </tr> `)
        }

        function renameAccessories() {
            $('#accommodation-form').find('.accessory-list .row').each(function(index, accessory) {
                $(this).find('.accessory-detail').each(function(e, detail) {
                    const name = $(this).attr('data-input_name');
                    $(this).attr('name', `accessories[${index}][${name}]`)
                })
            })
        }

        function renameTrackingDetails() {
            $('#tracking-form').find('table tbody.tracking-details tr').each(function(index, details) {
                $(this).find('.tracking-detail').each(function(e, detail) {
                    const name = $(this).attr('data-input_name');
                    $(this).attr('name', `parameters[${index}][${name}]`)
                })
            })
        }

        function loadRoomList(room_id = null, branch_id) {
            const form = $('#accommodation-form')
            $.get(`{{ route('admin.room') }}/list?branch_id=${branch_id}`, function(rooms) {
                form.find('.accommodation-room-list').empty();
                $.each(rooms.filter(room => room.status === 1), function(index, room) {
                    var pets = '';
                    const accommodations = room.accommodations,
                        petCount = accommodations.filter(accommodation => accommodation.status === 0).length;
                    if (accommodations) {
                        $.each(accommodations, function(i, accommodation) {
                            if (!accommodation.status) {
                                pets += (pets != '' ? ', ' : '') + accommodation._pet.name
                            }
                        })
                    }
                    var str = `<div class="cage me-3 text-center position-relative py-3" style="flex: 0 0 auto; white-space: nowrap">
                                        <input class="btn-check" id="accommodation-room-${index + 1}" name="room_id" type="radio" value="${room.id}" ${room.id == room_id ? 'checked' : ''} autocomplete="off">
                                        <label class="btn btn-outline-primary" for="accommodation-room-${index + 1}"><i class="bi bi-shop me-2"></i>${room.name}</label>
                                        ${pets ? `<small class="badge cursor-pointer key-bg-secondary position-absolute top-0 end-0 p-1" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="${pets}" title="">${petCount} <i class="bi bi-github"></i></small>` : ''}
                                    </div>`
                    form.find('.accommodation-room-list').append(str);
                })
            })
        }

        function fillTracking(tracking_groups) {
            const form = $('#accommodation-form')
            var str = '';
            form.find('.accommodation-trackings').empty()
            $.each(tracking_groups, function(date, trackings) {
                str = `<div class="accordion-item bg-light">
                            <h2 class="accordion-header" style="background: #eaebec">
                                <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#tracking-date-${date}" type="button" aria-expanded="true" aria-controls="tracking-date-${date}">
                                    Ngày ${formatDate(date)}
                                </button>
                            </h2>
                            <div class="accordion-collapse collapse show" id="tracking-date-${date}">
                                <div class="accordion-body">
                                    <div class="table-responsive bg-white">
                                        <table class="table key-table mb-0 accommodation-tracking">
                                            <thead>
                                                <tr>
                                                    <th>Thời gian</th>
                                                    <th>Phụ tá</th>
                                                    <th>Kết luận</th>
                                                    <th>Đánh giá</th>
                                                    <th style="width: 20%">Hình ảnh</th>
                                                    <th style="width: 5%"></th>
                                                </tr>
                                            </thead>
                                            <tbody>`
                $.each(trackings, function(index, tracking) {
                    var gallery = '';
                    if (tracking.galleryUrl) {
                        gallery = tracking.galleryUrl.map((url, index) => {
                            return `<img class="thumb p-1 cursor-pointer" src="${url}" alt="Image ${index + 1}" width="30%" height="auto" />`;
                        }).join('');
                    }
                    str += `<tr>
                                <td><a class="btn text-info fw-bold p-0 btn-update-tracking" data-id="${tracking.id}">${formatTime(tracking.created_at)}</a></td>
                                <td>${tracking._assistant.name}</td>
                                <td>${tracking.note ?? ''}</td>
                                <td class="text-center">${tracking.score}/10</td>
                                <td>
                                    ${gallery}
                                </td>
                                <td>
                                    <a class="btn btn-link text-decoration-none btn-remove-tracking" data-id="${tracking.id}">
                                        <i class="bi bi-trash3"></i>
                                    </a>
                                </td>
                            </tr>`
                })
                str += `</tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>`
                form.find('.accommodation-trackings').append(str);
            })
        }

        function fillGridRoomList(url) {
            const gridView = $('#room-list-modal #grid-view');
            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    gridView.empty();
                    if (data.length > 0) {
                        data.forEach(item => {
                            gridView.append(item)
                        })
                    }
                    $('.modal#room-list-modal').modal('show')
                }
            });
        }

        function formatDate(dateString) {
            const date = new Date(dateString);

            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        }

        function formatTime(time) {
            const date = new Date(time);

            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');

            return `${hours}:${minutes}`;
        }
    </script>
    <script src="{{ asset('admin/js/main.js') }}?v={{ $version_name }}"></script>
    @stack('quick_images')
    @stack('scripts')

</html>
