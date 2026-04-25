<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MDAR Cinema - @yield('title', 'Book Your Experience')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<<<<<<< HEAD
    <style>
        :root {
            --bg-primary: #0a0a1a;
            --bg-secondary: #12122a;
            --bg-card: rgba(255,255,255,0.04);
            --accent: #e50914;
            --accent-hover: #ff1a25;
            --gold: #f5c518;
            --text-primary: #ffffff;
            --text-secondary: #8b8b9e;
            --glass: rgba(255,255,255,0.06);
            --glass-border: rgba(255,255,255,0.08);
            --gradient-1: linear-gradient(135deg, #e50914 0%, #b20710 100%);
            --gradient-2: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --shadow-glow: 0 0 40px rgba(229,9,20,0.15);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ── Navbar ── */
        .navbar-cinema {
            background: rgba(10,10,26,0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--glass-border);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .navbar-cinema .brand-logo {
            font-size: 1.6rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--text-primary);
            text-decoration: none;
        }
        .navbar-cinema .brand-logo span { color: var(--accent); }
        .navbar-cinema .nav-link {
            color: var(--text-secondary) !important;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
        }
        .navbar-cinema .nav-link:hover {
            color: var(--text-primary) !important;
            background: var(--glass);
        }
        .btn-accent {
            background: var(--gradient-1);
            color: white;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-accent:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(229,9,20,0.4);
            color: white;
        }

        /* ── Glass Card ── */
        .glass-card {
            background: var(--glass);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            backdrop-filter: blur(10px);
            transition: all 0.4s ease;
        }
        .glass-card:hover {
            border-color: rgba(229,9,20,0.3);
            transform: translateY(-4px);
            box-shadow: var(--shadow-glow);
        }

        /* ── Movie Card ── */
        .movie-card {
            border-radius: 16px;
            overflow: hidden;
            background: var(--bg-secondary);
            border: 1px solid var(--glass-border);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
        }
        .movie-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 60px rgba(229,9,20,0.2);
            border-color: var(--accent);
        }
        .movie-card .poster-wrap {
            position: relative;
            overflow: hidden;
            height: 350px;
        }
        .movie-card .poster-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .movie-card:hover .poster-wrap img { transform: scale(1.1); }
        .movie-card .poster-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 60%;
            background: linear-gradient(transparent, rgba(10,10,26,0.95));
        }
        .movie-card .rating-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: rgba(0,0,0,0.7);
            backdrop-filter: blur(10px);
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--gold);
        }
        .movie-card .card-body { padding: 1.2rem; }
        .movie-card .card-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 0.3rem;
        }
        .movie-meta {
            color: var(--text-secondary);
            font-size: 0.85rem;
        }

        /* ── Seat System ── */
        .screen-bar {
            background: linear-gradient(90deg, transparent, var(--accent), transparent);
            height: 4px;
            border-radius: 50%;
            margin: 0 auto 2rem;
            width: 70%;
            box-shadow: 0 0 30px rgba(229,9,20,0.5);
        }
        .screen-label {
            text-align: center;
            color: var(--text-secondary);
            font-size: 0.85rem;
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
        }
        .seat-btn {
            width: 38px;
            height: 38px;
            margin: 3px;
            border-radius: 8px 8px 4px 4px;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 700;
            transition: all 0.2s ease;
            position: relative;
        }
        .seat-btn.available {
            background: #1a3a2a;
            color: #4ade80;
            border: 1px solid #2d5a3d;
        }
        .seat-btn.available:hover {
            background: #2d5a3d;
            transform: scale(1.15);
        }
        .seat-btn.booked {
            background: #3a1a1a;
            color: #666;
            cursor: not-allowed;
            border: 1px solid #4a2a2a;
        }
        .seat-btn.selected {
            background: var(--gradient-1);
            color: white;
            transform: scale(1.1);
            box-shadow: 0 4px 15px rgba(229,9,20,0.4);
        }

        /* ── Section Headers ── */
        .section-header {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }
        .section-sub {
            color: var(--text-secondary);
            font-size: 1rem;
            margin-bottom: 2rem;
        }

        /* ── Alerts ── */
        .alert-cinema {
            background: var(--glass);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            backdrop-filter: blur(10px);
            color: var(--text-primary);
        }
        .alert-cinema.success { border-left: 4px solid #4ade80; }
        .alert-cinema.danger { border-left: 4px solid var(--accent); }

        /* ── Form Inputs ── */
        .form-cinema {
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--glass-border);
            border-radius: 10px;
            color: var(--text-primary);
            padding: 0.7rem 1rem;
            transition: all 0.3s ease;
        }
        .form-cinema:focus {
            background: rgba(255,255,255,0.08);
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(229,9,20,0.15);
            color: var(--text-primary);
        }
        .form-cinema option { background: var(--bg-secondary); color: var(--text-primary); }

        /* ── Footer ── */
        .footer-cinema {
            background: var(--bg-secondary);
            border-top: 1px solid var(--glass-border);
            padding: 2rem 0;
            margin-top: 4rem;
            text-align: center;
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        /* ── Animations ── */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-in {
            animation: fadeInUp 0.6s ease forwards;
        }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
    </style>
=======
    <link href="{{ asset('css/main_custom.css') }}" rel="stylesheet">
>>>>>>> 6e22249051c96f03f5b85cb386105d8d06e856a7
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar-cinema">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="{{ route('home') }}" class="brand-logo"><span>MDAR</span> Cinema</a>
            <div class="d-flex align-items-center gap-2">
                @auth
                    @if(auth()->user()->role && auth()->user()->role->name === 'admin')
                        <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-shield-halved me-1"></i> Admin</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn-accent btn btn-sm"><i class="fas fa-sign-out-alt me-1"></i> {{ auth()->user()->name }}</button>
                    </form>
                @else
                    <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt me-1"></i> Login</a>
                    <a class="btn-accent btn btn-sm" href="{{ route('register') }}"><i class="fas fa-user-plus me-1"></i> Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-cinema success p-3 animate-in"><i class="fas fa-check-circle me-2 text-success"></i>{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-cinema danger p-3 animate-in"><i class="fas fa-exclamation-triangle me-2 text-danger"></i>{{ session('error') }}</div>
        @endif
    </div>

    <!-- Content -->
    <main class="container py-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer-cinema">
        <div class="container">
            <p class="mb-1"><span style="color:var(--accent);font-weight:700;">MDAR</span> Cinema &copy; {{ date('Y') }}</p>
            <small>Your Premium Movie Experience</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
