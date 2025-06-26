@extends('admin.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h5 class="text-uppercase">{{ __('messages.post.post_management') }}</h5>
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">{{ __('messages.post.post_management') }}</li>
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
                    @if (!empty(Auth::user()->can(App\Models\User::CREATE_POST)))
                        <a class="btn k-btn-info mb-3 block" href="{{ route('admin.post', ['key' => 'new']) }}">
                            <i class="bi bi-plus-circle"></i>
                            {{ __('messages.add') }}
                        </a>
                    @endif
                    <div class="d-inline-block process-btns d-none">
                        @if (!empty(Auth::user()->can(App\Models\User::DELETE_POSTS)))
                            <a class="btn btn-danger btn-removes mb-3 ms-2" type="button">
                                <i class="bi bi-trash"></i>
                                {{ __('messages.delete') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card">
                @if (!empty(Auth::user()->can(App\Models\User::READ_POSTS)))
                    <div class="card-body">
                        <form class="batch-form" method="post">
                            @csrf
                            <table class="table table-striped table-bordered key-table" id="post-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.datatable.code') }}</th>
                                        <th>{{ __('messages.post.title') }}</th>
                                        <th>{{ __('messages.post.content') }}</th>
                                        <th>{{ __('messages.post.image') }}</th>
                                        <th>{{ __('messages.post.author') }}</th>
                                        <th>{{ __('messages.post.category') }}</th>
                                        <th>{{ __('messages.post.type') }}</th>
                                        <th>{{ __('messages.datatable.status') }}</th>
                                        <th>{{ __('messages.post.created_at') }}</th>
                                        <th></th>
                                        <th>
                                            <input class="form-check-input all-choices" type="checkbox">
                                        </th>
                                    </tr>
                                </thead>
                            </table>
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
        config.routes.get = `{{ route('admin.post') }}`,
            config.routes.remove = `{{ route('admin.post.remove') }}`,
            config.routes.sort = `{{ route('admin.post.sort') }}`

        $(document).ready(function() {
            const table = $('#post-table').DataTable({
                processing: true,
                serverSide: true,
                orderCellsTop: true,
                ajax: {
                    url: `{{ route('admin.post') }}` + window.location.search
                },
                columns: [
                    config.datatable.columns.id, {
                        data: 'title',
                        name: 'title'
                    }, {
                        data: 'content',
                        name: 'content'
                    }, {
                        data: 'image',
                        name: 'image'
                    }, {
                        data: 'author',
                        name: 'author'
                    }, {
                        data: 'category',
                        name: 'category'
                    }, {
                        data: 'type',
                        name: 'type'
                    },
                    config.datatable.columns.status,
                    config.datatable.columns.created_at,
                    config.datatable.columns.action,
                    config.datatable.columns.checkboxes,
                ],
                aLengthMenu: config.datatable.lengths,
                language: config.datatable.lang,
                columnDefs: config.datatable.columnDefines,
                order: [
                    [$("#post-table thead tr th").length - 3, 'ASC']
                ]
            })
            initDataTable('post-table', '4, 10, 11')
        })
    </script>
@endpush
