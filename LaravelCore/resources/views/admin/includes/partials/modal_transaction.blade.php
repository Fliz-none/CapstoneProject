<form class="save-form" id="transaction-form" name="transaction" method="post">
    @csrf
    <div class="modal fade" id="transaction-modal" aria-labelledby="transaction-modal-label">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title fs-5 text-white" id="transaction-modal-label">Transaction</h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <div class="row">
                            <div class="col-4 my-auto form-group">
                                <label data-bs-toggle="tooltip" data-bs-title="Customer performing the transaction" for="transaction-customer_id">{{ __('messages.datatable.customer') }}</label>
                            </div>
                            <div class="col-8">
                                <select class="form-select select2" id="transaction-customer_id" name="customer_id" data-ajax--url="{{ route('admin.user', ['key' => 'select2']) }}" data-placeholder="{{ __('messages.transaction.required_without') }}">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <div class="row">
                            <div class="col-4 my-auto form-group">
                                <label data-bs-toggle="tooltip" data-bs-title="Cashier performing the transaction with the customer" for="transaction-cashier_id">{{ __('messages.datatable.cashier') }}</label>
                            </div>
                            <div class="col-8">
                                <select class="form-select" id="transaction-cashier_id" name="cashier_id">
                                    <option selected disabled hidden>Select a cashier</option>
                                    @foreach (cache()->get('cashiers') as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <div class="row">
                            <div class="col-4 my-auto form-group">
                                <label class="form-label" data-bs-toggle="tooltip" data-bs-title="Customer's payment method" for="transaction-cash">{{ __('messages.datatable.payment_method') }}</label>
                            </div>
                            <div class="col-8">
                                <div class="my-3">
                                    <select class="form-select" id="transaction-payment" name="payment">
                                        <option value="1">{{ __('messages.datatable.cash') }}</option>
                                        @php
                                            $settings = cache()->get('settings');
                                            $bankInfos = isset($settings['bank_info']) ? json_decode($settings['bank_info'], true) : [];
                                        @endphp
                                        @foreach ($bankInfos as $index => $bank)
                                            <option value="{{ $index + 2 }}">{{ $bank['bank_number'] }} - {{ $bank['bank_account'] }} - {{ $bank['bank_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <div class="row">
                            <div class="col-4 my-auto form-group">
                                <label data-bs-toggle="tooltip" data-bs-title="Amount the customer has paid" for="transaction-amount">{{ __('messages.datatable.amount') }}</label>
                            </div>
                            <div class="col-8">
                                <h5>
                                    <div class="input-group">
                                        <input class="form-control w-50 transaction-amount money" id="transaction-amount" name="amount" type="text" value="0" placeholder="Payment amount" onclick="this.select()" inputmode="numeric"
                                            autocomplete="off" required>
                                        <span class="input-group-text">VND</span>
                                    </div>
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <div class="row">
                            <div class="col-4 my-auto">
                                <label class="form-label" for="transaction-pay">{{ __('messages.datatable.status') }}</label>
                            </div>
                            <div class="col-8">
                                <div class="my-3">
                                    <div class="d-grid">
                                        <div class="btn-group">
                                            <input class="btn-check" id="transaction-pay" name="status" type="radio" value="pay" checked>
                                            <label class="btn btn-outline-primary" for="transaction-pay">
                                                Collect
                                            </label>
                                            <input class="btn-check" id="transaction-refund" name="status" type="radio" value="refund">
                                            <label class="btn btn-outline-primary" for="transaction-refund">
                                                Refund
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <div class="row">
                            <div class="col-4 my-auto">
                                <label data-bs-toggle="tooltip" data-bs-title="Content or detailed information about the transaction" for="transaction-note">{{ __('messages.note') }}</label>
                            </div>
                            <div class="col-8">
                                <input class="form-control" id="transaction-note" name="note" type="text" placeholder="Enter payment details">
                            </div>
                        </div>
                    </div>
                    <hr class="px-5">
                    <div class="mb-3 text-end">
                        <button class="btn btn-light btn-print print-transaction" data-url="{{ getPath(route('admin.transaction')) }}" type="button">
                            <i class="bi bi-printer-fill"></i>
                        </button>
                        @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_TRANSACTION, App\Models\User::CREATE_TRANSACTION)))
                            <input name="id" type="hidden">
                            <input name="order_id" type="hidden">
                            <button class="btn btn-primary" id="transaction-submit" type="submit">
                                Save
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
