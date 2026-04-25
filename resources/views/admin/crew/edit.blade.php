@extends('layouts.admin')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card bg-white text-dark shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h3 class="mb-0 h5"><i class="fas fa-user-edit me-2"></i>Edit Crew Member: {{ $crew->name }}</h3>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.crew.update', $crew) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Member Name</label>
                            <input type="text" name="name" class="form-control form-control-lg" value="{{ old('name', $crew->name) }}" required>
                            @error('name')<span class="text-danger small">{{ $message }}</span>@enderror
                        </div>

                        <div id="movie-associations">
                            <label class="form-label fw-bold mb-2">Movie Associations</label>
                            
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
                                        <button type="button" class="btn btn-outline-danger remove-row" {{ $i == 0 ? 'disabled' : '' }}>
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            @endfor
                        </div>

                        <button type="button" class="btn btn-sm btn-outline-secondary mt-2 mb-4" id="add-movie-row">
                            <i class="fas fa-plus me-1"></i>Add Another Movie
                        </button>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4">Update Member</button>
                            <a href="{{ route('admin.crew.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let rowIdx = {{ $movieCount }};
    document.getElementById('add-movie-row').addEventListener('click', function() {
        const container = document.getElementById('movie-associations');
        const rows = container.querySelectorAll('.movie-row');
        const newRow = rows[0].cloneNode(true);
        
        // Reset values and update names
        newRow.querySelector('select[name^="movies"]').name = `movies[${rowIdx}][movie_id]`;
        newRow.querySelector('select[name*="role_id"]').name = `movies[${rowIdx}][role_id]`;
        newRow.querySelectorAll('select').forEach(s => s.value = "");
        
        // Show remove button
        newRow.querySelector('.remove-row').style.display = 'block';
        
        container.appendChild(newRow);
        rowIdx++;
    });

    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-row')) {
            e.target.closest('.movie-row').remove();
        }
    });
</script>
@endsection
