<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MDAR Admin Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-primary: #0a0a1a;
            --bg-secondary: #12122a;
            --bg-sidebar: #05050f;
            --accent: #e50914;
            --accent-hover: #ff1a25;
            --text-primary: #ffffff;
            --text-secondary: #8b8b9e;
            --glass: rgba(255,255,255,0.04);
            --glass-border: rgba(255,255,255,0.08);
            --gradient-1: linear-gradient(135deg, #e50914 0%, #b20710 100%);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            display: flex;
            min-height: 100vh;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: 260px;
            background: var(--bg-sidebar);
            border-right: 1px solid var(--glass-border);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
        }
        .sidebar-brand {
            padding: 1.5rem;
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-primary);
            text-decoration: none;
            border-bottom: 1px solid var(--glass-border);
            text-align: center;
        }
        .sidebar-brand span { color: var(--accent); }
        
        .sidebar-nav {
            padding: 1.5rem 1rem;
            flex-grow: 1;
        }
        .nav-item { margin-bottom: 0.5rem; }
        .nav-link {
            color: var(--text-secondary);
            font-weight: 500;
            padding: 0.8rem 1rem;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
        }
        .nav-link:hover, .nav-link.active {
            color: var(--text-primary);
            background: var(--glass);
        }
        .nav-link.active {
            border-left: 4px solid var(--accent);
            background: rgba(229,9,20,0.1);
        }

        /* ── Main Content ── */
        .main-content {
            flex-grow: 1;
            margin-left: 260px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ── Topbar ── */
        .topbar {
            height: 70px;
            background: rgba(10,10,26,0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--glass-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .content-area {
            padding: 2rem;
            flex-grow: 1;
        }

        /* ── Cards & Tables ── */
        .card {
            background: var(--bg-secondary);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .card-header {
            background: rgba(0,0,0,0.2);
            border-bottom: 1px solid var(--glass-border);
            padding: 1rem 1.5rem;
            font-weight: 600;
        }
        .table {
            color: var(--text-primary);
            margin-bottom: 0;
        }
        .table-hover tbody tr:hover {
            color: var(--text-primary);
            background-color: var(--glass);
        }
        .table-dark {
            background-color: transparent;
            color: var(--text-secondary);
        }
        .table-dark th {
            background-color: rgba(0,0,0,0.4);
            border-color: var(--glass-border);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
        }
        .table td, .table th {
            border-color: var(--glass-border);
            padding: 1rem;
            vertical-align: middle;
        }

        /* ── Forms & Buttons ── */
        .form-control, .form-select {
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--glass-border);
            color: var(--text-primary);
            border-radius: 8px;
            padding: 0.6rem 1rem;
        }
        .form-control:focus, .form-select:focus {
            background: rgba(255,255,255,0.08);
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(229,9,20,0.15);
            color: var(--text-primary);
        }
        .btn-primary {
            background: var(--gradient-1);
            border: none;
        }
        .btn-primary:hover {
            background: var(--gradient-1);
            box-shadow: 0 4px 15px rgba(229,9,20,0.4);
            transform: translateY(-2px);
        }

        /* ── Dashboard Stats ── */
        .stat-card {
            background: var(--glass);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: transform 0.3s ease;
        }
        .stat-card:hover { transform: translateY(-5px); }
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            background: rgba(229,9,20,0.1);
            color: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
        }
        .stat-content h3 { font-size: 1.8rem; font-weight: 700; margin: 0; }
        .stat-content p { color: var(--text-secondary); margin: 0; font-size: 0.9rem; }

    </style>
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
