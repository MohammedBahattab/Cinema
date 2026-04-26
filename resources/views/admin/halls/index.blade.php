@extends('layouts.admin')

@section('content')
<div class="row mt-4">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-primary fw-bold mb-0">Manage Halls</h3>
            <a href="{{ route('admin.halls.create') }}" class="btn btn-primary px-4">Add New Hall</a>
        </div>
        
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Rows</th>
                            <th>Seats/Row</th>
                            <th>Total</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($halls as $hall)
                        <tr>
                            <td>{{ $hall->id }}</td>
                            <td class="fw-bold">{{ $hall->name }}</td>
                            <td>{{ $hall->total_rows }}</td>
                            <td>{{ $hall->seats_per_row }}</td>
                            <td class="text-info fw-bold">{{ $hall->total_rows * $hall->seats_per_row }}</td>
                            <td class="text-center">
                                <form action="{{ route('admin.halls.destroy', $hall->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Delete?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center py-4 text-muted">No halls found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection