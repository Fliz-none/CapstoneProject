@forelse($conversations as $conversation)
    <li class="p-2 border-bottom bg-body-tertiary {{ $active_id == $conversation->id ? 'active' : '' }}" data-conversation_id="{{ $conversation->id }}">
        <a href="javascript:void(0);" class="d-flex justify-content-between">
            <div class="d-flex flex-row">
                <img src="{{ $conversation->customer->avatarUrl }}" alt="avatar"
                    class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="60">
                <div class="pt-1 w-100">
                    <p class="fw-bold mb-0">{{ $conversation->customer->name }}</p>
                    <p class="small text-muted text-truncate" style="max-width: 120px;">
                        {{ $conversation->lastMessage() ? $conversation->lastMessage()->content : '' }}
                    </p>
                </div>
            </div>
            <div class="pt-1">
                <p class="small text-muted mb-1">{{ $conversation->lastMessageAt() }}
                </p>
                @if ($conversation->unreadMessagesCount() > 0)
                    <span class="badge bg-danger float-end">
                        {{ $conversation->unreadMessagesCount() }}
                    </span>
                @endif
            </div>
        </a>
    </li>
@empty
    <li class="p-2 border-bottom bg-body-tertiary" data-conversation_id="0">
        <div class="d-flex flex-row">
            <img src="{{ asset('admin/images/placeholder.webp') }}" alt="avatar"
                class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="60">
            <div class="pt-1">
                <p class="fw-bold mb-0">{{ __('messages.chat.no_chat') }}</p>
                <p class="small text-muted">{{ __('messages.chat.not_yet_chat') }}</p>
            </div>
        </div>
    </li>
@endforelse
