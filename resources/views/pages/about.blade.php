@extends('layouts.app')

@section('title', 'About Karatu')
@section('meta_description', 'Learn about Karatu, the highland gateway to Ngorongoro Crater, Lake Eyasi and Lake Manyara in northern Tanzania.')

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
            The highland gateway to Ngorongoro Crater, Lake Eyasi and Lake Manyara, at the heart of northern Tanzania's safari circuit.
        </p>
    </div>
</section>

{{-- Intro + stats --}}
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div>
            <p class="text-forest-600 text-sm font-semibold tracking-wide uppercase mb-3">Welcome to {{ setting('site_name', 'VisitKaratu') }}</p>
            <h2 class="text-3xl font-bold text-gray-900 mb-5">A cool green highland, surrounded by remarkable wildlife</h2>
            <div class="space-y-4 text-gray-600 leading-relaxed">
                <p>
                    Sitting at around 1,500 metres in the Ngorongoro highlands, Karatu is a lush farming town famous for its coffee
                    and wheat estates, crisp mountain air and warm hospitality. It is the natural base for exploring the Ngorongoro
                    Conservation Area, Lake Manyara National Park, and the ancient hunter-gatherer cultures of Lake Eyasi.
                </p>
                <p>
                    {{ setting('site_name', 'VisitKaratu') }} is a community directory that brings together the area's lodges, tour
                    operators, attractions, sport clubs and cultural experiences in one place, making it easy for travellers to
                    discover, compare and connect directly with local businesses.
                </p>
                <p>
                    Whether you are planning a full crater safari or simply passing through on the northern circuit,
                    Karatu offers a genuine, uncrowded side of Tanzania.
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

{{-- The Visit Karatu Project --}}
<section class="py-16 bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <p class="text-forest-600 text-sm font-semibold tracking-wide uppercase mb-2">The Visit Karatu Project</p>
            <h2 class="section-title">Building bridges between Tanzania and Switzerland</h2>
            <p class="text-gray-500 mt-3 max-w-3xl mx-auto leading-relaxed">Through sports, tourism and sustainable development.</p>
        </div>
        <div class="space-y-4 text-gray-600 leading-relaxed max-w-3xl mx-auto">
            <p>
                The Visit Karatu Project is a strategic initiative designed to promote Karatu District as a leading
                destination for tourism, sports, culture, investment and international partnerships.
            </p>
            <p>
                Through collaboration with the District Council of Karatu, the Tanzania Football Federation (TFF),
                the Njohole Foundation and FC Bavois of Switzerland, the project works to create lasting opportunities
                for youth, local communities and international partners, connecting the two countries through shared
                values of friendship, innovation and sustainable development.
            </p>
        </div>
    </div>
</section>

