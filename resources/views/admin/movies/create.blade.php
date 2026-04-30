@extends('layouts.admin')

@section('content')
<div class="row mt-4 justify-content-center">
    <div class="col-md-8">
        <div class="card p-4 text-dark">
            <h3 class="mb-4">Add New Movie</h3>
            
            @if($errors->any())
                <div class="alert alert-danger bg-danger text-white border-0">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label>Title *</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Duration (Minutes) *</label>
                        <input type="number" name="duration_minutes" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Release Date</label>
                        <input type="date" name="release_date" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Language</label>
                        <input type="text" name="language" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Rating</label>
                        <input type="text" name="rating" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>

                 <div class="mb-3">
   
                 <label>Categories</label>
   
                 <select name="categories[]" class="form-control" multiple>
   
                 @foreach($categories as $cat)
   
                 <option value="{{ $cat->id }}"
   
                 {{ in_array($cat->id, old('categories', [])) ? 'selected' : '' }}>
   
                 {{ $cat->name }}
   
                </option>
   
                @endforeach
   
            </select>
   
            <small class="text-muted-2">Hold Ctrl to select multiple.</small>

        </div>

                <div class="mb-3">
                    <label>Studio</label>
                    <select name="studio_id" class="form-control">
                        <option value="">Select Studio</option>
                        @foreach($studios as $studio)
                            <option value="{{ $studio->id }}">{{ $studio->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Poster Image</label>
                    <input type="file" name="poster_image" class="form-control" accept="image/*">
                </div>

                <button type="submit" class="btn btn-success w-100 mt-3">Save Movie</button>
            </form>
        </div>
    </div>
</div>
@endsection
