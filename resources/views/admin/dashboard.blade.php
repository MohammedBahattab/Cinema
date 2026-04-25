@extends('layouts.admin')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h2 class="fw-bold mb-0">Dashboard Overview</h2>
        <p class="text-secondary mb-0">Welcome back, {{ auth()->user()->name }}</p>
    </div>
    <div class="text-secondary">
        <i class="far fa-calendar-alt me-2"></i>{{ date('l, d F Y') }}
    </div>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon stat-movies">
                <i class="fas fa-film"></i>
            </div>
            <div class="stat-content">
                <p>Total Movies</p>
                <h3>{{ $totalMovies }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon stat-showtimes">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-content">
                <p>Active Showtimes</p>
                <h3>{{ $totalShowtimes }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon stat-bookings">
                <i class="fas fa-ticket-alt"></i>
            </div>
            <div class="stat-content">
                <p>Total Bookings</p>
                <h3>{{ $totalBookings }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon stat-halls">
                <i class="fas fa-door-open"></i>
            </div>
            <div class="stat-content">
                <p>Cinema Halls</p>
                <h3>{{ $totalHalls }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-0">
            <div class="card-header border-0 d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-bold text-white"><i class="fas fa-history text-accent me-2"></i>Recent Bookings</h5>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-outline-light rounded-pill px-3">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0 align-middle">
                        <thead class="bg-dark bg-opacity-50 border-bottom border-secondary">
                            <tr>
                                <th class="ps-4">Booking ID</th>
                                <th>Customer</th>
                                <th>Movie</th>
                                <th>Date & Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentBookings as $booking)
                            <tr>
                                <td class="ps-4 fw-bold">#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center user-avatar-sm">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div>
                                            <div class="text-white">{{ $booking->user ? $booking->user->name : $booking->guestUser->full_name }}</div>
                                            <small class="text-secondary">{{ $booking->user ? 'Registered User' : 'Guest' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold text-white">{{ $booking->showtime->movie->title }}</div>
                                    <small class="text-secondary">{{ $booking->showtime->hall->name }}</small>
                                </td>
                                <td>
                                    <div class="text-white">{{ \Carbon\Carbon::parse($booking->showtime->show_date)->format('d M Y') }}</div>
                                    <small class="text-secondary">{{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('H:i') }}</small>
                                </td>
                                <td>
                                    @if($booking->status == 'confirmed')
                                        <span class="badge bg-success bg-opacity-20 text-success border border-success rounded-pill px-3 py-2">Confirmed</span>
                                    @elseif($booking->status == 'pending')
                                        <span class="badge bg-warning bg-opacity-20 text-warning border border-warning rounded-pill px-3 py-2">Pending</span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-20 text-danger border border-danger rounded-pill px-3 py-2">{{ ucfirst($booking->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-secondary">
                                    <i class="fas fa-inbox fa-3x mb-3 opacity-50"></i>
                                    <h5>No bookings found.</h5>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
