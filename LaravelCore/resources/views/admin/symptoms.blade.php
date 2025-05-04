@extends('admin.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <h5 class="text-uppercase">{{ $pageName }}</h5>
                    <nav class="breadcrumb-header float-start" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Bảng tin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $pageName }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-12 col-lg-6">
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-12">
                    @if (!empty(Auth::user()->can(App\Models\User::CREATE_SYMPTOM)))
                        <a class="btn k-btn-info mb-3 block btn-create-symptom">
                            <i class="bi bi-plus-circle"></i>
                            Thêm
                        </a>
                    @endif
                    <div class="d-inline-block process-btns d-none">
                        @if (!empty(Auth::user()->can(App\Models\User::DELETE_SYMPTOMS)))
                            <a class="btn btn-danger btn-removes mb-3 ms-2" type="button">
                                <i class="bi bi-trash"></i>
                                Xoá
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card">
                @if (!empty(Auth::user()->can(App\Models\User::READ_SYMPTOMS)))
                    <div class="card-body">
                        <form class="batch-form" method="post">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered key-table" id="symptom-table">
                                    <thead>
                                        <tr>
                                            <th>Mã</th>
                                            <th>Tên</th>
                                            <th>Nhóm cơ quan</th>
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
        config.routes.get = `{{ route('admin.symptom') }}`
        config.routes.remove = `{{ route('admin.symptom.remove') }}`

        $(document).ready(function() {
            const table = $('#symptom-table').DataTable({
                bStateSave: true,
                stateSave: true,
                serverSide: true,
                orderCellsTop: true,
                ajax: {
                    url: `{{ route('admin.symptom') }}` + window.location.search
                },
                columns: [
                    config.datatable.columns.code,
                    config.datatable.columns.name, {
                        data: 'group',
                        name: 'group'
                    },
                    config.datatable.columns.action,
                    config.datatable.columns.checkboxes,
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
            initDataTable('symptom-table', '4, 5')
            $(document).on('click', '.btn-create-symptom', function(e) {
                e.preventDefault();
                const form = $('#symptom-form')
                resetForm(form)
                form.attr('action', `{{ route('admin.symptom.create') }}`)
                form.find('.modal').modal('show')
            })

            $(document).on('click', '.btn-update-symptom', function(e) {
                e.preventDefault();
                const id = $(this).attr('data-id'),
                    form = $('#symptom-form');
                resetForm(form)
                $.get(`{{ route('admin.symptom') }}/${id}`, function(symptom) {
                    form.find('[name=id]').val(symptom.id)
                    form.find('[name=name]').val(symptom.name)
                    form.find('[name=group]').val(symptom.group)
                    $.each(symptom.diseases, function(i, disease) {
                        form.find(`input[name='diseases[]'][value='${disease.id}']`).prop(
                            'checked', true);
                    })
                    $.each(symptom.medicines, function(i, medicine) {
                        form.find(`input[name='medicines[]'][value='${medicine.id}']`).prop(
                            'checked', true);
                    })
                    $.each(symptom.services, function(i, service) {
                        form.find(`input[name='services[]'][value='${service.id}']`).prop(
                            'checked', true);
                    })
                    sortCheckedInput(form)
                    form.attr('action', `{{ route('admin.symptom.update') }}`)
                    form.find('.modal').modal('show')
                })
            })
        })
    </script>
@endpush
