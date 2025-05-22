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
    <meta name="apple-mobile-web-app-title" content="{{ Auth::user()->branch->name }}">
    <meta name="apple-mobile-web-app-status-bar-style" content="white">

    {{-- Mô tả của web app --}}
    <meta name="apple-mobile-web-app-description"
        content=" {{ Auth::user()->branch->name }}">
    {{-- Ảnh hiển thị khi thêm vào màn hình Home --}}
    <link href="{{ asset('admin/images/logo/favicon.svg') }}" rel="apple-touch-icon">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    @php
        $version_name = cache()->get('version')->name ?? '1.0.0';
    @endphp
    <link href="{{ asset('admin/css/bootstrap.css') }}?v={{ $version_name }}" rel="stylesheet">
    <link href="{{ asset('admin/css/work.css') }}?v={{ $version_name }}" rel="stylesheet">

    <link href="{{ asset('admin/vendors/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendors/bootstrap-icons/bootstrap-icons.css') }}?v={{ $version_name }}"
        rel="stylesheet">
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
                navigator.serviceWorker.register(`{{ asset('js/service-worker.js') }}`).then(function(
                registration) {
                    // console.log('ServiceWorker registration successful with scope: ', registration.scope);
                }, function(err) {
                    // console.error('ServiceWorker registration failed: ', err);
                });
            });
        }
        $(document).ready(function() {
            $(window).on('offline', function() {
                $('.loading').removeClass('d-none');
                Swal.fire("Alert!", 'You are offline', "info");
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
            @include('admin.includes.partials.modal_barcode')
            @include('admin.includes.partials.modal_category')
            @include('admin.includes.partials.modal_attribute')
            @include('admin.includes.partials.modal_branch')
            @include('admin.includes.partials.modal_log')
            @include('admin.includes.partials.modal_role')
            @include('admin.includes.partials.modal_stock')
            @include('admin.includes.partials.modal_supplier')
            @include('admin.includes.partials.modal_timekeeping')
            @include('admin.includes.partials.modal_transaction')
            @include('admin.includes.partials.modal_user')
            @include('admin.includes.partials.modal_warehouse')
            @include('admin.includes.partials.modal_local')
            @include('admin.includes.partials.modal_expense')
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
        </div>
    </div>
    <div class="d-none" id="print-wrapper"></div>
    <div class="d-none" id="render-wrapper"></div>
    <div class="loading d-none">
        <div class="spinner card">Loading...</div>
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
                "sProcessing": "Processing...",
                "sLengthMenu": "_MENU_ rows / page",
                "sZeroRecords": "No content available.",
                "sInfo": "Showing _START_ to _END_ of _TOTAL_ entries",
                "sInfoEmpty": "No entries found",
                "sInfoFiltered": "(filtered from _MAX_ total entries)",
                'searchPlaceholder': "Search data",
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
                title: "Attention!",
                text: "Please confirm before proceeding?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "var(--bs-danger)",
                cancelButtonColor: "var(--bs-primary)",
                confirmButtonText: "Confirm",
                cancelButtonText: "Back",
                reverseButtons: false
            },
            delay: {
                title: "Still processing...",
                text: "Your action is taking longer to process. Please be patient!",
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
            tab = $('#order-modal').hasClass('show') ? $('#order-modal') : $('#export-modal').hasClass('show') ?
            $('#export-modal') : $('.tab-pane.active'),
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
                    pushToastify("The inventory package does not have enough stock. Please select another package to supplement.", 'danger')
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
                pushToastify("The inventory package does not have enough stock. Please select another package to supplement.", 'danger')
            }
        }
        if (!availableUnit && !availableStock) {
            tab.find('.export-receipt').length ? addCardToExport(stock) : addCardToOrder(stock)
        }
    })

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
        form.find('.modal').modal('show').find('.modal-title').text('New product')
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
        form.find('.modal').modal('show').find('.modal-title').text('New variant')
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
                <td><input class="form-control" name="unit_barcode[]" type="text" value="${unit.barcode ? unit.barcode : ''}" placeholder="Barcode"></td>
                <td><input class="form-control" name="unit_term[]" type="text" value="${unit.term}" placeholder="Name" required></td>
                <td><input class="form-control money" name="unit_price[]" type="text" value="${unit.price}" placeholder="Price" required></td>
                <td><input class="form-control bg-white" name="unit_rate[]" type="text" value="${unit.rate}" placeholder="Conversion rate" required disabled></td>
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
                    <td><input class="form-control" name="unit_barcode[]" type="text" placeholder="Barcode"></td>
                    <td><input class="form-control" name="unit_term[]" type="text" placeholder="Name" required></td>
                    <td><input class="form-control money" name="unit_price[]" type="text" placeholder="Price" required></td>
                    <td><input class="form-control" name="unit_rate[]" type="text" placeholder="Conversion rate" required></td>
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
            pushToastify('At least one unit is required.!', 'danger')
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
                    <label class="form-label" for="variable-${i}">Select a variant</label>
                        <select id="variable-${i}" class="form-control form-control-sm mb-1 barcode-variable" placeholder="Select a variant" autocomplete="off" required>
                            ${variables}
                        </select>
                        <label class="form-label" for="unit-${i}">Select a unit</label>
                        <select id="unit-${i}" class="form-control form-control-sm mb-1 barcode-unit" placeholder="Select a unit" autocomplete="off" required>
                            ${units}
                        </select>
                        <input type="hidden" class="barcode-product-name" value="${product.name}">
                        <label class="form-label" for="quantity-${i}">Print quantity</label>
                        <input class="form-control form-control-sm barcode-quantity" id="quantity-${i}" placeholder="Enter quantity" type="text" value="2" autocomplete="off" inputmode="numeric" required>
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
                            pushToastify("Barcode already exists!", 'danger')
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
                                pushToastify("Barcode already exists!", 'danger')
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
                            pushToastify("Product not found!", 'danger')
                        }
                        btn.prop("disabled", false).html('<i class="bi bi-plus-circle"></i> Add stock');
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
                                pushToastify("This product is out of stock in the system.", 'danger')
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
     * CATEGORY PROCESS
     */
    $(document).on('click', '.btn-create-category', function(e) {
        e.preventDefault();
        const form = $('#category-form')
        resetForm(form)
        form.find('[name=status]').prop('checked', true);
        form.attr('action', `{{ route('admin.category.create') }}`)
        form.find('.modal').modal('show').find('.modal-title').text('New category')
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
     * PROFILE
     */
    $('.btn-change-branch').on('click', function() {
        Swal.fire({
            title: 'Select branch',
            html: `
            <select id="main_branch" class="form-select" name="main_branch">
                @foreach (Auth::user()->branches as $branch)
                    <option value="{{ $branch->id }}"{{ Auth::user()->main_branch == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                @endforeach
            </select>
        `,
            showCancelButton: true,
            confirmButtonText: 'Save',
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
                            title: 'An error occurred',
                            text: 'Please try again later!',
                        });
                    }
                });
            }
        });
    });

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
        form.find('.modal').modal('show').find('.modal-title').text('New user account')
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
            form.find('#user_role-modal-label').text('Set role for ' + user.name)
            $.each(user.roles, function(i, role) {
                $('input[name="role_id[]"][value="' + role.id + '"]').prop('checked', true);
            });
            $.each(user.branches, function(i, branch) {
                $('input[name="branch_id[]"][value="' + branch.id + '"]').prop('checked', true);
            });
            $.each(user.warehouses, function(i, warehouse) {
                $('input[name="warehouse_id[]"][value="' + warehouse.id + '"]').prop('checked',
                    true);
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
        form.find('.modal').modal('show').find('.modal-title').text('New warehouse')
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
        form.find('.modal').modal('show').find('.modal-title').text('New branch')
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
        form.find('.modal').modal('show').find('.modal-title').text('New import')
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
            options +=
                `<option value="${item.id}" data-rate="${item.rate}" data-price="${item.price}" ${item.rate == unit.rate ? 'selected' : ''}>${item.term}</option>`
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
                        <input type="text" name="quantities[]" class="form-control-plaintext import_detail-quantity fs-5 text-center" onclick="this.select()" placeholder="Quantity" value="1" inputmode="numeric" required/>
                        <button type="button" class="btn btn-outline-primary rounded-circle mt-1 btn-inc"><i class="bi bi-plus"></i></button>
                    </div>
                </td>
                <td><input type="text" name="prices[]" class="form-control form-control-plaintext border-bottom fs-5 money text-end" list="unit_prices-${unit.id}" value="0" onclick="this.select()" placeholder="Import price" inputmode="numeric" required></td>
                <td><input type="text" name="lots[]" class="form-control form-control-plaintext border-bottom fs-5" onclick="this.select()" placeholder="Lot"></td>
                <td><input type="date" name="expireds[]" class="form-control form-control-plaintext border-bottom fs-5" min="{{ date('Y-m-d') }}" inputmode="numeric" placeholder="Expiration date"></td>
                <td>
                    <datalist id="unit_prices-${unit.id}">
                        ${ Object.values(unit.import_prices).map(price => `<option>${number_format(price)}</option>`).join('') }
                    </datalist>
                    <input type="hidden" name="import_detail_ids[]" />
                    <input type="hidden" name="stock_ids[]"/>
                    <button type="submit" class="btn btn-link px-0 btn-remove-detail import">
                        <i class="bi bi-trash" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"></i>
                    </button>
                </td>
            </tr>`
        $('#import-stocks').append(str)
        totalImport()
    }
    //''''''''''''''''''''''''''''''''''''''''''''

    $(document).on('change', `.import_detail-unit_id[name='unit_ids[]']`, function() {
        const newUnit = parseInt($(this).val()),
            current = $(this).closest('tr').find(`[name='current_unit_ids[]']`),
            count = $(".import_detail-unit_id[name='unit_ids[]']").filter(function() {
                return $(this).val() == newUnit;
            }).length;
        if (count > 1) {
            pushToastify('Already exist this unit in another row', 'danger')
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
                    <input type="text" name="quantities[]" class="form-control-plaintext fs-5 text-center" onclick="this.select()" placeholder="Quantity" value="${number_format(detail.quantity)}" inputmode="numeric" required/>
                    <button type="button" class="btn btn-outline-primary rounded-circle mt-1 btn-inc"><i class="bi bi-plus"></i></button>
                </div>
            </td>
            <td><input type="text" name="prices[]" class="form-control form-control-plaintext border-bottom fs-5 money text-end" list="unit_prices-${detail.unit_id}" value="${detail.price}" onclick="this.select()" placeholder="Import Price" inputmode="numeric" required></td>
            <td><input type="text" name="lots[]" class="form-control form-control-plaintext border-bottom fs-5" value="${detail.stock.lot ? detail.stock.lot : ''}" onclick="this.select()" placeholder="Lot Number"></td>
            <td><input type="date" name="expireds[]" class="form-control form-control-plaintext border-bottom fs-5" value="${detail.stock.expired != null ? detail.stock.expired : ''}" inputmode="numeric" placeholder="Expiration Date"></td>
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
                title: 'Warning!',
                html: "Invalid quantity entries have been detected recently.<br>Would you like to review them?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirm',
                cancelButtonText: 'Review',
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
        form.find('.modal').modal('show').find('.modal-title').text('New export')
    }

    function addCardToExport(stock) {
        let tab = $('#export-modal'),
            units = stock.productUnits.map((item) => {
                return `<option value="${item.id}" data-rate="${item.rate}" data-price="${item.price}" ${item.id == stock.productUnit.id ? 'selected' : ''}>${item.term}</option>`
            }).join('')
        if (!units.length) {
            units =
                `<option value="${stock.productUnit.id}" data-rate="${stock.productUnit.rate}" data-price="${stock.productUnit.price}" selected>${stock.productUnit.term}</option>`
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
                        ${stock.stockExpired == null || stock.stockExpired == '' ? '' : `<div class="badge bg-light-info">EXP ${moment(stock.stockExpired).format('DD/MM/YYYY')}</div>`}
                        <div class="badge bg-light-info">
                            Available stock ${stock.stockConvertQuantity}
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
                        <input type="text" name="notes[]" class="form-control form-control-lg form-control-plaintext export_detail-note" placeholder="Item Note"/>
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
                                Remove from export order
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
                        ${export_detail.expired == null || export_detail.expired == '' ? '' : `<div class="badge bg-light-info">EXP ${moment(export_detail.expired).format('DD/MM/YYYY')}</div>`}
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
                        <input type="text" name="notes[]" class="form-control form-control-lg form-control-plaintext export_detail-note" placeholder="Item note" value="${export_detail.note != null ? export_detail.note : ''}"/>
                    </div>
                </div>
                <div class="dropstart btn-group position-absolute top-0 end-0">
                    <button class="btn btn-link mb-0 px-2 py-1" data-bs-toggle="dropdown" type="button" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu shadow-lg p-2" style="z-index: 9999">
                        <li><a class="dropdown-item btn-history-detail_stock" data-variable-id="${export_detail._stock.variable_id}" href="#">Sales History</a></li>
                        <hr class="dropdown-divider">
                        <li>
                            <input type="hidden" class="export_detail-id" name="ids[]" value="${export_detail.id}">
                            <a class="dropdown-item btn btn-remove-detail remove-card" data-id="${export_detail.id}" data-url="{{ getPath(route('admin.export_detail.remove')) }}">
                                Remove from export order
                            </a>
                        </li>
                    </ul>
                </div>
            </div>`;
    }

    $(document).on('change', '[name=export_warehouse]', function() {
        const input = $(this).closest('.modal').find('.search-input')
        input.attr('data-url', '{{ route('admin.stock') }}?key=search&action=export&warehouse_id=' + $(this)
            .val())
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
        $('#order-modal').modal('show').find('.modal-title').text('New order')
    })

    function addCardToOrder(stock) {
        let tab = $('#order-modal').hasClass('show') ? $('#order-modal') : $('.tab-pane.active'),
            units = stock.productUnits.map((item) => {
                return `<option value="${item.id}" data-rate="${item.rate}" data-price="${item.price}" ${item.rate == stock.productUnit.rate ? 'selected' : ''}>${item.term}</option>`
            }).join('')
        if (!units.length) {
            units =
                `<option value="${stock.productUnit.id}" data-rate="${stock.productUnit.rate}" data-price="${stock.productUnit.price}" selected>${stock.productUnit.term}</option>`
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
                        ${stock.stockExpired == null || stock.stockExpired == '' ? '' : `<div class="badge bg-light-info">EXP ${moment(stock.stockExpired).format('DD/MM/YYYY')}</div>`}
                        <div class="badge bg-light-info">
                            Available stock ${stock.stockConvertQuantity}
                            <input type="hidden" class="order_detail-stock_quantity" name="stock_quantities[]" value="${stock.stockQuantity}"/>
                        </div>
                    </div>
                    <div class="col-12 col-lg-5">
                        <div class="row">
                            <div class="col-7 col-md-4 d-flex justify-content-between position-relative">
                                <input class="order_detail-price" name="prices[]" type="hidden" value="${stock.productUnit.price}">
                                <span class="position-absolute top-100 start-50 mt-2 translate-middle badge bg-danger d-none"></span>
                                <input class="form-control form-control-plaintext form-control-lg order_detail-discounted_price text-end money" name="discounted_price[]" onclick="this.select()" type="text" value="${stock.productUnit.price}" inputmode="numeric" placeholder="Price">
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
                        <li><a class="dropdown-item btn-history-detail_stock" data-variable-id="${stock.variableId}" href="#">Sales History</a></li>
                        <li><a class="dropdown-item btn-note-detail_stock" data-variable-id="${stock.variableId}" href="#">Item Note</a></li>
                        <hr class="dropdown-divider" />
                        <li>
                            <input type="hidden" class="order_detail-id" name="ids[]">
                            <input type="hidden" class="order_detail-export_id" name="export_ids[]">
                            <a class="dropdown-item btn btn-remove-detail remove-card">
                                Remove from order
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
            form.find('.card-transactions').add('.btn-print.print-order').removeClass('d-none').attr(
                'data-id', obj.id)
            form.find(`.btn-create-transaction`).attr('data-order', obj.id)
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
                }
            });
            if (obj.deleted_at != null) {
                form.find('.btn[type=submit]:last-child').addClass('d-none')
            }
            totalOrder()
            form.find('.modal').modal('show').find('.modal-title').text('Order ' + obj.code)
        })
    })

    function htmlOrderDetail(detail) {
        let className = '', number = '', discountedPrice = ''
        console.log(detail);

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
                        ${detail._stock.expired != null ? '<div class="badge bg-light-info">EXP ' + moment(detail._stock.expired).format('DD/MM/YYYY') + '</div>' : ''}
                        <div class="badge bg-light-info">
                            Available stock ${detail._stock.quantity}
                            <input type="hidden" class="order_detail-stock_quantity" name="stock_quantities[]" value="${parseInt(detail.totalSaleQuantity) + parseInt(detail._stock.quantity)}"/>
                        </div>
                    </div>
                    <div class="col-12 col-lg-5">
                        <div class="row">
                            <div class="col-7 col-md-4 d-flex justify-content-between position-relative">
                                <input class="order_detail-price" name="prices[]" type="hidden" value="${detail.price}">
                                <span class="position-absolute top-100 start-50 mt-2 translate-middle badge ${className}">${number}</span>
                                <input class="form-control form-control-plaintext form-control-lg order_detail-discounted_price text-end money" name="discounted_price[]" onclick="this.select()" type="text" value="${discountedPrice}" inputmode="numeric" placeholder="Price">
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
                        <li><a class="dropdown-item btn-history-detail_stock" data-variable-id="${stock.variableId}" href="#">Sales History</a></li>
                        <li><a class="dropdown-item btn-note-detail_stock" data-variable-id="${stock.variableId}" href="#">Item Note</a></li>
                        <hr class="dropdown-divider" />
                        <li>
                            <input type="hidden" class="order_detail-id" name="ids[]" value="${detail.id}">
                            <input type="hidden" class="order_detail-export_id" name="export_ids[]" value="${detail.export_detail != null ? detail.export_detail.export_id : ''}">
                            <a class="dropdown-item btn btn-remove-detail remove-card" data-id="${detail.id}" data-url="{{ getPath(route('admin.detail.remove')) }}">
                                Remove from order
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
             title: 'Item Note',
            input: 'textarea',
            inputLabel: 'Enter note',
            inputValue: card.find('.order_detail-note').val(),
            inputPlaceholder: 'Enter your note here...',
            inputAttributes: {
                'aria-label': 'Enter your note here'
            },
            showCancelButton: true,
        confirmButtonText: 'Save',
        cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                var note = result.value;
                card.find('.order_detail-note').val(note).prev().text('Note: ' + note);
            }
        });
    });

    $(document).on('click', '.btn-price-order_detail', function() {
        const inputPrice = $(this).parent().find(`[name='prices[]']`),
            inputDiscount = $(this).parent().find(`[name='discounts[]']`),
            inputDiscountedPrice = $(this).parent().find(`[name='discounted_price[]']`),
            badge = $(this).parent().find('.badge')

        Swal.fire({
            title: 'Product Discount',
            html: `
            <input id="order_detail-amount" class="form-control form-control-lg mb-3 text-end" onclick="this.select()" placeholder="Enter discount (amount or %)">`,
            showCancelButton: true,
            confirmButtonText: 'Save',
            cancelButtonText: 'Cancle',
            focusConfirm: false,
            didOpen: () => {
                detailAmount = Swal.getPopup().querySelector('#order_detail-amount');
                detailAmount.value = inputDiscount.val()
                detailAmount.select();
                detailAmount.addEventListener('input', function() {
                    $(this).val($(this).val().replace(/(?!^-)[^0-9]/g, ''));
                });
                detailAmount.addEventListener('keyup', (event) => event.key === 'Enter' && Swal
                    .clickConfirm());
            },
            preConfirm: () => {
                const amount = parseInt(detailAmount.value)
                // Kiểm tra xem cả hai trường đều được nhập và trường số tiền chỉ chứa giá trị số
                if (!amount || isNaN(parseFloat(amount)) || amount < 0) {
                    Swal.showValidationMessage(`Invalid data!`);
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
            badge.removeClass('bg-success').addClass('bg-danger').text(
                `-${number_format(originalPrice - discountedPrice)}`).removeClass('d-none')
        } else if (originalPrice < discountedPrice) {
            badge.removeClass('bg-danger').addClass('bg-success').text(
                `+${number_format(discountedPrice - originalPrice)}`).removeClass('d-none')
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
            pushToastify("This unit of measure already exists in another item of the order.", 'danger')
            card.find(`[name='unit_ids[]']`).val(currentUnit)
        } else if (!validateQuantity(card)) {
            pushToastify("The inventory package does not have enough stock. Please select another package to supplement.", 'danger')
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
                    var rate = parseFloat($(this).closest('.detail').find(`[name='unit_ids[]'] option:selected`)
                        .attr('data-rate')) || 0;
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
                discountInput.parent().prev().html('Discount<br/>percentage')
            } else {
                discount = d
                discountInput.parent().prev().html('Discount<br/>amount')
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
                css: [`{{ asset('admin/css/bootstrap.css') }}`,
                    `{{ asset('admin/css/key.css') }}?v={{ $version_name }}`
                ],
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
                    form.find('.modal-title').text('Add transaction')
                    form.find('[name=amount]').val(Math.abs(order.total - order.paid))
                    form.find(`[name='order_id']`).val(order_id)
                    form.find('[name=status]').closest('.form-group').removeClass('d-none')
                    form.find('[name=note]').val(note + ' order ' + order_id)
                } else {
                    pushToastify('Order not found', 'danger')
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
            form.find('[name=status][value=pay]').prop('checked', true).closest('.form-group').addClass(
                'd-none')
            form.find('[name=note]').val('Debt payment')
        }
        form.find('.btn-print.print-transaction').addClass('d-none').removeAttr('data-id')
        form.find('.send-zns-btns').empty()
        form.find('[name=cashier_id]').val(`{{ Auth::id() }}`)
        form.attr('action', `{{ route('admin.transaction.create') }}`)
        form.find('.modal').modal('show').find('.modal-title').text('New transaction')
    })

    $(document).on('click', '.btn-update-transaction', function() {
        const id = $(this).attr('data-id'),
            customer_id = $(this).attr('data-customer_id')
        const form = $('#transaction-form');
        resetForm(form)
        form.attr('action', `{{ route('admin.transaction.update') }}`)
        $.get(` {{ route('admin.transaction') }}/${id}`, function(transaction) {
            if (transaction.customer_id != null) {
                var option = new Option(transaction._customer.name, transaction._customer.id, true,
                    true);
                form.find('[name=customer_id]').html(option).trigger({
                    type: 'select2:select'
                });
            }
            form.find(`[name='id']`).val(id);
            form.find('.modal-title').text('Transaction ' + transaction.code)
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
            form.find(`[name='status'][value = '${transaction.amount > 0 ? 1 : 0}']`).prop('checked', true)
            form.find('.btn-print.print-transaction').removeClass('d-none').attr('data-id', transaction.id)
            if (transaction.deleted_at != null) {
                form.find('.btn[type=submit]:last-child').addClass('d-none')
            }
            form.find('.send-zns-btns').html(transaction.customer_id ?
                `<a class="btn btn-outline-info btn-send-zns send-transaction" data-id="${transaction.id}" data-url="{{ getPath(route('admin.transaction.send_zns')) }}" data-phone="${transaction._customer.phone}">Send Zalo to Customer</a>` : '')
            form.find('.modal').modal('show').find('.modal-title').text('Transaction ' + transaction.code)
        })
    })

    $(document).on('click', '.btn-convert-scores', function() {
        const user_scores = $('[name=scores]'),
            original_scores = $('[name=original_scores]'),
            order_discount = $('[name=discount]')
        user_scores.val(original_scores.val())
        order_discount.val(0)
        Swal.fire({
            title: 'Redeem Discount Points',
            html: `
            <input id="convert-scores" class="form-control form-control-lg mb-3 text-end" onclick="this.select()" placeholder="Enter the number of points to redeem">`,
            showCancelButton: true,
            confirmButtonText: 'Save',
            cancelButtonText: 'Cancle',
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
                    Swal.showValidationMessage(`Invalid data!`);
                } else if (scores > user_scores.val()) {
                    Swal.showValidationMessage(`Redeemable points must not exceed your current balance.`);
                } else if (parseFloat(scores) % 1000 != 0) {
                    Swal.showValidationMessage(`"Points must be divisible by 1000`);
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
            let str =
                `<span class="badge bg-secondary me-2 mb-2">Account since ${moment(suggest.created_at).format('DD/MM/YYYY')}</span>`
            if (suggest.countOrders) {
                str +=`<span class="badge bg-secondary me-2 mb-2">Purchased <span class="text-white fw-bold fs-5">${number_format(suggest.countOrders)}</span> times</span>`
                if (suggest.countPayments) {
                    str +=`<span class="badge bg-secondary me-2 mb-2">Average number of payments per order: <span class="text-white fw-bold fs-5">${number_format(suggest.countPayments)} times</span></span>`
                }
            } else {
                str += `<span class="badge bg-secondary me-2 mb-2">No purchases yet</span>`
            }
            if (suggest.scores) {
                if (suggest.scores > 1000) {
                    str +=
                        `<span class="badge bg-success btn-convert-scores cursor-pointer me-2 mb-2">Currently has <span class="text-white fw-bold fs-5">${number_format(suggest.scores)}</span> points</span>
                        <input type="hidden" name="scores" value="${suggest.scores}">
                        <input type="hidden" name="original_scores" value="${suggest.scores}">`
                } else {
                    str += `<span class="badge bg-secondary me-2 mb-2">Currently has <span class="text-white fw-bold fs-5">${number_format(suggest.scores)}</span> points</span>`
                }
            }
            if (suggest.debt) {
                $format = suggest.debt > 0 ? {
                    'color': 'danger',
                    'sign': '-',
                    'string': 'In debt '
                } : {
                    'color': 'success',
                    'sign': '+',
                    'string': 'Has '
                }
                str +=
                    `<span class="badge bg-${$format['color']} me-2 mb-2">${$format['string']} <span class="text-white fw-bold fs-5">${$format['sign']}${number_format(Math.abs(suggest.debt))}VND</span></span>`
            }
            if (suggest.averagePaymentDelay) {
                str +=
                    `<span class="badge bg-secondary me-2 mb-2">Average debt age: <span class="text-white fw-bold fs-5">${number_format(suggest.averagePaymentDelay)}</span> days</span>`
            }
            $('.customer-suggestions').html(str)
            $('.customer-information').val(suggest.name + (suggest.phone ? ' - ' + suggest.phone : ''))
        })
    }

    /**
     * DATATABLES
     */
    function showVariables(product_id = null) {
        $('#variables-datatable').closest('.card-variables').removeClass('d-none').find('.btn-create-variable').attr(
            'data-product', product_id)
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
                    $('.order-sum').text(number_format(totalOrder) + 'VND');
                    $('.transaction-sum').text(number_format(totalAmount) + 'VND');
                    $('.transaction-remain')
                        .html(transactionRemain < 0 ?
                            `<span class="text-danger">${number_format(transactionRemain) + 'VND'}</span>` :
                            transactionRemain > 0 ?
                            `<span class="text-success">${number_format(transactionRemain) + 'VND'}</span>` :
                            number_format(transactionRemain) + 'VND')
                        .prev().text(transactionRemain < 0 ? `Underpaid` : transactionRemain > 0 ? `Overpaid` : `Paid in full`)
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

    //Render lịch làm việc
    function renderSchedule(monday, target) {
        const days = Array.from({
            length: 7
        }, (_, i) => monday.clone().add(i, 'days'));
        let html = `<tr class="tr-head">
                        <th style="min-width: 210px">Name</th>
                        ${days.map((day, index) => {
                            const dayName = day.format('ddd');
                            const date = day.format('DD/MM/YYYY');
                            const dayClass = index === 5 ? 'text-success': index === 6 ? 'text-danger' : '';
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
