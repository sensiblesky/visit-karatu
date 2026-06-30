@extends('layouts.dashboard')

@section('title', 'Messages')
@section('heading', 'Enquiries & Messages')

@section('content')
<div class="space-y-4">
    @forelse($enquiries as $enquiry)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <span class="font-semibold text-gray-900">{{ $enquiry->name }}</span>
                    @if($enquiry->email)
                        <span class="text-gray-400 text-sm ml-2">{{ $enquiry->email }}</span>
                    @endif
                    <span class="text-gray-400 text-sm ml-2">re: {{ $enquiry->listing->name }}</span>
                </div>
                <span class="px-2 py-1 rounded-full text-xs font-bold
                    {{ $enquiry->status === 'responded' ? 'bg-forest-100 text-forest-700' : ($enquiry->status === 'closed' ? 'bg-gray-100 text-gray-600' : 'bg-blue-100 text-blue-700') }}">
                    {{ ucfirst($enquiry->status) }}
                </span>
            </div>
            <p class="text-sm text-gray-700">{{ $enquiry->message }}</p>
            <div class="mt-3 flex items-center gap-4 text-xs text-gray-400">
                <span>{{ $enquiry->created_at->format('d M Y H:i') }}</span>
                @if($enquiry->phone)
                    <a href="tel:{{ $enquiry->phone }}" class="inline-flex items-center gap-1.5 text-forest-700 hover:underline">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        {{ $enquiry->phone }}
                    </a>
                @endif
            </div>
        </div>
    @empty
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center text-gray-400">
            No messages yet.
        </div>
    @endforelse
    {{ $enquiries->links() }}
</div>
@endsection
