<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <title>@yield('title', setting('site_name', 'Visit Karatu')) | {{ setting('site_tagline', 'Discover. Experience. Karatu.') }}</title>
    <meta name="description" content="@yield('meta_description', setting('hero_subtitle', 'Karatu is your gateway to Ngorongoro, Lake Manyara, Lake Eyasi and unforgettable cultural experiences.'))">

    {{-- Open Graph / Twitter --}}
    @php $ogImage = trim($__env->yieldContent('og_image')) ?: asset('images/placeholders/savanna.jpg'); @endphp
    <meta property="og:site_name" content="{{ setting('site_name', 'Visit Karatu') }}">
    <meta property="og:title" content="@yield('title', setting('site_name', 'Visit Karatu'))">
    <meta property="og:description" content="@yield('meta_description', setting('hero_subtitle', 'Discover Karatu, Tanzania.'))">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', setting('site_name', 'Visit Karatu'))">
    <meta name="twitter:description" content="@yield('meta_description', setting('hero_subtitle', 'Discover Karatu, Tanzania.'))">
    <meta name="twitter:image" content="{{ $ogImage }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        /* Visible keyboard focus for accessibility (WCAG 2.4.7) */
        a:focus-visible, button:focus-visible, [role="button"]:focus-visible,
        input:focus-visible, select:focus-visible, textarea:focus-visible {
            outline: 2px solid #166534; outline-offset: 2px; border-radius: 4px;
        }
        /* Skip-to-content link (WCAG 2.4.1) — hidden until focused */
        .skip-link {
            position: absolute; left: 1rem; top: -3rem; z-index: 100;
            background: #166534; color: #fff; padding: 0.6rem 1rem; border-radius: 0.5rem;
            font-size: 0.875rem; font-weight: 600; transition: top 0.15s ease;
        }
        .skip-link:focus { top: 1rem; }
    </style>
    @stack('styles')
    @stack('head')
</head>
<body class="font-sans bg-white text-gray-900">

<a href="#main" class="skip-link">Skip to content</a>

