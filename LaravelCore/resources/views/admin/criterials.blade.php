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
                    @if (!empty(Auth::user()->can(App\Models\User::CREATE_CRITERIAL)))
                        <a class="btn btn-info mb-3 block btn-create-criterial">
                            <i class="bi bi-plus-circle"></i>
                            Thêm
                        </a>
                    @endif
                    <div class="d-inline-block process-btns d-none">
                        @if (!empty(Auth::user()->can(App\Models\User::DELETE_CRITERIALS)))
                            <a class="btn btn-danger btn-removes mb-3 ms-2" type="button">
                                <i class="bi bi-trash"></i>
                                Xoá
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card">
                @if (!empty(Auth::user()->can(App\Models\User::READ_CRITERIALS)))
                    <div class="card-body">
                        <form class="batch-form" method="post">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered key-table" id="criterial-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên tiêu chí</th>
                                            <th>Mô tả</th>
                                            <th>Tham chiếu</th>
                                            <th>Ngày tạo</th>
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
        config.routes.remove = `{{ route('admin.criterial.remove') }}`

        $(document).ready(function() {
            const table = $('#criterial-table').DataTable({
                processing: true,
                serverSide: true,
                orderCellsTop: true,
                ajax: {
                    url: `{{ route('admin.criterial') }}` + window.location.search
                },
                columns: [
                    config.datatable.columns.id,
                    config.datatable.columns.name, {
                        data: 'description',
                        name: 'description'
                    }, {
                        data: 'normal_index',
                        name: 'normal_index'
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

            // Hàm thêm hàng tự động khi nhập vào ô input
            $(document).on('click', '.btn-create-normal_index', function() {
                $('#criterial-normal_indexes').append(appendRowForCriterial());
            });

            $(document).on('click', '.btn-update-criterial', function(e) {
                e.preventDefault();
                const id = $(this).attr('data-id'),
                    form = $('#criterial-form');
                resetForm(form);
                form.find('#criterial-normal_indexes').empty();
                $.get(`{{ route('admin.criterial') }}/${id}`, function(criterial) {
                    form.find('[name=id]').val(criterial.id);
                    form.find('[name=name]').val(criterial.name);
                    form.find('[name=description]').val(criterial.description);
                    form.find('[name="unit"]').val(criterial.unit);
                    const normal_index = criterial.normal_index ? JSON.parse(criterial.normal_index) : [];
                    if (normal_index.length !== 0) {
                        normal_index.forEach(function(item) {
                            form.find('#criterial-normal_indexes').append(appendRowForCriterial(item));
                        });
                    } else {
                        form.find('#criterial-normal_indexes').append(appendRowForCriterial());
                    }
                    form.attr('action', `{{ route('admin.criterial.update') }}`);
                    form.find('.modal').modal('show');
                });
            });
            initDataTable('criterial-table', '6, 7');
        })
    </script>
@endpush
