@extends('layouts.admin')

@section('content')
<div class="row mt-4">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Manage Showtimes</h2>
            <a href="{{ route('admin.showtimes.create') }}" class="btn btn-primary">Add New Showtime</a>
        </div>
        
        <div class="table-responsive bg-white rounded p-3 text-dark">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Movie</th>
                        <th>Hall</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($showtimes as $showtime)
                    <tr>
                        <td>{{ $showtime->id }}</td>
                        <td>{{ $showtime->movie->title ?? 'N/A (Deleted)' }}</td>
                        <td>{{ $showtime->hall->name }}</td>
                        <td>{{ $showtime->show_date }}</td>
                        <td>{{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($showtime->end_time)->format('H:i') }}</td>
                        <td>${{ number_format($showtime->price, 2) }}</td>
                        <td>
                            <form action="{{ route('admin.showtimes.destroy', $showtime->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this showtime?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No showtimes found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
