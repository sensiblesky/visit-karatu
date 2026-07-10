@extends('layouts.app')

@section('title', 'Partners & Sponsors')
@section('meta_description', 'Meet the partners and sponsors supporting tourism and football development in Karatu, and learn how your organisation can join them.')

@section('content')

{{-- Hero --}}
<section class="relative overflow-hidden min-h-[300px] flex items-center">
    <div class="absolute inset-0">
        <img src="/images/placeholders/savanna.jpg" alt="" class="w-full h-full object-cover object-center">
        <div class="absolute inset-0 bg-gradient-to-b from-forest-950/75 to-forest-950/90"></div>
    </div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 text-white">
        <nav class="text-xs text-white/60 mb-3 flex items-center gap-1.5">
            <a href="{{ route('home') }}" class="hover:text-white transition">Home</a><span>/</span><span class="text-white/90">Partners & Sponsors</span>
        </nav>
        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-3">Partners & Sponsors</h1>
        <p class="text-lg text-white/80 max-w-2xl leading-relaxed">
            Organisations working with us to promote tourism, culture and football development across Karatu.
        </p>
    </div>
</section>

{{-- Sponsor grid, graded by level --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-20">
        @forelse($grouped as $level => $items)
            @php
                $heading = $labels[$level] ?? ucfirst($level).' Sponsors';
                $isPlatinum = $level === 'platinum';
                $cols = $isPlatinum ? 'sm:grid-cols-2 lg:grid-cols-3' : 'sm:grid-cols-3 lg:grid-cols-4';
            @endphp
            <div>
                <div class="flex items-center gap-4 mb-8">
                    @if($isPlatinum)<span class="text-[10px] font-bold uppercase tracking-widest bg-gray-900 text-white px-2.5 py-1 rounded-full">Platinum</span>@endif
                    <h2 class="text-xl font-bold text-gray-900">{{ $heading }}</h2>
                    <div class="flex-1 h-px bg-gray-100"></div>
                </div>
                <div class="grid grid-cols-2 {{ $cols }} gap-6 sm:gap-8">
                    @foreach($items as $sponsor)
                        @php
                            // Sports partners get a rich detail page; others link out to their site.
                            $href = $sponsor->is_sports ? route('partners.show', $sponsor) : $sponsor->website_url;
                            $tag = $href ? 'a' : 'div';
                            $external = ! $sponsor->is_sports && $sponsor->website_url;
                        @endphp
                        <{{ $tag }}
                            @if($href) href="{{ $href }}" @if($external) target="_blank" rel="noopener nofollow" @endif @endif
                            class="group bg-gray-50 hover:bg-white border border-gray-100 hover:border-forest-200 rounded-2xl p-8 flex flex-col items-center justify-center text-center transition hover:shadow-md {{ $isPlatinum ? 'py-12' : '' }}">
                            <div class="{{ $isPlatinum ? 'h-28' : 'h-20' }} flex items-center justify-center mb-4">
                                @if($sponsor->logo_url)
                                    <img src="{{ $sponsor->logo_url }}" alt="{{ $sponsor->name }}" class="{{ $isPlatinum ? 'max-h-28' : 'max-h-20' }} max-w-full object-contain">
                                @else
                                    <span class="text-lg font-bold text-gray-300">{{ $sponsor->name }}</span>
                                @endif
                            </div>
                            <p class="{{ $isPlatinum ? 'text-base' : 'text-sm' }} font-semibold text-gray-800 group-hover:text-forest-700 transition">{{ $sponsor->name }}</p>
                            @if($sponsor->tier)<p class="text-xs text-gray-400 mt-0.5">{{ $sponsor->tier }}</p>@endif
                        </{{ $tag }}>
                    @endforeach
                </div>
            </div>
        @empty
            <p class="text-center text-gray-400 py-10">No sponsors listed yet.</p>
        @endforelse
    </div>
</section>

{{-- Sports partnerships callout (their logos live on the dedicated hub) --}}
@if($hasSportsPartners)
<section class="py-16 bg-forest-950 text-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-forest-300 text-sm font-semibold tracking-wide uppercase mb-2">On the world stage</p>
        <h2 class="text-3xl font-bold mb-4">Sports Partnerships</h2>
        <p class="text-white/80 max-w-2xl mx-auto leading-relaxed mb-7">
            From FC Bavois to the region's football federations, Karatu is building partnerships that put the
            district on the global sporting map. Meet the clubs and organisations behind them.
        </p>
        <a href="{{ route('sports-sponsorships') }}" class="btn-primary inline-flex">Explore Sports Sponsorships</a>
    </div>
</section>
@endif

{{-- Become a sponsor --}}
<section id="become-a-sponsor" class="py-16 bg-gray-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-start">
            <div>
                <p class="text-forest-600 text-sm font-semibold tracking-wide uppercase mb-2">Get involved</p>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Become a Sponsor</h2>
                <p class="text-gray-600 leading-relaxed mb-5">
                    Put your brand in front of thousands of travellers and locals discovering Karatu. Partner with us to
                    support sustainable tourism, cultural heritage and grassroots football, and gain visibility across
                    the site, events and the sports scene.
                </p>
                <ul class="space-y-2.5 text-sm text-gray-600">
                    @foreach(['Logo placement on the homepage & this partners page','Association with Karatu tourism & football events','A dedicated link to your website','Recognition across our channels'] as $benefit)
                        <li class="flex items-start gap-2.5">
                            <svg class="w-5 h-5 text-forest-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $benefit }}
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8">
                <h3 class="font-bold text-gray-900 mb-4">Register your interest</h3>

                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl p-3 mb-4">
                        <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('sponsors.apply') }}" enctype="multipart/form-data" class="space-y-3">
                    @csrf
                    <input type="text" name="website_hp" tabindex="-1" autocomplete="off" class="hidden" aria-hidden="true">

                    <input type="text" name="organisation" value="{{ old('organisation') }}" placeholder="Organisation / brand *" required class="form-input">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <input type="text" name="contact_name" value="{{ old('contact_name') }}" placeholder="Contact name *" required class="form-input">
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email *" required class="form-input">
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Phone" class="form-input">
                        <input type="url" name="website_url" value="{{ old('website_url') }}" placeholder="Website (https://...)" class="form-input">
                    </div>
                    <select name="tier" class="form-input">
                        <option value="">Preferred package (optional)</option>
                        <option value="Platinum" @selected(old('tier')==='Platinum')>Platinum (front-page & key pages)</option>
                        <option value="Gold" @selected(old('tier')==='Gold')>Gold</option>
                        <option value="Silver" @selected(old('tier')==='Silver')>Silver</option>
                    </select>
                    <textarea name="message" rows="3" placeholder="Tell us a little about your organisation..." class="form-input resize-y">{{ old('message') }}</textarea>
                    <div>
                        <label class="text-xs font-medium text-gray-500 block mb-1">Logo (optional)</label>
                        <input type="file" name="logo" accept="image/*"
                               class="text-sm text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-forest-50 file:text-forest-700 hover:file:bg-forest-100">
                    </div>
                    <button type="submit" class="btn-primary w-full justify-center">Submit Interest</button>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
