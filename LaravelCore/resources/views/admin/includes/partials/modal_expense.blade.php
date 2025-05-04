<form class="save-form" id="expense-form" name="expense" method="post">
    @csrf
    <div class="modal fade" id="expense-modal" aria-labelledby="expense-modal-label">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title fs-5 text-white" id="expense-modal-label">Phiếu chi</h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row p-0 p-md-2">
                        <div class="col-12 col-md-7">
                            <div class="mb-3 form-group">
                                <label data-bs-toggle="tooltip" data-bs-title="Người nhận tiền từ phiếu chi này" for="expense-receiver_id">Người nhận</label>
                                <select class="form-select select2" id="expense-receiver_id" name="receiver_id" data-ajax--url="{{ route('admin.user', ['key' => 'select2']) }}" data-placeholder="Chọn người nhận">
                                </select>
                            </div>
                            <div class="mb-3 form-group">
                                <label class="form-label" data-bs-toggle="tooltip" data-bs-title="Hình thức thanh toán của khách" for="expense-cash">Hình thức</label>
                                <div class="d-grid">
                                    <div class="btn-group">
                                        <input class="btn-check" id="expense-transfer" name="payment" type="radio" value="2" checked>
                                        <label class="btn btn-outline-primary" for="expense-transfer">
                                            Chuyển khoản
                                        </label>
                                        <input class="btn-check" id="expense-cash" name="payment" type="radio" value="1">
                                        <label class="btn btn-outline-primary" for="expense-cash">
                                            Tiền mặt
                                        </label>
                                        <input class="btn-check" id="expense-card" name="payment" type="radio" value="0">
                                        <label class="btn btn-outline-primary" for="expense-card">
                                            Quẹt thẻ
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label data-bs-toggle="tooltip" data-bs-title="Số tiền chi" for="expense-amount">Số tiền</label>
                                <input class="form-control expense-amount money" id="expense-amount" name="amount" type="text" value="0" placeholder="Số tiền chi" onclick="this.select()" inputmode="numeric" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label data-bs-toggle="tooltip" data-bs-title="Phân loại các khoản chi tùy theo mục đích cụ thể" for="expense-note">Chọn danh mục chi tiêu</label>
                                <select class="form-control" name="group" id="expense-group">
                                    @php
                                        $expense_group = cache()->get('settings_' . Auth::user()->company_id)['expense_group'] ?? '[]';
                                    @endphp
                                    @foreach (json_decode($expense_group) as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label data-bs-toggle="tooltip" data-bs-title="Ghi chú chi tiết về phiếu chi" for="expense-note">Ghi chú</label>
                                <textarea class="form-control" id="expense-note" name="note" type="text" rows="3" placeholder="Nhập nội dung ghi chú"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-md-5">
                            <div class="sticky-top">
                                <div class="form-group mb-3">
                                    <label class="form-label ratio ratio-1x1 select-avatar" for="expense-avatar">
                                        <img class="img-fluid rounded-4 object-fit-cover" id="expense-avatar-preview" src="{{ asset('admin/images/placeholder.webp') }}" alt="Ảnh đại diện">
                                    </label>
                                    <input class="form-control" id="expense-avatar" name="avatar" type="file" hidden accept="image/*">
                                    <div class="d-grid">
                                        <button class="btn btn-outline-primary btn-remove-image d-none" type="button">Xoá</button>
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
                                <label class="form-check-label" data-bs-toggle="tooltip" data-bs-title="Trạng thái phiếu chi" for="expense-status">Duyệt</label>
                            </div>
                        @endif
                        @if (!empty(Auth::user()->can(App\Models\User::UPDATE_EXPENSE, App\Models\User::CREATE_EXPENSE)))
                            <div class="ms-auto">
                                <input name="id" type="hidden">
                                <button class="btn btn-primary" id="expense-submit" type="submit">
                                    Lưu
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</form>
