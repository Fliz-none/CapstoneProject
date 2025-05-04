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
                <div class="col-12 col-lg-10">
                    @if (!empty(Auth::user()->can(App\Models\User::CREATE_INFO)))
                        <a class="btn k-btn-info mb-3 block" href="{{ route('admin.info', ['key' => 'new']) }}">
                            <i class="bi bi-plus-circle"></i>
                            Thêm
                        </a>
                        <a class="btn btn-success ms-2 mb-3 block btn-create-info">
                            <i class="bi bi-plus-circle"></i>
                            Thêm nhanh
                        </a>
                    @endif
                    {{-- <div class="d-inline-block process-btns d-none">
                        @if (!empty(Auth::user()->can(App\Models\User::DELETE_INFOS)))
                            <a class="btn btn-danger btn-removes mb-3 ms-2" type="button">
                                <i class="bi bi-trash"></i>
                                Xoá
                            </a>
                        @endif
                    </div> --}}
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
                @if (!empty(Auth::user()->can(App\Models\User::READ_INFOS)))
                    <div class="card-body">
                        <table class="table table-striped key-table" id="info-table">
                            <thead>
                                <tr>
                                    <th>Mã</th>
                                    <th>Thú cưng</th>
                                    <th>Khách hàng</th>
                                    <th>Bác sĩ</th>
                                    <th>Khám tại</th>
                                    <th>Chẩn đoán sơ bộ</th>
                                    <th>Các chỉ định</th>
                                    <th>Chẩn đoán bệnh</th>
                                </tr>
                            </thead>
                        </table>
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
            config.routes.remove = `{{ route('admin.info.remove') }}`

            const table = $('#info-table').DataTable({
                processing: true,
                serverSide: true,
                orderCellsTop: true,
                ajax: {
                    url: `{{ route('admin.info') }}` + window.location.search
                },
                columns: [
                    config.datatable.columns.code, {
                        data: 'pet',
                        name: 'pet',
                    }, {
                        data: 'customer',
                        name: 'customer',
                    }, {
                        data: 'doctor',
                        name: 'doctor',
                    }, {
                        data: 'type',
                        name: 'type',
                    }, {
                        data: 'prelim_diag',
                        name: 'prelim_diag',
                        sortable: false,
                        searchable: false
                    }, {
                        data: 'indications',
                        name: 'indications',
                        sortable: false
                    }, {
                        data: 'final_diag',
                        name: 'final_diag',
                        sortable: false
                    },
                    // config.datatable.columns.action,
                ],
                language: config.datatable.lang,
                pageLength: config.datatable.pageLength,
                aLengthMenu: config.datatable.lengths,
                order: [
                    [0, 'DESC']
                ]
            })
            initDataTable('info-table', '6, 8')
        })
        $('.list-branches').change(function() {
            window.location.href = `{{ route('admin.info') }}?branch_id=${$(this).val()}`
        })
    </script>
@endpush