{{-- ===== NAVBAR ===== --}}
<header x-data="{ mobileOpen: false, scrolled: false }"
        x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 20)"
        :class="scrolled ? 'bg-white shadow-md' : 'bg-white/95 backdrop-blur-sm shadow-sm'"
        class="sticky top-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-18 py-3">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center shrink-0">
                <img loading="lazy" decoding="async" src="{{ asset('images/logo.png') }}" alt="{{ setting('site_name', 'Visit Karatu') }}" class="h-11 w-auto">
            </a>

            {{-- Desktop nav --}}
            <nav class="hidden lg:flex items-center gap-1">
                <a href="{{ route('home') }}" class="nav-link px-3 py-2 rounded-lg hover:bg-gray-50">Home</a>

                {{-- Explore dropdown --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.away="open = false"
                            :aria-expanded="open" aria-haspopup="true"
                            class="nav-link px-3 py-2 rounded-lg hover:bg-gray-50 flex items-center gap-1">
                        Explore
                        <svg class="w-4 h-4 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-transition x-cloak
                         class="absolute top-full left-0 mt-1 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50">
                        @foreach(\App\Models\Category::orderBy('sort_order')->get() as $cat)
                            <a href="{{ route('listings.category', $cat->slug) }}"
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-forest-50 hover:text-forest-700 transition-colors">
                                {{ $cat->name }}
                            </a>
                        @endforeach
                        <div class="my-1 border-t border-gray-100"></div>
                        <a href="{{ route('things-to-do') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-forest-50 hover:text-forest-700 transition-colors">Things to Do</a>
                        <a href="{{ route('listings.map') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-forest-50 hover:text-forest-700 transition-colors">Map View</a>
                        <a href="{{ route('events.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-forest-50 hover:text-forest-700 transition-colors">Events</a>
                    </div>
                </div>

                <a href="{{ route('listings.category', 'lodges-hotels') }}" class="nav-link px-3 py-2 rounded-lg hover:bg-gray-50">Stay</a>

                {{-- News dropdown --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.away="open = false"
                            :aria-expanded="open" aria-haspopup="true"
                            class="nav-link px-3 py-2 rounded-lg hover:bg-gray-50 flex items-center gap-1">
                        News
                        <svg class="w-4 h-4 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-transition x-cloak
                         class="absolute top-full left-0 mt-1 w-52 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50">
                        <a href="{{ route('news.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-forest-50 hover:text-forest-700 transition-colors">Latest News</a>
                        <a href="{{ route('news.videos') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-forest-50 hover:text-forest-700 transition-colors">Videos &amp; Live</a>
                        <a href="{{ route('news.archive') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-forest-50 hover:text-forest-700 transition-colors">Archive</a>
                    </div>
                </div>

                {{-- Partner dropdown --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.away="open = false"
                            :aria-expanded="open" aria-haspopup="true"
                            class="nav-link px-3 py-2 rounded-lg hover:bg-gray-50 flex items-center gap-1">
                        Partner
                        <svg class="w-4 h-4 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-transition x-cloak
                         class="absolute top-full left-0 mt-1 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50">
                        <a href="{{ route('invest') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-forest-50 hover:text-forest-700 transition-colors">Invest in Karatu</a>
                        <a href="{{ route('sports-sponsorships') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-forest-50 hover:text-forest-700 transition-colors">Sports Sponsorships</a>
                        <a href="{{ route('sponsors.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-forest-50 hover:text-forest-700 transition-colors">Partners &amp; Sponsors</a>
                        <div class="my-1 border-t border-gray-100"></div>
                        <a href="{{ route('sponsors.index') }}#become-a-sponsor" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-forest-50 hover:text-forest-700 transition-colors">Become a Sponsor</a>
                    </div>
                </div>

                {{-- About dropdown --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.away="open = false"
                            :aria-expanded="open" aria-haspopup="true"
                            class="nav-link px-3 py-2 rounded-lg hover:bg-gray-50 flex items-center gap-1">
                        About
                        <svg class="w-4 h-4 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-transition x-cloak
                         class="absolute top-full left-0 mt-1 w-52 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50">
                        <a href="{{ route('about') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-forest-50 hover:text-forest-700 transition-colors">About Karatu</a>
                        <a href="{{ route('district-council') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-forest-50 hover:text-forest-700 transition-colors">District Council</a>
                    </div>
                </div>
            </nav>

            {{-- Right actions --}}
            <div class="flex items-center gap-2">
                @php
                    $vkLanguages = ['en' => 'English', 'sw' => 'Kiswahili', 'fr' => 'Français', 'de' => 'Deutsch'];
                    $vkCurrent = 'en';
                    if (($gt = request()->cookie('googtrans')) && preg_match('~/en/(\w+)~', $gt, $m) && isset($vkLanguages[$m[1]])) {
                        $vkCurrent = $m[1];
                    }
                @endphp

                {{-- Personalized language menu (drives Google Translate under the hood) --}}
                <div x-data="{ open: false }" class="relative notranslate hidden sm:block">
                    <button @click="open = !open" @click.away="open = false"
                            :aria-expanded="open" aria-haspopup="true" aria-label="Change language"
                            class="flex items-center gap-1.5 px-2.5 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-50 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/></svg>
                        <span class="font-medium">{{ strtoupper($vkCurrent) }}</span>
                        <svg class="w-3.5 h-3.5 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-transition x-cloak
                         class="absolute right-0 top-full mt-2 w-44 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50">
                        @foreach($vkLanguages as $code => $label)
                            <button type="button" onclick="vkSetLanguage('{{ $code }}')"
                                    class="flex items-center justify-between w-full text-left px-4 py-2.5 text-sm hover:bg-forest-50 transition-colors {{ $vkCurrent === $code ? 'text-forest-700 font-semibold' : 'text-gray-700' }}">
                                {{ $label }}
                                @if($vkCurrent === $code)
                                    <svg class="w-4 h-4 text-forest-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                @endif
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Hidden Google Translate engine (widget UI is fully suppressed via CSS) --}}
                <div id="google_translate_element" aria-hidden="true"></div>

                @auth
                    @if(auth()->user()->isStakeholder() || auth()->user()->isAdmin())
                        <a href="{{ route('dashboard.index') }}"
                           class="hidden sm:inline-flex items-center gap-1.5 text-sm font-medium text-forest-700 hover:text-forest-900 px-3 py-2 rounded-lg hover:bg-forest-50 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/></svg>
                            Dashboard
                        </a>
                    @endif
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.index') }}"
                           class="hidden sm:inline-flex text-xs font-bold text-red-600 border border-red-200 px-3 py-1.5 rounded-lg hover:bg-red-50 transition">
                            Admin
                        </a>
                    @endif
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" @click.away="open = false"
                                :aria-expanded="open" aria-haspopup="true" aria-label="Account menu"
                                class="w-9 h-9 rounded-full bg-forest-700 text-white text-sm font-bold flex items-center justify-center hover:bg-forest-800 transition">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </button>
                        <div x-show="open" x-transition x-cloak
                             class="absolute right-0 top-full mt-2 w-48 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50">
                            <div class="px-4 py-2 border-b border-gray-100 mb-1">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="flex items-center gap-2 w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">Logout</button>
                            </form>
                        </div>
                    </div>
                @endauth

                {{-- Mobile menu toggle --}}
                <button @click="mobileOpen = !mobileOpen" :aria-expanded="mobileOpen" aria-label="Toggle menu" aria-controls="mobile-menu" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition">
                    <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="mobileOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div id="mobile-menu" x-show="mobileOpen" x-transition x-cloak class="lg:hidden border-t border-gray-100 bg-white">
        <div class="px-4 py-4 space-y-1">
            @php
                $mLink = 'block px-4 py-2.5 text-sm font-medium text-gray-700 rounded-xl hover:bg-forest-50 hover:text-forest-700';
                $mSub = 'block pl-8 pr-4 py-2 text-sm text-gray-600 rounded-xl hover:bg-forest-50 hover:text-forest-700';
                $mGroup = 'w-full flex items-center justify-between px-4 py-2.5 text-sm font-medium text-gray-700 rounded-xl hover:bg-forest-50 hover:text-forest-700';
            @endphp
            <a href="{{ route('home') }}" class="{{ $mLink }}">Home</a>

            {{-- Explore --}}
            <div x-data="{ open: false }">
                <button @click="open = !open" :aria-expanded="open" class="{{ $mGroup }}">
                    Explore
                    <svg class="w-4 h-4 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open" x-transition x-cloak>
                    @foreach(\App\Models\Category::orderBy('sort_order')->get() as $cat)
                        <a href="{{ route('listings.category', $cat->slug) }}" class="{{ $mSub }}">{{ $cat->name }}</a>
                    @endforeach
                    <a href="{{ route('things-to-do') }}" class="{{ $mSub }}">Things to Do</a>
                    <a href="{{ route('listings.map') }}" class="{{ $mSub }}">Map View</a>
                    <a href="{{ route('events.index') }}" class="{{ $mSub }}">Events</a>
                </div>
            </div>

            <a href="{{ route('listings.category', 'lodges-hotels') }}" class="{{ $mLink }}">Stay</a>

            {{-- News --}}
            <div x-data="{ open: false }">
                <button @click="open = !open" :aria-expanded="open" class="{{ $mGroup }}">
                    News
                    <svg class="w-4 h-4 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open" x-transition x-cloak>
                    <a href="{{ route('news.index') }}" class="{{ $mSub }}">Latest News</a>
                    <a href="{{ route('news.videos') }}" class="{{ $mSub }}">Videos & Live</a>
                    <a href="{{ route('news.archive') }}" class="{{ $mSub }}">Archive</a>
                </div>
            </div>

            {{-- Partner --}}
            <div x-data="{ open: false }">
                <button @click="open = !open" :aria-expanded="open" class="{{ $mGroup }}">
                    Partner
                    <svg class="w-4 h-4 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open" x-transition x-cloak>
                    <a href="{{ route('invest') }}" class="{{ $mSub }}">Invest in Karatu</a>
                    <a href="{{ route('sports-sponsorships') }}" class="{{ $mSub }}">Sports Sponsorships</a>
                    <a href="{{ route('sponsors.index') }}" class="{{ $mSub }}">Partners & Sponsors</a>
                    <a href="{{ route('sponsors.index') }}#become-a-sponsor" class="{{ $mSub }}">Become a Sponsor</a>
                </div>
            </div>

            {{-- About --}}
            <div x-data="{ open: false }">
                <button @click="open = !open" :aria-expanded="open" class="{{ $mGroup }}">
                    About
                    <svg class="w-4 h-4 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open" x-transition x-cloak>
                    <a href="{{ route('about') }}" class="{{ $mSub }}">About Karatu</a>
                    <a href="{{ route('district-council') }}" class="{{ $mSub }}">District Council</a>
                </div>
            </div>

            {{-- Language --}}
            <div class="pt-3 mt-2 border-t border-gray-100 notranslate">
                <p class="px-4 text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Language</p>
                <div class="grid grid-cols-2 gap-1">
                    @foreach($vkLanguages as $code => $label)
                        <button type="button" onclick="vkSetLanguage('{{ $code }}')"
                                class="text-left px-4 py-2 text-sm rounded-xl hover:bg-forest-50 {{ $vkCurrent === $code ? 'text-forest-700 font-semibold' : 'text-gray-700' }}">{{ $label }}</button>
                    @endforeach
                </div>
            </div>
            @auth
                <div class="pt-3 border-t border-gray-100 flex flex-col gap-2">
                    <a href="{{ route('dashboard.index') }}" class="btn-outline text-sm py-2.5 text-center">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}">@csrf<button class="w-full text-sm text-red-600 py-2">Logout</button></form>
                </div>
            @endauth
        </div>
    </div>
</header>

{{-- ===== BREAKING NEWS TICKER ===== --}}
@php $breakingNews = \App\Models\Post::breaking()->latestFirst()->limit(6)->get(); @endphp
@if($breakingNews->isNotEmpty())
    <div x-data="{ show: true }" x-show="show" class="bg-red-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-4 h-11">
                <span class="hidden sm:inline-flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-wider shrink-0">
                    <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span> Breaking
                </span>
                <div class="flex-1 overflow-hidden">
                    <div class="flex items-center gap-10 whitespace-nowrap animate-[ticker_30s_linear_infinite] hover:[animation-play-state:paused]">
                        @foreach($breakingNews as $bn)
                            <a href="{{ route('news.show', $bn) }}" class="text-sm font-medium hover:underline shrink-0">{{ $bn->title }}</a>
                            <span class="text-white/40 shrink-0">•</span>
                        @endforeach
                        {{-- duplicate for seamless loop --}}
                        @foreach($breakingNews as $bn)
                            <a href="{{ route('news.show', $bn) }}" class="text-sm font-medium hover:underline shrink-0" aria-hidden="true">{{ $bn->title }}</a>
                            <span class="text-white/40 shrink-0">•</span>
                        @endforeach
                    </div>
                </div>
                <button @click="show = false" class="shrink-0 opacity-70 hover:opacity-100" aria-label="Dismiss">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    </div>
    @push('styles')
    <style>@keyframes ticker { from { transform: translateX(0); } to { transform: translateX(-50%); } }</style>
    @endpush
@endif

{{-- Flash messages --}}
@if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
         class="fixed top-20 right-4 z-50 bg-forest-700 text-white px-5 py-3.5 rounded-2xl shadow-xl flex items-center gap-3 text-sm font-medium">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') }}
        <button @click="show = false" class="ml-2 opacity-70 hover:opacity-100">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
@endif
@if(session('error'))
    <div class="fixed top-20 right-4 z-50 bg-red-600 text-white px-5 py-3.5 rounded-2xl shadow-xl text-sm font-medium">
        {{ session('error') }}
    </div>
@endif

<main id="main" tabindex="-1">
    {{-- Supports both @extends('layouts.app') pages (@yield) and Breeze's
         <x-app-layout> component pages such as the profile page ($slot). --}}
    @yield('content')
    @isset($slot){{ $slot }}@endisset
</main>

{{-- ===== FOOTER ===== --}}
<footer class="bg-forest-950 text-white">
    {{-- Newsletter --}}
    <div class="border-b border-forest-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="max-w-md">
                <h3 class="text-lg font-bold text-white mb-1">Get Karatu news in your inbox</h3>
                <p class="text-sm text-forest-300">New stories, events and travel tips. No spam.</p>
            </div>
            <form method="POST" action="{{ route('newsletter.subscribe') }}" class="flex gap-2 w-full md:w-auto md:min-w-[26rem]">
                @csrf
                <input type="text" name="company" tabindex="-1" autocomplete="off" class="hidden" aria-hidden="true">
                <label for="nl_email" class="sr-only">Email address</label>
                <input id="nl_email" type="email" name="email" required placeholder="you@email.com"
                       class="flex-1 rounded-xl border-0 text-gray-900 px-4 py-3 text-sm focus:ring-2 focus:ring-forest-400">
                <button class="bg-white text-forest-900 font-semibold px-6 rounded-xl hover:bg-forest-50 transition whitespace-nowrap">Subscribe</button>
            </form>
        </div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
            <div class="lg:col-span-1">
                <a href="{{ route('home') }}" class="inline-flex items-center mb-4">
                    <img loading="lazy" decoding="async" src="{{ asset('images/logo-white.png') }}" alt="{{ setting('site_name', 'Visit Karatu') }}" class="h-14 w-auto">
                </a>
                <p class="text-forest-300 text-sm leading-relaxed">{{ setting('footer_about', 'Your gateway to Ngorongoro Crater, Lake Eyasi, Lake Manyara, and the heart of northern Tanzania.') }}</p>
                <div class="flex gap-3 mt-5">
                    @if($fb = setting('social_facebook'))
                        <a href="{{ $fb }}" target="_blank" aria-label="Facebook" class="w-9 h-9 rounded-full bg-forest-800 flex items-center justify-center text-forest-300 hover:bg-forest-600 hover:text-white transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                    @endif
                    @if($ig = setting('social_instagram'))
                        <a href="{{ $ig }}" target="_blank" aria-label="Instagram" class="w-9 h-9 rounded-full bg-forest-800 flex items-center justify-center text-forest-300 hover:bg-forest-600 hover:text-white transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        </a>
                    @endif
                    @if($li = setting('social_linkedin'))
                        <a href="{{ $li }}" target="_blank" aria-label="LinkedIn" class="w-9 h-9 rounded-full bg-forest-800 flex items-center justify-center text-forest-300 hover:bg-forest-600 hover:text-white transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                    @endif
                </div>
            </div>
            <div>
                <h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Explore Karatu</h4>
                <ul class="space-y-2.5">
                    @foreach(\App\Models\Category::orderBy('sort_order')->get() as $cat)
                        <li><a href="{{ route('listings.category', $cat->slug) }}" class="text-sm text-forest-300 hover:text-white transition">{{ $cat->name }}</a></li>
                    @endforeach
                    <li><a href="{{ route('events.index') }}" class="text-sm text-forest-300 hover:text-white transition">Events</a></li>
                    <li><a href="{{ route('listings.map') }}" class="text-sm text-forest-300 hover:text-white transition">Map View</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">More</h4>
                <ul class="space-y-2.5">
                    <li><a href="{{ route('about') }}" class="text-sm text-forest-300 hover:text-white transition">About Karatu</a></li>
                    <li><a href="{{ route('sponsors.index') }}" class="text-sm text-forest-300 hover:text-white transition">Partners & Sponsors</a></li>
                    <li><a href="{{ route('sponsors.index') }}#become-a-sponsor" class="text-sm text-forest-300 hover:text-white transition">Become a Sponsor</a></li>
                    <li><a href="{{ route('district-council') }}" class="text-sm text-forest-300 hover:text-white transition">District Council</a></li>
                    <li><a href="mailto:{{ setting('contact_email', 'info@visitkaratu.com') }}" class="text-sm text-forest-300 hover:text-white transition">List Your Business</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Contact</h4>
                <ul class="space-y-3 text-sm text-forest-300">
                    <li class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 mt-0.5 shrink-0 text-forest-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ setting('contact_address', 'Karatu Town, Arusha Region, Tanzania') }}
                    </li>
                    <li class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 mt-0.5 shrink-0 text-forest-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        {{ setting('contact_email', 'info@visitkaratu.com') }}
                    </li>
                    <li class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 mt-0.5 shrink-0 text-forest-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        {{ setting('contact_phone', '+255 748 859 172') }}
                    </li>
                </ul>
            </div>
        </div>
        <div class="border-t border-forest-900 pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-forest-500">
            <span>&copy; {{ date('Y') }} {{ setting('site_name', 'VisitKaratu') }}. All rights reserved.</span>
            <div class="flex gap-6">
                <a href="{{ route('privacy') }}" class="hover:text-forest-300 transition">Privacy Policy</a>
                <a href="{{ route('terms') }}" class="hover:text-forest-300 transition">Terms of Use</a>
            </div>
        </div>
    </div>
</footer>

{{-- Google Translate engine — UI fully hidden; driven by our own language menu --}}
<style>
    /* Suppress every part of Google's own widget & top banner */
    #google_translate_element { position: absolute; left: -9999px; height: 0; overflow: hidden; }
    .goog-te-banner-frame, .goog-te-banner-frame.skiptranslate,
    .goog-te-gadget-icon, iframe.skiptranslate, #goog-gt-tt, .goog-te-balloon-frame { display: none !important; }
    .goog-te-gadget { font-size: 0 !important; }
    body { top: 0 !important; position: static !important; }
    /* Google wraps translated text in <font> tags — keep them inheriting our styles */
    font { background: transparent !important; box-shadow: none !important; }
</style>
<script>
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'en,sw,fr,de',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
            autoDisplay: false
        }, 'google_translate_element');
    }

    // Manual choice from our menu: set the googtrans cookie and reload.
    function vkSetLanguage(lang) {
        var host = location.hostname;
        var expire = 'expires=Thu, 01 Jan 1970 00:00:00 GMT';
        // clear any existing value (all scopes)
        document.cookie = 'googtrans=;path=/;' + expire;
        document.cookie = 'googtrans=;path=/;domain=' + host + ';' + expire;
        document.cookie = 'googtrans=;path=/;domain=.' + host + ';' + expire;
        if (lang && lang !== 'en') {
            var val = '/en/' + lang;
            document.cookie = 'googtrans=' + val + ';path=/';
            document.cookie = 'googtrans=' + val + ';path=/;domain=.' + host;
        }
        // remember that the visitor made a choice, so auto-detect never overrides it
        document.cookie = 'vk_lang_seen=1;path=/;max-age=' + (60 * 60 * 24 * 365);
        location.reload();
    }
</script>
<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" async></script>

{{-- Cookie consent (shown once; choice remembered in localStorage) --}}
<div x-data="{ show: false }" x-init="show = !localStorage.getItem('vk_cookie_consent')"
     x-show="show" x-transition x-cloak
     class="fixed bottom-4 inset-x-4 sm:inset-x-auto sm:right-6 sm:max-w-sm z-[60] bg-white rounded-2xl shadow-2xl border border-gray-100 p-5">
    <p class="text-sm font-semibold text-gray-900 mb-1">We use cookies</p>
    <p class="text-xs text-gray-500 leading-relaxed mb-4">
        Essential cookies keep the site running; we also use a cookie to remember your language.
        See our <a href="{{ route('privacy') }}" class="text-forest-700 underline">Privacy Policy</a>.
    </p>
    <div class="flex gap-2">
        <button @click="localStorage.setItem('vk_cookie_consent','accepted'); show = false"
                class="flex-1 bg-forest-700 text-white text-sm font-semibold py-2 rounded-xl hover:bg-forest-800 transition">Accept</button>
        <button @click="localStorage.setItem('vk_cookie_consent','declined'); show = false"
                class="px-4 text-sm font-medium text-gray-500 hover:text-gray-700 transition">Decline</button>
    </div>
</div>

@livewireScripts
@stack('scripts')
</body>
</html>
