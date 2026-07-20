@extends('layouts.app')

@section('title', $listing->name)
@section('meta_description', $listing->short_description)
@php $cover = $listing->images->firstWhere('is_cover', true) ?? $listing->images->first(); @endphp
@section('og_image', $cover ? url(Storage::url($cover->path)) : url('/images/placeholders/savanna.jpg'))
@section('og_type', 'place')

@push('head')
<script type="application/ld+json">
@php
    $schemaType = match($listing->category->slug) {
        'lodges-hotels' => 'LodgingBusiness',
        'attractions' => 'TouristAttraction',
        default => 'LocalBusiness',
    };
    $ld = [
        '@context' => 'https://schema.org',
        '@type' => $schemaType,
        'name' => $listing->name,
        'description' => $listing->short_description,
        'url' => route('listings.show', $listing->slug),
        'image' => $cover ? url(Storage::url($cover->path)) : url('/images/placeholders/savanna.jpg'),
        'address' => [
            '@type' => 'PostalAddress',
            'addressLocality' => $listing->location->name,
            'addressRegion' => 'Arusha',
            'addressCountry' => 'TZ',
        ],
    ];
    if ($listing->latitude && $listing->longitude) {
        $ld['geo'] = ['@type' => 'GeoCoordinates', 'latitude' => (float) $listing->latitude, 'longitude' => (float) $listing->longitude];
    }
    if ($listing->phone) $ld['telephone'] = $listing->phone;
    if ($listing->approved_reviews_count > 0) {
        $ld['aggregateRating'] = [
            '@type' => 'AggregateRating',
            'ratingValue' => round($listing->approved_reviews_avg_rating, 1),
            'reviewCount' => $listing->approved_reviews_count,
        ];
    }
    if ($listing->price_amount) {
        $ld['priceRange'] = '$' . number_format($listing->price_amount);
    }
@endphp
{!! json_encode($ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('home')],
        ['@type' => 'ListItem', 'position' => 2, 'name' => $listing->category->name, 'item' => route('listings.category', $listing->category->slug)],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $listing->name, 'item' => route('listings.show', $listing->slug)],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush

@section('content')

{{-- Breadcrumb --}}
<div class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <nav class="text-xs text-gray-400 flex items-center gap-1.5 flex-wrap">
            <a href="{{ route('home') }}" class="hover:text-forest-600 transition">Home</a>
            <span>/</span>
            <a href="{{ route('listings.index') }}" class="hover:text-forest-600 transition">Listings</a>
            <span>/</span>
            <a href="{{ route('listings.category', $listing->category->slug) }}" class="hover:text-forest-600 transition">{{ $listing->category->name }}</a>
            <span>/</span>
            <span class="text-gray-600 font-medium truncate max-w-xs">{{ $listing->name }}</span>
        </nav>
    </div>
</div>

