@extends('layouts.app')

@section('content')
<div class="text-center mb-5 animate-in delay-1">
    <h1 class="display-4 fw-bold">Experience the Magic of <span style="color: var(--accent);">Cinema</span></h1>
    <p class="text-secondary fs-5">Book your tickets for the latest blockbusters and premium experiences.</p>
</div>


@include('movies.partials.movie_list')

@endsection
