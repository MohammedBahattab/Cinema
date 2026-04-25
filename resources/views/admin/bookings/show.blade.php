@extends('layouts.admin')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-outline-secondary mb-2">
            <i class="fas fa-arrow-left me-1"></i> Back to Bookings
        </a>
        <h2 class="fw-bold mb-0">Booking Details #{{ str_pad($booking->id, 8, '0', STR_PAD_LEFT) }}</h2>
    </div>
    <div>
        <span class="badge bg-success bg-opacity-20 text-success border border-success px-4 py-2 rounded-pill fs-6">
            {{ strtoupper($booking->status) }}
        </span>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 mb-4">
            <div class="card-header bg-transparent border-bottom border-secondary py-3">
                <h5 class="mb-0 text-white"><i class="fas fa-info-circle text-accent me-2"></i>General Information</h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="text-secondary small text-uppercase fw-bold mb-1">Customer</label>
                        <div class="text-white fs-5">{{ $booking->user ? $booking->user->name : $booking->guestUser->full_name }}</div>
                        <div class="text-secondary">{{ $booking->user ? $booking->user->email : $booking->guestUser->phone_number }}</div>
                        <small class="badge bg-secondary mt-2">{{ $booking->user ? 'Registered' : 'Guest' }}</small>
                    </div>
                    <div class="col-md-6">
                        <label class="text-secondary small text-uppercase fw-bold mb-1">Booking Date</label>
                        <div class="text-white fs-5">{{ $booking->created_at->format('d M Y, H:i') }}</div>
                        <div class="text-secondary">{{ $booking->created_at->diffForHumans() }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-secondary small text-uppercase fw-bold mb-1">Movie</label>
                        <div class="text-white fs-5 fw-bold">{{ $booking->showtime->movie->title }}</div>
                        <div class="text-secondary">{{ $booking->showtime->movie->duration_minutes }} mins | {{ $booking->showtime->movie->language }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-secondary small text-uppercase fw-bold mb-1">Showtime & Venue</label>
                        <div class="text-white fs-5">{{ \Carbon\Carbon::parse($booking->showtime->show_date)->format('l, d F Y') }}</div>
                        <div class="text-warning fw-bold">{{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->showtime->end_time)->format('H:i') }}</div>
                        <div class="text-secondary">{{ $booking->showtime->hall->name }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0">
            <div class="card-header bg-transparent border-bottom border-secondary py-3">
                <h5 class="mb-0 text-white"><i class="fas fa-chair text-accent me-2"></i>Selected Seats</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-dark table-borderless">
                        <thead>
                            <tr class="border-bottom border-secondary">
                                <th>Seat</th>
                                <th>Row</th>
                                <th class="text-end">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($booking->seats as $seat)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-dark rounded p-2"><i class="fas fa-chair text-secondary"></i></div>
                                        <span class="fw-bold">Seat {{ $seat->seat_number }}</span>
                                    </div>
                                </td>
                                <td>{{ $seat->row_number }}</td>
                                <td class="text-end fw-bold text-success">${{ number_format($seat->pivot->price, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 mb-4 bg-accent bg-opacity-10 border border-accent border-opacity-20">
            <div class="card-body">
                <h5 class="fw-bold text-white mb-4">Payment Summary</h5>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-secondary">Subtotal</span>
                    <span class="text-white">${{ number_format($booking->payments->sum('amount'), 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-secondary">Tax & Fees</span>
                    <span class="text-white">$0.00</span>
                </div>
                <hr class="border-secondary">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-white fw-bold">Total Paid</span>
                    <span class="fs-3 fw-bold text-accent">${{ number_format($booking->payments->sum('amount'), 2) }}</span>
                </div>
                <div class="mt-4">
                    @foreach($booking->payments as $payment)
                        <div class="p-3 bg-dark bg-opacity-50 rounded border border-secondary mb-2">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-secondary small">Method: {{ ucfirst($payment->payment_method) }}</span>
                                <span class="text-success small fw-bold">Success</span>
                            </div>
                            <div class="text-white small">Date: {{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('d M Y, H:i') : 'N/A' }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card border-0">
            <div class="card-body">
                <button onclick="window.print()" class="btn btn-outline-light w-100 mb-2 rounded-pill">
                    <i class="fas fa-print me-2"></i> Print Booking
                </button>
                <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this booking?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100 rounded-pill">
                        <i class="fas fa-trash-alt me-2"></i> Cancel Booking
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
