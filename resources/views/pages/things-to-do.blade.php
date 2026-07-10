@extends('layouts.app')

@section('title', 'Things to Do in Karatu')
@section('meta_description', 'Hiking, the Sunday gulio (mnada) markets, cultural experiences and Karatu nightlife: the best things to do in and around Karatu.')

@section('content')

{{-- Hero --}}
<section class="relative overflow-hidden min-h-[340px] flex items-center">
    <div class="absolute inset-0">
        <img src="{{ setting('things_hero_image', asset('images/placeholders/savanna.jpg')) }}" alt="Things to do in Karatu" class="w-full h-full object-cover object-center">
        <div class="absolute inset-0 bg-gradient-to-b from-forest-950/70 to-forest-950/90"></div>
    </div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-white">
        <nav class="text-xs text-white/60 mb-3 flex items-center gap-1.5">
            <a href="{{ route('home') }}" class="hover:text-white transition">Home</a><span>/</span><span class="text-white/90">Things to Do</span>
        </nav>
        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-3">Things to Do in Karatu</h1>
        <p class="text-lg text-white/80 max-w-2xl leading-relaxed">
            Beyond the crater rim: hiking trails, lively local markets, cultural encounters and Karatu after dark.
        </p>
    </div>
</section>

{{-- Curated highlights --}}
<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach([
                ['title' => 'Hiking & Nature Walks', 'desc' => 'Trek the Ngorongoro highlands, forest walks around Karatu, and the descent to Lake Eyasi. Guided day hikes suit all levels.', 'tag' => 'Outdoors'],
                ['title' => 'Gulio / Mnada: the Sunday Markets', 'desc' => 'Karatu\'s famous rotating flea markets (gulio), with cattle, produce, fabrics and street food. A real taste of local life.', 'tag' => 'Local life'],
                ['title' => 'Cultural Encounters', 'desc' => 'Meet the Iraqw, spend a morning with the Hadzabe hunter-gatherers, or watch a Datoga blacksmith at work.', 'tag' => 'Culture'],
                ['title' => 'Karatu Nightlife', 'desc' => 'Wind down with live music, local brews and bonfire evenings at lodges and bars around Karatu town.', 'tag' => 'After dark'],
            ] as $thing)
                <div class="bg-gray-50 rounded-2xl border border-gray-100 p-8 hover:shadow-md transition">
                    <span class="inline-block text-[11px] font-bold uppercase tracking-wider text-forest-600 bg-forest-100 px-2.5 py-1 rounded-full mb-4">{{ $thing['tag'] }}</span>
                    <h2 class="text-xl font-bold text-gray-900 mb-2">{{ $thing['title'] }}</h2>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $thing['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Real listings --}}
@if($listings->isNotEmpty())
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-8">
            <div>
                <p class="text-forest-600 uppercase tracking-widest text-xs font-semibold mb-1">Book an experience</p>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Attractions &amp; experiences</h2>
            </div>
            <a href="{{ route('listings.category', 'attractions') }}" class="text-sm font-semibold text-forest-700 hover:text-forest-900 hidden sm:inline-flex items-center gap-1.5">
                View all <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($listings as $listing)
                <a href="{{ route('listings.show', $listing->slug) }}" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition group">
                    <div class="h-40 bg-forest-100 overflow-hidden">
                        <img loading="lazy" src="{{ $listing->coverImage ? Storage::url($listing->coverImage->path) : '/images/placeholders/savanna.jpg' }}" alt="{{ $listing->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-4">
                        @if($listing->location)<p class="text-xs text-gray-400 mb-1">{{ $listing->location->name }}</p>@endif
                        <h3 class="text-sm font-semibold text-gray-900 line-clamp-2 group-hover:text-forest-700 transition">{{ $listing->name }}</h3>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
