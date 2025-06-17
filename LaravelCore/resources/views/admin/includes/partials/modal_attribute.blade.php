<form class="save-form" id="attribute-form" method="post">
    @csrf
    <div class="modal fade" id="attribute-modal" data-bs-backdrop="static" aria-labelledby="attribute-modal-label">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="attribute-modal-label">{{ __('messages.attribute.attribute') }}</h1>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 form-group">
                        <label class="form-label" for="attribute-key" data-bs-toggle="tooltip" data-bs-title="A specific characteristic used to describe and distinguish a product">{{ __('messages.attribute.attribute_name') }}</label>
                        <input class="form-control" id="attribute-key" name="key" type="text" placeholder="{{ __('messages.attribute.attribute_name') }}">
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label" for="attribute-value" data-bs-toggle="tooltip" data-bs-title="The value of the attribute">{{ __('messages.dashboard_canvas_value') }}</label>
                        <textarea class="form-control" id="attribute-value" name="value" placeholder="{{ __('messages.attribute.attribute_placeholder') }}"></textarea>
                    </div>
                    <hr class="px-5">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-12 text-end">
                                @if (!empty(Auth::user()->hasAnyPermission(App\Models\User::UPDATE_ATTRIBUTE, App\Models\User::CREATE_ATTRIBUTE)))
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
