<form class="save-form" id="catalogue-form" method="post">
    @csrf
    <div class="modal fade" id="catalogue-modal" data-bs-backdrop="static" aria-labelledby="catalogue-modal-label">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h1 class="modal-title text-white fs-5" id="catalogue-modal-label">Catalogue</h1>
                    <button class="btn-close text-white" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="sticky-top">
                                <label class="form-label select-image" for="catalogue-avatar">
                                    <img class="img-fluid rounded-4 object-fit-cover" src="{{ asset('admin/images/placeholder.webp') }}" alt="Thumbnail">
                                </label>
                                <input class="hidden-image" id="catalogue-avatar" name="avatar" type="hidden">
                                <div class="d-grid">
                                    <button class="btn btn-outline-primary btn-remove-image d-none" type="button">Remove</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="catalogue-name" data-bs-toggle="tooltip" data-bs-title="The name used to group or categorize">{{ __('messages.category.category_name') }}</label>
                                <input class="form-control" id="catalogue-name" name="name" type="text" placeholder="Catalogue Name" autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="catalogue-parent_id" data-bs-toggle="tooltip" data-bs-title="A parent catalogue that may contain subcategories">{{ __('messages.category.category_parent') }}</label>
                                <select class="form-control select2" id="catalogue-parent_id" name="parent_id" data-ajax--url="{{ route('admin.catalogue', ['key' => 'select2']) }}" data-placeholder="{{ __('messages.category.select_category_parent') }}" type="text">
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="catalogue-note" data-bs-toggle="tooltip" data-bs-title="Detailed description of this catalogue">{{ __('messages.datatable.description') }}</label>
                                <textarea class="form-control" id="catalogue-note" name="note" rows="6" placeholder="{{ __('messages.datatable.description') }}"></textarea>
                            </div>
                        </div>
                    </div>
                    <hr class="px-5">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-12 col-lg-6 d-flex align-items-center gap-2">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" id="catalogue-status" name="status" type="checkbox" checked>
                                    <label class="form-check-label" for="catalogue-status" data-bs-toggle="tooltip" data-bs-title="Status of the catalogue; if disabled, adding products, importing and selling is not allowed">{{ __('messages.active') }}</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" id="catalogue-is_featured" name="is_featured" type="checkbox" checked>
                                    <label class="form-check-label" for="catalogue-is_featured" data-bs-toggle="tooltip" data-bs-title="Mark this catalogue as featured">Featured</label>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 text-end">
                                @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_CATALOGUE, App\Models\User::CREATE_CATALOGUE)))
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
