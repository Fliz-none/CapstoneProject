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
                    @if (!empty(Auth::user()->can(App\Models\User::CREATE_ATTRIBUTE)))
                        <a class="btn btn-info mb-3 block btn-create-attribute">
                            <i class="bi bi-plus-circle"></i>
                            Add
                        </a>
                    @endif
                    <div class="d-inline-block process-btns d-none">
                        @if (!empty(Auth::user()->can(App\Models\User::DELETE_ATTRIBUTES)))
                            <a class="btn btn-danger btn-removes mb-3 ms-2" type="button">
                                <i class="bi bi-trash"></i>
                                Delete
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card">
                @if (!empty(Auth::user()->can(App\Models\User::READ_ATTRIBUTES)))
                    <div class="card-body">
                        <form class="batch-form" method="post">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered key-table" id="attribute-table">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Value</th>
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
        config.routes.remove = `{{ route('admin.attribute.remove') }}`

        $(document).ready(function() {
            const table = $('#attribute-table').DataTable({
                processing: true,
                serverSide: true,
                orderCellsTop: true,
                ajax: {
                    url: `{{ route('admin.attribute') }}` + window.location.search
                },
                columns: [
                    config.datatable.columns.id,
                    config.datatable.columns.name, {
                        data: 'value',
                        name: 'value'
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
                ]
            })
            initDataTable('attribute-table', '4, 5');

            $(document).on('click', '.btn-create-attribute', function(e) {
                e.preventDefault();
                const form = $('#attribute-form')
                resetForm(form)
                form.attr('action', `{{ route('admin.attribute.create') }}`)
                form.find('.modal').modal('show')
            })

            $(document).on('click', '.btn-update-attribute', function(e) {
                e.preventDefault();
                const id = $(this).attr('data-id'),
                    form = $('#attribute-form');
                resetForm(form)
                $.get(`{{ route('admin.attribute') }}/${id}`, function(attribute) {
                    form.find('[name=key]').val(attribute.key)
                    form.find('[name=value]').val(attribute.value)
                    form.find('[name=id]').val(attribute.id)
                    form.attr('action', `{{ route('admin.attribute.update') }}`)
                    form.find('.modal').modal('show')
                })
            })
        })
    </script>
@endpush
