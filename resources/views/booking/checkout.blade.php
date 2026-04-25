@extends('layouts.app')

@section('content')
<div class="row justify-content-center animate-in">
    <div class="col-lg-8">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold">Secure Checkout</h2>
            <p class="text-secondary">Complete your details to confirm the reservation.</p>
        </div>

        <div class="glass-card p-0 overflow-hidden mb-5">
            <div class="row g-0">
                <div class="col-md-5 bg-dark p-4 border-end border-secondary d-flex flex-column justify-content-between">
                    <div>
                        <h4 class="text-white fw-bold mb-4">Order Details</h4>
                        <div class="mb-3">
                            <small class="text-secondary d-block">Movie</small>
                            <span class="fs-5">{{ $showtime->movie->title }}</span>
                        </div>
                        <div class="mb-3">
                            <small class="text-secondary d-block">Date & Time</small>
                            <span>{{ \Carbon\Carbon::parse($showtime->show_date)->format('D, d M') }} at {{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }}</span>
                        </div>
                        <div class="mb-3">
                            <small class="text-secondary d-block">Hall & Seats</small>
                            <span>{{ $showtime->hall->name }} ({{ count($seats) }} Tickets)</span>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-top border-secondary">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fs-5 text-secondary">Total Due</span>
                            <span class="fs-2 fw-bold text-warning">${{ number_format($totalPrice, 2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-7 p-4 p-md-5">
                    <h4 class="fw-bold mb-4">Guest Information</h4>
                    
                    @guest
                    <div class="alert alert-cinema border-primary mb-4 p-3 d-flex gap-3 align-items-start">
                        <i class="fas fa-info-circle text-primary mt-1 fs-5"></i>
                        <div>
                            <p class="mb-1 fw-bold text-white">Checking out as Guest</p>
                            <small class="text-secondary">Want to keep track of your tickets? <a href="{{ route('login') }}" class="text-accent text-decoration-none fw-bold">Log in here</a>.</small>
                        </div>
                    </div>
                    @endguest

                    <form action="{{ route('booking.store', $showtime->id) }}" method="POST">
                        @csrf
                        @foreach($seats as $seat)
                            <input type="hidden" name="seats[]" value="{{ $seat }}">
                        @endforeach

                        @guest
                        <div class="mb-4">
                            <label class="form-label text-secondary">Full Name *</label>
                            <input type="text" name="full_name" class="form-cinema w-100" placeholder="John Doe" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-secondary">Phone Number *</label>
                            <input type="tel" name="phone_number" class="form-cinema w-100" placeholder="+1 234 567 8900" required>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <label class="form-label text-secondary">Email Address <small>(Optional)</small></label>
                                <input type="email" name="email" class="form-cinema w-100" placeholder="john@example.com">
                            </div>
                            <div class="col-md-4 mt-3 mt-md-0">
                                <label class="form-label text-secondary">Age <small>(Optional)</small></label>
                                <input type="number" name="age" class="form-cinema w-100" placeholder="18">
                            </div>
                        </div>
                        @else
                        <div class="text-center py-4">
                            <div class="bg-dark rounded-circle d-inline-flex align-items-center justify-content-center mb-3 border border-secondary" style="width:80px;height:80px;">
                                <i class="fas fa-user-check fa-2x text-success"></i>
                            </div>
                            <h5>Logged in as <span class="text-warning">{{ auth()->user()->name }}</span></h5>
                            <p class="text-secondary">Your tickets will be saved to your account securely.</p>
                        </div>
                        @endguest

                        <button type="submit" class="btn-accent w-100 py-3 mt-2 fs-5 rounded-pill shadow-lg">
                            Pay & Confirm Booking
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
