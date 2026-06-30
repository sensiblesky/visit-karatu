<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <title>{{ setting('site_name', config('app.name', 'VisitKaratu')) }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex">

        {{-- Left: brand panel --}}
        <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden">
            <img src="https://images.unsplash.com/photo-1516426122078-c23e76319801?w=1200&q=85"
                 alt="Karatu landscape" class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-br from-forest-900/80 to-forest-950/90"></div>
            <div class="relative z-10 flex flex-col justify-between p-12 text-white">
                <a href="{{ route('home') }}" class="inline-flex items-center">
                    <img src="{{ asset('images/logo-white.png') }}" alt="{{ setting('site_name', 'Visit Karatu') }}" class="h-14 w-auto">
                </a>
                <div>
                    <h2 class="text-4xl font-extrabold leading-tight mb-4">Your gateway to<br>Northern Tanzania</h2>
                    <p class="text-forest-200 text-lg leading-relaxed max-w-md">
                        List your lodge, tour, or attraction and reach thousands of travellers planning their Ngorongoro adventure.
                    </p>
                </div>
                <div class="flex items-center gap-6 text-sm text-forest-300">
                    <span>Ngorongoro Crater</span>
                    <span class="w-1 h-1 bg-forest-400 rounded-full"></span>
                    <span>Lake Eyasi</span>
                    <span class="w-1 h-1 bg-forest-400 rounded-full"></span>
                    <span>Lake Manyara</span>
                </div>
            </div>
        </div>

        {{-- Right: form panel --}}
        <div class="flex-1 flex flex-col justify-center items-center px-6 py-12 bg-gray-50">
            <a href="{{ route('home') }}" class="lg:hidden inline-flex items-center mb-8">
                <img src="{{ asset('images/logo.png') }}" alt="{{ setting('site_name', 'Visit Karatu') }}" class="h-12 w-auto">
            </a>

            <div class="w-full sm:max-w-md bg-white shadow-sm border border-gray-100 rounded-3xl p-8">
                {{ $slot }}
            </div>

            <a href="{{ route('home') }}" class="mt-6 text-sm text-gray-400 hover:text-forest-600 transition flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/></svg>
                Back to homepage
            </a>
        </div>
    </div>
</body>
</html>
