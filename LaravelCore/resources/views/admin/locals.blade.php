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
                    @if (!empty(Auth::user()->can(App\Models\User::CREATE_ANIMAL)))
                        <a class="btn k-btn-info mb-3 block btn-create-local">
                            <i class="bi bi-plus-circle"></i>
                            Thêm
                        </a>
                    @endif
                    <div class="d-inline-block process-btns d-none">
                        @if (!empty(Auth::user()->can(App\Models\User::DELETE_ANIMALS)))
                            <a class="btn btn-danger btn-removes mb-3 ms-2" type="button">
                                <i class="bi bi-trash"></i>
                                Xoá
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card">
                @if (!empty(Auth::user()->can(App\Models\User::READ_ANIMALS)))
                    <div class="card-body">
                        <form class="batch-form" method="post">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered key-table" id="local-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tỉnh / Thành phố</th>
                                            <th>Quận / Huyện</th>
                                            <th>Ngày thêm</th>
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
        config.routes.get = `{{ route('admin.local') }}`
        config.routes.remove = `{{ route('admin.local.remove') }}`

        $(document).ready(function() {
            const table = $('#local-table').DataTable({
                processing: true,
                serverSide: true,
                orderCellsTop: true,
                ajax: {
                    url: `{{ route('admin.local') }}` + window.location.search
                },
                columns: [
                    config.datatable.columns.id, {
                        data: 'city',
                        name: 'city'
                    }, {
                        data: 'district',
                        name: 'district'
                    },
                    config.datatable.columns.created_at,
                    config.datatable.columns.action,
                    config.datatable.columns.checkboxes,
                ],
                aLengthMenu: config.datatable.lengths,
                language: config.datatable.lang,
                columnDefs: config.datatable.columnDefines,
                order: [
                    [0, 'DESC']
                ],
            })
            initDataTable('local-table', '5, 6')
            $(document).on('click', '.btn-create-local', function(e) {
                e.preventDefault();
                const form = $('#local-form')
                resetForm(form)
                form.attr('action', `{{ route('admin.local.create') }}`)
                form.find('.modal').modal('show')
            })

            $(document).on('click', '.btn-update-local', function(e) {
                e.preventDefault();
                const id = $(this).attr('data-id'),
                    form = $('#local-form');
                resetForm(form)
                $.get(`{{ route('admin.local') }}/${id}`, function(local) {
                    form.find('[name=id]').val(local.id)
                    form.find('[name=city]').val(local.city)
                    form.find('[name=district]').val(local.district)
                    form.attr('action', `{{ route('admin.local.update') }}`)
                    form.find('.modal').modal('show')
                })
            })
        })
    </script>
@endpush