{{-- Vision & Mission --}}
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-forest-700 text-white rounded-3xl p-8 sm:p-10">
            <p class="text-forest-200 text-sm font-semibold tracking-wide uppercase mb-3">Our Vision</p>
            <p class="text-xl sm:text-2xl font-bold leading-snug">
                To position Karatu as an internationally recognised destination for tourism, sports development,
                culture and sustainable investment.
            </p>
        </div>
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8 sm:p-10">
            <p class="text-forest-600 text-sm font-semibold tracking-wide uppercase mb-4">Our Mission</p>
            <ul class="space-y-3 text-gray-600">
                @foreach([
                    'Promote Karatu worldwide.',
                    'Develop sports partnerships between Tanzania and Switzerland.',
                    'Support youth through education and sport.',
                    'Strengthen tourism and investment opportunities.',
                    'Build sustainable international cooperation.',
                ] as $point)
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-forest-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="leading-relaxed">{{ $point }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>

{{-- Official Launch Ceremony --}}
<section class="py-16 bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <p class="text-forest-600 text-sm font-semibold tracking-wide uppercase mb-2">Official Launch Ceremony</p>
            <h2 class="section-title">A day marking a long-term partnership</h2>
            <p class="text-gray-500 mt-3 max-w-2xl mx-auto leading-relaxed">
                The ceremony brings together partners from Tanzania and Switzerland to open the project and unveil
                the Visit Karatu website. Date and venue to be announced.
            </p>
        </div>

        <ol class="relative border-l-2 border-forest-100 ml-3 space-y-6">
            @foreach([
                ['14:00', 'Guest Reception', 'Registration, welcome by the protocol team and seating of guests.'],
                ['14:30', 'Official Opening Ceremony', 'National anthems, welcome address and presentation of the project vision, mission and objectives.'],
                ['14:50', 'Official Speeches', 'Remarks from the Guest of Honour and partners, including FC Bavois, Black Rhino Academy and the Njohole Foundation.'],
                ['15:40', 'Symbolic Partnership Ceremony', 'Signing of the partnership, exchange of gifts and presentation of the FC Bavois kit featuring the Visit Karatu logo.'],
                ['16:00', 'Multimedia Presentation', 'Discovering Karatu, the FC Bavois partnership, and the official unveiling of the Visit Karatu website.'],
                ['16:40', 'Cultural Entertainment', 'Traditional Tanzanian dance, entertainment, an interactive quiz and giveaways.'],
                ['18:00', 'Presentation of Partners', 'Recognition of strategic partners and exchange of commemorative plaques.'],
                ['18:30', 'Gala Dinner & Networking', 'Dinner, live music, media interviews and a networking session.'],
                ['22:00', 'Closing Ceremony', 'Vote of thanks and closing remarks.'],
            ] as $agenda)
                <li class="ml-6">
                    <span class="absolute -left-[9px] mt-1.5 w-4 h-4 rounded-full bg-forest-600 border-4 border-white"></span>
                    <div class="flex flex-col sm:flex-row sm:items-baseline sm:gap-3">
                        <span class="text-sm font-bold text-forest-700 shrink-0 w-14">{{ $agenda[0] }}</span>
                        <div>
                            <h3 class="font-bold text-gray-900">{{ $agenda[1] }}</h3>
                            <p class="text-sm text-gray-600 leading-relaxed mt-0.5">{{ $agenda[2] }}</p>
                        </div>
                    </div>
                </li>
            @endforeach
        </ol>
    </div>
</section>

{{-- Official partners --}}
<section class="py-16 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <p class="text-forest-600 text-sm font-semibold tracking-wide uppercase mb-2">In Partnership With</p>
            <h2 class="section-title">Our Partners</h2>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach([
                ['District Council of Karatu', 'Local government'],
                ['Black Rhino Academy-International', 'Strategic sports partner'],
                ['Tanzania Football Federation (TFF)', 'Federation partner'],
                ['Arusha Football Federation (AFF)', 'Regional football'],
                ['Njohole Foundation', 'Community & youth'],
                ['FC Bavois (Switzerland)', 'Founding football partner'],
                ['Visit Karatu Project Team', 'Coordination'],
            ] as $partner)
                <div class="bg-white rounded-2xl border border-gray-100 p-6 text-center flex flex-col justify-center">
                    <h3 class="font-bold text-gray-900 text-sm leading-snug">{{ $partner[0] }}</h3>
                    <p class="text-xs text-forest-600 mt-1.5">{{ $partner[1] }}</p>
                </div>
            @endforeach
        </div>
        <div class="mt-6 text-center">
            <a href="{{ route('sponsors.index') }}" class="text-sm font-semibold text-forest-700 hover:text-forest-800">See our partners &amp; sponsors</a>
        </div>
    </div>
</section>

{{-- Guiding quote --}}
<section class="bg-forest-900 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
        <svg class="w-10 h-10 text-forest-500 mx-auto mb-5" fill="currentColor" viewBox="0 0 24 24"><path d="M9.983 3v7.391c0 5.704-3.731 9.57-8.983 10.609l-.995-2.151c2.432-.917 3.995-3.638 3.995-5.849h-4v-10h9.983zm14.017 0v7.391c0 5.704-3.748 9.57-9 10.609l-.996-2.151c2.433-.917 3.996-3.638 3.996-5.849h-3.983v-10h9.983z"/></svg>
        <p class="text-2xl sm:text-3xl font-bold leading-snug">
            Together we connect communities, inspire young people and promote Karatu to the world.
        </p>
        <p class="text-forest-300 mt-6 text-sm">Visit Karatu Project &middot; Renatus Boniface Njohole &amp; Christian Weidmann</p>
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
                ['title' => 'By Air', 'text' => 'Fly into Kilimanjaro International Airport (JRO) or Arusha Airport, then drive 3–4 hours west to Karatu. For a quicker connection, take a domestic flight via Lake Manyara (Manyara) Airport, a short drive from Karatu.'],
                ['title' => 'By Road', 'text' => 'Karatu sits on the sealed road between Arusha and the Ngorongoro Gate, about 140 km from Arusha town.'],
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
