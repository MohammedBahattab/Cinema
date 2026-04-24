@extends('layouts.admin')

@section('content')
<div class="row mt-4">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Manage Halls</h2>
            <a href="{{ route('admin.halls.create') }}" class="btn btn-primary">Add New Hall</a>
        </div>
        
        <div class="table-responsive bg-white rounded p-3 text-dark">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Rows</th>
                        <th>Seats per Row</th>
                        <th>Total Seats</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($halls as $hall)
                    <tr>
                        <td>{{ $hall->id }}</td>
                        <td>{{ $hall->name }}</td>
                        <td>{{ $hall->total_rows }}</td>
                        <td>{{ $hall->seats_per_row }}</td>
                        <td>{{ $hall->total_rows * $hall->seats_per_row }}</td>
                        <td>
                            <form action="{{ route('admin.halls.destroy', $hall->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this hall? This will delete all associated seats!')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No halls found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
