@extends('layouts.admin')

@section('content')
<div class="row mt-4 justify-content-center">
    <div class="col-md-6">
        <div class="card p-4 text-dark">
            <h3 class="mb-4">Add New Studio</h3>
            @if($errors->any())
                <div class="alert alert-danger bg-danger text-white border-0">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('admin.studios.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Studio Name *</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Country</label>
                    <input type="text" name="country" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Founded Year</label>
                    <input type="number" name="founded_year" class="form-control" min="1800" max="2099">
                </div>
                <button type="submit" class="btn btn-success w-100">Save Studio</button>
            </form>
        </div>
    </div>
</div>
@endsection
