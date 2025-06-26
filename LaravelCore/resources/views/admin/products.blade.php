@extends('admin.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h5 class="text-uppercase">{{ __('messages.product.product_management') }}</h5>
                    <nav class="breadcrumb-header float-start" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">{{ __('messages.product.product_management') }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-12 col-md-6">
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-12 col-md-6">
                    @if (!empty(Auth::user()->can(App\Models\User::CREATE_PRODUCT)))
                        <a class="btn btn-info mb-3 block" href="{{ route('admin.product', ['key' => 'new']) }}">
                            <i class="bi bi-plus-circle"></i>
                            {{ __('messages.add') }}
                        </a>
                        {{-- <a class="btn btn-success ms-2 mb-3 block btn-create-product">
                            <i class="bi bi-plus-circle"></i>
                            Quick Add
                        </a> --}}
                    @endif
                    @if (!empty(Auth::user()->can(App\Models\User::UPDATE_PRODUCT)))
                        <button class="btn btn-primary mb-3 btn-sort ms-2" type="button">
                            <i class="bi bi-filter-left"></i>
                            {{ __('messages.product.sort') }}
                        </button>
                    @endif
                    <div class="d-inline-block process-btns d-none">
                        <a class="btn btn-primary btn-barcode-product mb-3 ms-2" type="button">
                            <i class="bi bi-upc-scan"></i>
                            Barcode
                        </a>
                        @if (!empty(Auth::user()->can(App\Models\User::UPDATE_PRODUCT)))
                            <button class="btn mb-3 btn-add-catalogues-product ms-2 btn-outline-primary" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-blockquote-left" viewBox="0 0 16 16">
                                    <path d="M2.5 3a.5.5 0 0 0 0 1h11a.5.5 0 0 0 0-1zm5 3a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1zm-5 3a.5.5 0 0 0 0 1h11a.5.5 0 0 0 0-1zm3-5.5v1.5h2v1H5.5v2h-1v-2H2.5v-1.2h2.2v-1.5h1z" />
                                </svg>
                                Add category
                            </button>
                            <button class="btn mb-3 btn-remove-catalogues-product ms-2 btn-outline-danger" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-blockquote-left" viewBox="0 0 16 16">
                                    <path d="M2.5 3a.5.5 0 0 0 0 1h11a.5.5 0 0 0 0-1zm5 3a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1zm-5 3a.5.5 0 0 0 0 1h11a.5.5 0 0 0 0-1zM2 7.6h3v0.8H2v-0.8z" />
                                </svg>
                                Delete category
                            </button>
                        @endif
                        @if (!empty(Auth::user()->can(App\Models\User::DELETE_PRODUCTS)))
                            <a class="btn btn-danger btn-removes mb-3 ms-2" type="button">
                                <i class="bi bi-trash"></i>
                                {{ __('messages.delete') }}
                            </a>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-md-6 d-flex justify-content-end">
                    @if (!empty(Auth::user()->can(App\Models\User::READ_PRODUCTS)))
                        <form action="" method="post">
                            <button class="btn k-btn-info mb-3 btn-refill-product" type="button">
                                <i class="bi bi-box-arrow-down"></i>
                                {{ __('messages.product.import_excel') }}
                            </button>
                            <input class="d-none" id="refill-file" name="refill_file" type="file" accept=".xlsx, .xls">
                        </form>
                    @endif
                    @if (!empty(Auth::user()->can(App\Models\User::READ_PRODUCTS)))
                        <button class="btn btn-warning mb-3 ms-2 btn-render-product" type="button">
                            <i class="bi bi-box-arrow-in-up"></i>
                            {{ __('messages.product.export_excel') }}
                        </button>
                    @endif
                </div>
            </div>
            <div class="card">
                @if (!empty(Auth::user()->can(App\Models\User::READ_PRODUCTS)))
                    <div class="card-body">
                        <form class="batch-form" method="post">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered key-table" id="products-datatable">
                                    <thead>
                                        <tr>
                                            <th>{{ __('messages.datatable.code') }}</th>
                                            <th>{{ __('messages.product.product_gallery') }}</th>
                                            <th>{{ __('messages.product.product_name') }}</th>
                                            <th>{{ __('messages.category.category') }}</th>
                                            <th>{{ __('messages.variable.variable') }}</th>
                                            <th>{{ __('messages.datatable.status') }}</th>
                                            <th>{{ __('messages.datatable.order') }}</th>
                                            <th></th>
                                            <th>
                                                <input class="form-check-input all-choices" type="checkbox">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                @else
                    @include('admin.includes.access_denied')
                @endif
            </div>
        </section>
    </div>
    @include('admin.includes.partials.modal_render_product')
@endsection

@push('scripts')
    <script>
        config.routes.get = `{{ route('admin.product') }}`
        config.routes.sort = `{{ route('admin.product.sort') }}`
        config.routes.remove = `{{ route('admin.product.remove') }}`
        showProducts()
        initDataTable('products-datatable', '2, 6, 7, 8, 9,')
        $(document).ready(function() {
            $(document).on('click', '.btn-render-product', function() {
                $('#render-product-modal').modal('show');
            })

            $(document).on('click', '.btn-export-confirm', function(e) {
                e.preventDefault();
                let selectedColumns = $('.render-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();
                let catalogue_id = $('#render-product-modal').find('[name="catalogue"]').val();
                $.ajax({
                    url: `{{ route('admin.product') }}/?key=render`,
                    type: 'GET',
                    data: {
                        columns: selectedColumns,
                        catalogue_id: catalogue_id,
                    },
                    success: function(template) {
                        $('#render-wrapper').html(template);
                        const hideCols = ['unit_id', 'unit_created_at'];
                        downloadExcel(extractTableData($('#render-wrapper')), hideCols, `sanpham_${moment().format('DD/MM/YYYY')}.xlsx`);
                        $('#render-product-modal').modal('hide');
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr, status, error);
                        if (xhr.status == 422) {
                            const errors = xhr.responseJSON.errors;
                            pushToastify(errors?.catalogue_id?.[0] || errors?.columns?.[0] || 'An unknown error occurred. Please try again.', 'danger');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'An error occurred',
                                text: 'Please try again.',
                            });
                        }
                    }
                });
            });

            function extractTableData(elm) {
                // Get all column headers from thead
                let headers = [],
                    data = [];
                elm.find('thead th').each(function() {
                    headers.push($(this).text().trim());
                });

                elm.find('tbody tr').each(function() {
                    let cells = $(this).find('td');
                    let rowData = {};
                    headers.forEach((header, index) => {
                        rowData[header] = cells.eq(index).text().trim();
                    });
                    data.push(rowData);
                });
                return data;
            }

            function downloadExcel(data, hideCols, fileName) {
                if (data != undefined && data) {
                    const ws = XLSX.utils.json_to_sheet(data),
                        range = XLSX.utils.decode_range(ws['!ref']),
                        columnWidths = Object.keys(data[0]).map((key) => {
                            const maxLength = data.reduce((max, row) => Math.max(max, row[key].toString().length), key.length);
                            return {
                                wch: maxLength + 3
                            };
                        });

                    // Set column widths
                    ws['!cols'] = columnWidths;

                    Object.keys(data[0]).forEach((columnName, colIndex) => {
                        if (hideCols.includes(columnName)) {
                            ws['!cols'][colIndex] = {
                                hidden: true
                            };
                        }
                    });

                    // Create and download Excel file
                    const wb = XLSX.utils.book_new();
                    XLSX.utils.book_append_sheet(wb, ws, "mainSheet");
                    XLSX.writeFile(wb, fileName);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'An error occurred',
                        text: 'The data is invalid, please try again later.',
                    });
                }
            }

            let isMouseDown = false;
            $(document).on('mousedown', '.render-label', function() {
                isMouseDown = true;
                const checkbox = $(this).siblings('.render-checkbox');
                checkbox.prop('checked', !checkbox.prop('checked'));
                return false;
            }).on('mouseover', '.render-label', function() {
                if (isMouseDown) {
                    const checkbox = $(this).siblings('.render-checkbox');
                    checkbox.prop('checked', !checkbox.prop('checked'));
                }
            });

            $(document).mouseup(function() {
                isMouseDown = false;
            });

            $(document).on('click', '.render-label', function() {
                const checkbox = $(this).siblings('.render-checkbox');
                checkbox.prop('checked', !checkbox.prop('checked'));
            })

            //Import excel
            $(document).on('click', '.btn-refill-product', function() {
                console.log('clicked');
                $(this).parent().find('input[name="refill_file"]').trigger('click');
            })

            $(document).on('change', 'input[name="refill_file"]', function() {
                const form = $(this).closest('form');
                form.attr('action', `{{ route('admin.product.refill') }}`);
                submitForm(form)
                    .fail(function() {
                        $('input[name="refill_file"]').val('');
                    });
            });

            $(document).on("click", ".btn-remove-catalogues-product", function () {
                var form = $(this).closest("section").find(".batch-form");
                form.attr("action", `{{ route('admin.product.remove_catalogues') }}`);
                Swal.fire(config.sweetAlert.confirm).then((result) => {
                    if (result.isConfirmed) {
                        $(this).prop("disabled", true).html(`<span class="spinner-border spinner-border-sm" id="spinner-form" role="status"></span>`);
                        submitForm(form)
                            .done(function () {
                                resetForm(form);
                                $(".btn-remove-catalogues-product")
                                    .prop("disabled", false)
                                    .html(`<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-blockquote-left" viewBox="0 0 16 16"><path d="M2.5 3a.5.5 0 0 0 0 1h11a.5.5 0 0 0 0-1zm5 3a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1zm-5 3a.5.5 0 0 0 0 1h11a.5.5 0 0 0 0-1zM2 7.6h3v0.8H2v-0.8z" /></svg> Delete category`)
                                    .parent()
                                    .addClass("d-none");
                            })
                            .fail(function () {
                                $(".btn-remove-catalogues-product").prop("disabled", false)
                                .html('<span class="text-white""><i class="bi bi-exclamation-circle-fill mt-1"></i> Try again</span>');
                            });
                    }
                });
            });

            $(document).on("click", ".btn-add-catalogues-product", function () {
                var form = $(this).closest("section").find(".batch-form");
                form.attr("action", `{{ route('admin.product.add_catalogues') }}`);

                // Cấu hình SweetAlert
                Swal.fire({
                    title: "Chọn danh mục",
                    text: "Chọn một danh mục để tiếp tục",
                    icon: "info",
                    html: `<select class="form-control select2" id="products-catalogue_id" data-ajax--url="{{ route('admin.catalogue', ['key' => 'select2']) }}" data-placeholder="Chọn một danh mục"></select>`,
                    showCancelButton: true,
                    confirmButtonColor: "var(--bs-primary)",
                    cancelButtonColor: "var(--bs-secondary)",
                    confirmButtonText: "Xác nhận",
                    cancelButtonText: "Quay lại",
                    reverseButtons: false,
                    didOpen: () => {
                        $("#products-catalogue_id").select2({...config.select2, dropdownParent: $(".swal2-popup")});
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const catalogue_id = $("#products-catalogue_id").val();
                        if(catalogue_id){
                            $(this).prop("disabled", true).html(`<span class="spinner-border spinner-border-sm" id="spinner-form" role="status"></span>`)
                            form.append(`<input type="hidden" name="catalogue_id" value="${catalogue_id}">`)
                            submitForm(form)
                                .done(function () {
                                    resetForm(form);
                                    $(".btn-add-catalogues-product")
                                        .prop("disabled", false)
                                        .html(`<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-blockquote-left" viewBox="0 0 16 16"><path d="M2.5 3a.5.5 0 0 0 0 1h11a.5.5 0 0 0 0-1zm5 3a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1zm-5 3a.5.5 0 0 0 0 1h11a.5.5 0 0 0 0-1zm3-5.5v1.5h2v1H5.5v2h-1v-2H2.5v-1.2h2.2v-1.5h1z" /></svg>Thêm danh mục`)
                                        .parent()
                                        .addClass("d-none");
                                })
                                .fail(function () {
                                    $(".btn-add-catalogues-product").prop("disabled", false)
                                    .html('<span class="text-white"><i class="bi bi-exclamation-circle-fill mt-1"></i> Thử lại</span>');
                                });
                        }else{
                            pushToastify('Vui lý chọn một danh mục', 'danger')
                        }
                    }
                });
            });
        });
    </script>
@endpush
