@foreach ($posts as $post)
    <div class="mb-2 p-2 border rounded bg-light text-dark web-rendered-data">
        <strong class="d-block">{{ $post['title'] ?? '(Không có tiêu đề)' }}</strong>
        @if (!empty($post['category']))
            <small class="text-muted">📂 {{ $post['category'] }}</small><br>
        @endif
        @if (!empty($post['created_at']))
            <small class="text-muted">🕒 {{ \Carbon\Carbon::parse($post['created_at'])->diffForHumans() }}</small><br>
        @endif
        @if (!empty($post['slug']))
            <a class="text-primary" href="{{ url('/posts/' . $post['category_slug'] . '/' . $post['slug']) }}" target="_blank">Xem chi tiết</a>
        @endif
    </div>
@endforeach
