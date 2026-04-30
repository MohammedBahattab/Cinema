@extends('layouts.app')

@section('content')

@push('styles')
    <link href="{{ asset('css/search.css') }}" rel="stylesheet">
@endpush

<div class="container-fluid px-4">

    <!-- 🔍 البحث -->
    <input type="text" id="searchInput" class="form-control mb-4" placeholder="Search movies...">

    <div class="row">

        <!-- 🎛 الفلاتر (يسار) -->
        <div class="col-lg-3">
            <div class="glass-card p-3">

                <h5>Categories</h5>
                <div class="tags-container d-flex flex-wrap gap-2 mb-4">
                    @foreach($categories as $cat)
                        <div class="category-tag">
                            <input type="checkbox" 
                                   class="filter category-checkbox d-none" 
                                   id="cat-{{ $cat->id }}" 
                                   value="{{ $cat->id }}">
                            <label for="cat-{{ $cat->id }}" class="tag-label category-style">
                                {{ $cat->name }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <hr>

                <h5>Studios</h5>
                <div class="tags-container d-flex flex-wrap gap-2 mb-4">
                    @foreach($studios as $studio)
                        <div class="studio-tag">
                            <input type="checkbox" 
                                   class="filter studio-checkbox d-none" 
                                   id="studio-{{ $studio->id }}" 
                                   value="{{ $studio->id }}">
                            <label for="studio-{{ $studio->id }}" class="tag-label studio-style">
                                {{ $studio->name }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <hr>

                <h5>Year</h5>
                <input type="number" id="year" class="form-control">

                <h5 class="mt-3">Min Rating</h5>
                <input type="number" id="rating" class="form-control" step="0.1">

            </div>
        </div>

        <!-- 🎬 النتائج (يمين) -->
        <div class="col-lg-9">
            <div id="results">
                @include('movies.partials.results', ['gridClass' => 'col-12 col-md-6 col-xl-4'])
            </div>
        </div>

    </div>
</div>

@endsection