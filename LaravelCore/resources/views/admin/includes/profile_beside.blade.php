@php
    $logs = json_decode($logs);
@endphp
<div class="card mb-3">
    <div class="card-body">
        <div class="d-flex flex-column align-items-center text-center">
            <form action="{{ route('admin.profile.change_avatar') }}" method="post" enctype="multipart/form-data">
                @csrf
                <label class="avt" for="profile-avatar">
                    <img class="rounded-circle" src="{{ Auth::user()->avatarUrl }}" alt="Admin" style="object-fit: cover; width: 150px; height: 150px;">
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

<!-- Modal -->
<div class="modal fade" id="activityLogModal" tabindex="-1" aria-labelledby="activityLogLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white" id="activityLogLabel">Lịch sử hoạt động</h5>
                <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Đóng"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover table-borderless" id="log-table">
                        <thead>
                            <tr>
                                <th>{{ __('messages.log.code') }}</th>
                                <th>{{ __('messages.log.user') }}</th>
                                <th>{{ __('messages.log.action') }}</th>
                                <th>{{ __('messages.log.object') }}</th>
                                <th>{{ __('messages.log.code_user') }}</th>
                                <th>{{ __('messages.log.location') }}</th>
                                <th>{{ __('messages.log.browser') }}</th>
                                <th>{{ __('messages.log.platform') }}</th>
                                <th>{{ __('messages.log.device') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($logs as $log)
                                <tr>
                                    <td><a class="cursor-pointer btn-detail-log text-primary fw-bold" data-id=" {{ $log->id }}">{{ $log->code }}</a> </td>
                                    <td>{{ $log->user_id }}</td>
                                    <td>{{ $log->action }}</td>
                                    <td>{{ $log->object }}</td>
                                    <td>{{ $log->type }}</td>
                                    <td>{{ $log->ip }}</td>
                                    <td>{{ $log->agent }}</td>
                                    <td>{{ $log->platform }}</td>
                                    <td>{{ $log->device }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center text-muted" colspan="9">Không có lịch sử hoạt động.</td>
                                </tr>
                            @endforelse
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
            $('.btn-activity-log').on('click', function(e) {
                e.preventDefault();
                console.log('click');
                $('#activityLogModal').modal('show');
            });
        })
    </script>
@endpush
