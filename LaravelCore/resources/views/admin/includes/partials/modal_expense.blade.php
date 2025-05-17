<form class="save-form" id="expense-form" name="expense" method="post">
    @csrf
    <div class="modal fade" id="expense-modal" aria-labelledby="expense-modal-label">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title fs-5 text-white" id="expense-modal-label">Expense Voucher</h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row p-0 p-md-2">
                        <div class="col-12 col-md-7">
                            <div class="mb-3 form-group">
                                <label data-bs-toggle="tooltip" data-bs-title="The recipient of this expense voucher" for="expense-receiver_id">Recipient</label>
                                <select class="form-select select2" id="expense-receiver_id" name="receiver_id" data-ajax--url="{{ route('admin.user', ['key' => 'select2']) }}" data-placeholder="Select recipient">
                                </select>
                            </div>
                            <div class="mb-3 form-group">
                                <label class="form-label" data-bs-toggle="tooltip" data-bs-title="Customer's payment method" for="expense-cash">Payment Method</label>
                                <div class="d-grid">
                                    <div class="btn-group">
                                        <input class="btn-check" id="expense-transfer" name="payment" type="radio" value="2" checked>
                                        <label class="btn btn-outline-primary" for="expense-transfer">
                                            Bank Transfer
                                        </label>
                                        <input class="btn-check" id="expense-cash" name="payment" type="radio" value="1">
                                        <label class="btn btn-outline-primary" for="expense-cash">
                                            Cash
                                        </label>
                                        <input class="btn-check" id="expense-card" name="payment" type="radio" value="0">
                                        <label class="btn btn-outline-primary" for="expense-card">
                                            Card Payment
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label data-bs-toggle="tooltip" data-bs-title="Amount of money spent" for="expense-amount">Amount</label>
                                <input class="form-control expense-amount money" id="expense-amount" name="amount" type="text" value="0" placeholder="Amount spent" onclick="this.select()" inputmode="numeric" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label data-bs-toggle="tooltip" data-bs-title="Categorize expenses by specific purpose" for="expense-note">Select Expense Category</label>
                                <select class="form-control" name="group" id="expense-group">
                                    @php
                                        $expense_group = cache()->get('settings')['expense_group'] ?? '[]';
                                    @endphp
                                    @foreach (json_decode($expense_group) as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label data-bs-toggle="tooltip" data-bs-title="Detailed notes about the expense voucher" for="expense-note">Notes</label>
                                <textarea class="form-control" id="expense-note" name="note" type="text" rows="3" placeholder="Enter notes"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-md-5">
                            <div class="sticky-top">
                                <div class="form-group mb-3">
                                    <label class="form-label ratio ratio-1x1 select-avatar" for="expense-avatar">
                                        <img class="img-fluid rounded-4 object-fit-cover" id="expense-avatar-preview" src="{{ asset('admin/images/placeholder.webp') }}" alt="Avatar">
                                    </label>
                                    <input class="form-control" id="expense-avatar" name="avatar" type="file" hidden accept="image/*">
                                    <div class="d-grid">
                                        <button class="btn btn-outline-primary btn-remove-image d-none" type="button">Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="px-5">
                    <div class="mb-3 text-end d-flex justify-content-between align-items-center">
                        {{-- <button class="btn btn-light btn-print print-expense" data-url="{{ getPath(route('admin.expense')) }}" type="button">
                            <i class="bi bi-printer-fill"></i>
                        </button> --}}
                        @if (Auth::user()->can(App\Models\User::APPROVE_EXPENSE))
                            <div class="d-inline-block form-check form-switch">
                                <input class="form-check-input" id="expense-status" name="status" type="checkbox" value="1" role="switch" checked>
                                <label class="form-check-label" data-bs-toggle="tooltip" data-bs-title="Status of the expense voucher" for="expense-status">Approve</label>
                            </div>
                        @endif
                        @if (!empty(Auth::user()->can(App\Models\User::UPDATE_EXPENSE, App\Models\User::CREATE_EXPENSE)))
                            <div class="ms-auto">
                                <input name="id" type="hidden">
                                <button class="btn btn-primary" id="expense-submit" type="submit">
                                    Save
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
