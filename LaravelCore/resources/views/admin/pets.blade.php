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
                <div class="col-12 col-md-6">
                    @if (Auth::user()->can(App\Models\User::CREATE_PET))
                        <a class="btn k-btn-info mb-3 block btn-create-pet">
                            <i class="bi bi-plus-circle"></i>
                            Thêm
                        </a>
                    @endif
                    <div class="d-inline-block process-btns d-none">
                        @if (Auth::user()->can(App\Models\User::DELETE_CATALOGUES))
                            <a class="btn btn-danger btn-removes mb-3 ms-2" type="button">
                                <i class="bi bi-trash"></i>
                                Xoá
                            </a>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-md-6 text-end">
                    <div class="d-left justify-content-end align-items-center"></div>
                    <button class="btn k-btn-info mb-3 block btn-input-excel" data-bs-toggle="modal"
                        data-bs-target="#inputExcel" type="button">
                        <i class="bi bi-box-arrow-down"></i>
                        Nhập từ excel
                    </button>
                    <button class="btn btn-warning mb-3 block btn-output-excel" data-bs-toggle="modal"
                        data-bs-backdrop="false" data-bs-target="#outputExcel" type="button">
                        <i class="bi bi-box-arrow-in-up"></i>
                        Xuất ra excel
                    </button>
                    <div class="btn-group mb-3" role="group" aria-label="View">
                        <input class="btn-check" id="display-grid" name="display" type="radio" autocomplete="off"
                            {{ !isset($_GET['display']) ? '' : 'checked' }}>
                        <label class="btn btn-outline-primary" for="display-grid"
                            onclick="window.location='{{ route('admin.pet') }}?display=grid'">
                            <i class="bi bi-grid-fill"></i>
                        </label>
                        <input class="btn-check" id="display-list" name="display" type="radio" autocomplete="off"
                            {{ isset($_GET['display']) ? '' : 'checked' }}>
                        <label class="btn btn-outline-primary" for="display-list"
                            onclick="window.location='{{ route('admin.pet') }}'">
                            <i class="bi bi-list-check"></i>
                        </label>
                    </div>
                </div>
            </div>
            @if (Auth::user()->can(App\Models\User::READ_PETS))
                <div class="card">
                    <div class="card-body">
                        <form class="batch-form" method="POST">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered key-table" id="pet-table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Mã</th>
                                            <th class="text-center">Ảnh</th>
                                            <th class="text-center">Tên thú cưng</th>
                                            <th class="text-center">Tên</th>
                                            <th class="text-center">Thông tin</th>
                                            <th class="text-center">Khách hàng</th>
                                            <th class="text-center">Lần khám gần nhất</th>
                                            <th class="text-center">Trạng thái</th>
                                            <th>ID</th>
                                            <th></th>
                                            <th>
                                                <input class="form-check-input all-choices" type="checkbox">
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </form>
                        <div class="row grid-view" id="grid-view"> </div>
                    </div>
                </div>
            @else
                @include('admin.includes.access_denied')
            @endif
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        config.routes.get = `{{ route('admin.pet') }}`
        config.routes.remove = `{{ route('admin.pet.remove') }}`

        $(document).ready(function() {
            const table = $('#pet-table').DataTable({
                bStateSave: true,
                stateSave: true,
                processing: true,
                serverSide: true,
                orderCellsTop: true,
                ajax: {
                    url: `{{ route('admin.pet') }}` + window.location.search
                },
                columns: [
                    config.datatable.columns.code,
                    config.datatable.columns.avatar, {
                        data: 'name_url',
                        name: 'name_url'
                    }, {
                        data: 'name',
                        name: 'name',
                        className: 'd-none'
                    }, {
                        data: 'info',
                        name: 'info'
                    }, {
                        data: 'customer_info',
                        name: 'customer_info'
                    }, {
                        data: 'latest_info',
                        name: 'latest_info'
                    },
                    config.datatable.columns.status, {
                        data: 'id',
                        name: 'id',
                        className: 'd-none'
                    },
                    config.datatable.columns.action,
                    config.datatable.columns.checkboxes,
                ],
                @if (isset($_GET['display']) && $_GET['display'] == 'grid')
                    initComplete: function(settings, json) {
                        // show new container for data
                        $('#grid-view').insertBefore('#pet-table');
                        $('#grid-view').show();
                    },
                    rowCallback: function(row, data) {
                        let text = `
                        <div class="col-6 col-md-3 col-lg-2 my-2">
                            <input class="d-none choice" type="checkbox" value="${data.id}" data-name="${data.name}" id="choice-${data.id}" name="choices[]" />
                            <label for="choice-${data.id}" class="d-block choice-label">
                                <div class="card card-image">
                                    @if (!empty(Auth::user()->can(App\Models\User::DELETE_PET)))
                                    <form action="{{ route('admin.pet.remove') }}" method="post" class="save-form">
                                        @csrf
                                        <input type="hidden" name="choices[]" value="${data.id}">
                                        <button type="submit" class="btn-close btn-remove-pet" aria-label="Close"></button>
                                    </form>
                                    @endif
                                    <div class="ratio ratio-1x1">
                                        <img src="${data.avatarUrl}" class="card-img-top object-fit-cover p-1" alt="${ data.name}">
                                    </div>
                                    <div class="p-3">
                                        <p class="card-title fs-5 d-inline-block fs-5 fw-bold">
                                            <span data-bs-toggle="tooltip" data-bs-title="${data.name}">${data.name}</span>
                                            <span class="badge bg-light-info fs-6">
                                                <small>${data.animal.specie} ${data.genderStr} ${ $('<span/>').html(data.neuterIcon).text() }</small>
                                            </span>
                                        </p>
                                        <figcaption class="blockquote-footer">
                                            <small class="text-body-secondary"><em>${data._customer.name} • ${data._customer.phone}</em></small>
                                        </figcaption>
                                        <div class="row justify-content-between">
                                            <div class="col-auto card-text mb-0"><small class="text-body-secondary">Ngày thêm: ${moment(data.created_at).format('DD/MM/YY HH:mm')}</small></div>
                                        </div>
                                        <div class="row justify-content-between">
                                        </div>
                                    </div>
                                    @if (!empty(Auth::user()->can(App\Models\User::READ_PET)))
                                    <div class="d-grid">
                                        <a class="btn btn-link text-decoration-none btn-sm btn-update-pet" data-id="${data.id}">Xem chi tiết</a>
                                    </div>
                                    @endif
                                </div>
                            </label>
                        </div>`
                        $('#grid-view').append(text)
                    },
                    preDrawCallback: function(settings) {
                        $('#pet-table').empty();
                        $('#grid-view').empty();
                    },
                    aLengthMenu: [
                        [6, 12, 24, 480],
                        [6, 12, 24, 480]
                    ],
                    pageLength: 24,
                @else
                    columnDefs: [{
                        target: [10, 1, 9],
                        sortable: false,
                        searchable: false,
                    }, {
                        target: [1, 4, 5],
                        sortable: false,
                    }],
                    aLengthMenu: config.datatable.lengths,
                    pageLength: 20,
                    order: [
                        [0, 'DESC']
                    ],
                @endif
                language: config.datatable.lang,
            })
            initDataTable('pet-table', '2, 9, 10, 11', '3');
        })
    </script>
@endpush
