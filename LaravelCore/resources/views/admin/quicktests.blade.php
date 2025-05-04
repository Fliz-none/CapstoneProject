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
                @if (!empty(Auth::user()->can(App\Models\User::READ_QUICKTESTS)))
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped key-table" id="quicktest-table">
                                <thead>
                                    <tr>
                                        <th>Mã</th>
                                        <th>Thú cưng</th>
                                        <th>KTV / CN</th>
                                        <th>Chỉ định</th>
                                        <th>Trạng thái</th>
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
        $(document).ready(function() {
            const table = $('#quicktest-table').DataTable({
                processing: true,
                serverSide: true,
                orderCellsTop: true,
                ajax: {
                    url: `{{ route('admin.quicktest') }}` + window.location.search
                },
                columns: [
                    config.datatable.columns.code, {
                        data: 'pet',
                        name: 'pet',
                    }, {
                        data: 'technician',
                        name: 'technician',
                        sortable: false,
                    }, {
                        data: 'content',
                        name: 'content',
                    },
                    config.datatable.columns.status,
                ],
                language: config.datatable.lang,
                pageLength: config.datatable.pageLength,
                aLengthMenu: config.datatable.lengths,
                columnDefs: config.datatable.columnDefines,
                order: [
                    [0, 'DESC']
                ]
            })
            initDataTable('quicktest-table', '4, 5')
        });
        $('.list-branches').change(function() {
            window.location.href = `{{ route('admin.quicktest') }}?branch_id=${$(this).val()}`
        })
    </script>
@endpush
