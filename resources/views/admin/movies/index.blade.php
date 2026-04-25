@extends('layouts.admin')

@section('content')
<div class="row mt-4">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Manage Movies</h2>
            <a href="{{ route('admin.movies.create') }}" class="btn btn-primary">Add New Movie</a>
        </div>
        
        <div class="table-responsive bg-white rounded p-3">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Poster</th>
                        <th>Title</th>
                        <th>Duration</th>
                        <th>Studio</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($movies as $movie)
                    <tr>
                        <td>{{ $movie->id }}</td>
                        <td>
                            @if($movie->poster_image)
                                <img src="{{ str_starts_with($movie->poster_image, 'http') ? $movie->poster_image : asset('storage/' . $movie->poster_image) }}" width="50" alt="Poster">
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $movie->title }}</td>
                        <td>{{ $movie->duration_minutes }} mins</td>
                        <td>{{ $movie->studio ? $movie->studio->name : 'N/A' }}</td>
                        <td>
                            <a href="{{ route('admin.movies.edit', $movie->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.movies.destroy', $movie->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this movie?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No movies found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
