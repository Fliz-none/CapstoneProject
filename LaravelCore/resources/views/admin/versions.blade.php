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
                    @if (!empty(Auth::user()->can(App\Models\User::CREATE_VERSION)))
                        <a class="btn k-btn-info mb-3 block btn-create-version">
                            <i class="bi bi-plus-circle"></i>
                            Thêm
                        </a>
                    @endif
                </div>
            </div>
            <div class="card">
                @if (!empty(Auth::user()->can(App\Models\User::READ_VERSIONS)))
                    <div class="card-body">
                        <form class="batch-form" method="post">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered key-table" id="version-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Phiên bản</th>
                                            <th>Mô tả</th>
                                            <th>Người cập nhật</th>
                                            <th>Ngày cập nhật</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
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
        config.routes.get = `{{ route('admin.version') }}`
        config.routes.remove = `{{ route('admin.version.remove') }}`

        $(document).ready(function() {
            const table = $('#version-table').DataTable({
                dom: 'lftip',
                processing: true,
                serverSide: true,
                ajax: {
                    url: `{{ route('admin.version') }}`
                },
                columns: [
                    config.datatable.columns.id, {
                        data: 'name',
                        name: 'name'
                    }, {
                        data: 'description',
                        name: 'description'
                    },{
                        data: 'user',
                        name: 'user'
                    },
                    config.datatable.columns.created_at,
                    config.datatable.columns.action,
                ],
                language: config.datatable.lang,
                pageLength: config.datatable.pageLength,
                aLengthMenu: config.datatable.lengths,
                columnDefs: config.datatable.columnDefines,
                order: [
                    [0, 'DESC']
                ],
            })

            $(document).on('click', '.btn-create-version', function(e) {
                e.preventDefault();
                const form = $('#version-form')
                resetForm(form)
                form.find('[name=description]').summernote('code', '');
                form.attr('action', `{{ route('admin.version.create') }}`)
                form.find('.modal').modal('show')
            })

            $(document).on('click', '.btn-update-version', function(e) {
                e.preventDefault();
                const id = $(this).attr('data-id'),
                    form = $('#version-form');
                resetForm(form)
                $.get(`{{ route('admin.version') }}/${id}`, function(version) {
                    form.find('[name=id]').val(version.id)
                    form.find('[name=name]').val(version.name)
                    form.find('[name=description]').summernote('code', version.description);
                    form.attr('action', `{{ route('admin.version.update') }}`)
                    form.find('.modal').modal('show')
                })
            })
        })
    </script>
@endpush
