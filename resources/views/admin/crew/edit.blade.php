@extends('layouts.admin')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card border-0 shadow-lg">
                <div class="card-header border-bottom border-secondary py-3 d-flex align-items-center">
                    <h3 class="mb-0 h5 text-primary fw-bold">
                        <i class="fas fa-user-edit me-2"></i>Edit Crew Member: {{ $crew->name }}
                    </h3>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.crew.update', $crew) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary">Member Name</label>
                            <input type="text" name="name" class="form-control form-control-lg" value="{{ old('name', $crew->name) }}" required>
                            @error('name')<span class="text-danger small">{{ $message }}</span>@enderror
                        </div>

                        <div id="movie-associations">
                            <label class="form-label fw-bold mb-2 text-secondary">Movie Associations</label>
                            
                            @php $movieCount = count($crew->movies) > 0 ? count($crew->movies) : 1; @endphp
                            
                            @for($i = 0; $i < $movieCount; $i++)
                                @php $currentAssociation = $crew->movies->get($i); @endphp
                                <div class="movie-row row mb-2 g-2">
                                    <div class="col-md-5">
                                        <select name="movies[{{ $i }}][movie_id]" class="form-select">
                                            <option value="">Select Movie...</option>
                                            @foreach($movies as $movie)
                                                <option value="{{ $movie->id }}" {{ ($currentAssociation && $currentAssociation->id == $movie->id) ? 'selected' : '' }}>
                                                    {{ $movie->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-5">
                                        <select name="movies[{{ $i }}][role_id]" class="form-select">
                                            <option value="">Select Role...</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}" {{ ($currentAssociation && $currentAssociation->pivot->crew_role_id == $role->id) ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-danger remove-row w-100" {{ $i == 0 && $movieCount == 1 ? 'style=display:none' : '' }}>
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            @endfor
                        </div>

                        <button type="button" class="btn btn-sm btn-outline-info mt-2 mb-4" id="add-movie-row">
                            <i class="fas fa-plus me-1"></i> Add Another Movie
                        </button>
                        
                        <div class="d-flex gap-2 pt-3 border-top border-secondary">
                            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold">Update Member</button>
                            <a href="{{ route('admin.crew.index') }}" class="btn btn-outline-secondary px-4 py-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection