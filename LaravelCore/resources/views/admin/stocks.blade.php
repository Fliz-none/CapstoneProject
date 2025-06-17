@extends('admin.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h5 class="text-uppercase">{{ __('messages.stock.stock_management') }}</h5>
                    <nav class="breadcrumb-header float-start" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">{{ __('messages.stock.stock_management') }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-12 col-md-6">
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-12 col-lg-10">
                    @if (!empty(Auth::user()->can(App\Models\User::CREATE_IMPORT)))
                        <a class="btn btn-info mb-3 block btn-create-import" type="button">
                            <i class="bi bi-box-arrow-in-right"></i> {{ __('messages.import.import') }}
                        </a>
                    @endif
                    @if (!empty(Auth::user()->can(App\Models\User::CREATE_EXPORT)))
                        <a class="btn btn-info mb-3 block btn-create-export">
                            <i class="bi bi-box-arrow-left"></i> {{ __('messages.export.export') }}
                        </a>
                    @endif
                    @if (!empty(Auth::user()->can(App\Models\User::PRINT_STOCK)))
                        <a class="btn btn-info mb-3 block btn-render-stock">
                            <i class="bi bi-card-checklist"></i> {{ __('messages.stock.stock_export') }}
                        </a>
                    @endif
                </div>
                <div class="col-12 col-lg-2 text-end">
                    @if (Auth::user()->warehouses->count())
                        <select
                            class="form-control form-control-lg form-control-plaintext bg-transparent text-end list-warehouses" required autocomplete="off">
                            <option selected hidden disabled>{{ __('messages.stock.your_warehouse') }}</option>
                            @foreach (Auth::user()->warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}" {{ isset($_GET['warehouse_id']) && $_GET['warehouse_id'] == $warehouse->id ? 'selected' : '' }}>
                                    {{ $warehouse->name }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>
            <div class="card">
                @if (!empty(Auth::user()->can(App\Models\User::READ_STOCKS)))
                    <div class="card-body">
                        <form id="batch-form" method="post">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered key-table" id="stock-table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('messages.datatable.code') }}</th>
                                            <th>{{ __('messages.stock.image') }}</th>
                                            <th>{{ __('messages.product.product_name') }}</th>
                                            <th>{{ __('messages.stock.quantity') }}</th>
                                            <th>{{ __('messages.stock.price') }}</th>
                                            <th>{{ __('messages.stock.stock_import') }}</th>
                                            <th>Lot</th>
                                            <th>{{ __('messages.stock.exp') }}</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tfoot></tfoot>
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
@endsection

@push('scripts')
    <script>
        config.routes.load = `{{ route('admin.stock') }}`
        config.routes.create = `{{ route('admin.import.create') }}`
        config.routes.update = `{{ route('admin.stock.update') }}`
        config.routes.remove = `{{ route('admin.import.remove') }}`
        $(document).ready(function() {
            const table = $('#stock-table').DataTable({
                buttons: ['excel'],
                bStateSave: true,
                stateSave: true,
                serverSide: true,
                orderCellsTop: true,
                ajax: {
                    url: config.routes.load + window.location.search,
                    dataSrc: function(json) {
                        if (window.location.search && json.totalQuantity) {
                            $('#stock-table tfoot').empty().html(`
                                <tr>
                                    <th colspan="3" class="text-end">Tổng</th>
                                    <th>${number_format(json.totalQuantity)} món</th>
                                    <th colspan="4"></th>
                                </tr>`)
                        } else {
                            $('#stock-table tfoot').empty()
                        }
                        return json.data;
                    }
                },
                columns: [
                    config.datatable.columns.code,
                    config.datatable.columns.avatar,
                    {
                        data: 'variable',
                        name: 'variable',
                    },
                    config.datatable.columns.quantity,
                    config.datatable.columns.price,
                    {
                        data: 'import',
                        name: 'import',
                    }, {
                        data: 'lot',
                        name: 'lot',
                        className: 'text-center',
                    }, {
                        data: 'expired',
                        name: 'expired',
                        className: 'text-center',
                    },
                    config.datatable.columns.action
                ],
                language: config.datatable.lang,
                pageLength: config.datatable.pageLength,
                aLengthMenu: config.datatable.lengths,
                order: [
                    [0, 'DESC']
                ]
            })
            initDataTable('stock-table', '2, 9');

            $('.list-warehouses').change(function() {
                window.location.href = `{{ route('admin.stock') }}?warehouse_id=${$(this).val()}`
            })

            $('.btn-render-stock').click(function(e) {
                e.preventDefault()
                var now = new Date(),
                    startDate = moment().startOf('month'),
                    endDate = moment().endOf('month');
                const form = $('#render_stock-form');
                $('#render_stock-daterange').daterangepicker({
                    "startDate": startDate,
                    "endDate": endDate,
                    opens: 'left',
                    locale: {
                        format: 'DD/MM/YYYY'
                    }
                });
                form.attr('action', `{{ route('admin.stock.sync') }}`)
                form.find('.btn-sync-stock').attr('disabled', false)
                form.find('.table-render-stock tbody').html('<tr><td class="text-center" colspan="88">Select the category and warehouse to list stock</td></tr>')
                form.find('.modal').modal('show')
            })

            $('#render_stock-warehouse_id, #render_stock-catalogue_id, [name=daterange]').change(function() {
                const modal = $('#render_stock-modal'),
                    catalogue_id = modal.find('#render_stock-catalogue_id').val(),
                    warehouse_id = modal.find('#render_stock-warehouse_id').val(),
                    range = modal.find('[name=daterange]').val()
                if (warehouse_id) {
                    $.get(`{{ route('admin.stock', ['key' => 'print']) }}/?catalogue_id=${catalogue_id}&warehouse_id=${warehouse_id}&range=${range}`,
                        function(stocks) {
                            modal.find('.table-render-stock tbody').html(stocks)
                        })
                }
            })
        })

        $(document).on('click', '.btn-view-stock-detail', function() {
            const id = $(this).attr('data-id');
            $('#detail-table').DataTable({
                dom: 'ftip',
                processing: true,
                serverSide: true,
                info: false,
                ajax: {
                    url: `{{ route('admin.detail') }}?stock_id=${id}`
                },
                columns: [{
                        data: 'order_id',
                        name: 'order_id'
                    },
                    {
                        data: 'product',
                        name: 'product'
                    },
                    {
                        data: 'quantity',
                        name: 'quantity'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    }
                ],
                language: config.datatable.lang,
            });
            $('#detail-form').find('.modal').modal('show').find('#detail-modal-label').text('Export history')
        })

        $(document).on('click', '.btn-print-stock', function(e) {
            e.preventDefault();
            printJS({
                printable: 'render-stock',
                type: 'html',
                css: [`{{ asset('admin/css/bootstrap.css') }}`, `{{ asset('admin/css/key.css') }}`],
                targetStyles: ['*'],
                showModal: false,
            });
        })

        $(document).on('click', '.btn-sync-stock', function(e) {
            e.preventDefault();
            $(this).closest('form').submit();
            // $(this).attr('disabled', true);
        })
    </script>
@endpush
