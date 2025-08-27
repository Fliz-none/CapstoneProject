@php
    $logs = json_decode($logs);
    // dd($logs);
@endphp
<div class="card mb-3">
    <div class="card-body">
        <div class="d-flex flex-column align-items-center text-center">
            <form action="{{ route('admin.profile.change_avatar') }}" method="post" enctype="multipart/form-data">
                @csrf
                <label class="avt rounded-circle border border-1" for="profile-avatar" style=" width: 10rem; height: 10rem;">
                    <img class="rounded-circle w-100 h-100 object-fit-contain " src="{{ Auth::user()->avatarUrl }}" alt="Avatar">
                </label>
                <input name="id" type="hidden" value="{{ Auth::user()->id }}">
                <input class="d-none" id="profile-avatar" name="avatar" type="file" accept="image/*">
            </form>
            <div class="mt-3">
                <h4>{{ Auth::user()->name }}</h4>
                <p class="text-secondary mb-1">{{ Auth::user()->getRoleNames()->first() }}</p>
                <p class="text-muted font-size-sm">{{ Auth::user()->scores }} {{ __('messages.profile.point') }}</p>
            </div>
        </div>
    </div>
</div>
<div class="card mb-3">
    <ul class="list-group list-group-flush">
        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap p-4">
            <a href="{{ route('admin.profile') }}">
                <i class="bi bi-person-circle me-2"></i>
                {{ __('messages.profile.accountinformation') }}
            </a>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap p-4">
            <a href="{{ route('admin.profile', ['key' => 'settings']) }}">
                <i class="bi bi-gear-fill me-2"></i>
                {{ __('messages.profile.accountsetting') }}
            </a>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap p-4">
            <a href="{{ route('admin.profile', ['key' => 'password']) }}">
                <i class="bi bi-shield-lock-fill me-2"></i>
                {{ __('messages.profile.changepassword') }}
            </a>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap p-4">
            <a class="btn-attendance-history cursor-pointer">
                <i class="bi bi-calendar2-week me-2"></i>
                {{ __('messages.profile.attendance_history') }}
            </a>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap p-4">
            <a class="btn-activity-log cursor-pointer">
                <i class="bi bi-ui-checks me-2"></i>
                {{ __('messages.profile.activity') }}
            </a>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap p-4">
            <a href="{{ route('admin.profile', ['key' => 'logout']) }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="bi bi-x-circle-fill me-2"></i>
                {{ __('messages.profile.logout') }}
            </a>
        </li>
    </ul>
</div>

<!-- Modal Activity Log -->
<div class="modal fade" id="activityLogModal" style="max-height: 90vh;" aria-labelledby="activityLogLabel" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white" id="activityLogLabel">{{ __('messages.profile.activity') }}</h5>
                <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Đóng"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover table-borderless" id="log-table-profile">
                        <thead>
                            <tr>
                                <th>{{ __('messages.log.code') }}</th>
                                <th>{{ __('messages.log.user') }}</th>
                                <th>{{ __('messages.log.action') }}</th>
                                <th>{{ __('messages.log.object') }}</th>
                                <th>{{ __('messages.log.object_code') }}</th>
                                <th>{{ __('messages.log.location') }}</th>
                                <th>{{ __('messages.log.browser') }}</th>
                                <th>{{ __('messages.log.platform') }}</th>
                                <th>{{ __('messages.log.device') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($logs as $log)
                                @php
                                    $user = App\Models\User::find($log->user_id);
                                    $user->name ? ($userName = $user->name) : ($userName = __('messages.unknown'));

                                    switch ($log->action) {
                                        case 1:
                                            $actionText = __('messages.create');
                                            break;
                                        case 2:
                                            $actionText = __('messages.update');
                                            break;
                                        case 3:
                                            $actionText = __('messages.delete');
                                            break;
                                        default:
                                            $actionText = __('messages.unknown');
                                            break;
                                    }
                                @endphp
                                <tr>
                                    <td>
                                        @if ($log->action == '2')
                                            <a class="cursor-pointer btn-detail-log text-primary fw-bold" data-id=" {{ $log->id }}">{{ $log->code }}</a>
                                        @else
                                            <a class="cursor-pointer text-primary" data-id=" {{ $log->id }}">{{ $log->code }}</a>
                                        @endif
                                    </td>
                                    <td>{{ $log->user->name }}</td>
                                    <td>{{ $log->action_name }}</td>
                                    <td>{{ $log->type }}</td>
                                    <td>{{ $log->object }}</td>
                                    <td>{{ $log->ip }}</td>
                                    <td>{{ $log->agent }}</td>
                                    <td>{{ $log->platform }}</td>
                                    <td>{{ $log->device }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center text-muted" colspan="9">{{ __('messages.profile.np_activity') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Attendance History -->
<div class="modal fade" id="attendanceHistoryModal" aria-labelledby="attendanceHistoryLabel" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white" id="attendanceHistoryLabel">{{ __('messages.profile.attendance_history') }}</h5>
                <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Đóng"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover table-borderless" id="work-table">
                        <thead>
                            <tr>
                                <th>{{ __('messages.datatable.code') }}</th>
                                <th>{{ __('messages.log.user') }}</th>
                                <th>{{ __('messages.datatable.branch') }}</th>
                                <th>{{ __('messages.work_schedule.shift') }}</th>
                                <th>{{ __('messages.work_schedule.check_in') }}</th>
                                <th>{{ __('messages.work_schedule.check_out') }}</th>
                                <th>{{ __('messages.note') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($works))
                                @forelse ($works as $work)
                                    <tr>
                                        <td><a class="cursor-pointer btn-detail-work text-primary fw-bold" data-id=" {{ $work->id }}">{{ $work->code }}</a> </td>
                                        <td>{{ $work->user->name ?? '—' }}</td>
                                        <td>{{ $work->branch->name ?? '—' }}</td>
                                        <td style="white-space: pre-line;"> {{ $work->shift_info }}</td>
                                        <td>{{ $work->real_checkin ?? '—' }}</td>
                                        <td>{{ $work->real_checkout ?? '—' }}</td>
                                        <td>{{ $work->note ?? '—' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center text-muted" colspan="10">Không có lịch sử chấm công.</td>
                                    </tr>
                                @endforelse
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {

            $('#profile-avatar').change(function(e) {
                
                e.preventDefault()
                const form = $(this).parents('form')
                src = URL.createObjectURL(document.getElementById('profile-avatar').files[0])
                $(this).parents('form').find('img').attr('src', src)
                submitForm(form).done(function(response) {
                    if (response.status == "success") {
                        setTimeout(() => {
                            location.reload();
                        }, 1500)
                    }
                })
            })


            $('.btn-activity-log').on('click', function(e) {

                $('#log-table-profile').DataTable({
                    language: config.datatable.lang,
                });
                e.preventDefault();
                $('#activityLogModal').modal('show');
            });

            $('.btn-attendance-history').on('click', function(e) {
                e.preventDefault();
                $('#attendanceHistoryModal').modal('show');
            });
        })
    </script>
@endpush
