@extends('admin.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h5 class="text-uppercase">{{ $pageName }}</h5>
                    <nav class="breadcrumb-header float-start" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng tin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $pageName }}</li>
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
                    @if (!empty(Auth::user()->can(App\Models\User::CREATE_EXPENSE)))
                        <a class="btn btn-info mb-3 block btn-create-expense">
                            <i class="bi bi-plus-circle"></i>
                            Thêm
                        </a>
                    @endif
                    <div class="d-inline-block process-btns d-none">
                        @if (!empty(Auth::user()->can(App\Models\User::DELETE_EXPENSES)))
                            <a class="btn btn-danger btn-removes mb-3 ms-2" type="button">
                                <i class="bi bi-trash"></i>
                                Xoá
                            </a>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-lg-2">
                    @if (Auth::user()->branches->count())
                        <select class="form-control form-control-lg form-control-plaintext bg-transparent text-end"
                            name="expenses-branch" required autocomplete="off">
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
                @if (!empty(Auth::user()->can(App\Models\User::READ_EXPENSES)))
                    <div class="card-body">
                        <form class="batch-form" method="post">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-striped" id="expense-table">
                                    <thead>
                                        <tr>
                                            <th>Mã</th>
                                            <th>Thời gian</th>
                                            <th>Hình ảnh</th>
                                            <th>Ghi chú</th>
                                            <th>Người tạo phiếu</th>
                                            <th>Người nhận</th>
                                            <th>Số tiền</th>
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
        config.routes.remove = `{{ route('admin.expense.remove') }}`
        $(document).ready(function() {
            var groupColumn = 1;
            const table = $('#expense-table').DataTable({
                processing: true,
                stateSave: true,
                serverSide: true,
                orderCellsTop: true,
                ajax: {
                    url: `{{ route('admin.expense') }}` + window.location.search
                },
                columns: [
                    config.datatable.columns.code,
                    config.datatable.columns.created_at,
                    config.datatable.columns.avatar, {
                        data: 'note',
                        name: 'note',
                    }, {
                        data: 'user',
                        name: 'user',
                    }, {
                        data: 'receiver',
                        name: 'receiver',
                    }, {
                        data: 'amount',
                        name: 'amount',
                        className: 'text-center',
                    },
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
                    [groupColumn, 'DESC']
                ],
                drawCallback: function(settings) {
                    var api = this.api();
                    var rows = api.rows({ page: 'current' }).nodes();
                    var last = null;
                    
                    api.column(groupColumn, { page: 'current' })
                        .data()
                        .each(function(date, i) {
                            let counting_date = moment(date).format('DD/MM/YYYY');
                            let total_amount = 0;
                            $(`[data-date='${counting_date}']`).each(function() {
                                let amount = parseInt($(this).val());
                                total_amount += amount;
                            });
                            if (last !== counting_date) {
                                $(rows).eq(i).before(
                                    `<tr class="group fw-bold bg-light-primary text-black">
                                            <td>${counting_date}</td>
                                            <td colspan="4"></td>
                                            <td class="fw-bold text-end text-success">${number_format(total_amount)}đ</td>
                                            <td colspan="3"></td>
                                        </tr>`
                                );
                                last = counting_date;
                            }
                        });
                }
            })
            table.column(groupColumn).visible(false);
            initDataTable('expense-table', '2, 8', '2, 3');
        })
        $('[name=expenses-branch]').change(function() {
            window.location.href = `{{ route('admin.expense') }}?branch_id=${$(this).val()}`
        })
    </script>
@endpush
