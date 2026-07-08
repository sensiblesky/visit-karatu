{{-- Reviews tab --}}
@php
    $reviews = $listing->approvedReviews;
    $avg = $listing->approved_reviews_avg_rating;
    $count = $listing->approved_reviews_count;
@endphp

{{-- Summary --}}
@if($count > 0)
    <div class="flex items-center gap-5 mb-6 pb-6 border-b border-gray-100">
        <div class="text-center shrink-0">
            <div class="text-4xl font-extrabold text-forest-700">{{ number_format($avg, 1) }}</div>
            <div class="flex justify-center my-1">
                @for($i = 1; $i <= 5; $i++)
                    <svg class="w-4 h-4 {{ $i <= round($avg) ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                @endfor
            </div>
            <div class="text-xs text-gray-400">{{ $count }} review{{ $count === 1 ? '' : 's' }}</div>
        </div>
        <p class="text-sm text-gray-500">Real feedback from visitors who experienced {{ $listing->name }}.</p>
    </div>
@endif

{{-- Existing reviews --}}
@if($reviews->isEmpty())
    <div class="text-center py-8">
        <p class="text-gray-500 text-sm">No reviews yet. Be the first to leave a review!</p>
    </div>
@else
    <div class="space-y-4 mb-8">
        @foreach($reviews as $review)
            <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-forest-700 text-white text-sm font-bold flex items-center justify-center">
                            {{ strtoupper(substr($review->reviewer_name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ $review->reviewer_name }}</p>
                            <p class="text-xs text-gray-400">{{ $review->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                    <div class="flex gap-0.5">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                </div>
                @if($review->comment)
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $review->comment }}</p>
                @endif
            </div>
        @endforeach
    </div>
@endif

{{-- Write a review --}}
<div class="bg-forest-50/60 border border-forest-100 rounded-2xl p-6" x-data="{ rating: 0, hover: 0 }">
    <h4 class="font-bold text-gray-900 mb-1">Write a Review</h4>
    <p class="text-xs text-gray-500 mb-4">Share your experience. Reviews are checked before they appear.</p>

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl p-3 mb-4">
            <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('reviews.store', $listing) }}" class="space-y-3">
        @csrf
        {{-- Honeypot --}}
        <input type="text" name="website" tabindex="-1" autocomplete="off" class="hidden" aria-hidden="true">

        {{-- Star picker --}}
        <div>
            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1.5">Your rating</label>
            <input type="hidden" name="rating" :value="rating">
            <div class="flex gap-1">
                @for($i = 1; $i <= 5; $i++)
                    <button type="button" @click="rating = {{ $i }}" @mouseenter="hover = {{ $i }}" @mouseleave="hover = 0"
                            class="focus:outline-none">
                        <svg class="w-8 h-8 transition"
                             :class="(hover || rating) >= {{ $i }} ? 'text-amber-400' : 'text-gray-300'"
                             fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </button>
                @endfor
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <input type="text" name="author_name" value="{{ old('author_name') }}" placeholder="Your name *" required class="form-input">
            <input type="email" name="author_email" value="{{ old('author_email') }}" placeholder="Email (optional, not shown)" class="form-input">
        </div>
        <textarea name="comment" rows="3" placeholder="Tell others about your experience..." class="form-input resize-y">{{ old('comment') }}</textarea>

        <button type="submit" class="btn-primary" :disabled="rating === 0" :class="rating === 0 && 'opacity-50 cursor-not-allowed'">
            Submit Review
        </button>
    </form>
</div>
