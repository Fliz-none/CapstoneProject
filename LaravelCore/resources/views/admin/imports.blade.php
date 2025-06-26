@extends('admin.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h5 class="text-uppercase">{{ __('messages.import.import_management') }}</h5>
                    <nav class="breadcrumb-header float-start" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">{{ __('messages.import.import_management') }}</li>
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
                    @if (!empty(Auth::user()->can(App\Models\User::CREATE_IMPORT)))
                        <a class="btn btn-info mb-3 block btn-create-import">
                            <i class="bi bi-plus-circle"></i>
                            {{ __('messages.add') }}
                        </a>
                    @endif
                    <div class="d-inline-block process-btns d-none">
                        @if (!empty(Auth::user()->can(App\Models\User::DELETE_IMPORTS)))
                            <a class="btn btn-danger btn-removes mb-3 ms-2" type="button">
                                <i class="bi bi-trash"></i>
                                {{ __('messages.delete') }}
                            </a>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-lg-2 text-end">
                    @if (Auth::user()->warehouses->count())
                        <select
                            class="form-control form-control-lg form-control-plaintext bg-transparent text-end list-warehouses"
                            required autocomplete="off">
                            <option selected hidden disabled>{{ __('messages.stock.your_warehouse') }}</option>
                            @foreach (Auth::user()->warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}"
                                    {{ isset($_GET['warehouse_id']) && $_GET['warehouse_id'] == $warehouse->id ? 'selected' : '' }}>
                                    {{ $warehouse->name }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>
            <div class="card">
                @if (!empty(Auth::user()->can(App\Models\User::READ_IMPORTS)))
                    <div class="card-body">
                        <form class="batch-form" method="post">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered key-table" id="import-table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('messages.datatable.code') }}</th>
                                            <th>{{ __('messages.import.import_content') }}</th>
                                            <th>{{ __('messages.import.created_by') }}</th>
                                            <th>{{ __('messages.import.receive_from') }}</th>
                                            <th>{{ __('messages.stock.warehouse') }}</th>
                                            <th>{{ __('messages.datatable.status') }}</th>
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
    <script type="text/javascript">
        config.routes.remove = `{{ route('admin.import.remove') }}`
        $(document).ready(function() {
            const table = $('#import-table').DataTable({
                bStateSave: true,
                stateSave: true,
                serverSide: true,
                orderCellsTop: true,
                ajax: {
                    url: `{{ route('admin.import') }}` + window.location.search
                },
                columns: [
                    config.datatable.columns.code,
                    config.datatable.columns.note,
                    {
                        'data': 'user',
                        'name': 'user',
                    },
                    {
                        'data': 'supplier',
                        'name': 'supplier',
                    },
                    {
                        'data': 'warehouse',
                        'name': 'warehouse',
                    },
                    {
                        'data': 'status',
                        'name': 'status',
                    },
                    config.datatable.columns.action,
                    config.datatable.columns.checkboxes,
                ],
                language: config.datatable.lang,
                pageLength: config.datatable.pageLength,
                aLengthMenu: config.datatable.lengths,
                columnDefs: config.datatable.columnDefines,
                order: [
                    [0, 'DESC']
                ]
            })
            initDataTable('import-table', '7, 8');
        })

        $('.list-warehouses').change(function() {
            window.location.href = `{{ route('admin.import') }}?warehouse_id=${$(this).val()}`
        })
    </script>
@endpush
