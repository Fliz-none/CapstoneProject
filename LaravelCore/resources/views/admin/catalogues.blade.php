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
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start">
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
                    @if (!empty(Auth::user()->can(App\Models\User::CREATE_CATALOGUE)))
                        <a class="btn k-btn-info mb-3 block btn-create-catalogue">
                            <i class="bi bi-plus-circle"></i>
                            Thêm
                        </a>
                    @endif
                    @if (!empty(Auth::user()->can(App\Models\User::UPDATE_CATALOGUE)))
                        <button class="btn btn-primary mb-3 btn-sort ms-2" type="button">
                            <i class="bi bi-filter-left"></i>
                            Sắp xếp
                        </button>
                    @endif
                    <div class="d-inline-block process-btns d-none">
                        @if (!empty(Auth::user()->can(App\Models\User::DELETE_CATALOGUES)))
                            <a class="btn btn-danger btn-removes mb-3 ms-2" type="button">
                                <i class="bi bi-trash"></i>
                                Xoá
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card">
                @if (!empty(Auth::user()->can(App\Models\User::READ_CATALOGUES)))
                    <div class="card-body">
                        <form class="batch-form" method="post">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered key-table" id="catalogue-table">
                                    <thead>
                                        <tr>
                                            <th>Mã</th>
                                            <th>Ảnh</th>
                                            <th>Tên</th>
                                            <th>Mô tả</th>
                                            <th>Danh mục cha</th>
                                            <th>Trạng thái</th>
                                            <th>STT</th>
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
        config.routes.get = `{{ route('admin.catalogue') }}`
        config.routes.sort = `{{ route('admin.catalogue.sort') }}`
        config.routes.remove = `{{ route('admin.catalogue.remove') }}`

        $(document).ready(function() {
            const table = $('#catalogue-table').DataTable({
                bStateSave: true,
                stateSave: true,
                serverSide: true,
                orderCellsTop: true,
                ajax: {
                    url: `{{ route('admin.catalogue') }}` + window.location.search
                },
                columns: [
                    config.datatable.columns.code,
                    config.datatable.columns.avatar,
                    config.datatable.columns.name,
                    config.datatable.columns.note, {
                        data: 'parent',
                        name: 'parent'
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
                    [$("#catalogue-table thead tr th").length - 3, 'ASC']
                ]
            })
            initDataTable('catalogue-table', '2, 6, 7, 8, 9');
        })
    </script>
@endpush
