@extends('layouts.admin')

@section('content')
<div class="row mt-4">
    <div class="col-md-6 mb-4">
        <h3 class="mb-3">Crew Roles</h3>
        <form action="{{ route('admin.crew.storeRole') }}" method="POST" class="mb-3">
            @csrf
            <div class="input-group shadow-sm">
                <input type="text" name="name" class="form-control bg-dark-input" placeholder="e.g. director, actor" required>
                <button type="submit" class="btn btn-primary">Add Role</button>
            </div>
            @error('name')<span class="text-danger small">{{ $message }}</span>@enderror
        </form>

        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0">
                    <thead>
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
                                    <button class="btn btn-sm btn-outline-danger border-0">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center py-3 text-secondary">No roles yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header border-bottom border-light-subtle d-flex justify-content-between align-items-center">
                <h4 class="mb-0 text-primary fw-bold">Crew Members Management</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.crew.storeCrew') }}" method="POST" class="mb-5 border-bottom border-secondary pb-4">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label class="form-label fw-bold small text-secondary uppercase">Member Name</label>
                            <input type="text" name="name" class="form-control form-control-lg" placeholder="e.g. Christopher Nolan" required>
                        </div>
                    </div>

                    <div id="movie-associations">
                        <label class="form-label fw-bold small text-secondary uppercase">Associate with Movies (Optional)</label>
                        <div class="movie-row row mb-2 g-2">
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
                                <button type="button" class="btn btn-outline-danger remove-row w-100">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-sm btn-outline-info mt-2 mb-4" id="add-movie-row">
                        <i class="fas fa-plus me-1"></i> Add Another Movie
                    </button>
                    
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary px-5 py-2 fw-bold">Save Crew Member</button>
                    </div>
                </form>

                <h4 class="mb-3 text-secondary">Existing Crew Members</h4>
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle">
                        <thead>
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
                                        <span class="badge movie-badge me-1">
                                            {{ $movie->title }} <span class="movie-role-text">[{{ $roleName }}]</span>
                                        </span>
                                    @empty
                                        <span class="text-muted small italic">No movies assigned</span>
                                    @endforelse
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
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
                            <tr><td colspan="4" class="text-center py-4 text-muted">No crew members yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection