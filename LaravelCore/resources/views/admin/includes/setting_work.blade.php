<div class="card mb-3">
    <form id="work-form" action="{{ route('admin.setting.work') }}" method="post">
        @csrf
        <div class="card-header d-flex justify-content-between">
            <h3>Shift settings</h3>
            <button class="btn btn-primary" type="submit">Save</button>
        </div>
        <div class="card-body">
            <div class="form-check form-check-inline mb-3">
                <input class="form-check-input form-check-info" id="allow_self_register-checkbox" name="allow_self_register" type="checkbox" {{ old('allow_self_register', json_decode($settings['work_info'])->allow_self_register) ? 'checked' : '' }}>
                <label class="form-check-label" for="allow_self_register-checkbox">
                    Allow employees to self-register shifts
                </label>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-striped table-shift">
                    <thead>
                        <tr>
                            <th>Shift Name</th>
                            <th>Check-in Time</th>
                            <th>Check-out Time</th>
                            <th>Staff Count/Shift</th>
                            <th style="width: 5%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $works = collect(old('shift_name', []))
                                ->zip(old('sign_checkin', []), old('sign_checkout', []), old('staff_number', []))
                                ->map(function ($item, $key) {
                                    return (object) ['shift_name' => $item[0], 'sign_checkin' => $item[1], 'sign_checkout' => $item[2], 'staff_number' => $item[3]];
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
                                        <td><input class="form-control form-control-plaintext w-auto @error("shift_name.$i") is-invalid @enderror" name="shift_name[{{ $i }}]" type="text" value="{{ $work->shift_name }}">
                                            @error("shift_name.$i")
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td><input class="form-control-plaintext" name="sign_checkin[{{ $i }}]" type="time" value="{{ $work->sign_checkin }}">
                                            @error("sign_checkin.$i")
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td><input class="form-control-plaintext" name="sign_checkout[{{ $i }}]" type="time" value="{{ $work->sign_checkout }}">
                                            @error("sign_checkout.$i")
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td><input class="form-control form-control-plaintext w-auto @error("staff_number.$i") is-invalid @enderror" name="staff_number[{{ $i }}]" type="text" value="{{ $work->staff_number }}">
                                            @error("staff_number.$i")
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td>
                                            <button class="btn btn-link text-decoration-none btn-remove-shift cursor-pointer" type="button">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @else
                            <tr class="text-center fst-italic text-primary">
                                <th colspan="5">
                                    <h6 class="pt-2">No shifts available</h6>
                                </th>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <button class="btn btn-info btn-add-shift" type="button"><i class="bi bi-plus"></i></button>
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
