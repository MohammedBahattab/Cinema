<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MDAR Admin Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/admin_custom.css') }}" rel="stylesheet">
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            <span>MDAR</span> Admin
        </a>
        <div class="sidebar-nav">
            <div class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link text-decoration-none {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.movies.index') }}" class="nav-link text-decoration-none {{ request()->routeIs('admin.movies.*') ? 'active' : '' }}">
                    <i class="fas fa-film"></i> Movies
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.bookings.index') }}" class="nav-link text-decoration-none {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                    <i class="fas fa-ticket-alt"></i> Bookings
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.halls.index') }}" class="nav-link text-decoration-none {{ request()->routeIs('admin.halls.*') ? 'active' : '' }}">
                    <i class="fas fa-person-booth"></i> Halls & Seats
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.showtimes.index') }}" class="nav-link text-decoration-none {{ request()->routeIs('admin.showtimes.*') ? 'active' : '' }}">
                    <i class="fas fa-clock"></i> Showtimes
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.studios.index') }}" class="nav-link text-decoration-none {{ request()->routeIs('admin.studios.*') ? 'active' : '' }}">
                    <i class="fas fa-building"></i> Studios
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.categories.index') }}" class="nav-link text-decoration-none {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i> Categories
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.crew.index') }}" class="nav-link text-decoration-none {{ request()->routeIs('admin.crew.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Crew
                </a>
            </div>
            <div class="nav-item mt-4">
                <a href="{{ route('home') }}" class="nav-link text-decoration-none" target="_blank">
                    <i class="fas fa-external-link-alt"></i> View Site
                </a>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Topbar -->
        <header class="topbar">
            <div>
                <h5 class="mb-0 text-white fw-bold">Admin Portal</h5>
            </div>
            <div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-light"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </div>
        </header>

        <!-- Content Area -->
        <div class="content-area">
            @if(session('success'))
                <div class="alert alert-success bg-success text-white border-0"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger bg-danger text-white border-0"><i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}</div>
            @endif

            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>