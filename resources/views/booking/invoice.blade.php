@extends('layouts.app')

@push('styles')
<style>
    .invoice-container {
        background: radial-gradient(circle at top right, var(--bg-secondary), var(--bg-primary));
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 30px 60px rgba(0,0,0,0.6);
    }
    .invoice-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: var(--gradient-1);
    }
    .watermark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-30deg);
        font-size: 10rem;
        font-weight: 800;
        color: rgba(255,255,255,0.02);
        pointer-events: none;
        z-index: 0;
        white-space: nowrap;
    }
    .invoice-header {
        border-bottom: 1px dashed rgba(255,255,255,0.1);
        padding-bottom: 2rem;
        margin-bottom: 2rem;
    }
    .invoice-content { position: relative; z-index: 1; }
    .detail-box {
        background: rgba(0,0,0,0.3);
        border-radius: 12px;
        padding: 1.5rem;
        height: 100%;
        border: 1px solid var(--glass-border);
    }
    
    @media print {
        body * { visibility: hidden; background: white !important; color: black !important; }
        .invoice-container, .invoice-container * { visibility: visible; }
        .invoice-container { 
            position: absolute; left: 0; top: 0; width: 100%; 
            border: none; box-shadow: none; background: white !important;
        }
        .invoice-container::before { display: none; }
        .btn-print, .navbar-cinema, .footer-cinema { display: none !important; }
        .text-warning { color: #000 !important; }
        .badge { border: 1px solid #000; color: #000 !important; }
        .detail-box { background: transparent !important; border: 1px solid #ddd; }
    }
</style>
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
                        <span class="badge bg-success bg-opacity-20 text-success border border-success px-3 py-2 rounded-pill">
                            <i class="fas fa-check-circle me-1"></i> {{ strtoupper($booking->status) }}
                        </span>
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
                            <tr class="border-bottom border-secondary" style="border-bottom-style: dashed !important;">
                                <td class="py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-dark rounded p-2 text-center" style="width:40px;">
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
                    <div class="text-end" style="width: 300px;">
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
