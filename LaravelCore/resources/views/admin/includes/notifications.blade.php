
<a class="nav-link text-gray-600 cursor-pointer {{ isset($hide) ? '' : 'show' }}" data-bs-toggle="dropdown" aria-expanded="{{ isset($hide) ? 'false' : 'true' }}">
    <i class="bi bi-bell bi-sub fs-4"></i>
    <span class="badge bg-danger position-absolute top-0 end-0 p-1">{{ optional($notis)->count() ?? '' }}</span>
</a>
<ul class="dropdown-menu dropdown-center dropdown-menu-sm-end shadow-lg notification-dropdown overflow-auto {{ isset($hide) ? '' : 'show' }}" data-bs-auto-close="false" aria-labelledby="dropdownMenuButton" style="max-height: 500px">
    @if ($notis->count())
        @foreach ($notis as $noti)
            <li class="dropdown-item notification-item position-relative">
                {!! $noti->description !!}
                <button class="btn-close btn-mark-notification" data-id="{{ $noti->id }}"></button>
            </li>
        @endforeach
    @else
        <li>
            <p class="text-center px-3 fst-italic text-nowrap">No notifications.</p>
        </li>
    @endif
</ul>