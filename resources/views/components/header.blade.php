@auth
<nav class="bg-primary navbar navbar-expand-lg main-navbar d-flex justify-content-between">
    <ul class="navbar-nav">
        <li>
            <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>

    <ul class="navbar-nav">
        <li class="nav-item dropdown position-relative">
            <a href="#" class="nav-link nav-link-lg beep dropdown-toggle" data-bs-toggle="dropdown">
                <i class="far fa-bell"></i>
                @if(auth()->user()->unreadNotifications->count())
                <span class="badge bg-danger position-absolute translate-middle p-1 rounded-circle"
                    style="top: 8px; right: 8px; font-size: 0.75rem;">
                    {{ auth()->user()->unreadNotifications->count() }}
                </span>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-end shadow-sm p-2" style="min-width: 300px;">
                <div class="dropdown-header fw-bold text-dark">Notifikasi</div>
                <div class="dropdown-divider"></div>

                @forelse(auth()->user()->notifications->take(5) as $notification)
                <a href="#" class="dropdown-item">
                    <div class="d-flex flex-column">
                        <!-- judul -->
                        <span class="fw-semibold text-wrap text-break">
                            {{ $notification->data['title'] ?? 'Notifikasi' }}
                        </span>
                        <!-- pesan -->
                        <small class="text-muted text-wrap text-break">
                            {{ $notification->data['message'] ?? '' }}
                        </small>
                        <small class="text-primary mt-1">
                            {{ $notification->created_at->diffForHumans() }}
                        </small>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
                @empty
                <div class="dropdown-item text-center text-muted">Tidak ada notifikasi</div>
                @endforelse

                <div class="dropdown-footer text-center">
                    <a href="{{ route('notifications.markAllAsRead') }}" class="text-decoration-none">
                        Tandai semua telah dibaca
                    </a>
                </div>
            </div>

        </li>

        <li class="dropdown position-relative">
            <a href="#" id="navbarDropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">
                    Hai, {{ auth()->check() ? substr(Auth::user()->name, 0, 50) : 'Tamu' }}
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end">
                <div class="dropdown-title">
                    Selamat Datang, {{ auth()->check() ? substr(Auth::user()->name, 0, 50) : 'Tamu' }}
                </div>
                <a class="dropdown-item has-icon" href="{{ url('profile/edit') }}">
                    <i class="fas fa-user"></i> Edit Profile
                </a>
                <a class="dropdown-item has-icon" href="{{ url('profile/ganti-password') }}">
                    <i class="fas fa-key"></i> Ganti Password
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ url('logout') }}" class="dropdown-item has-icon text-danger"
                    onclick="event.preventDefault(); localStorage.clear(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" class="d-none">
                    {{ csrf_field() }}
                </form>
            </div>
        </li>
    </ul>
</nav>
@endauth


<div class="navbar-bg">
    <nav class="navbar navbar-expand-lg main-navbar">
        <ul class="navbar-nav ml-auto">
            @auth
            <li>
                <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <li class="dropdown position-relative">
                <a href="#" id="navbarDropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
                    <div class="d-sm-none d-lg-inline-block">
                        Hai, {{ auth()->check() ? substr(Auth::user()->name, 0, 10) : 'Tamu' }}
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <div class="dropdown-title">
                        Selamat Datang, {{ auth()->check() ? substr(Auth::user()->name, 0, 10) : 'Tamu' }}
                    </div>
                    <a class="dropdown-item has-icon" href="{{ url('profile/edit') }}">
                        <i class="fas fa-user"></i> Edit Profile
                    </a>
                    <a class="dropdown-item has-icon" href="{{ url('profile/ganti-password') }}">
                        <i class="fas fa-key"></i> Ganti Password
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ url('logout') }}" class="dropdown-item has-icon text-danger"
                        onclick="event.preventDefault(); localStorage.clear(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" class="d-none">
                        {{ csrf_field() }}
                    </form>
                </div>
            </li>
            @endauth
        </ul>
    </nav>
</div>