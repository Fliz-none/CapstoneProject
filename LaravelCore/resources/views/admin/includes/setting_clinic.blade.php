<div class="card mb-3">
    <form id="company-form" action="{{ route('admin.setting.clinic') }}" method="post">
        @csrf
        <div class="card-header d-flex justify-content-between">
            <h3>Thiết lập phòng khám</h3>
            <button class="btn btn-primary btn-save" type="submit">Lưu</button>
        </div>
        <div class="card-body">
            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label" for="default_info_service">Cấp độ khám mặc định<br />
                    <small class="form-text text-muted" id="default_info_service-help">Chọn cấp độ khám mặc định khi bác sĩ lưu phiếu khám</small>
                </label>
                <div class="col-sm-8">
                    <ul class="list-group search-list">
                        @php
                            $services = cache()->get('services_' . Auth::user()->company_id)->where('ticket', 'info');
                        @endphp
                        @if ($services->count())
                            @foreach ($services as $key => $service)
                                <li class="list-group-item border-0 pb-0">
                                    <input class="form-check-input me-1" 
                                    id="default_info_service-{{ $service->id }}" 
                                    name="default_info_service" 
                                    type="radio" 
                                    value="{{ $service->id }}" 
                                    {{ old('default_info_service') == $service->id || cache()->get('settings_' . Auth::user()->company_id)['default_info_service'] == $service->id ? 'checked' : '' }}>
                                    <label class="form-check-label d-inline" for="default_info_service-{{ $service->id }}">{{ $service->name }}</label>
                                </li>
                            @endforeach
                        @else
                            <span class="ms-3 fst-italic">Không có dịch vụ được hiển thị</span>
                        @endif
                    </ul>
                    @error('default_info_service')
                        <span class="invalid-feedback d-block" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label" for="company_website">Địa chỉ web<br />
                    <small class="form-text text-muted" id="company_website-help">Đường dẫn đến trang web chính thức</small>
                </label>
                <div class="col-sm-8">
                    <input class="form-control @error('company_website') is-invalid @enderror" id="company_website" name="company_website" type="text" value="{{ $settings['company_website'] }}">
                    @error('company_website')
                        <span class="invalid-feedback d-block" role="alert"> <strong>{{ $message }}</strong> </span>
                    @enderror
                </div>
            </div>
        </div>
    </form>
</div>
<div class="card mb-3">
    <form id="symptom_disease-form" action="{{ route('admin.setting.symptom_disease') }}" method="post">
        @csrf
        <div class="card-header d-flex justify-content-between">
            <h3>Thiết lập phiếu khám</h3>
            <button class="btn btn-primary btn-save" type="submit">Lưu</button>
        </div>
        <div class="card-body">
            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label" for="autosave_info_disease">
                    Tự động lưu thông tin bệnh<br />
                    <small class="form-text text-muted">Tự động lưu bệnh khi tạo phiếu khám</small>
                </label>
                <div class="col-sm-8">
                    <input name="autosave_info_disease" type="hidden" value="0">
                    <input class="form-check-input @error('autosave_info_disease') is-invalid @enderror" id="autosave_info_disease" name="autosave_info_disease" type="checkbox" value="1"
                        {{ isset($settings['autosave_info_disease']) && $settings['autosave_info_disease'] == 1 ? 'checked' : '' }}>
                    @error('autosave_info_disease')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label" for="autosave_info_symptom">
                    Tự động lưu thông tin triệu chứng<br />
                    <small class="form-text text-muted">Tự động lưu triệu chứng khi tạo phiếu khám</small>
                </label>
                <div class="col-sm-8">
                    <input name="autosave_info_symptom" type="hidden" value="0">
                    <input class="form-check-input @error('autosave_info_symptom') is-invalid @enderror" id="autosave_info_symptom" name="autosave_info_symptom" type="checkbox" value="1"
                        {{ isset($settings['autosave_info_symptom']) && $settings['autosave_info_symptom'] == 1 ? 'checked' : '' }}>
                    @error('autosave_info_symptom')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
    </form>
</div>