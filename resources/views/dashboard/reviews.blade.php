@extends('layouts.dashboard')

@section('title', 'Reviews')
@section('heading', 'Reviews')

@section('content')
<div class="space-y-4">
    @forelse($reviews as $review)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-start justify-between mb-2">
                <div>
                    <span class="font-semibold text-gray-900">{{ $review->reviewer_name }}</span>
                    <span class="text-gray-400 text-sm ml-2">on {{ $review->listing->name }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="flex">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <span class="px-2 py-1 rounded-full text-xs font-bold
                        {{ $review->status === 'approved' ? 'bg-forest-100 text-forest-700' : ($review->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                        {{ ucfirst($review->status) }}
                    </span>
                </div>
            </div>
            @if($review->comment)
                <p class="text-sm text-gray-600">{{ $review->comment }}</p>
            @endif
            <p class="text-xs text-gray-400 mt-2">{{ $review->created_at->format('d M Y') }}</p>
        </div>
    @empty
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center text-gray-400">
            No reviews yet.
        </div>
    @endforelse
    {{ $reviews->links() }}
</div>
@endsection
