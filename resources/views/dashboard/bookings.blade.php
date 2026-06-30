@extends('layouts.dashboard')

@section('title', 'Bookings')
@section('heading', 'Bookings')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 text-left">Guest</th>
                    <th class="px-6 py-3 text-left">Listing</th>
                    <th class="px-6 py-3 text-left">Date</th>
                    <th class="px-6 py-3 text-left">Guests</th>
                    <th class="px-6 py-3 text-left">Amount</th>
                    <th class="px-6 py-3 text-left">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($bookings as $booking)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $booking->guest_name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $booking->listing->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $booking->booking_date->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $booking->adults }} adults{{ $booking->children ? ' / ' . $booking->children . ' children' : '' }}</td>
                        <td class="px-6 py-4 font-semibold">${{ number_format($booking->amount, 2) }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-bold
                                {{ $booking->status === 'confirmed' ? 'bg-forest-100 text-forest-700' : ($booking->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-12 text-center text-gray-400">No bookings yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $bookings->links() }}
    </div>
</div>
@endsection
