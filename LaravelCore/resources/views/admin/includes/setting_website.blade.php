<div class="card mb-3">
    <form id="email-form" action="{{ route('admin.setting.introduce') }}" method="post">
        @csrf
        <div class="card-header d-flex justify-content-between">
            <h3>General Website Settings</h3>
            <button class="btn btn-primary btn-save" type="submit">{{ __('messages.save') }}</button>
        </div>
        <div class="card-body">
            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label" for="setting-website">Edit Website<br />
                    <small class="form-text text-muted" id="setting-website-help">Edit the partials of website</small>
                </label>
                <div class="col-sm-8">
                    {{-- <a class="btn btn-light-info mb-3" href="{{ route('admin.setting', ['key' => 'footer']) }}">Footer</a> --}}
                    <a class="btn btn-light-info mb-3" href="{{ route('admin.setting', ['key' => 'website_page']) }}">About Us Page</a>
                </div>
                <label class="col-sm-4 col-form-label" for="company_slogan">Slogan<br />
                    <small class="form-text text-muted" id="company_slogan-help">Slogan of company</small>
                </label>
                <div class="col-sm-8">
                    <input class="form-control @error('company_slogan') is-invalid @enderror" id="company_slogan" name="company_slogan" type="text" value="{{ $settings['company_slogan'] ?? '' }}">
                    @error('company_slogan')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label" for="company_introduce">Introduce<br />
                    <small class="form-text text-muted" id="company_introduce-help">Brief introduction about the company</small>
                </label>
                <div class="col-sm-8">
                    <textarea class="form-control @error('company_introduce') is-invalid @enderror" id="company_introduce" name="company_introduce" type="text" rows="3">{{ $settings['company_introduce'] ?? '' }}</textarea>
                    @error('company_introduce')
                        <span class="invalid-feedback d-block" role="alert"> <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label" for="company_description">Description<br />
                    <small class="form-text text-muted" id="company_description-help">
                        Company Profile
                    </small>
                </label>
                <div class="col-sm-8">
                    <textarea class="form-control @error('company_description') is-invalid @enderror" id="company_description" name="company_description" rows="3">{{ $settings['company_description'] ?? '' }}</textarea>
                    @error('company_description')
                        <span class="invalid-feedback d-block" role="alert"> <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
    </form>
</div>
<div class="card mb-3">
    <form id="image-form" action="{{ route('admin.setting.banner') }}" method="post">
        @csrf
        <div class="card-header d-flex justify-content-between">
            <h3>Banner Settings</h3>
            <div>
                <button class="btn btn-primary btn-save mb-3" type="submit">{{ __('messages.save') }}</button>
            </div>
        </div>
        <div class="card-body">
            <div class="row justify-content-between align-items-stretch">
                <h5>Home Page</h5>
                <div class="col-12 col-md-6 mb-3">
                    <h6 class="text-secondary">Banner 1</h6>
                    <label class="form-label select-image" for="banner_home_1" style="height: 19rem !important"> <img class="img-fluid rounded-4 object-fit-contain h-100 w-100" alt="Banner" onerror="this.src='{{ asset('/images/bg-contact-1.jpg') }}';">
                    </label>
                    <input class="hidden-image" id="banner_home_1" name="banner_home_1" type="hidden" value="{{ $settings['banner_home_1'] ?? old('banner_home_1') }}">
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <h6 class="text-secondary">Banner 2</h6>
                    <label class="form-label select-image" for="banner_home_2" style="height: 19rem !important"> <img class="img-fluid rounded-4 object-fit-contain h-100 w-100" alt="Banner" onerror="this.src='{{ asset('/images/bg-contact-1.jpg') }}';">
                    </label>
                    <input class="hidden-image" id="banner_home_2" name="banner_home_2" type="hidden" value="{{ $settings['banner_home_2'] ?? old('banner_home_2') }}">
                </div>
            </div>
            <hr class="mx-4 mb-5">
            <div class="row justify-content-between align-items-stretch">
                <h5>Store Page</h5>
                <div class="col-12 col-md-6 mb-3">
                    <h6 class="text-secondary">Banner 1</h6>
                    <label class="form-label select-image" for="banner_store_1" style="height: 19rem !important"> <img class="img-fluid rounded-4 object-fit-contain h-100 w-100" alt="Banner" onerror="this.src='{{ asset('/images/bg-contact-1.jpg') }}';">
                    </label>
                    <input class="hidden-image" id="banner_store_1" name="banner_store_1" type="hidden" value="{{ $settings['banner_store_1'] ?? old('banner_store_1') }}">
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <h6 class="text-secondary">Banner 2</h6>
                    <label class="form-label select-image" for="banner_store_2" style="height: 19rem !important"> <img class="img-fluid rounded-4  object-fit-contain h-100 w-100" alt="Banner" onerror="this.src='{{ asset('/images/bg-contact-1.jpg') }}';">
                    </label>
                    <input class="hidden-image" id="banner_store_2" name="banner_store_2" type="hidden" value="{{ $settings['banner_store_2'] ?? old('banner_store_2') }}">
                </div>
            </div>
            <hr class="mx-4 mb-5">
            <div class="row justify-content-between align-items-stretch">
                <h5>Post</h5>
                <div class="col-12 col-md-6 mb-3">
                    <h6 class="text-secondary">Banner 1</h6>
                    <label class="form-label select-image" for="banner_post_1" style="height: 19rem !important"> <img class="img-fluid rounded-4 object-fit-contain h-100 w-100" alt="Banner" onerror="this.src='{{ asset('/images/bg-contact-1.jpg') }}';">
                    </label>
                    <input class="hidden-image" id="banner_post_1" name="banner_post_1" type="hidden" value="{{ $settings['banner_post_1'] ?? old('banner_post_1') }}">
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <h6 class="text-secondary">Banner 2</h6>
                    <label class="form-label select-image" for="banner_post_2" style="height: 19rem !important"> <img class="img-fluid rounded-4  object-fit-contain h-100 w-100" alt="Banner" onerror="this.src='{{ asset('/images/bg-contact-1.jpg') }}';">
                    </label>
                    <input class="hidden-image" id="banner_post_2" name="banner_post_2" type="hidden" value="{{ $settings['banner_post_2'] ?? old('banner_post_2') }}">
                </div>
            </div>
            <hr class="mx-4 mb-5">
            <div class="row justify-content-between align-items-stretch">
                <h5>Contact</h5>
                <div class="col-12 col-md-6 mb-3">
                    <h6 class="text-secondary">Banner</h6>
                    <label class="form-label select-image" for="banner_contact" style="height: 19rem !important"> <img class="img-fluid rounded-4 object-fit-contain h-100 w-100" alt="Banner" onerror="this.src='{{ asset('/images/bg-contact-1.jpg') }}';">
                    </label>
                    <input class="hidden-image" id="banner_contact" name="banner_contact" type="hidden" value="{{ $settings['banner_contact'] ?? old('banner_contact') }}">
                </div>
            </div>
        </div>
    </form>
</div>
