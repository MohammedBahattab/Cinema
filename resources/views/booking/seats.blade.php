@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/seats.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row mb-5 animate-in">
    <div class="col-12 text-center">
        <h2 class="display-5 fw-bold mb-2">{{ $showtime->movie->title }}</h2>
        <p class="text-secondary fs-5">
            <i class="far fa-calendar-alt me-2"></i>{{ \Carbon\Carbon::parse($showtime->show_date)->format('D, d M Y') }} 
            <span class="mx-3">•</span>
            <i class="far fa-clock me-2"></i>{{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }}
            <span class="mx-3">•</span>
            <i class="fas fa-map-marker-alt me-2"></i>{{ $showtime->hall->name }}
        </p>
    </div>
</div>

<div class="row g-5">
    <div class="col-lg-8 animate-in delay-1">
        <div class="seat-map-container">
            <div class="screen-bar"></div>
            <div class="screen-label">CINEMA SCREEN</div>
            
            <form action="{{ route('booking.checkout', $showtime->id) }}" method="POST" id="seatForm" class="mt-5 text-center">
                @csrf
                <div class="seats-container seats-scroll">
                    @php $rows = $showtime->hall->seats->groupBy('row_number'); @endphp

                    @foreach($rows as $rowNumber => $seats)
                        <div class="d-flex justify-content-center align-items-center mb-2">
                            <span class="text-secondary fw-bold me-4 seat-row-label">{{ $rowNumber }}</span>
                            @foreach($seats as $seat)
                                @php $isBooked = in_array($seat->id, $bookedSeats); @endphp
                               <div class="seat-btn {{ $isBooked ? 'booked' : 'available' }}" 
                               data-seat-id="{{ $seat->id }}"
                               data-seat-num="{{ $rowNumber.$seat->seat_number }}"
                               @if(!$isBooked) onclick="toggleSeat(this)" @endif>
                               <i class="fas fa-couch seat-icon"></i>
                               <span class="seat-num">{{ $seat->seat_number }}</span>
                            </div>
                            @endforeach
                            <span class="text-secondary fw-bold ms-4 seat-row-label">{{ $rowNumber }}</span>
                        </div>
                    @endforeach
                </div>
                <div id="selectedSeatsInputs"></div>
            </form>
        </div>

       <div class="d-flex justify-content-center gap-4 mt-4">
    <div class="d-flex align-items-center gap-2"><i class="fas fa-couch available"></i><span class="text-secondary">Available</span></div>
    <div class="d-flex align-items-center gap-2"><i class="fas fa-couch booked"></i><span class="text-secondary">Booked</span></div>
    <div class="d-flex align-items-center gap-2"><i class="fas fa-couch selected"></i><span class="text-secondary">Selected</span></div>
    </div>
    </div>

    <div class="col-lg-4 animate-in delay-2">
        <div class="booking-summary p-4">
            <h4 class="fw-bold mb-4 border-bottom border-secondary pb-3">Booking Summary</h4>
            
            <div class="d-flex justify-content-between mb-3">
                <span class="text-secondary">Ticket Price</span>
                <span class="fw-bold">${{ number_format($showtime->price, 2) }}</span>
            </div>
            
            <div class="d-flex justify-content-between mb-4">
                <span class="text-secondary">Selected Seats</span>
                <span class="fw-bold text-warning" id="seatCount">0</span>
            </div>

            <div class="p-3 bg-dark rounded mb-4">
                <div class="text-secondary mb-1 selected-label-container">Selected:</div>
                <div id="seatLabels" class="fw-bold text-white selected-seats-box">None</div>
            </div>

            <div class="d-flex justify-content-between mb-4 border-top border-secondary pt-3">
                <span class="fs-5">Total Amount</span>
                <span class="fs-4 fw-bold text-success" id="totalPrice">$0.00</span>
            </div>

            <button type="button" class="btn-accent w-100 py-3 fs-5 rounded-pill" id="checkoutBtn" disabled onclick="document.getElementById('seatForm').submit();">
                Proceed to Checkout <i class="fas fa-lock ms-2"></i>
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const ticketPrice = {{ $showtime->price }};
    
    function toggleSeat(element) {
        element.classList.toggle('selected');
        element.classList.toggle('available');
        updateForm();
    }

    function updateForm() {
        const selectedSeats = document.querySelectorAll('.seats-container .seat-btn.selected');
        const container = document.getElementById('selectedSeatsInputs');
        const btn = document.getElementById('checkoutBtn');
        const countEl = document.getElementById('seatCount');
        const priceEl = document.getElementById('totalPrice');
        const labelsEl = document.getElementById('seatLabels');
        
        container.innerHTML = '';
        let labels = [];
        
        if (selectedSeats.length > 0) {
            btn.disabled = false;
            selectedSeats.forEach(seat => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'seats[]';
                input.value = seat.dataset.seatId;
                container.appendChild(input);
                labels.push(seat.dataset.seatNum);
            });
            countEl.textContent = selectedSeats.length;
            priceEl.textContent = '$' + (selectedSeats.length * ticketPrice).toFixed(2);
            labelsEl.textContent = labels.join(', ');
        } else {
            btn.disabled = true;
            countEl.textContent = '0';
            priceEl.textContent = '$0.00';
            labelsEl.textContent = 'None';
        }
    }
</script>
@endpush
@endsection