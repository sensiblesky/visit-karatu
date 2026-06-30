@extends('layouts.dashboard')

@section('title', 'Dashboard')
@section('heading', 'Dashboard Overview')

@section('content')
{{-- Stat cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
    @foreach([
        ['label' => 'Profile Views', 'key' => 'profile_views', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>', 'tint' => 'bg-blue-50 text-blue-600'],
        ['label' => 'Search Views', 'key' => 'search_views', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>', 'tint' => 'bg-purple-50 text-purple-600'],
        ['label' => 'Bookings', 'key' => 'bookings', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>', 'tint' => 'bg-forest-50 text-forest-600'],
        ['label' => 'Enquiries', 'key' => 'enquiries', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>', 'tint' => 'bg-amber-50 text-amber-600'],
    ] as $card)
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-11 h-11 rounded-xl {{ $card['tint'] }} flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $card['icon'] !!}</svg>
                </div>
                <span class="inline-flex items-center gap-1 text-xs font-semibold {{ str_starts_with($stats[$card['key']]['delta'], '+') ? 'text-forest-600' : 'text-red-500' }}">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{ str_starts_with($stats[$card['key']]['delta'], '+') ? 'M5 10l7-7m0 0l7 7m-7-7v18' : 'M19 14l-7 7m0 0l-7-7m7 7V3' }}"/></svg>
                    {{ ltrim($stats[$card['key']]['delta'], '+') }}
                </span>
            </div>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($stats[$card['key']]['value']) }}</p>
            <p class="text-sm text-gray-500 mt-1">{{ $card['label'] }} <span class="text-gray-300">· vs last 30d</span></p>
        </div>
    @endforeach
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-8">
    {{-- Bookings line chart --}}
    <div class="xl:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-900">Bookings Overview</h2>
            <span class="text-xs text-gray-400 bg-gray-100 px-3 py-1 rounded-full">Last 30 Days</span>
        </div>
        <canvas id="bookingsChart" height="100"></canvas>
    </div>

    {{-- Donut chart --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-bold text-gray-900 mb-6">Listing Performance</h2>
        <canvas id="sourceChart" height="200"></canvas>
        <div class="mt-4 space-y-2">
            @php
                $sourceLabels = ['direct' => 'Direct', 'organic_search' => 'Organic Search', 'referral' => 'Referral', 'other' => 'Other'];
                $sourceColors = ['direct' => '#1B4D3E', 'organic_search' => '#16A34A', 'referral' => '#4ADE80', 'other' => '#BBF7D0'];
                $total = $sourceCounts->sum();
            @endphp
            @foreach($sourceLabels as $key => $label)
                @php $count = $sourceCounts[$key] ?? 0; $pct = $total > 0 ? round(($count / $total) * 100) : 0; @endphp
                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full" style="background: {{ $sourceColors[$key] }}"></div>
                        <span class="text-gray-600">{{ $label }}</span>
                    </div>
                    <span class="font-semibold text-gray-900">{{ $pct }}%</span>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Recent bookings table --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h2 class="text-lg font-bold text-gray-900">Recent Bookings</h2>
        <a href="{{ route('dashboard.bookings') }}" class="text-sm text-forest-700 hover:underline font-medium">View All →</a>
    </div>
    @if($recentBookings->isEmpty())
        <div class="px-6 py-12 text-center text-gray-400">No bookings yet.</div>
    @else
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
                    @foreach($recentBookings as $booking)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $booking->guest_name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $booking->listing->name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $booking->booking_date->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $booking->adults }}A {{ $booking->children ? '/ ' . $booking->children . 'C' : '' }}</td>
                            <td class="px-6 py-4 font-semibold text-gray-900">${{ number_format($booking->amount, 2) }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded-full text-xs font-bold
                                    {{ $booking->status === 'confirmed' ? 'bg-forest-100 text-forest-700' : ($booking->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
// Bookings line chart
const bookingsCtx = document.getElementById('bookingsChart').getContext('2d');
new Chart(bookingsCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode(array_map(fn($d) => \Carbon\Carbon::parse($d)->format('M j'), array_keys($chartData))) !!},
        datasets: [{
            label: 'Bookings',
            data: {!! json_encode(array_values($chartData)) !!},
            borderColor: '#1B4D3E',
            backgroundColor: 'rgba(27, 77, 62, 0.1)',
            tension: 0.4,
            fill: true,
            pointRadius: 3,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            x: { ticks: { maxTicksLimit: 8, font: { size: 11 } }, grid: { display: false } },
            y: { beginAtZero: true, ticks: { stepSize: 1 } }
        }
    }
});

// Source donut chart
const sourceCtx = document.getElementById('sourceChart').getContext('2d');
new Chart(sourceCtx, {
    type: 'doughnut',
    data: {
        labels: ['Direct', 'Organic Search', 'Referral', 'Other'],
        datasets: [{
            data: [
                {{ $sourceCounts['direct'] ?? 0 }},
                {{ $sourceCounts['organic_search'] ?? 0 }},
                {{ $sourceCounts['referral'] ?? 0 }},
                {{ $sourceCounts['other'] ?? 0 }}
            ],
            backgroundColor: ['#1B4D3E', '#16A34A', '#4ADE80', '#BBF7D0'],
            borderWidth: 0,
        }]
    },
    options: {
        cutout: '65%',
        plugins: { legend: { display: false } },
        responsive: true,
    }
});
</script>
@endpush
