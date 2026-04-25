@extends('layouts.admin')

@section('content')
<div class="row mt-4 justify-content-center">
    <div class="col-md-6">
        <div class="card p-4 text-dark">
            <h3 class="mb-4">Add New Showtime</h3>
            
            @if($errors->any())
                <div class="alert alert-danger bg-danger text-white border-0">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.showtimes.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Select Movie *</label>
                    <select name="movie_id" class="form-control" required>
                        <option value="">Choose a movie</option>
                        @foreach($movies as $movie)
                            <option value="{{ $movie->id }}">{{ $movie->title }} ({{ $movie->duration_minutes }}m)</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-3">
                    <label>Select Hall *</label>
                    <select name="hall_id" class="form-control" required>
                        <option value="">Choose a hall</option>
                        @foreach($halls as $hall)
                            <option value="{{ $hall->id }}">{{ $hall->name }} ({{ $hall->total_rows * $hall->seats_per_row }} seats)</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Show Date *</label>
                    <input type="date" name="show_date" class="form-control" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Start Time *</label>
                        <input type="time" name="start_time" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>End Time *</label>
                        <input type="time" name="end_time" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Ticket Price ($) *</label>
                    <input type="number" step="0.01" name="price" class="form-control" required min="0">
                </div>

                <button type="submit" class="btn btn-success w-100 mt-2">Create Showtime</button>
            </form>
        </div>
    </div>
</div>
@endsection
