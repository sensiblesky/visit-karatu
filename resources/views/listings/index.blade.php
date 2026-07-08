@extends('layouts.app')

@section('title', $currentCategory ? $currentCategory->name : 'All Listings')

@section('content')

{{-- Page header --}}
<div class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col sm:flex-row sm:items-center gap-3">
            <div class="flex-1">
                <nav class="text-xs text-gray-400 mb-2 flex items-center gap-1.5">
                    <a href="{{ route('home') }}" class="hover:text-forest-600 transition">Home</a>
                    <span>/</span>
                    <span class="text-gray-600">{{ $currentCategory ? $currentCategory->name : 'All Listings' }}</span>
                </nav>
                <h1 class="text-2xl font-bold text-gray-900">
                    {{ $currentCategory ? $currentCategory->name . ' in Karatu' : 'All Experiences in Karatu' }}
                </h1>
                @if($currentCategory && $currentCategory->description)
                    <p class="text-sm text-gray-500 mt-1">{{ $currentCategory->description }}</p>
                @endif
                <p class="text-sm text-gray-500 mt-1">{{ $listings->total() }} results found</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('listings.map') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-forest-700 border border-forest-200 hover:bg-forest-50 px-4 py-2.5 rounded-xl transition shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                    Map
                </a>
                <form method="GET" class="flex items-center gap-2">
                    @foreach(request()->except(['sort', 'page']) as $key => $val)
                        @if(is_array($val))
                            @foreach($val as $v)<input type="hidden" name="{{ $key }}[]" value="{{ $v }}">@endforeach
                        @else
                            <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                        @endif
                    @endforeach
                    <label class="text-sm text-gray-500 shrink-0">Sort by:</label>
                    <select name="sort" onchange="this.form.submit()"
                            class="text-sm border border-gray-200 rounded-xl px-4 py-2.5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-forest-500 bg-white">
                        <option value="recommended" {{ request('sort','recommended') === 'recommended' ? 'selected' : '' }}>Recommended</option>
                        <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low → High</option>
                        <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High → Low</option>
                        <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Top Rated</option>
                    </select>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col lg:flex-row gap-7">

            {{-- ===== SIDEBAR FILTERS ===== --}}
            <aside class="lg:w-72 shrink-0">
                <form method="GET" id="filter-form">
                    <input type="hidden" name="sort" value="{{ request('sort', 'recommended') }}">
                    <input type="hidden" name="search" value="{{ request('search') }}">

                    {{-- Mobile filter toggle --}}
                    <div x-data="{ open: false }" class="lg:hidden mb-4">
                        <button @click="open = !open" type="button"
                                class="w-full flex items-center justify-between bg-white border border-gray-200 rounded-xl px-5 py-3 text-sm font-semibold text-gray-700 shadow-sm">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                                Filters
                            </span>
                            <svg class="w-4 h-4 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open" x-transition class="mt-2">
                            @include('listings._filters')
                        </div>
                    </div>

                    {{-- Desktop filters always visible --}}
                    <div class="hidden lg:block">
                        @include('listings._filters')
                    </div>
                </form>
            </aside>

            {{-- ===== RESULTS ===== --}}
            <div class="flex-1 min-w-0">
                @if($listings->isEmpty())
                    <div class="bg-white rounded-3xl p-20 text-center shadow-sm border border-gray-100">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-5">
                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">No listings found</h3>
                        <p class="text-gray-400 text-sm mb-6">Try adjusting your filters or search terms.</p>
                        <a href="{{ request()->url() }}" class="btn-outline text-sm py-2.5">Clear all filters</a>
                    </div>
                @else
                    {{-- Card grid: 2-up on mobile, auto-filling rows on larger screens
                         (leftover cards in the last row grow to fill the width) --}}
                    <div class="flex flex-wrap gap-5">
                        @foreach($listings as $listing)
                            @php
                                $placeholders = [
                                    '/images/placeholders/pool.jpg',
                                    '/images/placeholders/lodge.jpg',
                                    '/images/placeholders/culture.jpg',
                                    '/images/placeholders/savanna.jpg',
                                ];
                                $ph = $placeholders[$loop->index % count($placeholders)];
                            @endphp
                            <a href="{{ route('listings.show', $listing->slug) }}"
                               class="card group flex flex-col grow basis-[calc(50%-0.625rem)] lg:basis-[280px] max-w-full">
                                {{-- Image --}}
                                <div class="relative h-44 sm:h-48 overflow-hidden bg-forest-100">
                                    <img loading="lazy" decoding="async" src="{{ $listing->coverImage ? Storage::url($listing->coverImage->path) : $ph }}"
                                         alt="{{ $listing->name }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    <div class="absolute top-3 left-3 flex flex-wrap gap-1.5">
                                        @if($listing->is_popular)
                                            <span class="badge-popular">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                Popular
                                            </span>
                                        @endif
                                    </div>
                                    <div class="absolute bottom-3 left-3">
                                        <span class="bg-white/90 text-forest-800 text-xs font-semibold px-2.5 py-1 rounded-full">{{ $listing->category->name }}</span>
                                    </div>
                                </div>

                                {{-- Content --}}
                                <div class="p-4 sm:p-5 flex flex-col flex-1">
                                    <h2 class="font-bold text-gray-900 text-base group-hover:text-forest-700 transition leading-snug line-clamp-2">
                                        {{ $listing->name }}
                                    </h2>
                                    <p class="text-xs text-gray-500 flex items-center gap-1 mt-1.5 mb-2">
                                        <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        {{ $listing->location->name }}
                                    </p>

                                    <p class="text-sm text-gray-600 line-clamp-2 leading-relaxed hidden sm:block">{{ $listing->short_description }}</p>

                                    @if($listing->approved_reviews_avg_rating)
                                        <div class="flex items-center gap-1.5 mt-2">
                                            <div class="flex">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-3.5 h-3.5 {{ $i <= round($listing->approved_reviews_avg_rating) ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                @endfor
                                            </div>
                                            <span class="text-xs text-gray-500">{{ number_format($listing->approved_reviews_avg_rating, 1) }} ({{ $listing->approved_reviews_count }})</span>
                                        </div>
                                    @endif

                                    <div class="mt-auto pt-3 mt-3 border-t border-gray-100 flex items-center justify-between gap-2">
                                        @if($listing->price_amount)
                                            <div>
                                                <span class="text-xs text-gray-400">From</span>
                                                <span class="text-forest-700 font-bold">${{ number_format($listing->price_amount) }}</span>
                                                <span class="text-xs text-gray-400 hidden sm:inline">/ {{ $listing->price_unit }}</span>
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-400">Contact for price</span>
                                        @endif
                                        <span class="inline-flex items-center gap-1 text-forest-700 text-sm font-semibold group-hover:gap-2 transition-all">
                                            View
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-8">
                        {{ $listings->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
