@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/invoice.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row justify-content-center animate-in">
    <div class="col-lg-9">
        
        <div class="text-center mb-4">
            <div class="d-inline-block p-3 rounded-circle bg-success bg-opacity-10 mb-3">
                <i class="fas fa-check-circle fa-3x text-success"></i>
            </div>
            <h2 class="fw-bold">Booking Confirmed!</h2>
            <p class="text-secondary">Thank you for choosing MDAR Cinema. Your tickets are ready.</p>
        </div>

        <div class="invoice-container p-4 p-md-5 mb-5">
            <div class="watermark">PAID</div>
            
            <div class="invoice-content">
                <div class="invoice-header d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div>
                        <h3 class="fw-bold mb-0">MDAR <span class="text-accent">Cinema</span></h3>
                        <small class="text-secondary">Premium Movie Experience</small>
                    </div>
                    <div class="text-end">
                        <div class="fs-5 fw-bold text-white mb-1">Booking #{{ str_pad($booking->id, 8, '0', STR_PAD_LEFT) }}</div>
                         <div class="mt-2">
                            @if($booking->status == 'confirmed')
                             <span class="badge bg-success text-white border border-success rounded-pill px-3 py-2">Confirmed</span>
                            @elseif($booking->status == 'pending')
                             <span class="badge bg-warning text-white border border-warning rounded-pill px-3 py-2">Pending</span>
                            @else
                             <span class="badge bg-danger text-white border border-danger rounded-pill px-3 py-2">{{ ucfirst($booking->status) }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-md-6">
                        <div class="detail-box">
                            <h6 class="text-secondary text-uppercase tracking-wider mb-3"><i class="fas fa-user text-accent me-2"></i>Customer Info</h6>
                            @if($booking->user)
                                <div class="fw-bold fs-5 mb-1">{{ $booking->user->name }}</div>
                                <div class="text-secondary mb-1"><i class="far fa-envelope me-2"></i>{{ $booking->user->email }}</div>
                                <div class="text-secondary"><i class="fas fa-phone me-2"></i>{{ $booking->user->phone_number ?? 'N/A' }}</div>
                            @else
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <div class="fw-bold fs-5">{{ $booking->guestUser->full_name }}</div>
                                    <span class="badge bg-secondary">Guest</span>
                                </div>
                                <div class="text-secondary mb-1"><i class="far fa-envelope me-2"></i>{{ $booking->guestUser->email ?? 'N/A' }}</div>
                                <div class="text-secondary"><i class="fas fa-phone me-2"></i>{{ $booking->guestUser->phone_number }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-box">
                            <h6 class="text-secondary text-uppercase tracking-wider mb-3"><i class="fas fa-film text-accent me-2"></i>Show Details</h6>
                            <div class="fw-bold fs-5 mb-1 text-warning">{{ $booking->showtime->movie->title }}</div>
                            <div class="text-white mb-1"><i class="far fa-calendar me-2 text-secondary"></i>{{ \Carbon\Carbon::parse($booking->showtime->show_date)->format('l, d F Y') }}</div>
                            <div class="text-white mb-1"><i class="far fa-clock me-2 text-secondary"></i>{{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('H:i A') }}</div>
                            <div class="text-white"><i class="fas fa-door-open me-2 text-secondary"></i>{{ $booking->showtime->hall->name }}</div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive mb-4">
                    <table class="table table-dark table-borderless align-middle mb-0">
                        <thead class="border-bottom border-secondary">
                            <tr>
                                <th class="text-secondary pb-3">Ticket / Seat</th>
                                <th class="text-secondary pb-3 text-center">Row</th>
                                <th class="text-secondary pb-3 text-end">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($booking->seats as $seat)
                            <tr class="border-bottom border-secondary invoice-row-dashed">
                                <td class="py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-dark rounded p-2 text-center w-40px">
                                            <i class="fas fa-chair text-secondary"></i>
                                        </div>
                                        <span class="fw-bold">Seat {{ $seat->seat_number }}</span>
                                    </div>
                                </td>
                                <td class="py-3 text-center text-white">{{ $seat->row_number }}</td>
                                <td class="py-3 text-end fw-bold">${{ number_format($seat->pivot->price, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @php $total = $booking->payments->sum('amount'); @endphp
                <div class="d-flex justify-content-end mt-4 pt-3 border-top border-secondary">
                    <div class="text-end invoice-total-box">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-secondary">Subtotal</span>
                            <span class="text-white">${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-secondary">Fees & Taxes</span>
                            <span class="text-white">$0.00</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center border-top border-secondary pt-3 mt-3">
                            <span class="fs-5 text-white">Total Paid</span>
                            <span class="fs-3 fw-bold text-accent">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center gap-3 btn-print">
            <button onclick="window.print()" class="btn btn-outline-light rounded-pill px-4 py-2">
                <i class="fas fa-print me-2"></i> Print Ticket
            </button>
            <a href="{{ route('home') }}" class="btn-accent text-decoration-none rounded-pill px-4 py-2">
                Return to Home <i class="fas fa-home ms-2"></i>
            </a>
        </div>
    </div>
</div>
@endsection