<li class="d-flex justify-content-end mb-4">
    <div class="card w-75 bg-chat-primary mb-0 cursor-pointer">
        <div class="card-header d-flex justify-content-between px-3 py-1 bg-chat-primary">
            <p class="fw-bold mb-0">{{ $message->sender->name }}</p>
            <p class="text-muted small mb-0">
                <i class="bi bi-clock"></i> {{ $message->created_at->diffForHumans() }}
            </p>
        </div>
        <div class="card-body">
            <p class="mb-0 p-3">
                {{ $message->content }}
            </p>
        </div>
    </div>
    <img src="{{ $message->sender->avatarUrl }}" alt="avatar"
        class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" width="50">
</li>
