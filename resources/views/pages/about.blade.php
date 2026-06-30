@extends('layouts.app')

@section('title', 'About Karatu')
@section('meta_description', 'Learn about Karatu — the highland gateway to Ngorongoro Crater, Lake Eyasi and Lake Manyara in northern Tanzania.')

@section('content')

{{-- Hero --}}
<section class="relative overflow-hidden min-h-[360px] flex items-center">
    <div class="absolute inset-0">
        <img loading="lazy" decoding="async" src="/images/placeholders/savanna.jpg"
             alt="Karatu highlands" class="w-full h-full object-cover object-center">
        <div class="absolute inset-0 bg-gradient-to-b from-forest-950/70 to-forest-950/85"></div>
    </div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-white">
        <nav class="text-xs text-white/60 mb-3 flex items-center gap-1.5">
            <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
            <span>/</span><span class="text-white/90">About Karatu</span>
        </nav>
        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-3">About Karatu</h1>
        <p class="text-lg text-white/80 max-w-2xl leading-relaxed">
            The highland gateway to Ngorongoro Crater, Lake Eyasi and Lake Manyara — and the heart of northern Tanzania's safari circuit.
        </p>
    </div>
</section>

{{-- Intro + stats --}}
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div>
            <p class="text-forest-600 text-sm font-semibold tracking-wide uppercase mb-3">Welcome to {{ setting('site_name', 'VisitKaratu') }}</p>
            <h2 class="text-3xl font-bold text-gray-900 mb-5">A cool green highland, surrounded by world-class wildlife</h2>
            <div class="space-y-4 text-gray-600 leading-relaxed">
                <p>
                    Sitting at around 1,500 metres in the Ngorongoro highlands, Karatu is a lush farming town famous for its coffee
                    and wheat estates, crisp mountain air and warm hospitality. It is the natural base for exploring the Ngorongoro
                    Conservation Area, Lake Manyara National Park, and the ancient hunter-gatherer cultures of Lake Eyasi.
                </p>
                <p>
                    {{ setting('site_name', 'VisitKaratu') }} is a community directory that brings together the area's lodges, tour
                    operators, attractions, sport clubs and cultural experiences in one place — making it easy for travellers to
                    discover, compare and connect directly with local businesses.
                </p>
                <p>
                    Whether you are planning a once-in-a-lifetime crater safari or simply passing through on the northern circuit,
                    Karatu offers an authentic, uncrowded slice of Tanzania.
                </p>
            </div>
            <div class="mt-8 flex flex-wrap gap-4">
                <a href="{{ route('listings.index') }}" class="btn-primary">Explore Listings</a>
                <a href="{{ route('events.index') }}" class="btn-outline">What's On</a>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="rounded-3xl overflow-hidden h-44 sm:h-56">
                <img loading="lazy" decoding="async" src="/images/placeholders/wildlife.jpg" alt="Wildlife" class="w-full h-full object-cover">
            </div>
            <div class="rounded-3xl overflow-hidden h-44 sm:h-56 mt-6">
                <img loading="lazy" decoding="async" src="/images/placeholders/culture.jpg" alt="Culture" class="w-full h-full object-cover">
            </div>
            <div class="rounded-3xl overflow-hidden h-44 sm:h-56 -mt-2">
                <img loading="lazy" decoding="async" src="/images/placeholders/lodge.jpg" alt="Lodge" class="w-full h-full object-cover">
            </div>
            <div class="rounded-3xl overflow-hidden h-44 sm:h-56 mt-4">
                <img loading="lazy" decoding="async" src="/images/placeholders/pool.jpg" alt="Pool" class="w-full h-full object-cover">
            </div>
        </div>
    </div>
</section>

{{-- Stats bar --}}
<section class="bg-forest-700 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid grid-cols-3 gap-6 text-center">
        <div>
            <div class="text-4xl font-extrabold">{{ $stats['listings'] }}+</div>
            <div class="text-forest-200 text-sm mt-1">Listings</div>
        </div>
        <div>
            <div class="text-4xl font-extrabold">{{ $stats['categories'] }}</div>
            <div class="text-forest-200 text-sm mt-1">Categories</div>
        </div>
        <div>
            <div class="text-4xl font-extrabold">{{ $stats['locations'] }}</div>
            <div class="text-forest-200 text-sm mt-1">Areas to explore</div>
        </div>
    </div>
</section>

{{-- What you'll find --}}
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <p class="text-forest-600 text-sm font-semibold tracking-wide uppercase mb-2">Explore</p>
            <h2 class="section-title">What You'll Find in Karatu</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($categories as $cat)
                <a href="{{ route('listings.category', $cat->slug) }}"
                   class="bg-white rounded-2xl border border-gray-100 hover:border-forest-200 hover:shadow-md p-5 text-center transition">
                    <h3 class="font-bold text-gray-900 text-sm">{{ $cat->name }}</h3>
                    @if($cat->description)
                        <p class="text-xs text-gray-500 mt-1.5 line-clamp-2">{{ $cat->description }}</p>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Getting here --}}
<section class="py-16 bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">Getting to Karatu</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach([
                ['title' => 'By Air', 'text' => 'Fly into Kilimanjaro International Airport (JRO) or Arusha Airport, then drive 3–4 hours west to Karatu.'],
                ['title' => 'By Road', 'text' => 'Karatu sits on the sealed road between Arusha and the Ngorongoro Gate — about 140 km from Arusha town.'],
                ['title' => 'Best Time', 'text' => 'Karatu is a year-round destination. June–October is dry-season prime time; the green season runs November–May.'],
            ] as $item)
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-2">{{ $item['title'] }}</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $item['text'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="relative py-20 overflow-hidden">
    <div class="absolute inset-0">
        <img loading="lazy" decoding="async" src="/images/placeholders/savanna.jpg" alt="" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-forest-900/85"></div>
    </div>
    <div class="relative z-10 max-w-3xl mx-auto text-center px-4">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Plan your Karatu adventure</h2>
        <p class="text-forest-200 mb-8">Browse lodges, tours and experiences, or list your own business on {{ setting('site_name', 'VisitKaratu') }}.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('listings.index') }}" class="bg-white text-forest-800 font-bold px-8 py-3.5 rounded-2xl hover:bg-forest-50 transition">Browse Listings</a>
            <a href="mailto:{{ setting('contact_email', 'info@visitkaratu.com') }}" class="border-2 border-white/40 text-white font-semibold px-8 py-3.5 rounded-2xl hover:bg-white/10 transition">List Your Business</a>
        </div>
    </div>
</section>

@endsection
