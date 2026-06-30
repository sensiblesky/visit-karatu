@extends('layouts.admin')

@section('title', 'Moderation')
@section('heading', 'Moderation Queue')

@section('content')
<div>
    {{-- Pending Listings --}}
    <section class="mb-12">
        <h2 class="text-xl font-bold text-gray-900 mb-5 flex items-center gap-2.5">
            <svg class="w-5 h-5 text-forest-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
            Pending Listings
            @if($pendingListings->count() > 0)
                <span class="bg-yellow-100 text-yellow-700 text-sm font-bold px-2 py-0.5 rounded-full">{{ $pendingListings->count() }}</span>
            @endif
        </h2>

        @if($pendingListings->isEmpty())
            <div class="bg-forest-50 border border-forest-200 rounded-2xl p-6 text-forest-700 text-sm flex items-center gap-2.5">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                No listings awaiting approval.
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3 text-left">Listing</th>
                            <th class="px-6 py-3 text-left">Owner</th>
                            <th class="px-6 py-3 text-left">Category</th>
                            <th class="px-6 py-3 text-left">Submitted</th>
                            <th class="px-6 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($pendingListings as $listing)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-semibold text-gray-900">{{ $listing->name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $listing->user->name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $listing->category->name }}</td>
                                <td class="px-6 py-4 text-gray-400 text-xs">{{ $listing->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <form method="POST" action="{{ route('admin.listings.approve', $listing) }}">
                                            @csrf
                                            <button class="inline-flex items-center gap-1.5 bg-forest-700 text-white text-xs font-bold px-4 py-2 rounded-lg hover:bg-forest-800 transition">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                Approve
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.listings.reject', $listing) }}">
                                            @csrf
                                            <button class="inline-flex items-center gap-1.5 bg-red-100 text-red-700 text-xs font-bold px-4 py-2 rounded-lg hover:bg-red-200 transition">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>

    {{-- Pending Reviews --}}
    <section>
        <h2 class="text-xl font-bold text-gray-900 mb-5 flex items-center gap-2.5">
            <svg class="w-5 h-5 text-forest-700" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
            Pending Reviews
            @if($pendingReviews->count() > 0)
                <span class="bg-yellow-100 text-yellow-700 text-sm font-bold px-2 py-0.5 rounded-full">{{ $pendingReviews->count() }}</span>
            @endif
        </h2>

        @if($pendingReviews->isEmpty())
            <div class="bg-forest-50 border border-forest-200 rounded-2xl p-6 text-forest-700 text-sm flex items-center gap-2.5">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                No reviews awaiting moderation.
            </div>
        @else
            <div class="space-y-4">
                @foreach($pendingReviews as $review)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex items-start justify-between gap-6">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="font-semibold text-gray-900">{{ $review->user->name }}</span>
                                <div class="flex">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endfor
                                </div>
                                <span class="text-xs text-gray-400">on {{ $review->listing->name }}</span>
                            </div>
                            @if($review->comment)
                                <p class="text-sm text-gray-600">{{ $review->comment }}</p>
                            @endif
                        </div>
                        <div class="flex items-center gap-3 shrink-0">
                            <form method="POST" action="{{ route('admin.reviews.approve', $review) }}">
                                @csrf
                                <button class="inline-flex items-center gap-1.5 bg-forest-700 text-white text-xs font-bold px-4 py-2 rounded-lg hover:bg-forest-800 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    Approve
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.reviews.reject', $review) }}">
                                @csrf
                                <button class="inline-flex items-center gap-1.5 bg-red-100 text-red-700 text-xs font-bold px-4 py-2 rounded-lg hover:bg-red-200 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                    Reject
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
</div>
@endsection
