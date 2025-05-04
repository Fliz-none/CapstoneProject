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
                    @if (!empty(Auth::user()->can(App\Models\User::CREATE_MEDICINE)))
                        <a class="btn k-btn-info mb-3 block btn-create-medicine">
                            <i class="bi bi-plus-circle"></i>
                            Thêm
                        </a>
                    @endif
                    <div class="d-inline-block process-btns d-none">
                        @if (!empty(Auth::user()->can(App\Models\User::DELETE_MEDICINES)))
                            <a class="btn btn-danger btn-removes mb-3 ms-2" type="button">
                                <i class="bi bi-trash"></i>
                                Xoá
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card">
                @if (!empty(Auth::user()->can(App\Models\User::READ_MEDICINES)))
                    <div class="card-body">
                        <form class="batch-form" method="post">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered key-table" id="medicine-table">
                                    <thead>
                                        <tr>
                                            <th>Mã</th>
                                            <th>Sản phẩm</th>
                                            <th>Tên thuốc</th>
                                            <th>Chống chỉ định</th>
                                            <th>Liều tham khảo</th>
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
    <script type="text/javascript">
        $(document).ready(function() {
            config.routes.remove = `{{ route('admin.medicine.remove') }}`

            const table = $('#medicine-table').DataTable({
                bStateSave: true,
                stateSave: true,
                processing: true,
                serverSide: true,
                orderCellsTop: true,
                ajax: {
                    url: `{{ route('admin.medicine') }}` + window.location.search
                },
                columns: [
                    config.datatable.columns.code, {
                        data: 'variable',
                        name: 'variable',
                    },
                    config.datatable.columns.name, {
                        data: 'contraindications',
                        name: 'contraindications',
                    }, {
                        data: 'sample_dosages',
                        name: 'sample_dosages',
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
                    [0, 'DESC']
                ]
            })
            initDataTable('medicine-table', '6, 7')
        })
    </script>
@endpush