<div class="bg-gray-50 pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="lg:flex lg:gap-8">

            {{-- ===== MAIN COLUMN ===== --}}
            <div class="flex-1 min-w-0">

                {{-- Hero gallery --}}
                @php
                    $placeholders = [
                        '/images/placeholders/wildlife.jpg',
                        '/images/placeholders/savanna.jpg',
                        '/images/placeholders/culture.jpg',
                        '/images/placeholders/lodge.jpg',
                    ];
                    $cover = $listing->images->firstWhere('is_cover', true) ?? $listing->images->first();
                    $otherImages = $listing->images->where('is_cover', false)->values();
                @endphp

                @php $galleryCount = $listing->images->count() ?: count($placeholders); @endphp
                <div x-data="{ activeImg: '{{ $cover ? Storage::url($cover->path) : $placeholders[0] }}', lightbox: false }"
                     class="mb-6">
                    {{-- Main image --}}
                    <div @click="lightbox = true"
                         class="rounded-3xl overflow-hidden h-72 md:h-[460px] bg-forest-100 mb-3 relative group cursor-zoom-in">
                        <img loading="lazy" decoding="async" :src="activeImg" alt="{{ $listing->name }}"
                             class="w-full h-full object-cover transition-all duration-500 group-hover:scale-[1.02]">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition"></div>
                        {{-- View / count badge --}}
                        <div class="absolute bottom-3 right-3 flex items-center gap-1.5 bg-black/55 backdrop-blur text-white text-xs font-medium px-3 py-1.5 rounded-full">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a2 2 0 012-2h12a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15l4-4 4 4M14 13l2-2 4 4"/></svg>
                            {{ $galleryCount }} photo{{ $galleryCount === 1 ? '' : 's' }}
                        </div>
                    </div>

                    {{-- Lightbox --}}
                    <div x-show="lightbox" x-cloak x-transition.opacity
                         @keydown.escape.window="lightbox = false"
                         class="fixed inset-0 z-[60] bg-black/90 flex items-center justify-center p-4" style="display:none">
                        <button @click="lightbox = false" class="absolute top-5 right-5 text-white/80 hover:text-white">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                        <img loading="lazy" decoding="async" :src="activeImg" alt="{{ $listing->name }}" @click.stop
                             class="max-h-[88vh] max-w-[92vw] object-contain rounded-xl shadow-2xl">
                    </div>
                    {{-- Thumbnails --}}
                    @if($listing->images->count() > 1 || true)
                        <div class="flex gap-2.5 overflow-x-auto pb-1">
                            @if($cover)
                                <button @click="activeImg = '{{ Storage::url($cover->path) }}'"
                                        :class="activeImg === '{{ Storage::url($cover->path) }}' ? 'ring-2 ring-forest-600' : 'ring-0'"
                                        class="h-20 w-28 rounded-xl overflow-hidden shrink-0 ring-offset-2 transition">
                                    <img loading="lazy" decoding="async" src="{{ Storage::url($cover->path) }}" class="w-full h-full object-cover">
                                </button>
                            @else
                                @foreach(array_slice($placeholders, 0, 4) as $idx => $ph)
                                    <button @click="activeImg = '{{ $ph }}'"
                                            :class="activeImg === '{{ $ph }}' ? 'ring-2 ring-forest-600' : 'ring-0'"
                                            class="h-20 w-28 rounded-xl overflow-hidden shrink-0 ring-offset-2 transition">
                                        <img loading="lazy" decoding="async" src="{{ $ph }}" class="w-full h-full object-cover">
                                    </button>
                                @endforeach
                            @endif
                            @foreach($otherImages as $img)
                                <button @click="activeImg = '{{ Storage::url($img->path) }}'"
                                        :class="activeImg === '{{ Storage::url($img->path) }}' ? 'ring-2 ring-forest-600' : 'ring-0'"
                                        class="h-20 w-28 rounded-xl overflow-hidden shrink-0 ring-offset-2 transition">
                                    <img loading="lazy" decoding="async" src="{{ Storage::url($img->path) }}" class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif

                    {{-- Videos --}}
                    @if($listing->videos->count())
                        <div class="mt-4">
                            <h3 class="text-sm font-semibold text-gray-700 mb-2 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-forest-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 6h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z"/></svg>
                                {{ $listing->videos->count() }} video{{ $listing->videos->count() === 1 ? '' : 's' }}
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach($listing->videos as $video)
                                    <video controls preload="metadata" playsinline
                                           @if($video->poster) poster="{{ Storage::url($video->poster) }}" @endif
                                           class="w-full rounded-2xl bg-black aspect-video object-cover">
                                        <source src="{{ Storage::url($video->path) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Title + meta --}}
                <div class="bg-white rounded-3xl p-7 shadow-sm border border-gray-100 mb-5">
                    <div class="flex flex-wrap items-start justify-between gap-4 mb-4">
                        <div>
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                <span class="text-xs font-semibold text-forest-700 bg-forest-50 px-3 py-1 rounded-full">{{ $listing->category->name }}</span>
                                @if($listing->is_popular)
                                    <span class="badge-popular">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        Popular
                                    </span>
                                @endif
                                @if($listing->plan_tier !== 'basic')
                                    <span class="badge-premium">{{ ucfirst($listing->plan_tier) }}</span>
                                @endif
                            </div>
                            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 leading-tight mb-2">{{ $listing->name }}</h1>
                            <div class="flex items-center gap-4 flex-wrap">
                                <p class="text-gray-500 flex items-center gap-1.5 text-sm">
                                    <svg class="w-4 h-4 text-forest-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $listing->location->name }}, Karatu, Tanzania
                                </p>
                                <button type="button"
                                        x-data="{ copied: false }"
                                        @click="
                                            const url = window.location.href;
                                            if (navigator.share) { navigator.share({ title: @js($listing->name), url }).catch(()=>{}); }
                                            else { navigator.clipboard.writeText(url); copied = true; setTimeout(()=>copied=false, 2000); }
                                        "
                                        class="inline-flex items-center gap-1.5 text-sm font-medium text-forest-700 hover:text-forest-900 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                    <span x-text="copied ? 'Link copied!' : 'Share'"></span>
                                </button>
                            </div>
                        </div>
                        @if($listing->approved_reviews_avg_rating)
                            <div class="bg-forest-50 rounded-2xl px-5 py-3 text-center">
                                <div class="text-3xl font-extrabold text-forest-700">{{ number_format($listing->approved_reviews_avg_rating, 1) }}</div>
                                <div class="flex justify-center my-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= round($listing->approved_reviews_avg_rating) ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endfor
                                </div>
                                <div class="text-xs text-gray-400">{{ $listing->approved_reviews_count }} reviews</div>
                            </div>
                        @endif
                    </div>

                    {{-- Tags --}}
                    @if($listing->tags)
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach($listing->tags as $tag)
                                <span class="flex items-center gap-1.5 text-xs font-medium text-gray-600 bg-gray-100 px-3 py-1.5 rounded-full">
                                    <svg class="w-3.5 h-3.5 text-forest-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    {{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    @endif

                    {{-- Amenity row --}}
                    @if($listing->amenities->count())
                        <div class="flex flex-wrap gap-2 pt-4 border-t border-gray-100">
                            @foreach($listing->amenities as $a)
                                <span class="text-xs text-gray-600 bg-gray-50 border border-gray-200 px-3 py-1.5 rounded-full font-medium">{{ $a->name }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Tabs — only the tabs the listing's category enables (admin-editable) --}}
                @php $visibleTabs = $listing->visibleTabs(); @endphp
                <div x-data="{ tab: '{{ array_key_first($visibleTabs) }}' }" class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    {{-- Tab nav --}}
                    <div class="border-b border-gray-100 overflow-x-auto">
                        <div class="flex gap-0 px-2 pt-2 min-w-max">
                            @foreach($visibleTabs as $key => $label)
                                <button @click="tab = '{{ $key }}'"
                                        :class="tab === '{{ $key }}' ? 'border-b-2 border-forest-600 text-forest-700 font-semibold bg-forest-50/50' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50'"
                                        class="px-6 py-3.5 text-sm rounded-t-xl transition-all whitespace-nowrap">
                                    {{ $label }}@if($key === 'reviews') ({{ $listing->approved_reviews_count }})@endif
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="p-7">
                        @foreach($visibleTabs as $key => $label)
                            <div x-show="tab === '{{ $key }}'" x-cloak>
                                @include('listings.tabs.' . $key)
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Location / map --}}
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mt-5">
                    <div class="p-7 pb-4">
                        <h3 class="font-bold text-gray-900 mb-1 flex items-center gap-2">
                            <svg class="w-5 h-5 text-forest-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Location
                        </h3>
                        <p class="text-sm text-gray-500">{{ $listing->address_text ?? $listing->location->name . ', Karatu, Tanzania' }}</p>
                    </div>
                    @php
                        $lat = $listing->latitude ?? $listing->location->latitude;
                        $lng = $listing->longitude ?? $listing->location->longitude;
                    @endphp
                    @if($lat && $lng)
                        @php $d = 0.04; @endphp
                        <iframe
                            title="Map of {{ $listing->name }}"
                            class="w-full h-64 border-0"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            src="https://www.openstreetmap.org/export/embed.html?bbox={{ $lng - $d }}%2C{{ $lat - $d }}%2C{{ $lng + $d }}%2C{{ $lat + $d }}&layer=mapnik&marker={{ $lat }}%2C{{ $lng }}"></iframe>
                        <div class="px-7 py-3 border-t border-gray-100">
                            <a href="https://www.google.com/maps/search/?api=1&query={{ $lat }},{{ $lng }}" target="_blank" rel="noopener"
                               class="inline-flex items-center gap-1.5 text-sm font-semibold text-forest-700 hover:text-forest-900">
                                Get directions
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                    @else
                        <div class="h-40 bg-forest-50 flex items-center justify-center text-forest-300 text-sm">
                            Map location not set
                        </div>
                    @endif
                </div>
            </div>

            {{-- ===== STICKY SIDEBAR ===== --}}
            <div class="lg:w-80 xl:w-96 shrink-0 mt-6 lg:mt-0">
                <div class="sticky top-24 space-y-4">

                    {{-- Price + CTA card --}}
                    <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden">
                        {{-- Price header --}}
                        <div class="bg-gradient-to-br from-forest-700 to-forest-800 p-6 text-white">
                            @if($listing->price_amount)
                                <p class="text-forest-200 text-sm mb-1">Starting from</p>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-4xl font-extrabold">${{ number_format($listing->price_amount) }}</span>
                                    <span class="text-forest-200 text-sm">/ {{ $listing->price_unit }}</span>
                                </div>
                            @else
                                <p class="text-lg font-semibold">Contact for pricing</p>
                            @endif
                        </div>

                        {{-- Booking form --}}
                        <div class="p-6">
                            @auth
                                <form method="POST" action="{{ route('bookings.store', $listing) }}" class="space-y-3 mb-4">
                                    @csrf
                                    <div>
                                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1.5">Your Name</label>
                                        <input type="text" name="guest_name" value="{{ auth()->user()->name }}" required
                                               class="form-input">
                                    </div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1.5">Adults</label>
                                            <input type="number" name="adults" value="2" min="1" max="20" required class="form-input">
                                        </div>
                                        <div>
                                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1.5">Children</label>
                                            <input type="number" name="children" value="0" min="0" max="20" class="form-input">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide block mb-1.5">Date</label>
                                        <input type="date" name="booking_date" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required class="form-input">
                                    </div>
                                    <button type="submit" class="w-full btn-primary justify-center py-3.5 text-base rounded-2xl">
                                        Check Availability
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('favorites.toggle', $listing) }}">
                                    @csrf
                                    <button type="submit"
                                            class="w-full flex items-center justify-center gap-2 py-3 rounded-2xl border-2 transition font-semibold text-sm
                                                {{ $isFavorited ? 'border-red-300 text-red-500 bg-red-50 hover:bg-red-100' : 'border-gray-200 text-gray-600 hover:border-forest-400 hover:text-forest-600' }}">
                                        <svg class="w-5 h-5" fill="{{ $isFavorited ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                        {{ $isFavorited ? 'Saved to Wishlist' : 'Add to Wishlist' }}
                                    </button>
                                </form>
                            @else
                                {{-- Online booking is handled directly with the operator --}}
                                <p class="text-sm text-gray-500 mb-3">To check availability or book, contact the operator directly:</p>
                                <div class="space-y-2">
                                    @if($listing->whatsapp_number)
                                        <a href="https://wa.me/{{ preg_replace('/\D/', '', $listing->whatsapp_number) }}" target="_blank"
                                           class="w-full btn-primary justify-center py-3.5 text-base rounded-2xl flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                                            Book via WhatsApp
                                        </a>
                                    @endif
                                    @if($listing->phone)
                                        <a href="tel:{{ $listing->phone }}"
                                           class="w-full flex items-center justify-center gap-2 py-3 rounded-2xl border-2 border-gray-200 text-gray-700 hover:border-forest-400 hover:text-forest-600 transition font-semibold text-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                            Call {{ $listing->phone }}
                                        </a>
                                    @endif
                                    @if($listing->email)
                                        <a href="mailto:{{ $listing->email }}"
                                           class="w-full flex items-center justify-center gap-2 py-3 rounded-2xl border-2 border-gray-200 text-gray-700 hover:border-forest-400 hover:text-forest-600 transition font-semibold text-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                            Email the operator
                                        </a>
                                    @endif
                                </div>

                                {{-- Or send a message right here (emails the operator) --}}
                                <div class="mt-5 pt-5 border-t border-gray-100">
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2.5">Send a message</p>
                                    <form method="POST" action="{{ route('enquiries.store', $listing) }}" class="space-y-2.5">
                                        @csrf
                                        <input type="text" name="company" tabindex="-1" autocomplete="off" class="hidden" aria-hidden="true">
                                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Your name *" required class="form-input">
                                        <div class="grid grid-cols-1 gap-2.5">
                                            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" class="form-input">
                                            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Phone" class="form-input">
                                        </div>
                                        <textarea name="message" rows="3" placeholder="Your message *" required class="form-input resize-y">{{ old('message') }}</textarea>
                                        <button type="submit" class="w-full btn-primary justify-center">Send Enquiry</button>
                                    </form>
                                </div>
                            @endauth
                        </div>
                    </div>

                    {{-- Contact card --}}
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                        <h4 class="font-bold text-gray-900 mb-4">Contact</h4>
                        <div class="space-y-3">
                            @if($listing->phone)
                                <a href="tel:{{ $listing->phone }}"
                                   class="flex items-center gap-3 text-sm text-gray-700 hover:text-forest-700 p-3 rounded-xl hover:bg-forest-50 transition">
                                    <div class="w-9 h-9 bg-forest-50 rounded-xl flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4 text-forest-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    </div>
                                    {{ $listing->phone }}
                                </a>
                            @endif
                            @if($listing->whatsapp_number)
                                <a href="https://wa.me/{{ preg_replace('/\D/', '', $listing->whatsapp_number) }}" target="_blank"
                                   class="flex items-center gap-3 text-sm text-gray-700 hover:text-green-700 p-3 rounded-xl hover:bg-green-50 transition">
                                    <div class="w-9 h-9 bg-green-50 rounded-xl flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.549 4.116 1.514 5.845L0 24l6.335-1.498A11.95 11.95 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.98 0-3.844-.573-5.426-1.567l-.388-.232-4.024.951.997-3.908-.253-.4A9.968 9.968 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
                                    </div>
                                    WhatsApp
                                </a>
                            @endif
                            @if($listing->email)
                                <a href="mailto:{{ $listing->email }}"
                                   class="flex items-center gap-3 text-sm text-gray-700 hover:text-forest-700 p-3 rounded-xl hover:bg-forest-50 transition">
                                    <div class="w-9 h-9 bg-forest-50 rounded-xl flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4 text-forest-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    </div>
                                    {{ $listing->email }}
                                </a>
                            @endif
                            @if($listing->address_text)
                                <div class="flex items-start gap-3 text-sm text-gray-600 p-3">
                                    <div class="w-9 h-9 bg-gray-50 rounded-xl flex items-center justify-center shrink-0 mt-0.5">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </div>
                                    {{ $listing->address_text }}
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Enquiry card --}}
                    @auth
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                            <h4 class="font-bold text-gray-900 mb-4">Send an Enquiry</h4>
                            <form method="POST" action="{{ route('enquiries.store', $listing) }}" class="space-y-3">
                                @csrf
                                <input type="hidden" name="name" value="{{ auth()->user()->name }}">
                                <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                                <textarea name="message" rows="4" placeholder="Ask about availability, pricing or anything else..." required
                                          class="form-input resize-none"></textarea>
                                <button type="submit"
                                        class="w-full flex items-center justify-center gap-2 py-3 rounded-2xl border-2 border-forest-600 text-forest-700 font-semibold text-sm hover:bg-forest-50 transition">
                                    Send Message
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        {{-- ===== YOU MIGHT ALSO LIKE ===== --}}
        @if($related->isNotEmpty())
            <div class="mt-14">
                <div class="flex items-end justify-between mb-6">
                    <div>
                        <p class="text-forest-600 text-sm font-semibold tracking-wide uppercase mb-1">Keep exploring</p>
                        <h2 class="text-2xl font-bold text-gray-900">You might also like</h2>
                    </div>
                    <a href="{{ route('listings.category', $listing->category->slug) }}"
                       class="hidden sm:inline-flex items-center gap-1.5 text-sm font-semibold text-forest-700 hover:text-forest-900">
                        More {{ $listing->category->name }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
                <div class="flex flex-wrap gap-5">
                    @php
                        $relPh = [
                            '/images/placeholders/pool.jpg',
                            '/images/placeholders/lodge.jpg',
                            '/images/placeholders/culture.jpg',
                            '/images/placeholders/savanna.jpg',
                        ];
                    @endphp
                    @foreach($related as $rel)
                        <a href="{{ route('listings.show', $rel->slug) }}"
                           class="card group flex flex-col grow basis-[calc(50%-0.625rem)] lg:basis-[260px] max-w-full">
                            <div class="relative h-40 overflow-hidden bg-forest-100">
                                <img loading="lazy" decoding="async" src="{{ $rel->coverImage ? Storage::url($rel->coverImage->path) : $relPh[$loop->index % count($relPh)] }}"
                                     alt="{{ $rel->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute bottom-2 left-2">
                                    <span class="bg-white/95 text-forest-800 text-[11px] font-semibold px-2 py-0.5 rounded-full shadow-sm">{{ $rel->category->name }}</span>
                                </div>
                            </div>
                            <div class="p-4 flex flex-col flex-1">
                                <h3 class="font-bold text-gray-900 text-sm group-hover:text-forest-700 transition line-clamp-2 leading-snug">{{ $rel->name }}</h3>
                                <p class="text-xs text-gray-500 flex items-center gap-1 mt-1">
                                    <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $rel->location->name }}
                                </p>
                                <div class="mt-auto pt-3 flex items-center justify-between">
                                    @if($rel->price_amount)
                                        <span class="text-forest-700 font-bold text-sm">${{ number_format($rel->price_amount) }}</span>
                                    @else
                                        <span class="text-xs text-gray-400">Enquire</span>
                                    @endif
                                    @if($rel->approved_reviews_avg_rating)
                                        <span class="flex items-center gap-1 text-xs text-gray-500">
                                            <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            {{ number_format($rel->approved_reviews_avg_rating, 1) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

{{-- ===== MOBILE STICKY BOOKING BAR ===== --}}
<div class="lg:hidden fixed bottom-0 inset-x-0 z-40 bg-white border-t border-gray-200 px-4 py-3 flex items-center justify-between gap-3 shadow-[0_-4px_20px_rgba(0,0,0,0.06)]">
    <div class="min-w-0">
        @if($listing->price_amount)
            <div class="text-lg font-extrabold text-forest-700 leading-none">${{ number_format($listing->price_amount) }}
                <span class="text-xs font-normal text-gray-400">/ {{ $listing->price_unit }}</span>
            </div>
        @else
            <div class="text-sm font-semibold text-gray-700">Contact for pricing</div>
        @endif
        <p class="text-[11px] text-gray-400 truncate">{{ $listing->name }}</p>
    </div>
    @php $waBook = $listing->whatsapp_number ? 'https://wa.me/' . preg_replace('/\D/', '', $listing->whatsapp_number) : ($listing->phone ? 'tel:' . $listing->phone : ($listing->email ? 'mailto:' . $listing->email : '#')); @endphp
    <a href="{{ $waBook }}" @if($listing->whatsapp_number) target="_blank" @endif
       class="btn-primary py-3 px-6 rounded-xl shrink-0 text-sm">
        Book Now
    </a>
</div>
@endsection
