@extends('layouts.admin')

@section('content')
<div class="row mt-4">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-primary fw-bold mb-0">Manage Showtimes</h3>
            <a href="{{ route('admin.showtimes.create') }}" class="btn btn-primary px-4">Add New Showtime</a>
        </div>
        
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Movie</th>
                            <th>Hall</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Price</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($showtimes as $showtime)
                        <tr>
                            <td>{{ $showtime->id }}</td>
                            <td class="fw-bold text-info">{{ $showtime->movie->title ?? 'N/A' }}</td>
                            <td><span class="badge bg-secondary">{{ $showtime->hall->name }}</span></td>
                            <td>{{ $showtime->show_date }}</td>
                            <td><span class="text-warning small">{{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }}</span></td>
                            <td class="text-success fw-bold">${{ number_format($showtime->price, 2) }}</td>
                            <td class="text-center">
                                <form action="{{ route('admin.showtimes.destroy', $showtime->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Delete?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center py-4 text-muted">No showtimes found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection