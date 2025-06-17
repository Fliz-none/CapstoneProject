<!-- Modal sort -->
<div class="modal fade" id="sort-modal" aria-labelledby="sort-label">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="sort-label">{{ __('messages.sort.sort') }}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <h6 class="text-secondary">{{ __('messages.sort.sort_by') }}</h6>
                        <select name="type" id="sort-type" class="form-select">
                            <option hidden selected disabled>{{ __('messages.sort.sort_by') }}</option>
                            <option value="time-az">{{ __('messages.sort.old') }}</option>
                            <option value="time-za">{{ __('messages.sort.new') }}</option>
                            <option value="title-az">{{ __('messages.sort.a_z') }}</option>
                            <option value="title-za">{{ __('messages.sort.z_a') }}</option>
                        </select>
                        <hr class="px-5 mt-3">
                        <ul id="sortable" class="list-group mb-3">
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
