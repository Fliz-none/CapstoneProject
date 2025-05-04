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
                <div class="col-12">
                    @if (!empty(Auth::user()->can(App\Models\User::CREATE_SERVICE)))
                        <a class="btn btn-info mb-3 block" href="{{ route('admin.service', ['key' => 'new']) }}">
                            <i class="bi bi-plus-circle"></i>
                            Thêm
                        </a>
                        <a class="btn btn-success ms-2 mb-3 block btn-create-service">
                            <i class="bi bi-plus-circle"></i>
                            Thêm nhanh
                        </a>
                    @endif
                    @if (!empty(Auth::user()->can(App\Models\User::UPDATE_SERVICE)))
                        <button class="btn btn-primary mb-3 btn-sort ms-2" type="button">
                            <i class="bi bi-filter-left"></i>
                            Sắp xếp
                        </button>
                    @endif
                    <div class="d-inline-block process-btns d-none">
                        @if (!empty(Auth::user()->can(App\Models\User::DELETE_SERVICES)))
                            <a class="btn btn-danger btn-removes mb-3 ms-2" type="button">
                                <i class="bi bi-trash"></i>
                                Xoá
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card">
                @if (!empty(Auth::user()->can(App\Models\User::READ_SERVICES)))
                    <div class="card-body">
                        <form class="batch-form" method="post">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered key-table" id="service-table">
                                    <thead>
                                        <tr>
                                            <th>Mã</th>
                                            <th>Tên</th>
                                            <th>Danh mục</th>
                                            <th>Giá</th>
                                            <th>Trạng thái</th>
                                            <th>Thứ tự</th>
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
        config.routes.remove = `{{ route('admin.service.remove') }}`,
            config.routes.get = `{{ route('admin.service') }}`,
            config.routes.sort = `{{ route('admin.service.sort') }}`

        $(document).ready(function() {
            const table = $('#service-table').DataTable({
                buttons: ['excel'],
                processing: true,
                serverSide: true,
                orderCellsTop: true,
                ajax: {
                    url: `{{ route('admin.service') }}` + window.location.search
                },
                columns: [
                    config.datatable.columns.code,
                    config.datatable.columns.name,
                    {
                        data: 'major',
                        name: 'major'
                    },
                    config.datatable.columns.price,
                    config.datatable.columns.status,
                    config.datatable.columns.sort,
                    config.datatable.columns.action,
                    config.datatable.columns.checkboxes,
                ],
                language: config.datatable.lang,
                pageLength: config.datatable.pageLength,
                aLengthMenu: config.datatable.lengths,
                columnDefs: config.datatable.columnDefines,
                // order: [
                //     [$("#service-table thead tr th").length - 3, 'ASC']
                // ]
            })
            initDataTable('service-table', '5, 6, 7, 8')

            $(document).on('click', '.btn-create-service', function(e) {
                e.preventDefault();
                const form = $('#service-form')
                resetForm(form)
                toggleCommitment();
                form.attr('action', `{{ route('admin.service.save') }}`)
                form.find('.modal').modal('show')
            })
        })
    </script>
@endpush
