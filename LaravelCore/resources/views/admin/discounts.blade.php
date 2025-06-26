@extends('admin.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h5 class="text-uppercase">{{ __('messages.discount_.discount_management') }}</h5>
                    <nav class="breadcrumb-header float-start" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">{{ __('messages.discount_.discount_management') }}</li>
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
                    @if (!empty(Auth::user()->can(App\Models\User::CREATE_DISCOUNT)))
                        <a class="btn btn-info mb-3 block btn-create-discount">
                            <i class="bi bi-plus-circle"></i>
                            {{__('messages.add') }}
                        </a>
                    @endif
                    <div class="d-inline-block process-btns d-none">
                        @if (!empty(Auth::user()->can(App\Models\User::DELETE_DISCOUNTS)))
                            <a class="btn btn-danger btn-removes mb-3 ms-2" type="button">
                                <i class="bi bi-trash"></i>
                                {{ __('messages.delete') }}
                            </a>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-lg-2">
                    @if (Auth::user()->branches->count())
                        <select
                            class="form-control form-control-lg form-control-plaintext bg-transparent text-end list-branches" required autocomplete="off">
                            <option selected hidden disabled>{{ __('messages.datatable.your_branch') }}</option>
                            @foreach (Auth::user()->branches as $branch)
                                <option value="{{ $branch->id }}" {{ isset($_GET['branch_id']) && $_GET['branch_id'] == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>
            <div class="card">
                @if (!empty(Auth::user()->can(App\Models\User::READ_DISCOUNTS)))
                    <div class="card-body">
                        <form class="batch-form" method="post">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered key-table" id="discount-table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('messages.datatable.code') }}</th>
                                            <th>{{ __('messages.discount_.discount_name') }}</th>
                                            <th>{{ __('messages.datatable.branch') }}</th>
                                            <th>{{ __('messages.discount_.type') }}</th>
                                            <th>{{ __('messages.discount_.vality') }}</th>
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

        @include('admin.includes.partials.modal_discount')
    </div>
@endsection

@push('scripts')
    <script>
        config.routes.get = `{{ route('admin.discount') }}`
        config.routes.remove = `{{ route('admin.discount.remove') }}`

        $(document).ready(function() {
            const table = $('#discount-table').DataTable({
                dom: 'lftip',
                processing: true,
                serverSide: true,
                ajax: {
                    url: config.routes.get + window.location.search
                },
                columns: [
                    config.datatable.columns.code,
                    config.datatable.columns.name,
                    {
                        data: 'branch',
                        name: 'branch',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'type',
                        name: 'type',
                        searchable: false,
                    },
                    {
                        data: 'validity',
                        name: 'validity',
                        searchable: false,
                        sortable: false
                    },
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

            let initVal = $('.list-branches').val();
            if (initVal) {
                table.column(2).visible(false);
            } else {
                table.column(2).visible(true);
            }

            $(document).on('change', '#discount-type', function() {
                const type = $(this).val()
                setDiscountType(parseInt(type))
            })

            $(document).on('click', '.btn-create-discount', function() {
                const form = $('#discount-form')
                resetForm(form)
                $('.discount-units').empty()
                form.find('[name=status]').prop('checked', true)
                $('.discount-type').addClass('d-none')
                form.attr('action', `{{ route('admin.discount.create') }}`).find('.modal').modal('show')
            })

            $(document).on('click', '.btn-update-discount', function() {
                const form = $('#discount-form'),
                    id = $(this).attr('data-id');
                resetForm(form)
                $('.discount-units').empty()
                $.get(`{{ route('admin.discount') }}/${id}`, function(discount) {
                    form.find(`[name=id]`).val(discount.id)
                    form.find(`[name=name]`).val(discount.name)

                    const branch = new Option(discount.branch.name, discount.branch_id, true, true)
                    form.find(`[name='branch_id']`).html(branch).trigger({
                        type: 'select2:select'
                    });

                    form.find('[name=type]').val(discount.type)

                    if (discount.type <= 1) {
                        setDiscountType(discount.type, discount.value, discount.min_quantity)
                    } else {
                        setDiscountType(discount.type, discount.buy_quantity, discount.get_quantity)
                    }

                    form.find('[name=start_date]').val(discount.start_date)
                    form.find('[name=end_date]').val(discount.end_date)

                    if (discount.units) {
                        $.each(discount.units, function(index, unit) {
                            const text = `<div class="discount-unit d-flex">
                                <p>${unit._variable.fullName} (${unit.term})</p>
                                <input type="hidden" name="unit_ids[]" value="${unit.id}">
                                <i class="bi bi-x-circle-fill ms-auto cursor-pointer text-danger btn-remove-discount-unit"></i>
                            </div>`;
                            $('#discount-form .discount-units').append(text)
                        })
                    }

                    form.find('[name=status]').prop('checked', discount.status)

                    form.attr('action', `{{ route('admin.discount.update') }}`).find('.modal').modal('show')
                })
            })


            $('.list-branches').change(function() {
                window.location.href = `{{ route('admin.discount') }}?branch_id=${$(this).val()}`
            })

            // Xử lý nhập dữ liệu giá trị
            $('[name=value]').on('keypress', function(e) {
                var char = String.fromCharCode(e.which);
                if (!/[0-9.]/.test(char)) {
                    e.preventDefault();
                    return;
                }

                var value = $(this).val();

                if (char === '.' && value.indexOf('.') !== -1) {
                    e.preventDefault();
                    return;
                }
            });

            // Phòng trường hợp dán
            $('[name=value]').on('input', function() {
                var val = $(this).val();
                var cleanVal = val.replace(/[^0-9.]/g, '');

                var parts = cleanVal.split('.');
                if (parts.length > 2) {
                    cleanVal = parts[0] + '.' + parts.slice(1).join('');
                }

                if (val !== cleanVal) {
                    $(this).val(cleanVal);
                }
            });

            $(document).on('click', '.btn-select-variable', function() {
                const json = $(this).find('input[type=hidden]').val(),
                    obj = JSON.parse(json),
                    text = `<div class="discount-unit d-flex">
                                <p>${obj._variable.fullName} (${obj.term})</p>
                                <input type="hidden" name="unit_ids[]" value="${obj.id}">
                                <i class="bi bi-x-circle-fill ms-auto cursor-pointer text-danger btn-remove-discount-unit"></i>
                            </div>`;
                $('#discount-form .discount-units').append(text)
            })

            $(document).on('click', '.btn-remove-discount-unit', function() {
                $(this).closest('.discount-unit').remove()
            })

        })

        function setDiscountType(type, a = null, b = null) {
            const form = $('#discount-form')
            form.find('.discount-type').addClass('d-none')
            switch (type) {
                case 0:
                    $('.discount-price').removeClass('d-none').find('[name=value]').removeClass('money').end().find('.discount-value-type').text('%')
                    if (a && b) {
                        form.find('[name=value]').val(a)
                        form.find('[name=min_quantity]').val(b)
                    } else if (input = form.find('[name=value]').val()) {
                        form.find('[name=value]').val(parseFloat(input).toFixed(2))
                    }
                    break;
                case 1:
                    $('.discount-price').removeClass('d-none').find('[name=value]').addClass('money').end().find('.discount-value-type').text('VND')
                    if (a && b) {
                        form.find('[name=value]').val(Math.floor(a))
                        form.find('[name=min_quantity]').val(b)
                    } else if (input = form.find('[name=value]').val()) {
                        form.find('[name=value]').val(Math.floor(input))
                    }
                    break;
                case 2:
                    $('.discount-buy-get').removeClass('d-none')
                    if (a && b) {
                        form.find('[name=buy_quantity]').val(a)
                        form.find('[name=get_quantity]').val(b)
                    }
                    break;
                default:
                    break;
            }
        }
    </script>
@endpush
