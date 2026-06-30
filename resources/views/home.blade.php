@extends('layouts.app')

@section('title', 'Visit Karatu')
@section('meta_description', 'Karatu is your gateway to Ngorongoro, Lake Manyara, Lake Eyasi and unforgettable cultural experiences in northern Tanzania.')

@section('content')

{{-- ===== HERO ===== --}}
@php
    $heroImage = setting('hero_image', 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=1800&q=85&auto=format&fit=crop');
    $heroVideo = setting('hero_video');
    $useVideo  = setting('hero_media_type', 'image') === 'video' && !empty($heroVideo);
@endphp
<section class="relative flex items-center overflow-hidden min-h-[520px] h-[68vh] max-h-[760px]">
    {{-- Background media (admin chooses image or video) --}}
    <div class="absolute inset-0">
        @if($useVideo)
            <video class="w-full h-full object-cover object-center"
                   autoplay muted loop playsinline preload="metadata"
                   poster="{{ $heroImage }}">
                <source src="{{ $heroVideo }}" type="video/mp4">
            </video>
        @else
            <img src="{{ $heroImage }}" alt="Karatu landscape" class="w-full h-full object-cover object-center">
        @endif
        <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-black/35 to-black/75"></div>
    </div>

    <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
        <div class="max-w-3xl">
            @if($badge = setting('hero_badge'))
                <span class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm text-white text-xs font-semibold px-3.5 py-1.5 rounded-full mb-5 border border-white/30">
                    <span class="w-2 h-2 bg-forest-300 rounded-full animate-pulse"></span>
                    {{ $badge }}
                </span>
            @endif
            <h1 class="text-3xl sm:text-5xl md:text-6xl font-extrabold text-white leading-[1.08] tracking-tight mb-4">
                {{ setting('hero_title', 'Discover the Heart of Northern Tanzania') }}
            </h1>
            <p class="text-base sm:text-lg md:text-xl text-white/80 mb-7 leading-relaxed max-w-xl">
                {{ setting('hero_subtitle', 'Karatu is your gateway to Ngorongoro, Lake Manyara, Lake Eyasi and unforgettable cultural experiences.') }}
            </p>

            {{-- Search bar: stacked & full-width on mobile, single pill on desktop --}}
            <form action="{{ route('listings.index') }}" method="GET"
                  class="bg-white/95 backdrop-blur rounded-2xl p-2 shadow-2xl max-w-2xl flex flex-col sm:flex-row sm:items-center gap-2">
                {{-- Search input --}}
                <div class="flex items-center gap-2.5 px-3 sm:flex-1 bg-gray-50 sm:bg-transparent rounded-xl">
                    <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" placeholder="{{ setting('hero_search_placeholder', 'Search for lodges, tours, activities...') }}"
                           class="flex-1 min-w-0 py-3 text-sm text-gray-800 placeholder-gray-400 bg-transparent border-0 focus:border-0 focus:outline-none focus:ring-0">
                </div>

                <div class="hidden sm:block w-px h-7 bg-gray-200 shrink-0"></div>

                {{-- Location select --}}
                <div class="flex items-center gap-2.5 px-3 sm:w-44 bg-gray-50 sm:bg-transparent rounded-xl">
                    <svg class="w-5 h-5 text-gray-400 shrink-0 sm:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <select name="location" class="flex-1 min-w-0 py-3 text-sm text-gray-600 border-0 focus:outline-none focus:ring-0 bg-transparent">
                        <option value="">All Locations</option>
                        @foreach($locations as $loc)
                            <option value="{{ $loc->slug }}">{{ $loc->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="flex items-center justify-center gap-2 bg-forest-700 hover:bg-forest-800 text-white font-semibold px-6 py-3.5 rounded-xl transition-all duration-200 text-sm whitespace-nowrap shadow-sm shrink-0">
                    <svg class="w-4 h-4 sm:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Search
                </button>
            </form>

            <div class="flex flex-wrap items-center gap-2 mt-6">
                <span class="inline-flex items-center gap-1.5 text-white/70 text-xs font-semibold uppercase tracking-wide mr-1">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    Popular
                </span>
                @foreach($categories->take(3) as $cat)
                    <a href="{{ route('listings.category', $cat->slug) }}"
                       class="inline-flex items-center text-white text-xs sm:text-sm font-medium bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/20 hover:border-white/40 px-3.5 py-1.5 rounded-full transition">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ===== CATEGORY ICONS ROW ===== --}}
<section class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex flex-wrap justify-center gap-y-2">
            @php
                // Modern duotone (Iconsax "bulk"-style) icons — a soft backdrop shape
                // at low opacity plus a solid accent. Keyed by slug so categories can
                // be renamed in the admin without touching this view.
                $catIcons = [
                    'lodges-hotels'  => ['svg' => '<path opacity=".4" d="M21 20.25H3a.75.75 0 0 1 0-1.5h18a.75.75 0 0 1 0 1.5Z"/><path d="M13 19.5h7.5V9.4c0-1.84-.88-2.75-2.74-2.75H15.7C13.85 6.65 13 7.56 13 9.4V19.5Z"/><path opacity=".4" d="M3.5 19.5H11V5.16c0-1.78-.83-2.66-2.6-2.66H6.1C4.33 2.5 3.5 3.38 3.5 5.16V19.5Z"/><path d="M6 9.75h2.5M6 12.5h2.5M6.25 6.5h2M16 10.5h1.5M16 13.25h1.5" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>', 'sub' => 'Lodges & hotels'],
                    'tour-operators' => ['svg' => '<path opacity=".4" d="M12 2.25A9.75 9.75 0 1 0 21.75 12 9.76 9.76 0 0 0 12 2.25Z"/><path d="M15.43 7.74 11 9.22a1.5 1.5 0 0 0-.95.95L8.57 14.6a.85.85 0 0 0 1.08 1.08l4.43-1.48a1.5 1.5 0 0 0 .95-.95l1.48-4.43a.85.85 0 0 0-1.08-1.08ZM12 13.05A1.05 1.05 0 1 1 13.05 12 1.05 1.05 0 0 1 12 13.05Z"/>', 'sub' => 'Safaris & day trips'],
                    'sport-clubs'    => ['svg' => '<path opacity=".4" d="M16.5 4.5h-9C5.6 4.5 4.5 5.6 4.5 7.5v1.6a5.4 5.4 0 0 0 5.4 5.4h4.2a5.4 5.4 0 0 0 5.4-5.4V7.5c0-1.9-1.1-3-3-3Z"/><path d="M4.9 5.6H4A2.5 2.5 0 0 0 1.5 8.1 3 3 0 0 0 4.5 11h.9a7.4 7.4 0 0 1-.5-2V5.6ZM19.1 5.6h.9A2.5 2.5 0 0 1 22.5 8.1 3 3 0 0 1 19.5 11h-.9a7.4 7.4 0 0 0 .5-2V5.6ZM13 14.4h-2v2.85h-1.1a1.1 1.1 0 0 0-1.1 1.1v1.15h6.4v-1.15a1.1 1.1 0 0 0-1.1-1.1H13V14.4Z"/>', 'sub' => 'Activities & clubs'],
                    'attractions'    => ['svg' => '<path opacity=".4" d="M19 8h-.42l-.62-1.33A2.4 2.4 0 0 0 15.74 5.3H8.26a2.4 2.4 0 0 0-2.22 1.37L5.42 8H5a3 3 0 0 0-3 3v6a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3v-6a3 3 0 0 0-3-3Z"/><path d="M12 9.6a3.7 3.7 0 1 0 0 7.4 3.7 3.7 0 0 0 0-7.4Zm0 5.6a1.9 1.9 0 1 1 0-3.8 1.9 1.9 0 0 1 0 3.8Z"/>', 'sub' => 'Crater, lakes & parks'],
                    'culture-crafts' => ['svg' => '<path opacity=".4" d="M12 2.25c-5.38 0-9.75 4.04-9.75 9 0 4.55 3.68 8.25 8.2 8.25 1.65 0 2.55-1.18 2.55-2.34 0-.54-.21-1-.55-1.36-.34-.36-.55-.83-.55-1.37 0-1.16.94-2.1 2.1-2.1h1.86A6.94 6.94 0 0 0 21.75 11c0-4.96-4.37-9-9.75-8.75Z"/><path d="M7.4 13.4a1.45 1.45 0 1 0 0-2.9 1.45 1.45 0 0 0 0 2.9ZM8.4 8.8a1.45 1.45 0 1 0 0-2.9 1.45 1.45 0 0 0 0 2.9ZM14.6 8.3a1.45 1.45 0 1 0 0-2.9 1.45 1.45 0 0 0 0 2.9Z"/>', 'sub' => 'Markets & artisans'],
                ];
            @endphp

            @foreach($categories->sortBy('sort_order') as $cat)
                @php $icon = $catIcons[$cat->slug] ?? ['svg' => '<circle opacity=".4" cx="12" cy="12" r="9"/>', 'sub' => 'Explore']; @endphp
                <a href="{{ route('listings.category', $cat->slug) }}"
                   class="group flex flex-col items-center gap-3 py-6 px-3 basis-1/3 sm:basis-1/4 md:basis-1/5 rounded-2xl hover:bg-forest-50/60 transition-all duration-300">
                    <div class="w-16 h-16 rounded-[1.25rem] bg-gradient-to-br from-forest-50 to-forest-100/70 ring-1 ring-forest-100 flex items-center justify-center text-forest-700
                                transition-all duration-300
                                group-hover:from-forest-600 group-hover:to-forest-700 group-hover:text-white group-hover:ring-forest-600
                                group-hover:-translate-y-1 group-hover:shadow-lg group-hover:shadow-forest-600/25">
                        <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor">
                            {!! $icon['svg'] !!}
                        </svg>
                    </div>
                    <div class="text-center">
                        <p class="text-sm font-semibold text-gray-800 group-hover:text-forest-700 transition">{{ $cat->name }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $icon['sub'] }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== TOP EXPERIENCES ===== --}}
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-10">
            <div>
                <p class="text-forest-600 text-sm font-semibold tracking-wide uppercase mb-2">Handpicked for you</p>
                <h2 class="section-title">Top Experiences in Karatu</h2>
            </div>
            <a href="{{ route('listings.index') }}"
               class="hidden md:inline-flex items-center gap-2 text-sm font-semibold text-forest-700 hover:text-forest-900 transition">
                View all
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        @if($featured->isEmpty())
            <div class="text-center py-16 text-gray-400">
                <p>No listings yet. Check back soon!</p>
            </div>
        @else
            {{-- Flexbox so the row auto-fills: complete rows split evenly, and any
                 leftover items in the last row grow to fill the remaining width
                 (a lone last card stretches to full width). Auto-adapts to page width. --}}
            <div class="flex flex-wrap gap-6">
                @foreach($featured as $listing)
                    <a href="{{ route('listings.show', $listing->slug) }}" class="card group flex flex-col grow basis-[calc(50%-0.75rem)] sm:basis-[260px] max-w-full">
                        {{-- Image --}}
                        <div class="relative h-52 overflow-hidden bg-forest-100">
                            @php
                                $placeholders = [
                                    'https://images.unsplash.com/photo-1551732998-9573f695fdbb?w=600&q=80',
                                    'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=600&q=80',
                                    'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=600&q=80',
                                    'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=600&q=80',
                                    'https://images.unsplash.com/photo-1578271887552-5ac3a72752bc?w=600&q=80',
                                ];
                                $ph = $placeholders[$loop->index % count($placeholders)];
                            @endphp
                            @if($listing->coverImage)
                                <img src="{{ Storage::url($listing->coverImage->path) }}"
                                     alt="{{ $listing->name }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <img src="{{ $ph }}" alt="{{ $listing->name }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @endif

                            {{-- Scrims for badge / pill legibility on any image --}}
                            <div class="absolute inset-x-0 top-0 h-16 bg-gradient-to-b from-black/35 to-transparent pointer-events-none"></div>
                            <div class="absolute inset-x-0 bottom-0 h-16 bg-gradient-to-t from-black/35 to-transparent pointer-events-none"></div>

                            {{-- Badges: both live in one wrapping row so they never overlap --}}
                            @if($listing->is_popular || $listing->plan_tier !== 'basic')
                                <div class="absolute top-3 left-3 right-3 flex flex-wrap items-start gap-1.5">
                                    @if($listing->is_popular)
                                        <span class="badge-popular shadow-sm">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            Popular
                                        </span>
                                    @endif
                                    @if($listing->plan_tier !== 'basic')
                                        <span class="badge-premium shadow-sm ml-auto">{{ ucfirst($listing->plan_tier) }}</span>
                                    @endif
                                </div>
                            @endif

                            {{-- Category pill --}}
                            <div class="absolute bottom-3 left-3">
                                <span class="bg-white/95 text-forest-800 text-xs font-semibold px-2.5 py-1 rounded-full shadow-sm">
                                    {{ $listing->category->name }}
                                </span>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="p-5 flex flex-col flex-1">
                            <h3 class="font-bold text-gray-900 text-base mb-1 group-hover:text-forest-700 transition line-clamp-2">
                                {{ $listing->name }}
                            </h3>
                            <p class="text-xs text-gray-500 flex items-center gap-1 mb-3">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $listing->location->name }}
                            </p>

                            @if($listing->approved_reviews_avg_rating)
                                <div class="flex items-center gap-1.5 mb-3">
                                    <div class="flex">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-3.5 h-3.5 {{ $i <= round($listing->approved_reviews_avg_rating) ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        @endfor
                                    </div>
                                    <span class="text-xs text-gray-500">{{ number_format($listing->approved_reviews_avg_rating, 1) }} ({{ $listing->approved_reviews_count }})</span>
                                </div>
                            @endif

                            <div class="mt-auto pt-3 border-t border-gray-100 flex items-center justify-between">
                                @if($listing->price_amount)
                                    <div>
                                        <span class="text-xs text-gray-400">From</span>
                                        <span class="text-forest-700 font-bold text-lg ml-1">${{ number_format($listing->price_amount) }}</span>
                                        <span class="text-xs text-gray-400"> / {{ $listing->price_unit }}</span>
                                    </div>
                                @else
                                    <span class="text-sm text-gray-400">Contact for price</span>
                                @endif
                                <svg class="w-5 h-5 text-gray-300 group-hover:text-forest-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        <div class="text-center mt-10 md:hidden">
            <a href="{{ route('listings.index') }}" class="btn-primary">View All Experiences</a>
        </div>
    </div>
</section>

{{-- ===== WHY KARATU ===== --}}
<section class="py-20 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div>
                <p class="text-forest-600 text-sm font-semibold tracking-wide uppercase mb-3">Northern Tanzania's Best Kept Secret</p>
                <h2 class="section-title mb-6">Why Karatu?</h2>
                <p class="text-gray-500 text-lg leading-relaxed mb-8">
                    Sitting at 1,500m in the cool Ngorongoro highlands, Karatu is surrounded by world-class wildlife and deeply authentic cultural experiences — without the crowds of the main parks.
                </p>
                <div class="space-y-5">
                    @foreach([
                        ['svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>', 'title' => 'Ngorongoro Crater', 'desc' => "The world's largest intact volcanic caldera — home to the Big Five and 25,000+ animals."],
                        ['svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>', 'title' => 'Hadzabe Bushwalk', 'desc' => "Meet one of Africa's last hunter-gatherer peoples at Lake Eyasi — a life-changing morning."],
                        ['svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>', 'title' => 'Highland Farm Lodges', 'desc' => "Wake up to coffee plantation views and crisp mountain air in some of Tanzania's finest lodges."],
                    ] as $item)
                        <div class="flex items-start gap-4 p-4 rounded-2xl hover:bg-forest-50 transition">
                            <div class="w-12 h-12 bg-forest-100 rounded-xl flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6 text-forest-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $item['svg'] !!}</svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 mb-1">{{ $item['title'] }}</h3>
                                <p class="text-sm text-gray-500 leading-relaxed">{{ $item['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-8">
                    <a href="{{ route('listings.index') }}" class="btn-primary">Explore All Listings</a>
                </div>
            </div>

            {{-- Image collage --}}
            <div class="relative h-[500px] hidden lg:block">
                <div class="absolute top-0 right-0 w-64 h-72 rounded-3xl overflow-hidden shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1551732998-9573f695fdbb?w=500&q=85" alt="Wildlife" class="w-full h-full object-cover">
                </div>
                <div class="absolute top-20 left-0 w-56 h-56 rounded-3xl overflow-hidden shadow-2xl border-4 border-white">
                    <img src="https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=400&q=85" alt="Culture" class="w-full h-full object-cover">
                </div>
                <div class="absolute bottom-0 right-12 w-52 h-48 rounded-3xl overflow-hidden shadow-2xl border-4 border-white">
                    <img src="https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=400&q=85" alt="Lodge" class="w-full h-full object-cover">
                </div>
                {{-- Floating stat card --}}
                <div class="absolute bottom-20 left-16 bg-white rounded-2xl shadow-xl p-4 border border-gray-100">
                    <p class="text-xs text-gray-400 font-medium mb-1">Happy Travellers</p>
                    <p class="text-2xl font-bold text-gray-900">12,000+</p>
                    <div class="flex mt-2">
                        @for($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== CATEGORY CARDS GRID ===== --}}
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <p class="text-forest-600 text-sm font-semibold tracking-wide uppercase mb-2">Browse by Interest</p>
            <h2 class="section-title">What Are You Looking For?</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @php
                $catImages = [
                    'lodges-hotels'  => 'https://images.unsplash.com/photo-1578271887552-5ac3a72752bc?w=600&q=80',
                    'tour-operators' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=600&q=80',
                    'sport-clubs'    => 'https://images.unsplash.com/photo-1551188167-6cf8c27ed5fc?w=600&q=80',
                    'attractions'    => 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=600&q=80',
                    'culture-crafts' => 'https://images.unsplash.com/photo-1577083552756-a197272ba42a?w=600&q=80',
                ];
            @endphp
            @foreach($categories->sortBy('sort_order') as $cat)
                <a href="{{ route('listings.category', $cat->slug) }}"
                   class="group relative rounded-3xl overflow-hidden h-52 md:h-64 block">
                    <img src="{{ $catImages[$cat->slug] ?? 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=600&q=80' }}"
                         alt="{{ $cat->name }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-4">
                        <p class="text-white font-bold text-base">{{ $cat->name }}</p>
                        <p class="text-white/60 text-xs mt-0.5">Explore →</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== SPONSORS / PARTNERS (single-row auto-scrolling marquee) ===== --}}
@if($sponsors->isNotEmpty())
<section class="py-14 bg-white border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <p class="text-forest-600 text-sm font-semibold tracking-wide uppercase mb-1.5">Proudly Supported By</p>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">Our Partners &amp; Sponsors</h2>
        </div>

        {{-- Marquee: duplicated track scrolls continuously, pauses on hover, fades at edges --}}
        <div class="marquee group relative">
            <div class="marquee__track group-hover:[animation-play-state:paused]">
                @foreach($sponsors->concat($sponsors) as $sponsor)
                    @php
                        $logo = $sponsor->logo_path ? Storage::url($sponsor->logo_path) : null;
                        $tag = $sponsor->website_url ? 'a' : 'div';
                    @endphp
                    <{{ $tag }}
                        @if($sponsor->website_url) href="{{ $sponsor->website_url }}" target="_blank" rel="noopener nofollow" @endif
                        title="{{ $sponsor->name }}"
                        class="shrink-0 flex items-center justify-center h-14 px-2"
                        aria-hidden="{{ $loop->index >= $sponsors->count() ? 'true' : 'false' }}">
                        @if($logo)
                            <img src="{{ $logo }}" alt="{{ $sponsor->name }}"
                                 class="max-h-12 w-auto object-contain grayscale opacity-60 hover:grayscale-0 hover:opacity-100 transition duration-300">
                        @else
                            <span class="text-base font-bold text-gray-300 whitespace-nowrap">{{ $sponsor->name }}</span>
                        @endif
                    </{{ $tag }}>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

{{-- ===== CTA BANNER ===== --}}
<section class="relative py-24 overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1551732998-9573f695fdbb?w=1600&q=80" alt="" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-forest-900/80"></div>
    </div>
    <div class="relative z-10 max-w-3xl mx-auto text-center px-4">
        <h2 class="text-4xl md:text-5xl font-bold text-white mb-5 leading-tight">
            {{ setting('cta_title', 'Own a Business in Karatu?') }}
        </h2>
        <p class="text-forest-200 text-lg mb-10 leading-relaxed">
            {{ setting('cta_subtitle', 'Join hundreds of lodges, tour operators, and experience providers already reaching thousands of travellers planning their northern Tanzania adventure.') }}
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="mailto:{{ setting('contact_email', 'info@visitkaratu.com') }}"
               class="bg-white text-forest-800 font-bold px-10 py-4 rounded-2xl hover:bg-forest-50 transition text-base shadow-xl">
                List Your Business →
            </a>
            <a href="{{ route('listings.index') }}"
               class="border-2 border-white/40 text-white font-semibold px-10 py-4 rounded-2xl hover:bg-white/10 transition text-base">
                Browse Listings
            </a>
        </div>
    </div>
</section>

@endsection
