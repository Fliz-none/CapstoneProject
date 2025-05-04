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
        <section>
            <div class="row">
                <div class="col-12 col-lg-10">
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
                @if (!empty(Auth::user()->can(App\Models\User::READ_DEBTS)))
                    <div class="card-body">
                        <form id="batch-form" method="post">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered key-table" id="debt-table">
                                    <thead>
                                        <tr>
                                            <th>Mã</th>
                                            <th>Khách hàng</th>
                                            <th>Số tiền nợ</th>
                                            <th>Từ ngày</th>
                                            <th></th>
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
        config.routes.load = `{{ route('admin.debt') }}`
        $(document).ready(function() {
            const table = $('#debt-table').DataTable({
                buttons: ['excel'],
                bStateSave: true,
                stateSave: true,
                processing: true,
                serverSide: true,
                orderCellsTop: true,
                ajax: {
                    url: config.routes.load + window.location.search
                },
                columns: [
                    config.datatable.columns.id,
                    config.datatable.columns.customer,
                    {
                        data: "debt",
                        name: "debt",
                        className: 'text-end'
                    },
                    {
                        data: "first_debt_order",
                        name: "first_debt_order",
                        searchable: true
                    },
                    config.datatable.columns.action
                ],
                language: config.datatable.lang,
                pageLength: config.datatable.pageLength,
                aLengthMenu: config.datatable.lengths,
                columnDefs: config.datatable.columnDefines,
                order: [
                    [1, 'DESC']
                ]
            })
            initDataTable('debt-table', '5');
        })

        $('.list-branches').change(function() {
            window.location.href = `{{ route('admin.debt') }}?branch_id=${$(this).val()}`
        })
    </script>
@endpush
