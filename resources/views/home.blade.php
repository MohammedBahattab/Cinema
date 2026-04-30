@extends('layouts.app')

@section('content')

<div class="text-center mb-5 animate-in delay-1">
    <h1 class="display-4 fw-bold">
        Experience the Magic of <span class = "colortitile">Cinema</span>
    </h1>
    <p class="text-secondary fs-5">
        Book your tickets for the latest blockbusters and premium experiences.
    </p>
</div>

<h3>Now Showing <span class = "colortitile">Today</span></h3>
@include('movies.partials.movie_list', ['movies' => $todayMovies])
<br>
<h3>Recommended</h3>
@include('movies.partials.movie_list', ['movies' => $randomMovies])
<br>
<h3>Movies For <span class = "colortitile">Family</span></h3>
@include('movies.partials.movie_list', ['movies' => $catMovies])



@endsection