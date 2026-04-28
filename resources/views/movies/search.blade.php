@extends('layouts.app')

@section('content')

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

<!-- 🎨 CSS -->
<style>
    .tag-label {
        padding: 6px 16px;
        border: 1px solid #e0e0e0;
        border-radius: 50px;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        background-color: #ffffff;
        color: #555;
        font-size: 0.85rem;
        display: inline-block;
        user-select: none;
    }

    /* category active */
    .category-checkbox:checked + .category-style {
        background-color: #6f42c1; 
        color: white;
        border-color: #59359a;
        box-shadow: 0 3px 6px rgba(111, 66, 193, 0.2);
    }

    /* studio active */
    .studio-checkbox:checked + .studio-style {
        background-color: #007bff;
        color: white;
        border-color: #0056b3;
        box-shadow: 0 3px 6px rgba(0, 123, 255, 0.2);
    }

    .tag-label:hover {
        border-color: #bbb;
        background-color: #f1f1f1;
    }
</style>

@endsection