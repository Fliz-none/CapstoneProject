<li class="d-flex justify-content-start mb-4">
    @php
        $canUpdate = Auth::user()->can(App\Models\User::UPDATE_USER);
        $avatarClass = 'rounded-circle d-flex align-self-start me-3 shadow-1-strong';
        if ($canUpdate) {
            $avatarClass .= ' btn-update-user cursor-pointer';
        }
    @endphp

    <img src="{{ $message->sender->avatarUrl }}" alt="avatar" width="50" class="{{ $avatarClass }}"
        @if ($canUpdate) data-id="{{ $message->sender_id }}" @endif>
    <div class="" style="max-width: 50%; width: fit-content;">
        <div class="card mb-0 cursor-pointer">
            <div class="card-header d-flex justify-content-between px-3 py-1 bg-chat-secondary">
                <p class="mb-0">{{ $message->sender->name }}</p>
            </div>
            <div class="card-body">
                <p class="mb-0 p-1">
                    {{ $message->content }}
                </p>
            </div>
        </div>
        <small class="text-muted me-3 mb-0 mt-1 d-block float-start">
            <i class="bi bi-clock"></i> {{ $message->created_at->diffForHumans() }}
        </small>
    </div>
</li>
