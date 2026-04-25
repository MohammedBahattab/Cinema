@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card p-4 mt-5">
            <h3 class="mb-4">Register</h3>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Age</label>
                    <input type="number" name="age" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Phone Number</label>
                    <input type="text" name="phone_number" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Register</button>
            </form>
        </div>
    </div>
</div>
@endsection
