@extends('admin.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-4 col-lg-6 order-md-1 order-last">
                    <h5 class="text-uppercase">{{ $pageName }}</h5>
                </div>
                <div class="col-12 col-md-4 col-lg-6 order-md-2 order-first">
                    <nav class="breadcrumb-header float-start float-lg-end" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">{{ $pageName }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    @if (session('response') && session('response')['status'] == 'success')
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check"></i>
            {!! session('response')['msg'] !!}
            <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close"></button>
        </div>
    @elseif (session('response'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-xmark"></i>
            {!! session('response')['msg'] !!}
            <button class="btn-close" data-bs-dismiss="alert" type="button" aria-label="Close"></button>
        </div>
    @endif
    @if (!empty(Auth::user()->can(App\Models\User::READ_SETTINGS)))
        <div class="page-content mb-3">
            <div class="row justify-content-center">
                <div class="col-12">
                    <ul class="nav nav-pills mb-3">
                        <li class="nav-item">
                            <a class="nav-link{!! Request::path() === 'quantri/setting/general' ? ' active" aria-current="page' : '' !!}" href="{{ route('admin.setting', ['key' => 'general']) }}">
                                General settings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link{!! Request::path() === 'quantri/setting/shop' ? ' active" aria-current="page' : '' !!}" href="{{ route('admin.setting', ['key' => 'shop']) }}">
                                Shop settings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link{!! Request::path() === 'quantri/setting/website' ? ' active" aria-current="page' : '' !!}" href="{{ route('admin.setting', ['key' => 'website']) }}">
                                Website settings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link{!! Request::path() === 'quantri/setting/work' ? ' active" aria-current="page' : '' !!}" href="{{ route('admin.setting', ['key' => 'work']) }}">
                                Work shift settings
                            </a>
                        </li>
                    </ul>
                    @switch(true)
                        @case(Request::path() === 'quantri/setting/shop')
                            @include('admin.includes.setting_shop')
                        @break

                        @case(Request::path() === 'quantri/setting/website')
                            @include('admin.includes.setting_website')
                        @break

                        @case(Request::path() === 'quantri/setting/work')
                            @include('admin.includes.setting_work')
                        @break

                        @default
                            @include('admin.includes.setting_general')
                    @endswitch
                </div>
            </div>
        </div>
    @else
        @include('admin.includes.access_denied')
    @endif
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).on('click', '.btn-remove-bank-account', function() {
                if ($('.bank-accounts').children().length > 1) {
                    $('.bank-accounts').children().last().remove();
                } else {
                    pushToastify('Please add at least one bank account', 'danger')
                }
            })
            $(document).on('click', '.btn-add-bank-account', function() {
                let number_accounts = $('.bank-accounts').children().length;
                let str = `<div class="bank-account"><hr>
                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label" for="bank_id-${number_accounts}">Bank<br />
                                        <small class="form-text text-muted" id="bank_id-help-${number_accounts}"> Used for generating QR codes for order payments.</small>
                                    </label>
                                    <div class="col-sm-8">
                                        <div class="d-none bank-names-hidden"></div>
                                        <select name="bank_ids[${number_accounts}]" id="bank_id-${number_accounts}" class="bank-selected form-select @error('bank_ids.${number_accounts}') is-invalid @enderror"> <option selected disabled hidden>Please select a bank</option> @foreach ($banks['data'] as $bank)     @if ($bank['transferSupported'] == 1)         <option data-bank_name="{{ $bank['short_name'] }}" value="{{ $bank['bin'] }}">             {{ $bank['short_name'] }} - {{ $bank['name'] }}         </option>     @endif @endforeach
                                        </select>
                                        @error('bank_ids.${number_accounts}') <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong> </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label" for="bank_account-${number_accounts}">Account name<br />
                                        <small class="form-text text-muted" id="bank_account-help-${number_accounts}">Used for generating QR codes for order payments.</small>
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control @error('bank_accounts.${number_accounts}') is-invalid @enderror" id="bank_account-${number_accounts}" name="bank_accounts[${number_accounts}]" type="text">
                                        @error('bank_accounts.${number_accounts}') <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong> </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label" for="bank_number-${number_accounts}">Account number<br />
                                        <small class="form-text text-muted" id="bank_number-help-${number_accounts}">Used for generating QR codes for order payments.</small>
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control @error('bank_numbers.${number_accounts}') is-invalid @enderror" id="bank_number-${number_accounts}" name="bank_numbers[${number_accounts}]" type="text">
                                        @error('bank_numbers.${number_accounts}') <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong> </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>`;
                $('.bank-accounts').append(str);
            });
            $(document).on('change', '.bank-selected', function() {
                const bankNameSelected = $(this).find('option:selected').attr('data-bank_name');
                console.log(bankNameSelected);
                $(this).parent().find('.bank-names-hidden').html(`<input type="hidden" name="bank_names[]" value="${bankNameSelected}">`)
            })
            $(document).on('input', '#expired_notification_frequency-preview', function() {
                let value = $(this).val().replace(/[^0-9]/g, '');
                $(this).val(value);
            }).on('focus', '#expired_notification_frequency-preview', function() {
                let value = $(this).val().replace(/[^0-9]/g, '');
                $(this).val(value);
            }).on('blur', '#expired_notification_frequency-preview', function() {
                let value = $(this).val().replace(/[^0-9]/g, '');
                $(this).val(value ? `Every ${value} days` : '');
                $('input[name="expired_notification_frequency"]').val(value);
            });

            // thiêt lập ca làm việc
            $(document).on('click', '.btn-remove-shift', function() {
                $(this).closest('tr').remove(); // Xóa dòng tương ứng với nút xóa
            });

            // Hàm để reset lại chỉ số của các dòng
            function resetShiftIndexes() {
                $('.work-shift').each(function(index) {
                    $(this).find('input[name^="shift_name"]').attr('name', `shift_name[${index}]`);
                    $(this).find('input[name^="sign_checkin"]').attr('name', `sign_checkin[${index}]`);
                    $(this).find('input[name^="sign_checkout"]').attr('name', `sign_checkout[${index}]`);
                    $(this).find('input[name^="staff_number"]').attr('name', `staff_number[${index}]`);
                });
            }

            // Sự kiện thêm ca mới
            $('.btn-add-shift').on('click', function() {
                const index = $('.work-shift').length;
                var newRow = `
                    <tr class="work-shift">
                        <td><input class="form-control form-control-plaintext w-auto" name="shift_name[${index}]" type="text" placeholder="Shift name"></td>
                        <td><input class="form-control-plaintext" name="sign_checkin[${index}]" type="time"></td>
                        <td><input class="form-control-plaintext" name="sign_checkout[${index}]" type="time"></td>
                        <td><input class="form-control form-control-plaintext w-auto" name="staff_number[${index}]" type="text" placeholder="Number of staff in shift"></td>
                        <td>
                            <button class="btn btn-link text-decoration-none btn-remove-shift cursor-pointer" type="button">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>`;
                !$('.work-shift').length ? $('.table-shift tbody').html(newRow) : $('.table-shift tbody').append(newRow);
            });

            $(document).on('click', '.btn-remove-shift', function() {
                $(this).closest('tr').remove(); // Xóa dòng khi nhấn nút xóa
                !$('.work-shift').length ? $('.table-shift tbody').html(`<tr class="text-center fst-italic text-primary"><th colspan="5"><h6 class="pt-2">There is no shift.</h6></th></tr>`) : '';
                resetShiftIndexes();
            });
        })

        $(document).on('click', '.btn-add-expense', function () {
            let index = $('.expense-group-item').length;
            let newExpenseField = `
                <div class="mb-3 row expense-group-item">
                        <input class="form-control" name="expense_group[]" type="text" placeholder="Enter expense item">
                </div>
            `;
            $('.expense-group-container').append(newExpenseField);
        });

        $(document).on('click', '.btn-remove-expense', function () {
            if ($('.expense-group-item').length > 1) {
                $('.expense-group-item').last().remove();
            } else {
                pushToastify('Please add at least one expense item.', 'danger');
            }
        });

    </script>
@endpush
