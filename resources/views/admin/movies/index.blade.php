@extends('layouts.admin')

@section('content')
<div class="row mt-4">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-primary fw-bold mb-0">Manage Movies</h3>
            <a href="{{ route('admin.movies.create') }}" class="btn btn-primary px-4">Add New Movie</a>
        </div>
        
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Poster</th>
                            <th>Title</th>
                            <th>Duration</th>
                            <th>Studio</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($movies as $movie)
                        <tr>
                            <td>{{ $movie->id }}</td>
                            <td>
                                @if($movie->poster_image)
                                    <img src="{{ str_starts_with($movie->poster_image, 'http') ? $movie->poster_image : asset('storage/' . $movie->poster_image) }}" 
                                         class="rounded shadow-sm border border-secondary" width="45" height="65" style="object-fit: cover;">
                                @else
                                    <div class="bg-secondary rounded text-center small py-2" style="width:45px">No Pic</div>
                                @endif
                            </td>
                            <td class="fw-bold">{{ $movie->title }}</td>
                            <td><span class="badge bg-dark border border-secondary">{{ $movie->duration_minutes }} mins</span></td>
                            <td><span class="badge bg-dark border border-secondary">{{ $movie->studio ? $movie->studio->name : 'N/A' }}</span></td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.movies.edit', $movie->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('admin.movies.destroy', $movie->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center py-4 text-muted">No movies found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection