@extends('layouts.admin')

@section('content')
<div class="row mt-4">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Manage Studios</h2>
            <a href="{{ route('admin.studios.create') }}" class="btn btn-primary">Add New Studio</a>
        </div>
        
        <div class="table-responsive bg-white rounded p-3 text-dark">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Country</th>
                        <th>Founded</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($studios as $studio)
                    <tr>
                        <td>{{ $studio->id }}</td>
                        <td>{{ $studio->name }}</td>
                        <td>{{ $studio->country ?? 'N/A' }}</td>
                        <td>{{ $studio->founded_year ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('admin.studios.edit', $studio->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.studios.destroy', $studio->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No studios found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
