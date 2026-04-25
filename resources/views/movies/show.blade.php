@extends('layouts.app')

@push('styles')
<<<<<<< HEAD
<style>
    .movie-hero {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 3rem;
        box-shadow: 0 20px 50px rgba(0,0,0,0.5);
    }
    .movie-hero img {
        width: 100%;
        height: 60vh;
        object-fit: cover;
        opacity: 0.5;
    }
    .movie-hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, var(--bg-primary) 0%, transparent 100%);
    }
    .movie-hero-content {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 3rem;
        display: flex;
        gap: 2rem;
        align-items: flex-end;
    }
    .movie-poster {
        width: 250px;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.8);
        border: 2px solid var(--glass-border);
        transform: translateY(20px);
    }
    .showtime-card {
        background: var(--glass);
        border: 1px solid var(--glass-border);
        border-radius: 12px;
        padding: 1.5rem;
        transition: all 0.3s ease;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .showtime-card:hover {
        background: rgba(229,9,20,0.05);
        border-color: rgba(229,9,20,0.3);
        transform: translateX(10px);
    }
</style>
=======
    <link href="{{ asset('css/movie_show.css') }}" rel="stylesheet">
>>>>>>> 6e22249051c96f03f5b85cb386105d8d06e856a7
@endpush

@section('content')
<div class="movie-hero animate-in">
    @if($movie->banner_image)
        <img src="{{ $movie->banner_image }}" alt="Banner">
    @elseif($movie->poster_image)
<<<<<<< HEAD
        <img src="{{ str_starts_with($movie->poster_image, 'http') ? $movie->poster_image : asset('storage/' . $movie->poster_image) }}" style="filter: blur(10px);" alt="Banner">
    @else
        <div style="height: 60vh; background: var(--bg-secondary);"></div>
=======
        <img src="{{ str_starts_with($movie->poster_image, 'http') ? $movie->poster_image : asset('storage/' . $movie->poster_image) }}" class="banner-blur" alt="Banner">
    @else
        <div class="empty-banner"></div>
>>>>>>> 6e22249051c96f03f5b85cb386105d8d06e856a7
    @endif
    <div class="movie-hero-overlay"></div>
    <div class="movie-hero-content flex-column flex-md-row text-center text-md-start">
        @if($movie->poster_image)
            <img src="{{ str_starts_with($movie->poster_image, 'http') ? $movie->poster_image : asset('storage/' . $movie->poster_image) }}" class="movie-poster" alt="{{ $movie->title }}">
        @endif
        <div class="pb-3">
            <div class="d-flex gap-2 mb-3 justify-content-center justify-content-md-start">
                @foreach($movie->categories as $cat)
                    <span class="badge bg-danger rounded-pill px-3">{{ $cat->name }}</span>
                @endforeach
            </div>
            <h1 class="display-3 fw-bold mb-2">{{ $movie->title }}</h1>
            <div class="text-secondary fs-5 d-flex gap-3 justify-content-center justify-content-md-start align-items-center">
                <span><i class="fas fa-calendar-alt me-2"></i>{{ $movie->release_date }}</span>
                <span><i class="far fa-clock me-2"></i>{{ $movie->duration_minutes }} min</span>
                <span><i class="fas fa-language me-2"></i>{{ $movie->language }}</span>
                <span class="text-warning fw-bold"><i class="fas fa-star me-1"></i>{{ $movie->rating }}</span>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5 pt-4">
    <div class="col-lg-8 pe-lg-5 animate-in delay-1">
        <h3 class="section-header">Synopsis</h3>
        <p class="fs-5 text-secondary lh-lg mb-5">{{ $movie->description ?? 'No description available for this movie.' }}</p>

        <h3 class="section-header">Cast & Crew</h3>
        <div class="row g-3 mb-5">
            @forelse($movie->crew as $member)
            <div class="col-md-4">
                <div class="glass-card p-3 d-flex align-items-center gap-3">
<<<<<<< HEAD
                    <div class="bg-dark rounded-circle d-flex align-items-center justify-content-center" style="width:50px;height:50px;">
=======
                    <div class="bg-dark rounded-circle d-flex align-items-center justify-content-center crew-avatar-container">
>>>>>>> 6e22249051c96f03f5b85cb386105d8d06e856a7
                        <i class="fas fa-user text-secondary"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold">{{ $member->name }}</h6>
                        <small class="text-secondary">{{ $member->pivot->crew_role_id == 1 ? 'Director' : 'Actor' }}</small>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-secondary">Crew details not available.</p>
            @endforelse
        </div>
    </div>

    <div class="col-lg-4 animate-in delay-2">
        <h3 class="section-header mb-4">Book Tickets</h3>
        @if($movie->showtimes->isEmpty())
            <div class="glass-card p-5 text-center">
                <i class="far fa-frown fa-3x text-secondary mb-3"></i>
                <h5>No Showtimes</h5>
                <p class="text-secondary mb-0">There are currently no showtimes available for this movie.</p>
            </div>
        @else
            <div class="d-flex flex-column gap-3">
                @foreach($movie->showtimes as $showtime)
                <div class="showtime-card">
                    <div>
                        <h5 class="fw-bold mb-1 text-white">{{ \Carbon\Carbon::parse($showtime->show_date)->format('D, d M') }}</h5>
                        <div class="text-secondary mb-2">
                            <i class="far fa-clock me-1"></i> {{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }}
                            <span class="mx-2">|</span>
                            <i class="fas fa-door-open me-1"></i> {{ $showtime->hall->name }}
                        </div>
                        <h4 class="text-warning mb-0 fw-bold">${{ number_format($showtime->price, 2) }}</h4>
                    </div>
                    <div>
                        <a href="{{ route('booking.seats', $showtime->id) }}" class="btn-accent text-decoration-none rounded-pill px-4">
                            Select Seats <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
