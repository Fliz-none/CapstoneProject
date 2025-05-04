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
                <div class="col-12">
                    @if (!empty(Auth::user()->can(App\Models\User::CREATE_COMPANY)))
                        <a class="btn btn-info mb-3 block btn-create-company">
                            <i class="bi bi-plus-circle"></i>
                            Thêm
                        </a>
                    @endif
                </div>
            </div>
            <div class="card">
                @if (!empty(Auth::user()->can(App\Models\User::READ_COMPANIES)))
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped" id="company-table" aaa="123">
                            <thead>
                                <tr>
                                    <th>Mã</th>
                                    <th>Tên công ty</th>
                                    <th>Địa chỉ công ty</th>
                                    <th>URL website</th>
                                    <th>Số điện thoại</th>
                                    <th>Trạng thái</th>
                                    <th>Hợp đồng đến</th>
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
        config.routes.batchRemove = `{{ route('admin.company.remove') }}`

        $(document).ready(function() {
            const table = $('#company-table').DataTable({
                dom: 'lftip',
                processing: true,
                serverSide: true,
                ajax: {
                    url: `{{ route('admin.company') }}` + window.location.search
                },
                columns: [
                    config.datatable.columns.code,
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'address',
                        name: 'address',
                    },
                    {
                        data: 'domain',
                        name: 'domain',
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                    },
                    {
                        data: 'status',
                        name: 'status',
                    },
                    {
                        data: 'deadline',
                        name: 'deadline',
                    },
                    config.datatable.columns.action,
                ],
                language: config.datatable.lang,
                pageLength: config.datatable.pageLength,
                aLengthMenu: config.datatable.lengths,
                columnDefs: config.datatable.columnDefines,
                order: [
                    [1, 'DESC']
                ]
            })

            $(document).on('click', '.btn-create-company', function(e) {
                e.preventDefault();
                const form = $('#company-form')
                resetForm(form)
                form.attr('action', `{{ route('admin.company.create') }}`)
                form.find('.modal').modal('show').find('.modal-title').text("Công ty")
            })

            $(document).on('click', '.btn-update-company', function(e) {
                e.preventDefault();
                const id = $(this).attr('data-id'),
                    form = $('#company-form');
                resetForm(form);

                $.get(`{{ route('admin.company') }}/${id}`, function(company) {
                    form.attr('action', `{{ route('admin.company.update') }}`);
                    form.find('[name=id]').val(company.id);
                    form.find('[name=name]').val(company.name);
                    form.find('[name=deadline]').val(moment(company.deadline).format('YYYY-MM-DD'));
                    form.find('[name=contract_total]').val(company.contract_total);
                    form.find('[name=address]').val(company.address);
                    form.find('[name=domain]').val(company.domain);
                    form.find('[name=phone]').val(company.phone);
                    form.find('[name=email]').val(company.email);
                    form.find('[name=tax_id]').val(company.tax_id);
                    form.find('[name=has_website]').prop('checked', company.has_website);
                    form.find('[name=has_shop]').prop('checked', company.has_shop);
                    form.find('[name=has_warehouse]').prop('checked', company.has_warehouse);
                    form.find('[name=has_clinic]').prop('checked', company.has_clinic);
                    form.find('[name=has_attendance]').prop('checked', company.has_attendance);
                    form.find('[name=has_beauty]').prop('checked', company.has_beauty);
                    form.find('[name=has_booking]').prop('checked', company.has_booking);
                    form.find('[name=note]').val(company.note);
                    form.find('[name=status]').prop('checked', company.status);
                    if (company.user_id != null) {
                        var option = new Option(company.user.name, company.user_id, true, true);
                        form.find('[name=user_id]').append(option).trigger({
                            type: 'select2:select'
                        });
                    } else {
                        form.find('[name=user_id]').val(null).trigger("change")
                    }
                    form.find('.modal').modal('show').find('.modal-title').text(company.code);
                });
            });

            $(document).on("click", ".btn-company-login", function(e) {
                e.preventDefault();
                const form = $(this).parent();
                Swal.fire({
                    title: "Xác nhận!",
                    text: "Đổi sang công ty này",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "var(--bs-success)",
                    cancelButtonColor: "var(--bs-primary)",
                    confirmButtonText: "Xác nhận",
                    cancelButtonText: "Quay lại",
                    reverseButtons: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        submitForm(form);
                    }
                });
            });
        })
    </script>
@endpush
