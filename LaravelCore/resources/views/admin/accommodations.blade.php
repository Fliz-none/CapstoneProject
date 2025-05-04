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
                <div class="col-12 col-md-10">
                    <a class="btn btn-info mb-3 block btn-read-rooms">
                        <i class="bi bi-shop me-1"></i>
                        Danh sách chuồng
                    </a>
                </div>
                <div class="col-12 col-lg-2">
                    @if (Auth::user()->branches->count())
                        <select class="form-control form-control-lg form-control-plaintext bg-transparent text-end list-branches" required autocomplete="off">
                            <option selected hidden disabled>Chi nhánh của bạn</option>
                            @foreach (Auth::user()->branches as $branch)
                                <option value="{{ $branch->id }}" {{ isset($_GET['branch_id']) && $_GET['branch_id'] == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>
            <div class="card">
                @if (!empty(Auth::user()->can(App\Models\User::READ_ACCOMMODATIONS)))
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered key-table" id="accommodation-table">
                                <thead>
                                    <tr>
                                        <th>Mã</th>
                                        <th>Thú cưng</th>
                                        <th>Bác sĩ chi định</th>
                                        <th>Chuồng</th>
                                        <th>Tình trạng theo dõi</th>
                                        <th class="text-center">Trạng thái</th>
                                        {{-- <th class="text-end sorting_disabled"></th> --}}
                                    </tr>
                                </thead>
                                <tbody></tbody>
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
            const table = $('#accommodation-table').DataTable({
                dom: 'lftip',
                processing: true,
                serverSide: true,
                ajax: {
                    url: `{{ route('admin.accommodation') }}` + window.location.search
                },
                columns: [
                    config.datatable.columns.code, {
                        data: 'pet',
                        name: 'pet',
                    }, {
                        data: 'assistant_id',
                        name: 'assistant_id',
                    }, {
                        data: 'room_id',
                        name: 'room_id',
                    }, {
                        data: 'note',
                        name: 'note',
                    },
                    config.datatable.columns.status,
                    // config.datatable.columns.action,
                ],
                language: config.datatable.lang,
            })

            $('.list-branches').change(function() {
                window.location.href = `{{ route('admin.accommodation') }}?branch_id=${$(this).val()}`
            })
        });
    </script>
@endpush
