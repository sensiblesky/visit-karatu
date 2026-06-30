@extends('layouts.dashboard')

@section('title', 'Analytics')
@section('heading', 'Analytics')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center">
    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-5">
        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
    </div>
    <p class="text-lg font-semibold text-gray-700">Advanced analytics coming soon</p>
    <p class="text-sm text-gray-400 mt-1 mb-6">For now, view your bookings and profile views on the Dashboard overview.</p>
    <a href="{{ route('dashboard.index') }}" class="inline-flex items-center gap-2 bg-forest-700 text-white px-6 py-3 rounded-xl font-semibold hover:bg-forest-800 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/></svg>
        Back to Dashboard
    </a>
</div>
@endsection
