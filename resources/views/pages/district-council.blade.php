@extends('layouts.app')

@section('title', 'Karatu District Council')
@section('meta_description', 'Karatu District Council: local government supporting tourism, culture and community development in the Karatu district of northern Tanzania.')

@section('content')

{{-- Hero --}}
<section class="relative overflow-hidden min-h-[320px] flex items-center">
    <div class="absolute inset-0">
        <img src="/images/placeholders/savanna.jpg" alt="Karatu district" class="w-full h-full object-cover object-center">
        <div class="absolute inset-0 bg-gradient-to-b from-forest-950/75 to-forest-950/90"></div>
    </div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-white">
        <nav class="text-xs text-white/60 mb-3 flex items-center gap-1.5">
            <a href="{{ route('home') }}" class="hover:text-white transition">Home</a><span>/</span><span class="text-white/90">District Council</span>
        </nav>
        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-3">Karatu District Council</h1>
        <p class="text-lg text-white/80 max-w-2xl leading-relaxed">
            The local government authority guiding development, tourism and community services across the Karatu district.
        </p>
    </div>
</section>

{{-- Intro --}}
<section class="py-16 bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="prose prose-gray max-w-none text-gray-600 leading-relaxed">
            <p>
                Karatu District Council is the local government authority responsible for the Karatu district in the
                Arusha Region of northern Tanzania. The council oversees planning, infrastructure, health, education,
                agriculture and, importantly for visitors, the sustainable development of tourism across one of the
                country's most visited gateways to the Ngorongoro Conservation Area, Lake Eyasi and Lake Manyara.
            </p>
            <p>
                Working alongside communities, lodges, tour operators and cultural groups, the council supports
                responsible tourism that benefits residents while protecting the district's natural and cultural heritage.
            </p>
        </div>
    </div>
</section>

{{-- What the council does --}}
<section class="py-14 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">How the Council Supports Tourism</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach([
                ['title' => 'Licensing & Standards', 'text' => 'Registers and supports local businesses such as lodges, tour operators and cultural sites, helping maintain quality and safety standards for visitors.'],
                ['title' => 'Community Development', 'text' => 'Reinvests tourism revenue into schools, health services, water and roads that serve residents across the district.'],
                ['title' => 'Heritage & Environment', 'text' => 'Protects the district\'s landscapes and cultural heritage, promoting sustainable, community-based tourism.'],
            ] as $item)
                <div class="bg-white rounded-2xl p-6 border border-gray-100">
                    <div class="w-11 h-11 rounded-xl bg-forest-50 text-forest-700 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M3 21h18M4 18h16M6 18V9m4 9V9m4 9V9m4 9V9M4 9l8-5 8 5"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">{{ $item['title'] }}</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $item['text'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Contact --}}
<section class="py-16 bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Get in Touch</h2>
            <ul class="space-y-3 text-sm text-gray-600">
                <li class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-forest-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Karatu District Council Offices, Karatu Town, Arusha Region, Tanzania
                </li>
                <li class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-forest-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    info@karatudc.go.tz
                </li>
            </ul>
        </div>
        <div class="rounded-3xl overflow-hidden h-64 border border-gray-100">
            <iframe title="Karatu on the map" class="w-full h-full border-0" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    src="https://www.openstreetmap.org/export/embed.html?bbox=35.70%2C-3.40%2C35.87%2C-3.29&layer=mapnik&marker=-3.3428%2C35.7864"></iframe>
        </div>
    </div>
</section>

@endsection
