@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/movie_show.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="movie-hero animate-in">
    @if($movie->banner_image)
        <img src="{{ $movie->banner_image }}" class="hero-background-img" alt="Background">
    @else
        <img src="{{ str_starts_with($movie->poster_image, 'http') ? $movie->poster_image : asset('storage/' . $movie->poster_image) }}" class="hero-background-img" alt="Background">
    @endif

    <div class="movie-hero-overlay"></div>

    <div class="movie-hero-content">
        @if($movie->poster_image)
            <img src="{{ str_starts_with($movie->poster_image, 'http') ? $movie->poster_image : asset('storage/' . $movie->poster_image) }}" class="movie-poster" alt="{{ $movie->title }}">
        @endif

        <div class="movie-details-side">
            <div class="d-flex gap-2 mb-3 justify-content-center justify-content-md-start flex-wrap">
                @foreach($movie->categories as $cat)
                    <span class="badge badge-category rounded-pill px-3">{{ $cat->name }}</span>
                @endforeach
            </div>
            
            <h1 class="movie-title-display text-white">{{ $movie->title }}</h1>
            
            <div class="text-light fs-5 d-flex gap-4 justify-content-center justify-content-md-start align-items-center flex-wrap">
                <span><i class="fas fa-calendar-alt me-2 text-accent"></i>{{ \Carbon\Carbon::parse($movie->release_date)->year }}</span>
                <span><i class="far fa-clock me-2 text-accent"></i>{{ $movie->duration_minutes }} min</span>
                <span><i class="fas fa-language me-2 text-accent"></i>{{ $movie->language }}</span>
                <span class="rating-star fw-bold"><i class="fas fa-star me-1"></i>{{ $movie->rating }}</span>
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
            <div class="crew-card animate-in">
            <div class="crew-avatar-container">
                <i class="fas fa-user text-secondary"></i>
             </div>
              <div class="crew-info">
                  <h6 class="crew-name text-white fw-bold">{{ $member->name }}</h6>
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
                        <h4 class="price-tag mb-0 fw-bold">${{ number_format($showtime->price, 2) }}</h4>
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