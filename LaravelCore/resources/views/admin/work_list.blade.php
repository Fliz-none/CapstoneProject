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
            <div class="row mb-3">
                <div class="col-12 col-lg-6">
                </div>
                <div class="col-12 col-lg-6 d-flex align-items-center justify-content-end">
                    <select class="form-control form-control-plaintext text-center w-auto ms-2 list-branches">
                        <option selected hidden disabled>Chi nhánh của bạn</option>
                        @foreach (Auth::user()->branches as $branch)
                            <option value="{{ $branch->id }}" {{ isset($_GET['branch_id']) && $_GET['branch_id'] == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                        @endforeach
                    </select>
                    @php
                       $active_calendar = !Request::query('display') === 'list' ? 'active' : '';
                       $active_list = Request::query('display') === 'list' ? 'active' : '';
                    @endphp
                    <div class="ms-2 btn-group">
                        <a class="btn btn-outline-primary {{ $active_calendar }}" id="display-calendar" href="{{ route('admin.work') }}">
                            <i class="bi bi-calendar-check"></i>
                        </a>
                        <a class="btn btn-outline-primary {{ $active_list }} " id="display-list" href="{{ route('admin.work') }}?display=list">
                            <i class="bi bi-list-check"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card">
                @if (!empty(Auth::user()->can(App\Models\User::READ_WORKS)))
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-borderless" id="work-table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Mã</th>
                                        <th>Tên nhân viên</th>
                                        <th>Giờ vào</th>
                                        <th>Giờ ra</th>
                                        <th>Hình ảnh</th>
                                        <th></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
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
        config.routes.batchRemove = `{{ route('admin.work.remove') }}`

        $(document).ready(function() {
            const table = $('#work-table').DataTable({
                bStateSave: true,
                stateSave: true,
                processing: true,
                serverSide: true,
                orderCellsTop: true,
                ajax: {
                    url: `{{ route('admin.work') }}` + window.location.search
                },
                columns: [
                    config.datatable.columns.checkboxes,
                    config.datatable.columns.code, {
                        data: 'user',
                        name: 'user'
                    }, {
                        data: 'check_in',
                        name: 'check_in'
                    }, {
                        data: 'check_out',
                        name: 'check_out'
                    }, {
                        data: 'images',
                        name: 'images',
                        className: 'text-center'
                    }, {
                        data: 'action',
                        name: 'action',
                    }
                ],
                language: config.datatable.lang,
                columnDefs: [{
                    target: 0,
                    sortable: false,
                    searchable: false,
                }]
            })
            initDataTable('work-table', '1, 6, 7')
            $('.list-branches').change(function() {
                window.location.href = `{{ route('admin.work') }}?display=list&branch_id=${$(this).val()}`
            })
        })
    </script>
@endpush
