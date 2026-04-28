@extends('layouts.admin')

@section('content')
<div class="row mt-4 justify-content-center">
    <div class="col-md-8">
        <div class="card p-4 text-dark">
            <h3 class="mb-4">Edit Movie: {{ $movie->title }}</h3>
            
            @if($errors->any())
                <div class="alert alert-danger bg-danger text-white border-0">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.movies.update', $movie->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label>Title *</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $movie->title) }}" required>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Duration (Minutes) *</label>
                        <input type="number" name="duration_minutes" class="form-control" value="{{ old('duration_minutes', $movie->duration_minutes) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Release Date</label>
                        <input type="date" name="release_date" class="form-control" value="{{ old('release_date', $movie->release_date) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Language</label>
                        <input type="text" name="language" class="form-control" value="{{ old('language', $movie->language) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Rating</label>
                        <input type="text" name="rating" class="form-control" value="{{ old('rating', $movie->rating) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $movie->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Studio</label>
                    <select name="studio_id" class="form-control">
                        <option value="">Select Studio</option>
                        @foreach($studios as $studio)
                            <option value="{{ $studio->id }}" {{ $movie->studio_id == $studio->id ? 'selected' : '' }}>{{ $studio->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Categories</label>
                    <select name="categories[]" class="form-control" multiple>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $movie->categories->contains($cat->id) ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <small class="text-muted-2">Hold Ctrl to select multiple.</small>
                </div>

                <div class="mb-3">
                    <label>Poster Image</label>
                    @if($movie->poster_image)
                        <div class="mb-2">
                            <img src="{{ str_starts_with($movie->poster_image, 'http') ? $movie->poster_image : asset('storage/' . $movie->poster_image) }}" alt="Poster" style="height: 100px; border-radius: 8px;">
                        </div>
                    @endif
                    <input type="file" name="poster_image" class="form-control" accept="image/*">
                    <small class="text-muted-2">Leave empty to keep current image.</small>
                </div>

                <button type="submit" class="btn btn-warning w-100 mt-3">Update Movie</button>
            </form>
        </div>
    </div>
</div>
@endsection
