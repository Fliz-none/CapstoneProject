@extends('admin.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <h5 class="text-uppercase">{{ $pageName }}</h5>
                    <nav class="breadcrumb-header float-start" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng tin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $pageName }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-12 col-lg-6">
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-12">
                    @if (!empty(Auth::user()->can(App\Models\User::CREATE_DISEASE)))
                        <a class="btn k-btn-info mb-3 block btn-create-diseases">
                            <i class="bi bi-plus-circle"></i>
                            Thêm
                        </a>
                    @endif
                    <div class="d-inline-block process-btns d-none">
                        @if (!empty(Auth::user()->can(App\Models\User::DELETE_DISEASES)))
                            <a class="btn btn-danger btn-removes mb-3 ms-2" type="button">
                                <i class="bi bi-trash"></i>
                                Xoá
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card">
                @if (!empty(Auth::user()->can(App\Models\User::READ_DISEASES)))
                    <div class="card-body">
                        <form class="batch-form" method="post">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered key-table" id="disease-table">
                                    <thead>
                                        <tr>
                                            <th>Mã</th>
                                            <th>Tên</th>
                                            <th>Chuỗi lây nhiễm</th>
                                            <th>Biến chứng</th>
                                            <th>Phòng ngừa</th>
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
        $(document).ready(function() {
            config.routes.remove = `{{ route('admin.disease.remove') }}`

            const table = $('#disease-table').DataTable({
                buttons: ['excel'],
                bStateSave: true,
                stateSave: true,
                processing: true,
                serverSide: true,
                orderCellsTop: true,
                ajax: {
                    url: `{{ route('admin.disease') }}` + window.location.search
                },
                columns: [
                    config.datatable.columns.code,
                    config.datatable.columns.name, {
                        data: 'infection_chain',
                        name: 'infection_chain'
                    }, {
                        data: 'complication',
                        name: 'complication'
                    }, {
                        data: 'prevention',
                        name: 'prevention'
                    },
                    config.datatable.columns.action,
                    config.datatable.columns.checkboxes,
                ],
                pageLength: config.datatable.pageLength,
                aLengthMenu: config.datatable.lengths,
                language: config.datatable.lang,
                columnDefs: config.datatable.columnDefines,
                order: [
                    [0, 'DESC']
                ],
            })
            initDataTable('disease-table', '6, 7')
        })
    </script>
@endpush
