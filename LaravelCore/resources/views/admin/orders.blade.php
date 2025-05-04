@extends('admin.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12">
                    <h5 class="text-uppercase">{{ $pageName }}</h5>
                    <nav class="breadcrumb-header float-start" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng tin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $pageName }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-12 col-lg-10">
                    @if (!empty(Auth::user()->can(App\Models\User::CREATE_ORDER)))
                        <a class="btn btn-info mb-3 btn-create-order">
                            <i class="bi bi-plus-circle"></i>
                            Thêm
                        </a>
                    @endif
                    <div class="d-inline-block process-btns d-none">
                        @if (!empty(Auth::user()->can(App\Models\User::DELETE_ORDERS)))
                            <a class="btn btn-danger btn-removes mb-3 ms-2" type="button">
                                <i class="bi bi-trash"></i>
                                Xoá
                            </a>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-lg-2">
                    @if (Auth::user()->branches->count())
                        <select
                            class="form-control form-control-lg form-control-plaintext bg-transparent text-end list-branches"
                            required autocomplete="off">
                            <option selected hidden disabled>Chi nhánh của bạn</option>
                            @foreach (Auth::user()->branches as $branch)
                                <option value="{{ $branch->id }}"
                                    {{ isset($_GET['branch_id']) && $_GET['branch_id'] == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>
            <div class="card">
                @if (!empty(Auth::user()->can(App\Models\User::READ_ORDERS)))
                    <div class="card-body">
                        <form class="batch-form" method="post">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered key-table" id="order-table">
                                    <thead>
                                        <tr>
                                            <th>Mã</th>
                                            <th>Khách hàng</th>
                                            <th>Thanh toán</th>
                                            <th>Người bán</th>
                                            <th>Chi nhánh</th>
                                            <th>Trạng thái</th>
                                            <th></th>
                                            <th>
                                                <input class="form-check-input all-choices" type="checkbox">
                                            </th>
                                        </tr>
                                    </thead>
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
        config.routes.load = `{{ route('admin.order') }}`
        config.routes.remove = `{{ route('admin.order.remove') }}`
        $(document).ready(function() {
            const table = $('#order-table').DataTable({
                bStateSave: true,
                stateSave: true,
                processing: true,
                serverSide: true,
                orderCellsTop: true,
                ajax: {
                    url: config.routes.load + window.location.search
                },
                columns: [
                    config.datatable.columns.code,
                    config.datatable.columns.customer, {
                        data: "paid",
                        name: "paid",
                        className: 'text-end',
                        searchable: true,
                        sortable: false,
                    }, {
                        data: "dealer",
                        name: "dealer",
                    }, {
                        data: "branch",
                        name: "branch",
                        sortable: false,
                    },
                    config.datatable.columns.status,
                    config.datatable.columns.action,
                    config.datatable.columns.checkboxes,
                ],
                language: config.datatable.lang,
                pageLength: config.datatable.pageLength,
                aLengthMenu: config.datatable.lengths,
                columnDefs: config.datatable.columnDefines,
                scrollCollapse: false,
                scrollX: false,
                order: [
                    [0, 'DESC']
                ]
            })
            initDataTable('order-table', '7, 8');
        })

        $('.list-branches').change(function() {
            window.location.href = `{{ route('admin.order') }}?branch_id=${$(this).val()}`
        })
    </script>
@endpush
