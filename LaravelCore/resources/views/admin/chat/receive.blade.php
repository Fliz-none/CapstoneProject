<li class="d-flex justify-content-start mb-4">
    <img src="{{ $message->sender->avatarUrl }}" alt="avatar"
        class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="50">
    <div class="card w-75 mb-0 cursor-pointer">
        <div class="card-header d-flex justify-content-between p-3">
            <p class="fw-bold mb-0">{{ $message->sender->name }}</p>
            <p class="text-muted small mb-0"><i class="bi bi-clock"></i> {{ $message->created_at->diffForHumans() }}</p>
        </div>
        <div class="card-body">
            <p class="mb-0">
                {{ $message->content }}
            </p>
        </div>
    </div>
</li>
