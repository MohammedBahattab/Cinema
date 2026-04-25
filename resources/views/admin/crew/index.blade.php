@extends('layouts.admin')

@section('content')
<div class="row mt-4">
    <div class="col-md-6 mb-4">
        <h3>Crew Roles</h3>
        <form action="{{ route('admin.crew.storeRole') }}" method="POST" class="mb-3">
            @csrf
            <div class="input-group">
                <input type="text" name="name" class="form-control" placeholder="e.g. director, actor, producer" required>
                <button type="submit" class="btn btn-success">Add Role</button>
            </div>
            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
        </form>

        <div class="bg-white rounded p-3 text-dark">
<<<<<<< HEAD
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Role Name</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="2" class="text-center">No roles yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <h3>Crew Members</h3>
        <form action="{{ route('admin.crew.storeCrew') }}" method="POST" class="mb-3">
            @csrf
            <div class="input-group">
                <input type="text" name="name" class="form-control" placeholder="e.g. Christopher Nolan" required>
                <button type="submit" class="btn btn-primary">Add Member</button>
            </div>
        </form>

        <div class="bg-white rounded p-3 text-dark">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($crews as $crew)
                    <tr>
                        <td>{{ $crew->id }}</td>
                        <td>{{ $crew->name }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="2" class="text-center">No crew members yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
=======
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Role Name</th>
                                <th class="text-center w-80px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td class="fw-bold">{{ $role->name }}</td>
                                <td class="text-center">
                                    <form action="{{ route('admin.crew.destroyRole', $role) }}" method="POST" onsubmit="return confirm('Delete this role?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center">No roles yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
        </div>
    </div>

    <div class="col-md-12 mb-4">
        <div class="card bg-white text-dark shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Crew Members Management</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.crew.storeCrew') }}" method="POST" class="mb-5 border-bottom pb-4">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Member Name</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Christopher Nolan" required>
                        </div>
                    </div>

                    <div id="movie-associations">
                        <label class="form-label fw-bold">Associate with Movies (Optional)</label>
                        <div class="movie-row row mb-2">
                            <div class="col-md-5">
                                <select name="movies[0][movie_id]" class="form-select">
                                    <option value="">Select Movie...</option>
                                    @foreach($movies as $movie)
                                        <option value="{{ $movie->id }}">{{ $movie->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5">
                                <select name="movies[0][role_id]" class="form-select">
                                    <option value="">Select Role...</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-danger remove-row"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-sm btn-outline-secondary mb-3" id="add-movie-row">+ Add Another Movie</button>
                    
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary px-4">Save Crew Member</button>
                    </div>
                </form>

                <h4>Existing Crew Members</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-hover mt-3 align-middle">
                        <thead class="table-dark">
                            <tr>
                                                            <th class="w-50px">ID</th>
                                        <th class="w-200px">Name</th>
                                        <th>Movies & Roles</th>
                                        <th class="text-center w-150px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($crews as $crew)
                            <tr>
                                <td>{{ $crew->id }}</td>
                                <td class="fw-bold">{{ $crew->name }}</td>
                                <td>
                                    @forelse($crew->movies as $movie)
                                        @php
                                            $roleName = $roles->find($movie->pivot->crew_role_id)->name ?? 'N/A';
                                        @endphp
                                        <span class="badge bg-info text-dark mb-1">
                                            {{ $movie->title }} 
                                            <span class="small opacity-75">({{ $roleName }})</span>
                                        </span>
                                    @empty
                                        <span class="text-muted small">No movies assigned</span>
                                    @endforelse
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('admin.crew.edit', $crew) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.crew.destroy', $crew) }}" method="POST" onsubmit="return confirm('Delete this member?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center py-3">No crew members yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let rowIdx = 1;
    document.getElementById('add-movie-row').addEventListener('click', function() {
        const container = document.getElementById('movie-associations');
        const firstRow = container.querySelector('.movie-row');
        const newRow = firstRow.cloneNode(true);
        
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
        if (e.target.classList.contains('remove-row')) {
            e.target.closest('.movie-row').remove();
        }
    });
</script>
>>>>>>> 6e22249051c96f03f5b85cb386105d8d06e856a7
@endsection
