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
                </div>
            </div>
            <div class="card">
                @if (!empty(Auth::user()->can(App\Models\User::READ_LOGS)))
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-borderless" id="log-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Action</th>
                                        <th>Object</th>
                                        <th>Code</th>
                                        <th>Location</th>
                                        <th>Browser</th>
                                        <th>Platform</th>
                                        <th>Device</th>
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
            const table = $('#log-table').DataTable({
                bStateSave: true,
                stateSave: true,
                serverSide: true,
                orderCellsTop: true,
                ajax: {
                    url: `{{ route('admin.log') }}` + window.location.search
                },
                columns: [
                    config.datatable.columns.code,
                    {
                        data: 'user_id',
                        name: 'user_id',
                    },
                    {
                        data: "action",
                        name: "action"
                    },
                    {
                        data: "type",
                        name: "type"
                    },
                    {
                        data: "object",
                        name: "object"
                    },
                    {
                        data: "ip",
                        name: "ip"
                    },
                    {
                        data: "agent",
                        name: "agent"
                    },
                    {
                        data: "platform",
                        name: "platform"
                    },
                    {
                        data: "device",
                        name: "device"
                    }
                ],
                language: config.datatable.lang,
                pageLength: config.datatable.pageLength,
                aLengthMenu: config.datatable.lengths,
                columnDefs: config.datatable.columnDefines,
                scrollCollapse: false,
                scrollX: false,
                order: [
                    [0, 'DESC']
                ]
            })
            initDataTable('log-table')
        })
    </script>
@endpush
