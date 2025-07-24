<form class="save-form" id="branch-form" method="post">
    @csrf
    <div class="modal fade" id="branch-modal" data-bs-backdrop="static" aria-labelledby="branch-modal-label">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="branch-modal-label">Branch</h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <!-- THÔNG TIN CHI NHÁNH (BÊN TRÁI) -->
                        <div class="col-12 col-md-6 order-2 order-md-1">
                            <div class="form-group row align-items-center">
                                <div class="col-12">
                                    <label class="form-label" data-bs-toggle="tooltip" data-bs-title="The name of the branch" for="branch-name">{{ __('messages.branches.name') }}</label>
                                </div>
                                <div class="col-12">
                                    <input class="form-control" id="branch-name" type="text" name="name" placeholder="{{ __('messages.branches.name') }}" autocomplete="off" required>
                                </div>
                            </div>

                            <div class="form-group row align-items-center mt-3">
                                <div class="col-12">
                                    <label class="form-label" data-bs-toggle="tooltip" data-bs-title="The phone number of the branch" for="branch-phone">{{ __('messages.branches.phone') }}</label>
                                </div>
                                <div class="col-12">
                                    <input class="form-control" id="branch-phone" type="text" name="phone" placeholder="{{ __('messages.branches.phone') }}" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row align-items-center mt-3">
                                <div class="col-12">
                                    <label class="form-label" data-bs-toggle="tooltip" data-bs-title="Detailed address of the branch" for="branch-address-preview">{{ __('messages.branches.address') }}</label>
                                </div>
                                <div class="col-12" style="position: relative">
                                    <input class="form-control" id="branch-address-preview" type="text" placeholder="{{ __('messages.branches.address') }}" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row align-items-center mt-3">
                                <div class="col-12">
                                    <label class="form-label" data-bs-toggle="tooltip" data-bs-title="Notes or reminders related to the branch" for="branch-note">{{ __('messages.note') }}</label>
                                </div>
                                <div class="col-12">
                                    <textarea class="form-control" id="branch-note" name="note" rows="3" placeholder="{{ __('messages.note') }}"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- BẢN ĐỒ (BÊN PHẢI) -->
                        <div class="col-12 col-md-6 order-1 order-md-2 sticky-top">
                            <input type="hidden" name="address">
                            <div id="branch-map" style="width: 100%; height: 350px; border: 1px solid #ccc; border-radius: 6px;"></div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-check form-switch px-0">
                                <input class="form-check-input ms-0 ms-md-1 me-1 me-md-2" id="branch-status" type="checkbox" name="status" value="1" role="switch" checked>
                                <label class="form-check-label" for="branch-status">{{ __('messages.active') }}</label>
                            </div>
                        </div>
                        <div class="col-6 text-end">
                            @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_BRANCH, App\Models\User::CREATE_BRANCH)))
                                <input name="id" type="hidden">
                                <button class="btn btn-primary px-3 fw-bold" type="submit">Save</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
