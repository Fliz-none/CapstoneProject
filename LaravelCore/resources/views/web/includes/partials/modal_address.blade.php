@php
    $user = Auth::check() ? Auth::user() : null;
@endphp

@if (Auth::check())
    <div class="save-form" id="user-address-form">
        <div class="modal fade" id="user-address-modal" data-bs-backdrop="static" aria-labelledby="user-address-modal-label">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h1 class="modal-title text-white fs-5" id="user-address-modal-label">{{ __('lang_web.profile.select_address') }}</h1>
                        <button class="btn-close text-white" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex">
                            <a class="btn btn-outline-primary btn-create-address border border-1 mb-3">
                                <i class="bi bi-plus-circle-dotted"></i> {{ __('lang_web.profile.create_address') }}
                            </a>
                            <div class="address-action d-flex d-none">
                                <a class="btn btn-outline-success btn-update-address border border-1 mb-3 ms-2" data-id="">
                                    <i class="bi bi-pencil-square"></i> {{ __('lang_web.profile.update_address') }}
                                </a>
                                <form id="remove-address-form" method="post" action="{{ route('profile.remove_address') }}">
                                    <input name="address" type="hidden">
                                    <button class="btn btn-outline-danger btn-remove-address border border-1 ms-2" type="subimt">
                                        <i class="bi bi-trash3"></i> {{ __('lang_web.profile.remove_address') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="overflow-auto" id="user-address-list" style="height: 20rem;">
                            @if ($user->address)
                                @foreach (json_decode($user->address, true) as $index => $address)
                                    <div class="user-address">
                                        <input class="btn-check" data-index="{{ $index + 1 }}" id="user-address-{{ $index + 1 }}" name="user_address" type="radio" value="{{ json_encode($address) }}" hidden>
                                        <label class="btn btn-outline-primary mt-1 w-100 text-start" data-recipient="{{ $address['recipient_name'] }} - {{ $address['recipient_phone'] }}" data-address="{{ $address['address'] }}"
                                            for="user-address-{{ $index + 1 }}">
                                            {{ $address['recipient_name'] }} - {{ $address['recipient_phone'] }} <br>
                                            {{ $address['address'] }}
                                        </label>
                                        <hr class="my-0">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer py-1">
                        <div class="text-end">
                            <a class="key-btn-dark btn-select-address cursor-pointer">OK</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="address-map-form" method="post" enctype="multipart/form-data" action="{{ route('profile.update_address') }}">
        @csrf
        <div class="modal fade" id="address-map-modal" data-bs-backdrop="static" aria-labelledby="address-map-modal-label">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h1 class="modal-title text-white fs-5" id="address-map-modal-label">{{ __('lang_web.profile.new_address') }}</h1>
                        <button class="btn-close text-white" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                    </div>
                    <div class="modal-body row">
                        <div class="col-12 col-md-6 d-flex flex-column justify-content-between">
                            <div class="delivery-info">
                                <div class="form-group">
                                    <label class="form-label" for="recipient-name">{{ __('lang_web.profile.recipient_name') }}</label>
                                    <input class="form-control" id="recipient-name" name="recipient_name" type="text" placeholder="{{ __('lang_web.profile.recipient_name') }}" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mt-3" for="recipient-phone">{{ __('lang_web.profile.phone') }}</label>
                                    <input class="form-control" id="recipient-phone" name="recipient_phone" type="text" placeholder="{{ __('lang_web.profile.recipient_phone') }}" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mt-3" for="address-map-preview">{{ __('lang_web.profile.address') }}</label>
                                    <input class="form-control" id="address-map-preview" type="text" placeholder="{{ __('lang_web.profile.delivery_address') }}" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-check form-switch fs-5">
                                <label class="form-check-label cursor-pointer" for="address-default">{{ __('lang_web.profile.address_default') }}</label>
                                <input class="form-check-input cursor-pointer" id="address-default" name="address_default" type="checkbox" value="yes" role="switch">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="order-1 order-md-2 sticky-top">
                                <input name="address" type="hidden">
                                <div id="address-map" style="width: 100%; height: 350px; border: 1px solid #ccc; border-radius: 6px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer py-1">
                        <div class="text-end">
                            <input name="old_address" type="hidden">
                            <button class="key-btn-dark" type="submit">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endif
