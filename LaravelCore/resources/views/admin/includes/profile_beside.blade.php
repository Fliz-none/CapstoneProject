
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
                <p class="text-muted font-size-sm">{{ Auth::user()->scores }} points</p>
            </div>
        </div>
    </div>
</div>
<div class="card mb-3">
    <ul class="list-group list-group-flush">
        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap p-4">
            <a href="{{ route('admin.profile') }}">
                <i class="bi bi-person-circle me-2"></i>
                Account Information
            </a>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap p-4">
            <a href="{{ route('admin.profile', ['key' => 'settings']) }}">
                <i class="bi bi-gear-fill me-2"></i>
                Update Information
            </a>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap p-4">
            <a href="{{ route('admin.profile', ['key' => 'password']) }}">
                <i class="bi bi-shield-lock-fill me-2"></i>
                Change Password
            </a>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap p-4">
            <a href="{{ route('admin.profile', ['key' => 'activity']) }}">
                <i class="bi bi-ui-checks me-2"></i>
                Activity Log
            </a>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap p-4">
            <a href="{{ route('admin.profile', ['key' => 'logout']) }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="bi bi-x-circle-fill me-2"></i>
                Logout
            </a>
        </li>
    </ul>
</div>