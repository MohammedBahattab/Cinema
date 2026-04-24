@extends('layouts.admin')

@section('content')
<div class="row mt-4">
    <div class="col-md-6 mb-4">
        <h3>Crew Roles</h3>
        <form action="{{ route('admin.crew.storeRole') }}" method="POST" class="mb-3">
            @csrf
            <div class="input-group">
                <input type="text" name="name" class="form-control" placeholder="e.g. director, actor, producer" required>
                <button type="submit" class="btn btn-success">Add Role</button>
            </div>
            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
        </form>

        <div class="bg-white rounded p-3 text-dark">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Role Name</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="2" class="text-center">No roles yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <h3>Crew Members</h3>
        <form action="{{ route('admin.crew.storeCrew') }}" method="POST" class="mb-3">
            @csrf
            <div class="input-group">
                <input type="text" name="name" class="form-control" placeholder="e.g. Christopher Nolan" required>
                <button type="submit" class="btn btn-primary">Add Member</button>
            </div>
        </form>

        <div class="bg-white rounded p-3 text-dark">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($crews as $crew)
                    <tr>
                        <td>{{ $crew->id }}</td>
                        <td>{{ $crew->name }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="2" class="text-center">No crew members yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
