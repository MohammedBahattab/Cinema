@extends('layouts.admin')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h2 class="fw-bold mb-0">Bookings Management</h2>
        <p class="text-secondary mb-0">View and manage all customer bookings.</p>
    </div>
</div>

<div class="card border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-dark table-hover mb-0 align-middle">
                <thead class="bg-dark bg-opacity-50 border-bottom border-secondary">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Customer</th>
                        <th>Movie & Show</th>
                        <th>Seats</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr>
                        <td class="ps-4 fw-bold">#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div>
                                    <div class="text-white">{{ $booking->user ? $booking->user->name : $booking->guestUser->full_name }}</div>
                                    <small class="text-secondary">{{ $booking->user ? $booking->user->email : $booking->guestUser->phone_number }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold text-white">{{ $booking->showtime->movie->title ?? 'Deleted Movie' }}</div>
                            <small class="text-secondary">
                                {{ \Carbon\Carbon::parse($booking->showtime->show_date)->format('d M') }} at {{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('H:i') }}
                            </small>
                        </td>
                        <td>
                            @foreach($booking->seats as $seat)
                                <span class="badge bg-secondary bg-opacity-30 text-white rounded-pill px-2">{{ $seat->row_number }}{{ $seat->seat_number }}</span>
                            @endforeach
                        </td>
                        <td>
                            <div class="fw-bold text-success">${{ number_format($booking->payments->sum('amount'), 2) }}</div>
                        </td>
                        <td>
                        @if($booking->status == 'confirmed')
                          <span class="badge bg-success text-white border border-success rounded-pill px-3 py-2">Confirmed</span>
                         @elseif($booking->status == 'pending')
                          <span class="badge bg-warning text-white border border-warning rounded-pill px-3 py-2">Pending</span>
                         @else
                          <span class="badge bg-danger text-white border border-danger rounded-pill px-3 py-2">{{ ucfirst($booking->status) }}</span>
                         @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-sm btn-outline-info rounded-pill px-3">Details</a>
                                <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this booking?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">Cancel</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-secondary">
                            <i class="fas fa-ticket-alt fa-3x mb-3 opacity-50"></i>
                            <h5>No bookings found.</h5>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    {{ $bookings->links() }}
</div>
@endsection
