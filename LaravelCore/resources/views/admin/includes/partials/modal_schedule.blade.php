<div class="modal fade" id="schedule-modal" data-bs-backdrop="static" aria-labelledby="schedule-modal-label">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h1 class="modal-title fs-5 text-white" id="schedule-modal-label">Lịch làm việc</h1>
                <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-4 ms-auto d-flex justify-content-end">
                        <select class="form-control form-control-plaintext text-center w-auto ms-2 schedule-list-branches">
                            <option value="all" selected>Tất cả chi nhánh</option>
                            @foreach (Auth::user()->branches as $branch)
                                <option value="{{ $branch->id }}" {{ isset($_GET['branch_id']) && $_GET['branch_id'] == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="table-responsive position-relative" style="max-height: 600px;">
                    <table class="table table-hover key-table text-nowrap" id="schedule-table">
                        <thead class="sticky-top bg-white z-2 border-secondary">
                        </thead>
                        <tbody>
                            @php
                                $work_info = json_decode(cache()->get('settings_' . Auth::user()->company_id)['work_info']);
                                unset($work_info->allow_self_register); // Loại bỏ trường 'allow_self_register'
                            @endphp
                            @foreach ($users as $user)
                                <tr>
                                    <td class="position-sticky bg-white start-0" style="z-index: 3">
                                        <a class="btn text-primary text-start p-0">{{ $user->name }}</a><br>
                                        <small>{{ $user->getRoleNames()->first() }}</small><br>
                                        <a class="cursor-pointer btn-sm btn-update-user text-primary px-0 fw-bold" data-id="{{ $user->id }}">{{ $user->code }}</a>
                                    </td>
                                    @for ($i = 0; $i < 7; $i++)
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm">
                                                @foreach ($work_info as $index => $work)
                                                    <input class="btn-check btn-change-schedule {{ $user->main_branch }}-{{ $user->id }}-{{ $index }}-{{ $i }}"
                                                        id="schedule-{{ $user->main_branch }}-{{ $user->id }}-{{ $index }}-{{ $i }}" data-user_id="{{ $user->id }}" data-main_branch="{{ $user->main_branch }}"
                                                        data-shift="{{ $work->sign_checkin }}-{{ $work->sign_checkout }}" data-date="{{ $i }}" data-branch_id="{{ $user->main_branch }}" type="checkbox">
                                                    <label class="btn p-1 px-2 btn-outline-info shadow-none" data-bs-toggle="tooltip" data-bs-title="{{ $work->shift_name . ' (' . $work->sign_checkin . ' - ' . $work->sign_checkout . ')' }}"
                                                        for="schedule-{{ $user->main_branch }}-{{ $user->id }}-{{ $index }}-{{ $i }}">C{{ $index + 1 }}</label>
                                                @endforeach
                                            </div>
                                        </td>
                                    @endfor
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
