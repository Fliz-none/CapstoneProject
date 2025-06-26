@extends('admin.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h5 class="text-uppercase">{{ __('messages.categories.category_management') }}</h5>
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">{{ __('messages.categories.category_management') }}</li>
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
                    @if (!empty(Auth::user()->can(App\Models\User::CREATE_CATEGORY)))
                        <a class="btn btn-info mb-3 block btn-create-category">
                            <i class="bi bi-plus-circle"></i>
                            {{ __('messages.add') }}
                        </a>
                    @endif
                    @if (!empty(Auth::user()->can(App\Models\User::UPDATE_CATEGORY)))
                        <button class="btn btn-primary mb-3 btn-sort ms-2" type="button">
                            <i class="bi bi-filter-left"></i>
                            {{ __('messages.categories.sort') }}
                        </button>
                    @endif
                    <div class="d-inline-block process-btns d-none">
                        @if (!empty(Auth::user()->can(App\Models\User::DELETE_CATEGORIES)))
                            <a class="btn btn-danger btn-removes mb-3 ms-2" type="button">
                                <i class="bi bi-trash"></i>
                                {{ __('messages.delete') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card">
                @if (!empty(Auth::user()->can(App\Models\User::READ_CATEGORIES)))
                    <div class="card-body">
                        <form class="batch-form" method="post">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-bordered key-table dataTable-table"
                                    id="category-table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('messages.datatable.code') }}</th>
                                            <th>{{ __('messages.categories.name') }}</th>
                                            <th>{{ __('messages.datatable.description') }}</th>
                                            <th>{{ __('messages.datatable.status') }}</th>
                                            <th>{{ __('messages.categories.created_at') }}</th>
                                            <th>{{ __('messages.datatable.order') }}</th>
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
        config.routes.get = `{{ route('admin.category') }}`
        config.routes.sort = `{{ route('admin.category.sort') }}`
        config.routes.remove = `{{ route('admin.category.remove') }}`

        $(document).ready(function() {
            const table = $('#category-table').DataTable({
                buttons: ['excel'],
                bStateSave: true,
                stateSave: true,
                processing: true,
                serverSide: true,
                orderCellsTop: true,
                ajax: {
                    url: `{{ route('admin.category') }}` + window.location.search
                },
                columns: [
                    config.datatable.columns.id,
                    config.datatable.columns.name,
                    config.datatable.columns.note,
                    config.datatable.columns.status,
                    config.datatable.columns.created_at,
                    config.datatable.columns.sort,
                    config.datatable.columns.action,
                    config.datatable.columns.checkboxes,
                ],
                pageLength: config.datatable.pageLength,
                aLengthMenu: config.datatable.lengths,
                language: config.datatable.lang,
                columnDefs: config.datatable.columnDefines,
                order: [
                    [$("#category-table thead tr th").length - 3, 'ASC']
                ]
            })
            initDataTable('category-table', '8, 9');
        })
    </script>
@endpush
