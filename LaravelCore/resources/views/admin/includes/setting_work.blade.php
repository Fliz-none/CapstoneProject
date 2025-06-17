<div class="card mb-3">
    <form id="work-form" action="{{ route('admin.setting.work') }}" method="post">
        @csrf
        <div class="card-header d-flex justify-content-between">
            <h3>{{ __('messages.shift_setting.shift_setting') }}</h3>
            <button class="btn btn-primary" type="submit">{{ __('messages.save') }}</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped table-shift">
                    <thead>
                        <tr>
                            <th>{{ __('messages.shift_setting.name') }}</th>
                            <th>{{ __('messages.shift_setting.checkin') }}</th>
                            <th>{{ __('messages.shift_setting.checkout') }}</th>
                            <th>{{ __('messages.shift_setting.staff') }}</th>
                            <th style="width: 5%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $works = collect(old('shift_name', []))
                                ->zip(old('sign_checkin', []), old('sign_checkout', []), old('staff_number', []))
                                ->map(function ($item, $key) {
                                    return (object) [
                                        'shift_name' => $item[0],
                                        'sign_checkin' => $item[1],
                                        'sign_checkout' => $item[2],
                                        'staff_number' => $item[3],
                                    ];
                                })
                                ->toArray();
                            if (empty($works)) {
                                $works = json_decode($settings['work_info']) ?? [];
                            }
                        @endphp
                        @if (!empty($works))
                            @foreach ($works as $i => $work)
                                @if (is_numeric($i))
                                    <tr class="work-shift">
                                        <td><input
                                                class="form-control form-control-plaintext w-auto @error("shift_name.$i") is-invalid @enderror"
                                                name="shift_name[{{ $i }}]" type="text"
                                                value="{{ $work->shift_name }}">
                                            @error("shift_name.$i")
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td><input class="form-control-plaintext"
                                                name="sign_checkin[{{ $i }}]" type="time"
                                                value="{{ $work->sign_checkin }}">
                                            @error("sign_checkin.$i")
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td><input class="form-control-plaintext"
                                                name="sign_checkout[{{ $i }}]" type="time"
                                                value="{{ $work->sign_checkout }}">
                                            @error("sign_checkout.$i")
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td><input
                                                class="form-control form-control-plaintext w-auto @error("staff_number.$i") is-invalid @enderror"
                                                name="staff_number[{{ $i }}]" type="text"
                                                value="{{ $work->staff_number }}">
                                            @error("staff_number.$i")
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td>
                                            <button
                                                class="btn btn-link text-decoration-none btn-remove-shift cursor-pointer"
                                                type="button">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @else
                            <tr class="text-center fst-italic text-primary">
                                <th colspan="5">
                                    <h6 class="pt-2">{{ __('messages.shift_setting.no_shift') }}</h6>
                                </th>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <button class="btn btn-info btn-add-shift" type="button"><i class="bi bi-plus"></i></button>
        </div>
        <hr>
        <div class="card-body">
            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label" for="allow_self_register">
                    {{ __('messages.shift_setting.allow') }}<br />
                    <small class="form-text text-muted">{{ __('messages.shift_setting.allow_placeholder') }}</small>
                </label>
                <div class="col-sm-2">
                    <input name="allow_self_register" type="hidden" value="0">
                    <input class="form-check-input @error('allow_self_register') is-invalid @enderror" id="allow_self_register" name="allow_self_register" type="checkbox" value="1"
                        {{ isset($settings['allow_self_register']) && $settings['allow_self_register'] == 1 ? 'checked' : '' }}>
                    @error('allow_self_register')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <label class="col-sm-4 col-form-label" for="require_attendance_on_company_wifi">
                    {{ __('messages.shift_setting.wifi_require') }}<br />
                    <small class="form-text text-muted">{{ __('messages.shift_setting.wifi_require_placeholder') }}</small>
                </label>
                <div class="col-sm-2">
                    <input name="require_attendance_on_company_wifi" type="hidden" value="0">
                    <input class="form-check-input @error('require_attendance_on_company_wifi') is-invalid @enderror" id="require_attendance_on_company_wifi" name="require_attendance_on_company_wifi" type="checkbox" value="1"
                        {{ isset($settings['require_attendance_on_company_wifi']) && $settings['require_attendance_on_company_wifi'] == 1 ? 'checked' : '' }}>
                    @error('require_attendance_on_company_wifi')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        @error('shift_name')
            pushToastify(`{{ $message }}`, 'danger')
        @enderror
    })
</script>
