@extends('layouts.app')

@section('title', $sponsor->name)
@section('meta_description', $sponsor->summary ?? "Visit Karatu's partnership with {$sponsor->name}.")
@if($sponsor->hero_image_url)
    @section('og_image', $sponsor->hero_image_url)
@endif

@section('content')

{{-- Hero --}}
<section class="relative bg-forest-950 text-white">
    @if($sponsor->hero_image_url)
        <div class="absolute inset-0">
            <img src="{{ $sponsor->hero_image_url }}" alt="" class="w-full h-full object-cover opacity-40">
            <div class="absolute inset-0 bg-gradient-to-b from-forest-950/60 to-forest-950/90"></div>
        </div>
    @endif
    <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <nav class="text-xs text-forest-300 mb-4 flex items-center gap-1.5">
            <a href="{{ route('home') }}" class="hover:text-white transition">Home</a><span>/</span>
            <a href="{{ route('sports-sponsorships') }}" class="hover:text-white transition">Sports Sponsorships</a>
        </nav>
        <p class="text-forest-300 uppercase tracking-widest text-xs font-semibold mb-2">{{ $sponsor->tier ?: 'Partner' }}</p>
        <h1 class="text-4xl sm:text-5xl font-extrabold">{{ $sponsor->name }}</h1>
        @if($sponsor->summary)<p class="text-forest-100 text-lg mt-4 max-w-2xl">{{ $sponsor->summary }}</p>@endif
    </div>
</section>

<div class="bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            {{-- About --}}
            <div class="lg:col-span-2">
                <h2 class="text-2xl font-bold text-gray-900 mb-5">About the Partnership</h2>
                @if($sponsor->body)
                    <div class="prose max-w-none text-gray-700 leading-relaxed space-y-4">{!! nl2br(e($sponsor->body)) !!}</div>
                @else
                    <p class="text-gray-500">Details about this partnership are coming soon.</p>
                @endif
            </div>

            {{-- Sidebar --}}
            <aside class="space-y-6">
                <div class="bg-gray-50 rounded-2xl p-6 text-center">
                    @if($sponsor->logo_url)
                        <img src="{{ $sponsor->logo_url }}" alt="{{ $sponsor->name }}" class="max-h-24 mx-auto object-contain mb-4">
                    @endif
                    @if($sponsor->website_url)
                        <a href="{{ $sponsor->website_url }}" target="_blank" rel="noopener"
                           class="btn-primary w-full inline-block py-2.5">Visit website</a>
                    @endif
                </div>
            </aside>
        </div>

        @if($others->isNotEmpty())
            <div class="mt-16 pt-10 border-t border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Other partnerships</h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
                    @foreach($others as $o)
                        <a href="{{ route('partners.show', $o) }}" class="group text-center">
                            <div class="rounded-2xl overflow-hidden aspect-[4/3] bg-gray-50 flex items-center justify-center mb-2">
                                @if($o->hero_image_url || $o->logo_url)
                                    <img loading="lazy" src="{{ $o->hero_image_url ?? $o->logo_url }}" alt="{{ $o->name }}"
                                         class="w-full h-full {{ $o->hero_image_url ? 'object-cover' : 'object-contain p-4' }} group-hover:scale-105 transition-transform duration-500">
                                @endif
                            </div>
                            <p class="text-sm font-semibold text-gray-800 group-hover:text-forest-700 transition">{{ $o->name }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

@endsection
