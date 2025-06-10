{{-- Hiển thị từng attachment nếu có --}}
@foreach ($message->attachments as $attachment)
    <li class="d-flex justify-content-start mb-1">
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
            <div class="card bg-chat-secondary mb-0 cursor-pointer d-flex align-items-center" style="border: 1px solid rgba(133, 133, 244, 0.841)">
                <div class="card-body p-1">
                    {{-- Attachment hiển thị --}}
                    <div class="d-flex flex-wrap gap-2">
                        @if ($attachment->file_url && Str::startsWith($attachment->mime_type, 'image/'))
                            <img src="{{ $attachment->file_url }}" alt="attachment"
                                class="rounded border ratio-1-1 object-fit-cover thumb img-fluid">
                        @else
                            <a href="{{ $attachment->file_url }}" target="_blank" class="text-decoration-none">
                                <i class="bi bi-file-earmark-fill"></i> {{ $attachment->file_name }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div style="width: 50px"></div>
    </li>
@endforeach
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
