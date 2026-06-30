@extends('layouts.admin')

@section('title', 'Reviews')
@section('heading', 'Review Moderation')

@section('content')
{{-- Status filter tabs --}}
<div class="flex flex-wrap gap-2 mb-6">
    @foreach(['' => 'All', 'pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'] as $key => $label)
        <a href="{{ route('admin.reviews.index', array_filter(['status' => $key])) }}"
           class="px-4 py-2 rounded-xl text-sm font-medium transition {{ ($status ?? '') === $key ? 'bg-gray-900 text-white' : 'bg-white border border-gray-200 text-gray-600 hover:border-gray-300' }}">
            {{ $label }}
            <span class="ml-1 {{ ($status ?? '') === $key ? 'text-gray-300' : 'text-gray-400' }}">{{ $counts[$key ?: 'all'] }}</span>
        </a>
    @endforeach
</div>

@if($reviews->isEmpty())
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center text-gray-400">
        No reviews found for this filter.
    </div>
@else
    <div class="space-y-4">
        @foreach($reviews as $review)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <div class="flex items-start justify-between gap-6">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-3 mb-2 flex-wrap">
                            <span class="font-semibold text-gray-900">{{ $review->user->name }}</span>
                            <div class="flex">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                            <span class="px-2 py-0.5 rounded-full text-xs font-bold
                                {{ $review->status === 'approved' ? 'bg-forest-100 text-forest-700' : ($review->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                {{ ucfirst($review->status) }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-400 mb-2">
                            on <a href="{{ route('listings.show', $review->listing->slug) }}" target="_blank" class="text-forest-700 hover:underline">{{ $review->listing->name }}</a>
                            · {{ $review->created_at->format('d M Y') }}
                        </p>
                        @if($review->comment)
                            <p class="text-sm text-gray-600">{{ $review->comment }}</p>
                        @endif
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        @if($review->status !== 'approved')
                            <form method="POST" action="{{ route('admin.reviews.approve', $review) }}">
                                @csrf
                                <button class="inline-flex items-center gap-1.5 bg-forest-700 text-white text-xs font-bold px-3 py-2 rounded-lg hover:bg-forest-800 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    Approve
                                </button>
                            </form>
                        @endif
                        @if($review->status !== 'rejected')
                            <form method="POST" action="{{ route('admin.reviews.reject', $review) }}">
                                @csrf
                                <button class="inline-flex items-center gap-1.5 bg-yellow-100 text-yellow-800 text-xs font-bold px-3 py-2 rounded-lg hover:bg-yellow-200 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                    Reject
                                </button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" onsubmit="return confirm('Permanently delete this review?')">
                            @csrf @method('DELETE')
                            <button class="inline-flex items-center gap-1.5 bg-red-100 text-red-700 text-xs font-bold px-3 py-2 rounded-lg hover:bg-red-200 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-6">{{ $reviews->links() }}</div>
@endif
@endsection
