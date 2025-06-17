<form class="save-form" id="branch-form" method="post">
    @csrf
    <div class="modal fade" id="branch-modal" data-bs-backdrop="static" aria-labelledby="branch-modal-label">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="branch-modal-label">Branch</h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="form-group row align-items-center">
                                <div class="col-12">
                                    <label for="branch-name" class="form-label" data-bs-toggle="tooltip" data-bs-title="The name of the branch">{{ __('messages.branches.name') }}</label>
                                </div>
                                <div class="col-12">
                                    <input type="text" id="branch-name" name="name" class="form-control" placeholder="{{ __('messages.branches.name') }}" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group row align-items-center">
                                <div class="col-12">
                                    <label for="branch-phone" class="form-label" data-bs-toggle="tooltip" data-bs-title="The phone number of the branch">{{ __('messages.branches.phone') }}</label>
                                </div>
                                <div class="col-12">
                                    <input type="text" id="branch-phone" name="phone" class="form-control" placeholder="{{ __('messages.branches.phone') }}" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group row align-items-center">
                                <div class="col-12">
                                    <label for="branch-address" class="form-label" data-bs-toggle="tooltip" data-bs-title="Detailed address of the branch">{{ __('messages.branches.address') }}</label>
                                </div>
                                <div class="col-12">
                                    <input type="text" id="branch-address" name="address" class="form-control" placeholder="{{ __('messages.branches.address') }}" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group row align-items-center">
                                <div class="col-12">
                                    <label for="branch-note" class="form-label" data-bs-toggle="tooltip" data-bs-title="Notes or reminders related to the branch">{{ __('messages.note') }}</label>
                                </div>
                                <div class="col-12">
                                    <textarea name="note" id="branch-note" rows="3" class="form-control" placeholder="{{ __('messages.note') }}"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-check form-switch px-0">
                                <input type="checkbox" id="branch-status" name="status" value="1" class="form-check-input ms-0 ms-md-1 me-1 me-md-2" role="switch" checked>
                                <label for="branch-status" class="form-check-label">{{ __('messages.active') }}</label>
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
