@extends('layouts.app')

@section('title', 'Sports Sponsorships')
@section('meta_description', "Visit Karatu partners with football clubs and sporting organisations to share Karatu with the world.")

@section('content')

{{-- Hero --}}
<section class="relative bg-forest-950 text-white">
    <div class="absolute inset-0">
        <img src="{{ setting('sports_hero_image', asset('images/placeholders/savanna.jpg')) }}" alt="" class="w-full h-full object-cover opacity-40">
        <div class="absolute inset-0 bg-gradient-to-b from-forest-950/70 to-forest-950/90"></div>
    </div>
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
        <p class="text-forest-300 uppercase tracking-widest text-xs font-semibold mb-3">Partnerships &amp; Sponsorships</p>
        <h1 class="text-4xl sm:text-5xl font-extrabold mb-4">Karatu on the World Stage</h1>
        <p class="text-forest-100 text-lg max-w-2xl mx-auto">Visit Karatu partners with football clubs and sporting organisations at home and abroad to share the heart of northern Tanzania with fans around the globe.</p>
    </div>
</section>

<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        @if($partners->isEmpty())
            <div class="text-center py-16 text-gray-400">
                <p>Our sports partnerships will be announced here soon.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($partners as $partner)
                    <a href="{{ route('partners.show', $partner) }}" class="group block">
                        <div class="text-center mb-3">
                            <p class="text-xs font-semibold uppercase tracking-wider text-forest-600">{{ $partner->tier ?: 'Partner' }}</p>
                            <h2 class="text-xl font-bold text-gray-900 group-hover:text-forest-700 transition">{{ $partner->name }}</h2>
                        </div>
                        <div class="relative rounded-2xl overflow-hidden aspect-[4/3] bg-gray-100 shadow-sm group-hover:shadow-lg transition">
                            @if($partner->hero_image_url || $partner->logo_url)
                                <img loading="lazy" src="{{ $partner->hero_image_url ?? $partner->logo_url }}" alt="{{ $partner->name }}"
                                     class="w-full h-full {{ $partner->hero_image_url ? 'object-cover' : 'object-contain p-10' }} group-hover:scale-105 transition-transform duration-500">
                            @endif
                            @if($partner->level === 'platinum')
                                <span class="absolute top-3 right-3 bg-forest-900/80 text-white text-[10px] font-bold uppercase tracking-wide px-2.5 py-1 rounded-full">Platinum</span>
                            @endif
                        </div>
                        @if($partner->summary)
                            <p class="text-sm text-gray-500 mt-3 line-clamp-2">{{ $partner->summary }}</p>
                        @endif
                    </a>
                @endforeach
            </div>
        @endif

        {{-- CTA --}}
        <div class="mt-16 bg-forest-50 rounded-3xl p-10 text-center">
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Become a sports partner</h3>
            <p class="text-gray-600 mb-6 max-w-xl mx-auto">Put your club or brand alongside Karatu's story. Reach fans across Tanzania, Europe and beyond.</p>
            <a href="{{ route('sponsors.index') }}#become-a-sponsor" class="btn-primary px-8 py-3 inline-block">Get in touch</a>
        </div>
    </div>
</div>

@endsection
