<header class='mb-3'>
    <nav class="navbar navbar-expand navbar-light navbar-top">
        <div class="container-fluid">
            <a class="burger-btn d-block cursor-pointer">
                <i class="bi bi-justify fs-3"></i>
            </a>
            @php
                $user = Auth::user();
                $notis = $user->notifications()->wherePivot('status', 0)->orderBy('id', 'DESC')->get();
            @endphp
            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" type="button" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-lg-0">
                    <a class="btn btn-change-language" style="margin-top: .35rem">
                        <i class="bi bi-translate fs-5 text-primary" data-bs-toggle="tooltip" data-bs-title="{{ __('messages.profile.language') }}"></i>
                    </a>
                    <li class="nav-item dropdown me-3 nav-notifications">
                        @include('admin.includes.notifications', ['notis' => $notis, 'hide' => false])
                    </li>
                </ul>
                @php
                    $avatarPath = '/user/' . Auth::user()->avatar;
                    $fullPath = public_path(env('FILE_STORAGE', '/storage') . $avatarPath);
                @endphp
                <div class="dropdown">
                    <a class="cursor-pointer" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-menu d-flex align-items-start">
                            <div class="user-name text-end me-3">
                                <h6 class="mb-0 mt-1 text-gray-600">{{ Auth::user()->name }}</h6>
                                <small class="text-secondary">{{ Auth::user()->branch ? Auth::user()->branch->name : 'No branches available.' }}</small>
                            </div>
                            <div class="user-img d-flex align-items-center">
                                <div class="avatar avatar-md">
                                    <img src="{{ Auth::user()->avatar ? Auth::user()->avatarUrl : asset('admin/images/logo/favicon_key.png') }}">
                                </div>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li>
                            <h6 class="dropdown-header">Hello, {{ Auth::user()->name }}</h6>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('admin.profile') }}">
                                <i class="bi bi-person-circle me-2"></i>
                                {{ __('messages.profile.accountinformation') }}
                            </a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('admin.profile', ['key' => 'settings']) }}">
                                <i class="bi bi-gear-fill me-2"></i>
                                {{ __('messages.profile.accountsetting') }}
                            </a>
                        </li>
                        @if (Auth::user()->branches->count() > 1)
                            <li>
                                <a class="dropdown-item cursor-pointer btn-change-branch">
                                    <i class="bi bi-git"></i>
                                    {{ __('messages.profile.changebranch') }}
                                </a>
                            </li>
                        @endif
                        <li><a class="dropdown-item" href="{{ route('admin.profile', ['key' => 'password']) }}">
                                <i class="bi bi-shield-lock-fill me-2"></i>
                                {{ __('messages.profile.changepassword') }}
                            </a>
                        </li>
                        <li class="submenu-item">
                            <a class="dropdown-item" href="{{ route('admin.work', ['key' => 'timekeeping']) }}">
                                <i class="bi bi-stopwatch"></i>
                                {{ __('messages.profile.timekeeping') }}
                            </a>
                        </li>
                        @php
                            $settings = cache()->get('settings');
                            $work_info = json_decode($settings['work_info']) ?? '';
                            $allow_self_register = $settings['allow_self_register'] ?? 1;
                        @endphp
                        @if ($allow_self_register)
                            <li class="submenu-item">
                                <a class="dropdown-item cursor-pointer btn-self-schedule">
                                    <i class="bi bi-calendar2-week"></i>
                                    {{ __('messages.profile.schedule') }}
                                </a>
                            </li>
                        @endif
                        <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                        submitLogoutForm();">
                                <i class="icon-mid bi bi-box-arrow-left me-2"></i>
                                {{ __('messages.profile.logout') }}
                            </a>
                        </li>
                        <form class="d-none" id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                        </form>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
