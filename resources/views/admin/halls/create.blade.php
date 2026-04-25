@extends('layouts.admin')

@section('content')
<div class="row mt-4 justify-content-center">
    <div class="col-md-6">
        <div class="card p-4 text-dark">
            <h3 class="mb-4">Create Hall (Auto-generates seats)</h3>
            
            @if($errors->any())
                <div class="alert alert-danger bg-danger text-white border-0">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.halls.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Hall Name *</label>
                    <input type="text" name="name" class="form-control" required placeholder="e.g. Hall A, VIP Lounge">
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Total Rows *</label>
                        <input type="number" name="total_rows" class="form-control" required min="1">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Seats per Row *</label>
                        <input type="number" name="seats_per_row" class="form-control" required min="1">
                    </div>
                </div>

                <div class="alert alert-info">
                    <small><i class="fas fa-info-circle"></i> Saving this will automatically create all seat records in the database based on rows and seats per row.</small>
                </div>

                <button type="submit" class="btn btn-success w-100 mt-2">Create Hall & Generate Seats</button>
            </form>
        </div>
    </div>
</div>
@endsection
