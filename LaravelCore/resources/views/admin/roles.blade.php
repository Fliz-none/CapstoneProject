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
                    @if (!empty(Auth::user()->can(App\Models\User::CREATE_ROLE)))
                        <a class="btn btn-info mb-3 block btn-create-role">
                            <i class="bi bi-plus-circle"></i>
                            Add
                        </a>
                    @endif
                </div>
            </div>
            <div class="card">
                @if (!empty(Auth::user()->can(App\Models\User::READ_ROLES)))
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-borderless" id="role-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Role Name</th>
                                        <th>Permissions</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
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
        config.routes.batchRemove = `{{ route('admin.role.remove') }}`

        $(document).ready(function() {
            const table = $('#role-table').DataTable({
                dom: 'lftip',
                processing: true,
                serverSide: true,
                ajax: {
                    url: `{{ route('admin.role') }}`
                },
                columns: [
                    config.datatable.columns.id,
                    config.datatable.columns.name, {
                        data: 'permissions',
                        name: 'permissions',
                        searchable: false,
                        sortable: false
                    },
                    config.datatable.columns.action,
                ],
                language: config.datatable.lang,
                pageLength: config.datatable.pageLength,
                aLengthMenu: config.datatable.lengths,
                columnDefs: config.datatable.columnDefines,
                order: [
                    [0, 'DESC']
                ]
            })

            $(document).on('click', '.btn-create-role', function(e) {
                e.preventDefault();
                const form = $('#role-form')
                resetForm(form)
                form.attr('action', `{{ route('admin.role.create') }}`)
                form.find('.modal').modal('show')
            })

            $(document).on('click', '.btn-update-role', function(e) {
                e.preventDefault();
                const id = $(this).attr('data-id'),
                    form = $('#role-form');
                resetForm(form)
                $.get(`{{ route('admin.role') }}/${id}`, function(role) {
                    form.find('[name=name]').val(role.name)
                    form.find('[name=id]').val(role.id)
                    $.each(role.permissions, function(index, permission) {
                        form.find(`#permission-${permission.id}`).prop('checked', true)
                    })
                    form.attr('action', `{{ route('admin.role.update') }}`)
                    form.find('.modal').modal('show')
                })
            })

            /**
             * Check all permission on section
             */
            $(document).on('change', '.permissions', function(e) {
                e.preventDefault();
                $(this).parents('.permission-section').find('.permission').prop('checked', $(this).prop('checked'));
            })
        })
    </script>
@endpush
