@php
    $canUpdate = Auth::user()->can(App\Models\User::UPDATE_USER);
    $avatarClass = 'rounded-circle d-flex align-self-start ms-3 shadow-1-strong';
    if ($canUpdate) $avatarClass .= ' btn-update-user cursor-pointer';
@endphp

<li class="d-flex justify-content-end mb-4">
    <div class="" style="max-width: 50%; width: fit-content;">
        <div class="card bg-chat-primary mb-0 cursor-pointer">
            <div class="card-header d-flex justify-content-between px-3 py-1 bg-chat-primary">
                <p class="mb-0">{{ $message->sender->name }}</p>
            </div>
            <div class="card-body">
                <p class="mb-0 p-1">
                    {{ $message->content }}
                </p>
            </div>
        </div>
        <small class="text-muted ms-3 mb-0 mt-1 float-end">
            <i class="bi bi-clock"></i> {{ $message->created_at->diffForHumans() }}
        </small>
    </div>
    <img src="{{ $message->sender->avatarUrl }}" alt="avatar" width="50"
        class="{{ $avatarClass }}"
        @if ($canUpdate) data-id="{{ $message->sender_id }}" @endif>
</li>
