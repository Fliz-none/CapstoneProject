@extends('admin.layouts.app')
@section('title')
    {{ $pageName }}
@endsection
@section('content')
    <div class="row tabbar">
        <div class="col-12 col-lg-4 mb-2">
            <div class="dropdown ajax-search">
                <div class="form-group mb-0 has-icon-left">
                    <div class="position-relative search-form">
                        <input class="form-control form-control-lg search-input" id="order-search-input"
                            data-url="{{ route('admin.stock') }}?key=search" type="text" autocomplete="off"
                            placeholder="Search products (F3)">
                        <div class="form-control-icon">
                            <i class="bi bi-search"></i>
                        </div>
                    </div>
                </div>
                <ul class="dropdown-menu shadow-lg overflow-auto w-100 search-result" id="order-search-result"
                    aria-labelledby="dropdownMenuButton" style="max-height: 45rem">
                    <!-- Search results will be appended here -->
                </ul>
            </div>
        </div>
        <div class="col-12 col-lg-8 mb-2">
            <ul class="nav nav-pills" id="order-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link btn-lg cursor-pointer btn-create-tab">
                        <i class="bi bi-plus-circle"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="tab-content" id="order-contents">
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $('.btn-create-tab').click(function() {
            const nextCount = $('.order-tab').length + 1
            if (nextCount > 5) {
                Toastify({
                    text: "You can create up to 5 orders at the same time.",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "center",
                    backgroundColor: "var(--bs-danger)",
                }).showToast();
                return false;
            }
            $('#order-contents').append(`
                <div class="tab-pane fade" id="order-${nextCount}" role="tabpanel" aria-labelledby="order-${nextCount}-tab">
                    <form action="{{ route('admin.order.create') }}" method="post" class="save-form">
                        <div class="row order-receipt">
                            <div class="col-12 col-lg-9 d-flex flex-column">
                                <div class="card h-100 mb-4">
                                    <div class="card-body order-details">
                                    </div>
                                </div>
                                <div class="card mt-auto">
                                    <div class="card-body p-3">
                                        <div class="form-group has-icon-left mb-0">
                                            <div class="position-relative">
                                                <textarea class="form-control form-control-lg border border-0" id="order-${nextCount}-note" name="note" rows="1" placeholder="Note"></textarea>
                                                <div class="form-control-icon">
                                                    <i class="bi bi-pen"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-3 d-flex flex-column">
                                <div class="card h-100">
                                    <div class="card-body d-flex flex-column">
                                        <div class="row">
                                            <label class="col-sm-4 mb-0 col-form-label d-flex align-items-center" for="order-${nextCount}-created_at">Created At</label>
                                            <div class="col-sm-8">
                                                <input class="form-control-plaintext text-end order-created_at" id="order-${nextCount}-created_at" name="created_at" type="datetime-local" max="{{ date('Y-m-d') }}" inputmode="numeric" autocomplete="off" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-4 mb-0 col-form-label d-flex align-items-center" for="order-${nextCount}-customer_id">
                                                Customer&nbsp;
                                                <a class="btn btn-link btn-create-user rounded-pill p-0" type="button">
                                                    <i class="bi bi-plus-circle"></i>
                                                </a>
                                            </label>
                                            <div class="col-sm-8">
                                                <select class="form-control-plaintext form-control select2 order-customer_id" id="order-${nextCount}-customer_id" name="customer_id" data-ajax--url="{{ route('admin.user', ['key' => 'select2']) }}" data-placeholder="Search customers (F4)" required autocomplete="off">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group mb-3 p-2 bg-light rounded-3 customer-suggestions">
                                        </div>
                                        <hr />
                                        <div class="row mb-3 row-total">
                                            <label class="col-sm-4 mb-0 col-form-label d-flex align-items-center" for="order-${nextCount}-total" data-bs-toggle="tooltip" data-bs-title="Total value of goods in the order">Total <span class="order-count px-1">0</span> items&nbsp;</label>
                                            <div class="col-sm-8">
                                                <input class="form-control-lg bg-white text-end form-control bg-white money order-total" id="order-${nextCount}-total" name="total" type="text" value="0" placeholder="Total money of the order" autocomplete="off" readonly>
                                            </div>
                                        </div>
                                        <div class="row row-discount">
                                            <label class="col-sm-4 mb-0 col-form-label d-flex align-items-center" for="order-${nextCount}-discount" data-bs-toggle="tooltip" data-bs-title="Price on total order (Amount or Percentage)">Discount</label>
                                            <div class="col-sm-8">
                                                <input class="form-control-lg text-end form-control bg-white money order-discount" id="order-${nextCount}-discount" name="discount" type="text" value="0" onclick="this.select()" placeholder="Amount or Percentage" autocomplete="off">
                                            </div>
                                        </div>
                                        <hr />
                                        <div class="row mb-3 row-summary">
                                            <label class="col-sm-4 mb-0 col-form-label d-flex align-items-center" for="order-${nextCount}-summary" data-bs-toggle="tooltip" data-bs-title="Amount due">Amount due</label>
                                            <div class="col-sm-8">
                                                <input class="form-control-lg text-end form-control bg-white money order-summary" id="order-${nextCount}-summary" name="summary" type="text" value="0" placeholder="Amount" autocomplete="off" readonly>
                                            </div>
                                        </div>
                                        <div class="order-payments" id="order-${nextCount}-payments">
                                        </div>
                                        <div class="row mb-3 row-change d-none">
                                            <label class="col-sm-4 mb-0 col-form-label d-flex align-items-center" for="order-${nextCount}-change" data-bs-toggle="tooltip" data-bs-title="Change returned to customer (in cash)">Change</label>
                                            <div class="col-sm-8">
                                                <input class="form-control-lg text-end form-control bg-white money order-change" id="order-${nextCount}-change" name="change" type="text" value="0" placeholder="Amount" autocomplete="off" readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-3 row-due d-none">
                                            <label class="col-sm-4 mb-0 col-form-label d-flex align-items-center" for="order-${nextCount}-due" data-bs-toggle="tooltip" data-bs-title="Amount remaining to be paid">Remaining balance</label>
                                            <div class="col-sm-8">
                                                <input class="form-control-lg text-end form-control bg-white money order-due" id="order-${nextCount}-due" name="due" type="text" value="0" placeholder="Amount" autocomplete="off" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group mb-3 mt-auto p-2 bg-light rounded-3 money-suggestion">
                                        </div>
                                        <div class="form-group mb-3">
                                            <div class="btn-group btn-group-lg dropup" role="group">
                                                <input class="btn-check order-payment" id="order-${nextCount}-payment-1" type="radio" value="1" autocomplete="off" name="payment">
                                                <label class="btn btn-outline-info" for="order-${nextCount}-payment-1">Cash</label>
                                                <input class="btn-check order-payment" id="order-${nextCount}-payment-2" type="radio" value="2" autocomplete="off" name="payment">
                                                <label class="btn btn-outline-info" for="order-${nextCount}-payment-2">Bank Transfer</label>
                                                <input class="btn-check order-payment" id="order-${nextCount}-payment-3" type="radio" value="3" autocomplete="off" name="payment">
                                                <label class="btn btn-outline-info" for="order-${nextCount}-payment-3">Card</label>
                                                <button class="btn btn-outline-info order-payment dropdown-toggle dropdown-toggle-split" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="bi bi-plus-circle"></i>
                                                </button>
                                                <div class="dropdown-menu" style="">
                                                    <a class="dropdown-item btn-create-payment fw-bold fs-5" data-value="3">Swipe Card</a>
                                                    <a class="dropdown-item btn-create-payment fw-bold fs-5" data-value="2">Bank Transfer</a>
                                                    <a class="dropdown-item btn-create-payment fw-bold fs-5" data-value="1">Cash</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-0">
                                            <div class="d-grid gap-2">
                                                @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_ORDER, App\Models\User::CREATE_ORDER)))
                                                    <input name="status" type="hidden" value="3">
                                                    <input name="id" type="hidden">
                                                    <button class="btn btn-lg btn-info btn-submit" type="submit">Save</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>`)
            $(this).parent().before(`
                <li class="nav-item position-relative" role="presentation">
                    <a class="nav-link btn-lg order-tab pe-5" id="order-${nextCount}-tab" data-bs-toggle="tab" href="#order-${nextCount}" role="tab" aria-controls="order-${nextCount}" aria-selected="false">
                        Order ${nextCount}
                    </a>
                    <button type="button" class="btn btn-light-primary btn-close-tab opacity-50 px-2 py-0 me-2 position-absolute end-0 top-50 translate-middle-y" data-index="${nextCount}">&times;</button>
                </li>`)
            var newTab = new bootstrap.Tab(document.getElementById(`order-${nextCount}-tab`));
            newTab.show();
            $('.tab-pane.active').find('[name=customer_id]').attr('data-ajax--url',
                `{{ route('admin.user', ['key' => 'select2']) }}`).select2(config.select2);
            $('.tab-content > .tab-pane > form > .row > .col-12').css('min-height', 'calc(100vh - ' + $('header')
                .outerHeight(true) + 'px)');
        })
        $('.btn-create-tab').trigger('click')
        $('header').removeClass('mb-3')

        $(document).on('shown.bs.tab', '#order-tabs a', function(event) {
            $('.tab-pane.active').find('[name=customer_id]').attr('data-ajax--url',
                `{{ route('admin.user', ['key' => 'select2']) }}`).select2(config.select2);
            $('.tab-content > .tab-pane > form > .row > .col-12').css('min-height', 'calc(100vh - ' + $('header')
                .outerHeight(true) + 'px)');
        });

        /**
         * Xử lý đóng tab
         */
        $(document).on('click', '.btn-close-tab', function(e) {
            e.preventDefault()
            const index = $(this).attr('data-index')
            Swal.fire(config.sweetAlert).then((result) => {
                if (result.isConfirmed) {
                    closeTab(index)
                }
            });
        })

        function closeTab(index) {
            const orderContent = $(`#order-${index}`),
                orderTab = $(`.btn-close-tab[data-index=${index}]`).closest('li')
            orderContent.remove()
            orderTab.remove()
            if ($('.order-tab').length) {
                if (!$('.order-tab.active').length) {
                    const lastIndex = $('.btn-close-tab:last-child').attr('data-index'),
                        lastTab = new bootstrap.Tab(document.getElementById(`order-${lastIndex}-tab`));
                    lastTab.show();
                }
            } else {
                $('.btn-create-tab').trigger('click')
            }
        }

        /**
         * Xử lý sự kiện bàn phím
         */
        $(document).keydown(function(e) {
            if ((e.ctrlKey || e.metaKey) && (e.key === 'f' || e.key === 'k' || e.key === 'n')) {
                switch (e.key) {
                    case 'f':
                        $('.search-form input').val('').change().focus()
                        $('.search-result').removeClass('show');
                        break;
                    case 'k':
                        $('.tab-pane.active').find('[name=customer_id]').select2('open')
                        setTimeout(() => {
                            $('input.select2-search__field').focus()
                        }, 1000);
                        break;
                    case 'n':
                        $('.btn-create-tab').trigger('click')
                        $('.search-form input').val('').change().focus()
                        break;

                    default:
                        break;
                }
            } else {
                switch (e.key) {
                    case 'Escape':
                        $('.search-form input').val('').change().focus()
                        $('.search-result').removeClass('show');
                        break;
                    case 'Enter':
                        e.preventDefault()
                        break;
                    case 'F3':
                        e.preventDefault()
                        $('.search-form input').val('').change().focus()
                        $('.search-result').removeClass('show');
                        break;
                    case 'F4':
                        e.preventDefault()
                        $('.tab-pane.active').find('[name=customer_id]').select2('open')
                        setTimeout(() => {
                            $('input.select2-search__field').focus()
                        }, 1000);
                        break;
                    default:
                        break;
                }
            }
        })

        /**
         * Xử lý thanh toán
         */
        $(document).on('click', '.order-payment', function() {
            const summary = $('.tab-pane.active').find('.order-summary').val()
            choosePayment($(this).val(), summary)
        })

        $(document).on('click', '.btn-create-payment', function() {
            const due = $('.tab-pane.active').find('.order-due').val()
            choosePayment($(this).attr('data-value'), due, 0)
        })

        function suggestPaymentAmounts(total) {
            const suggestions = new Set();
            const baseAmount = parseInt(total);

            // Thêm giá trị chính xác của đơn hàng
            suggestions.add(baseAmount);

            // Gợi ý các mức tiền tròn tiếp theo
            let increment = 10000;
            while (increment < 1000000) {
                let roundedAmount = Math.ceil(baseAmount / increment) * increment;
                if (roundedAmount !== baseAmount) {
                    suggestions.add(roundedAmount);
                }
                increment *= 10; // Tăng lên bậc tròn tiếp theo
            }

            // Thêm các mức tiền cố định (200.000, 500.000) nếu lớn hơn baseAmount
            const fixedAmounts = [200000, 500000];
            fixedAmounts.forEach(amount => {
                if (amount > baseAmount) {
                    suggestions.add(amount);
                }
            });

            return Array.from(suggestions).sort((a, b) => a - b);
        }

        function choosePayment(type, amount, clear = 1) {
            toggleBalance()
            switch (type) {
                case '1':
                    addPayToOrder(1, 'Cash payment', amount, clear)
                    $('.money-suggestion').html(suggestPaymentAmounts(amount).map((number) => {
                        return `<button class="btn btn-outline-info btn-suggest-amount cursor-pointer rounded-pill ms-1 mb-1" data-value="${number}" data-clear="${clear}" type="button">${number_format(number)}</button>`
                    }).join(''))
                    break;
                case '2':
                    chooseTransfer(clear);
                    break;
                case '3':
                    addPayToOrder(0, 'Swipe card payment', amount, clear);
                    break;
                default:
                    break;
            }
        }

        function chooseTransfer(clear = true) {
            const tab = $('.tab-pane.active'),
                bankInfos = @json($bankInfos);
            let optionsHtml = '';
            bankInfos.forEach((bank, index) => {
                optionsHtml +=
                    `<option value="${index}" data-bank_name="${bank.bank_name}">${bank.bank_account} - ${bank.bank_number} - ${bank.bank_name}</option>`;
            });

            Swal.fire({
                title: 'Thêm thanh toán',
                html: `
                    <select id="payment-select" class="form-select form-control-lg mb-3">
                        ${optionsHtml}
                    </select>
                    <input id="payment-amount" class="form-control form-control-lg mb-3 money" placeholder="Amount" value="${tab.find('input.order-summary').val()}">`,
                showCancelButton: true,
                confirmButtonText: 'Save',
                cancelButtonText: 'Cancel',
                focusConfirm: false,
                didOpen: () => {
                    paymentType = Swal.getPopup().querySelector('#payment-select');
                    paymentAmount = Swal.getPopup().querySelector('#payment-amount');
                    paymentAmount.addEventListener('input', function() {
                        $(this).val($(this).val().replace(/[^0-9]/g, ''));
                    });
                    $('.money').focus(function() {
                        $('.money').mask("#,##0", {
                            reverse: true
                        });
                    });
                    $('.money').blur(function() {
                        $('.money').unmask();
                    })
                    paymentType.addEventListener('keyup', (event) => event.key === 'Enter' && Swal
                    .clickConfirm());
                    paymentAmount.addEventListener('keyup', (event) => event.key === 'Enter' && Swal
                        .clickConfirm());
                },
                preConfirm: () => {
                    const note = $(paymentType).find('option:selected').attr('data-bank_name'),
                        type = parseInt(paymentType.value) + 2,
                        amount = paymentAmount.value;
                    // Kiểm tra xem cả hai trường đều được nhập và trường số tiền chỉ chứa giá trị số
                    if (!note || !amount || isNaN(parseFloat(amount))) {
                        Swal.showValidationMessage(`Data is invalid!`);
                    } else {
                        addPayToOrder(type, 'Through ' + note, amount, clear);
                    }
                }
            });
        }

        function addPayToOrder(type, note, amount, clear = true) {
            const tab = $('.tab-pane.active'),
                index = tab.attr('id').match(/order-(\d+)/)[1],
                count = clear ? 1 : tab.find(`.transaction-refund`).length + 1
            const newRow = `
                <div class="row mb-3 row-amount">
                    <label class="col-sm-4 mb-0 col-form-label d-flex align-items-center" for="transaction-${index}${count}-amount" data-bs-toggle="tooltip" data-bs-title="Amount due">${note}</label>
                    <div class="col-sm-8">
                        <div class="btn-group btn-group-lg">
                            <input type="hidden" name="transaction_refund[]" value="0">
                            <input type="checkbox" class="btn-check transaction-refund" id="transaction-${index}${count}-refund" autocomplete="off">
                            <label class="btn btn-outline-secondary" for="transaction-${index}${count}-refund"><i class="bi bi-reply-all-fill"></i></label>
                            <input type="hidden" value="${type}" name="transaction_payments[]">
                            <input type="hidden" value="${note}" name="transaction_notes[]">
                            <input class="form-control-lg text-end form-control money transaction-amount" id="transaction-${index}${count}-amount" name="transaction_amounts[]" type="text" value="${amount}" autocomplete="off" required>
                        </div>
                    </div>
                </div>`;
            if (clear) {
                tab.find(`#order-${index}-payments`).html(newRow);
            } else {
                tab.find(`#order-${index}-payments`).append(newRow);
            }
            toggleBalance()
        }

        $(document).on('click', '.btn-suggest-amount', function() {
            const clear = $(this).attr('data-clear') == '1' ? true : false
            addPayToOrder(1, 'Cash payment', $(this).attr('data-value'), clear)
        })

        $(document).on('change', '.transaction-amount', function() {
            toggleBalance()
        })

        $(document).on('change', '.transaction-refund', function() {
            const input = $(this).closest('.row-amount').find(`[name='transaction_notes[]']`),
                label = $(this).closest('.row-amount').find('label').eq(0),
                value = input.val()
            if ($(this).prop('checked')) {
                $(this).prev().val(1)
                if (value.includes('Income')) {
                    input.val(value.replace('Income', 'Expense'));
                    label.text(value.replace('Income', 'Expense'));
                }
            } else {
                $(this).prev().val(0)
                if (value.includes('Expense')) {
                    input.val(value.replace('Expense', 'Income'));
                    label.text(value.replace('Expense', 'Income'));
                }
            }
            toggleBalance();
        })

        function toggleBalance() {
            const tab = $('.tab-pane.active'),
                total = parseInt(tab.find('.order-summary').val().split(',').join('')),
                pay = tab.find('.transaction-amount').map(function() {
                    if ($(this).closest('.row-amount').find('.transaction-refund').prop('checked')) {
                        return parseFloat($(this).val().split(',').join('')) * -1 || 0;
                    } else {
                        return parseFloat($(this).val().split(',').join('')) || 0;
                    }
                }).get().reduce(function(sum, value) {
                    return sum + value;
                }, 0);
            if (pay - total >= 0) {
                tab.find('.order-change').val(pay - total).closest('.row').removeClass('d-none')
                tab.find('.order-due').val(0).closest('.row').addClass('d-none')
            } else {
                tab.find('.order-change').val(0).closest('.row').addClass('d-none')
                tab.find('.order-due').val(total - pay).closest('.row').removeClass('d-none')
            }
        }

        /**
         * Xử lý submit form
         */
        $(document).on('click', '.btn-submit', function(e) {
            e.preventDefault()
            const form = $(this).closest('form'),
                index = form.parent().attr('id').match(/order-(\d+)/)[1]
            submitForm(form).done(function(response) {
                closeTab(index)
                $.get(`{{ route('admin.order') }}/${response.id}/print`, function(template) {
                    $('#print-wrapper').html(template)
                    printJS({
                        printable: 'print-container',
                        type: 'html',
                        css: [`{{ asset('admin/css/bootstrap.css') }}`,
                            `{{ asset('admin/css/key.css') }}`
                        ],
                        targetStyles: ['*'],
                        showModal: false,
                    });
                })
            })
        })
    </script>
@endpush
