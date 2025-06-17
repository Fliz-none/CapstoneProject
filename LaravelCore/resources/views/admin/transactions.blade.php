@extends('admin.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h5 class="text-uppercase">{{ __('messages.transaction.transaction_mana') }}</h5>
                    <nav class="breadcrumb-header float-start" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">{{ __('messages.transaction.transaction_mana') }}</li>
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
                    @if (!empty(Auth::user()->can(App\Models\User::CREATE_TRANSACTION)))
                        <a class="btn btn-info mb-3 block btn-create-transaction">
                            <i class="bi bi-plus-circle"></i>
                            {{ __('messages.add') }}
                        </a>
                    @endif
                </div>
                <div class="col-12 col-lg-2">
                    @if (Auth::user()->branches->count())
                        <select
                            class="form-control form-control-lg form-control-plaintext bg-transparent text-end list-branches"
                            required autocomplete="off">
                            <option selected hidden disabled>{{ __('messages.datatable.your_branch') }}</option>
                            @foreach (Auth::user()->branches as $branch)
                                <option value="{{ $branch->id }}"
                                    {{ isset($_GET['branch_id']) && $_GET['branch_id'] == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>
            <div class="card">
                @if (!empty(Auth::user()->can(App\Models\User::READ_TRANSACTIONS)))
                    <div class="card-body">
                        <form id="batch-form" method="post">
                            <div class="table-responsive">
                                <table class="table table-bordered key-table" id="transaction-table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('messages.datatable.code') }}</th>
                                            <th>{{ __('messages.datatable.time') }}</th>
                                            <th>{{ __('messages.datatable.customer') }}</th>
                                            <th>{{ __('messages.datatable.cash') }}</th>
                                            <th>{{ __('messages.datatable.transfer') }}</th>
                                            <th>{{ __('messages.datatable.order') }}</th>
                                            <th>{{ __('messages.note') }}</th>
                                            <th>{{ __('messages.datatable.cashier') }}</th>
                                            <th>{{ __('messages.datatable.status') }}</th>
                                            <th></th>
                                            <th>
                                                <input class="form-check-input" id="all-choices" type="checkbox">
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </form>
                    </div>
                @else
                    @include('includes.access_denied')
                @endif
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        config.routes.load = `{{ route('admin.transaction') }}`
        config.routes.remove = `{{ route('admin.transaction.remove') }}`
        $(document).ready(function() {
            var groupColumn = 1;
            const table = $('#transaction-table').DataTable({
                bStateSave: true,
                stateSave: true,
                serverSide: true,
                orderCellsTop: true,
                ajax: {
                    url: config.routes.load + window.location.search
                },
                columns: [
                    config.datatable.columns.code,
                    config.datatable.columns.created_at,
                    config.datatable.columns.customer,
                    {
                        data: 'cash',
                        name: 'cash',
                        className: 'text-end',
                    },
                    {
                        data: 'transfer',
                        name: 'transfer',
                        className: 'text-end',
                    },
                    config.datatable.columns.order,
                    config.datatable.columns.note,
                    {
                        data: 'cashier',
                        name: 'cashier',
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'text-center',
                        sortable: false,
                    },
                    config.datatable.columns.action,
                    config.datatable.columns.checkboxes
                ],
                language: config.datatable.lang,
                pageLength: config.datatable.pageLength,
                aLengthMenu: config.datatable.lengths,
                columnDefs: config.datatable.columnDefines,
                order: [
                    [groupColumn, 'desc']
                ],
                drawCallback: function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;
                    api.column(groupColumn, {
                            page: 'current'
                        })
                        .data()
                        .each(function(date, i) {
                            let counting_date = moment(date).format('DD/MM/YYYY'),
                                transfer_amount = 0,
                                cash_amount = 0;
                            if (last !== counting_date) {
                                $(`[data-date='${counting_date}']`).each(function() {
                                    if (parseInt($(this).attr('data-payment')) > 1) {
                                        transfer_amount += parseInt($(this).val())
                                    } else {
                                        cash_amount += parseInt($(this).val())
                                    }
                                });
                                $(rows).eq(i).before(
                                    `<tr class="group bg-light-primary text-white">
                                        <td>${counting_date}</td>
                                        <td></td>
                                        <td class="text-end"><span class="fw-bold ${(cash_amount > 0 ? 'text-success">+' + number_format(cash_amount) : 'text-danger">' + number_format(cash_amount))}VND</span></td>
                                        <td class="text-end"><span class="fw-bold ${(transfer_amount > 0 ? 'text-success">+' + number_format(transfer_amount) : 'text-danger">' + number_format(transfer_amount))}VND</span></td>
                                        <td class="fw-bold text-end">${(number_format(cash_amount + transfer_amount))}VND</td>
                                        <td colspan="7"></td>
                                    </tr>`);
                                last = counting_date;
                            }
                        });
                }
            });
            initDataTable('transaction-table', '10, 11', '2');
            table.column(groupColumn).visible(false);
        })

        $('.list-branches').change(function() {
            window.location.href = `{{ route('admin.transaction') }}?branch_id=${$(this).val()}`
        })
    </script>
@endpush
