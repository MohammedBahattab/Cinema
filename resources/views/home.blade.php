@extends('layouts.app')

@section('content')
<div class="text-center mb-5 animate-in delay-1">
    <h1 class="display-4 fw-bold">Experience the Magic of <span style="color: var(--accent);">Cinema</span></h1>
    <p class="text-secondary fs-5">Book your tickets for the latest blockbusters and premium experiences.</p>
</div>

<div class="row g-4 animate-in delay-2">
    @forelse($movies as $movie)
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="movie-card">
            <div class="poster-wrap">
                @if($movie->poster_image)
                    <img src="{{ str_starts_with($movie->poster_image, 'http') ? $movie->poster_image : asset('storage/' . $movie->poster_image) }}" alt="{{ $movie->title }}">
                @else
                    <div class="h-100 w-100 d-flex align-items-center justify-content-center bg-dark text-muted">
                        <i class="fas fa-film fa-3x"></i>
                    </div>
                @endif
                <div class="poster-overlay"></div>
                <div class="rating-badge"><i class="fas fa-star text-warning me-1"></i>{{ $movie->rating ?? 'N/A' }}</div>
            </div>
            <div class="card-body text-center pb-4">
                <h5 class="card-title text-truncate">{{ $movie->title }}</h5>
                <div class="movie-meta mb-3">
                    <span><i class="far fa-clock me-1"></i>{{ $movie->duration_minutes }}m</span>
                    <span class="mx-2">•</span>
                    <span>{{ $movie->language ?? 'EN' }}</span>
                </div>
                <a href="{{ route('movies.show', $movie->id) }}" class="btn-accent text-decoration-none d-block w-100 rounded-pill">
                    View Details & Book
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <i class="fas fa-video-slash fa-4x text-muted mb-3"></i>
        <h3 class="text-muted">No movies showing right now</h3>
    </div>
    @endforelse
</div>
@endsection
