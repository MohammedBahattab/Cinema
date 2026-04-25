@extends('layouts.admin')

@section('content')
<div class="row mt-4">
    <div class="col-md-6">
        <h2>Manage Categories</h2>
        
        <form action="{{ route('admin.categories.store') }}" method="POST" class="mb-4">
            @csrf
            <div class="input-group">
                <input type="text" name="name" class="form-control" placeholder="New category name" required>
                <button type="submit" class="btn btn-success">Add Category</button>
            </div>
            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
        </form>

        <div class="table-responsive bg-white rounded p-3 text-dark">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">No categories found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
