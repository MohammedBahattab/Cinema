@extends('layouts.admin')

@section('content')
<div class="row mt-4">
    <div class="col-md-6">
        <h3 class="mb-3 text-primary fw-bold">Manage Categories</h3>
        
        <form action="{{ route('admin.categories.store') }}" method="POST" class="mb-4">
            @csrf
            <div class="input-group shadow-sm">
                <input type="text" name="name" class="form-control" placeholder="New category name" required>
                <button type="submit" class="btn btn-primary">Add Category</button>
            </div>
            @error('name')<span class="text-danger small">{{ $message }}</span>@enderror
        </form>

        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td class="fw-bold">{{ $category->name }}</td>
                            <td class="text-center">
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Delete?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center py-3 text-muted">No categories found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection