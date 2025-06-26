@extends('admin.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h5 class="text-uppercase">{{ __('messages.warehouses.warehouse_management') }}</h5>
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">{{ __('messages.warehouses.warehouse_management') }}</li>
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
                    @if (!empty(Auth::user()->can(App\Models\User::CREATE_WAREHOUSE)))
                        <a class="btn btn-info mb-3 block btn-create-warehouse">
                            <i class="bi bi-plus-circle"></i>
                            {{ __('messages.add') }}
                        </a>
                    @endif
                    <div class="d-inline-block process-btns d-none">
                        @if (!empty(Auth::user()->can(App\Models\User::DELETE_WAREHOUSES)))
                            <a class="btn btn-danger btn-removes mb-3 ms-2" type="button">
                                <i class="bi bi-trash"></i>
                                {{ __('messages.delete') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card">
                @if (!empty(Auth::user()->can(App\Models\User::READ_WAREHOUSES)))
                    <div class="card-body">
                        <form class="batch-form" method="post">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered key-table" id="warehouse-table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('messages.datatable.code') }}</th>
                                            <th>{{ __('messages.warehouses.name') }}</th>
                                            <th>{{ __('messages.branches.branch') }}</th>
                                            <th>{{ __('messages.warehouses.address') }}</th>
                                            <th>{{ __('messages.note') }}</th>
                                            <th>{{ __('messages.datatable.status') }}</th>
                                            <th></th>
                                            <th>
                                                <input class="form-check-input all-choices" type="checkbox">
                                            </th>
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
        config.routes.get = `{{ route('admin.warehouse') }}`
        config.routes.remove = `{{ route('admin.warehouse.remove') }}`

        $(document).ready(function() {
            const table = $('#warehouse-table').DataTable({
                dom: 'lftip',
                processing: true,
                serverSide: true,
                ajax: {
                    url: `{{ route('admin.warehouse') }}`
                },
                columns: [
                    config.datatable.columns.code,
                    config.datatable.columns.name,
                    {
                        data: 'branch',
                        name: 'branch',
                        searchable: false,
                        sortable: false
                    }, {
                        data: 'address',
                        name: 'address'
                    },
                    config.datatable.columns.note,
                    config.datatable.columns.status,
                    config.datatable.columns.action,
                    config.datatable.columns.checkboxes,
                ],
                language: config.datatable.lang,
                pageLength: config.datatable.pageLength,
                aLengthMenu: config.datatable.lengths,
                columnDefs: config.datatable.columnDefines,
                order: [
                    [0, 'DESC']
                ],
            })
        })
    </script>
@endpush
