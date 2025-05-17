<form class="save-form" id="local-form" method="post">
    @csrf
    <div class="modal fade" id="local-modal" data-bs-backdrop="static" aria-labelledby="local-modal-label">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title text-white fs-5" id="local-modal-label">Local Areas</h1>
                    <button class="btn-close text-white" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 form-group">
                        <label class="form-label" for="local-city" data-bs-toggle="tooltip" data-bs-title="Province or city of the local area">Province / City</label>
                        <input class="form-control" id="local-city" name="city" type="text" placeholder="Enter province or city name">
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label" for="local-district" data-bs-toggle="tooltip" data-bs-title="District of the local area">District</label>
                        <textarea class="form-control" id="local-district" name="district" rows="6" placeholder="Enter district name"></textarea>
                    </div>
                    <hr class="px-5">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-12 text-end">
                                @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_LOCAL, App\Models\User::CREATE_LOCAL)))
                                    <input name="id" type="hidden">
                                    <button class="btn btn-primary" type="submit">Save</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
