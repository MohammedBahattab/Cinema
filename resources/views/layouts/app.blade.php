<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MDAR Cinema - @yield('title', 'Book Your Experience')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('css/main_custom.css') }}" rel="stylesheet">
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