@php
    $canUpdate = Auth::user()->can(App\Models\User::UPDATE_USER);
    $avatarClass = 'rounded-circle d-flex align-self-start ms-3 shadow-1-strong';
    if ($canUpdate) {
        $avatarClass .= ' btn-update-user cursor-pointer';
    }
@endphp

@foreach ($message->attachments as $attachment)
    <li class="d-flex justify-content-end mb-1">
        <div class="" style="max-width: 50%; width: fit-content;">
            <div class="card bg-chat-primary mb-0 cursor-pointer d-inline-block" style="border: 1px solid rgba(133, 133, 244, 0.841)">
                <div class="card-body p-1">
                    {{-- Attachments --}}
                    <div class=" d-flex flex-wrap gap-2">
                        @if ($attachment->file_url && Str::startsWith($attachment->mime_type, 'image/'))
                            <img src="{{ $attachment->file_url }}" alt="attachment"
                                class="rounded border ratio-1-1 object-fit-cover thumb img-fluid">
                        @else
                            <a href="{{ $attachment->file_url }}" target="_blank" class="text-decoration-none text-truncate border py-2 px-3 d-inline-block" style="max-width: 150px;" title="{{ $attachment->file_name }}" >
                                <i class="bi bi-file-earmark-fill"></i> {{ $attachment->file_name }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div style="width: 50px" class="ms-3"></div>
    </li>
@endforeach
<li class="d-flex justify-content-end mb-4">
    <div class="" style="max-width: 50%; width: fit-content;">
        <div class="card bg-chat-primary mb-0 cursor-pointer">
            <div class="card-header d-flex justify-content-between px-3 py-1 bg-chat-primary">
                <p class="mb-0">{{ $message->sender->name }}</p>
            </div>
            <div class="card-body">
                {{-- Attachments --}}
                <div class=" d-flex flex-wrap gap-2">
                </div>
                <p class="mb-0 p-1">
                    {{ $message->content }}
                </p>
            </div>
        </div>
        <small class="text-muted ms-3 mb-0 mt-1 float-end">
            <i class="bi bi-clock"></i> {{ $message->created_at->diffForHumans() }}
        </small>
    </div>
    <img src="{{ $message->sender->avatarUrl }}" alt="avatar" width="50" class="{{ $avatarClass }}"
        @if ($canUpdate) data-id="{{ $message->sender_id }}" @endif>
</li>
