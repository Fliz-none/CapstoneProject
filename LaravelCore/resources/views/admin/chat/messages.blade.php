{{-- If has messages --}}
@if ($messages->count() > 0)
    @foreach ($messages as $message)
        @if ($message->sender_id == auth()->id())
            {{-- Tin nhắn của chính mình (gửi) – avatar bên phải --}}
            @include('admin.chat.broadcast', ['message' => $message])
        @else
            {{-- Tin nhắn của người khác (nhận) – avatar bên trái --}}
            @include('admin.chat.receive', ['message' => $message])
        @endif
    @endforeach
@else
@endif
