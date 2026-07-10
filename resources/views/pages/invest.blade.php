@extends('layouts.app')

@section('title', 'Invest in Karatu')
@section('meta_description', 'Investment opportunities in Karatu, northern Tanzania: tourism, hospitality, agriculture and sport. A gateway to Ngorongoro and Lake Manyara.')

@section('content')

{{-- Hero --}}
<section class="relative overflow-hidden min-h-[380px] flex items-center">
    <div class="absolute inset-0">
        <img src="{{ setting('invest_hero_image', asset('images/placeholders/savanna.jpg')) }}" alt="Invest in Karatu" class="w-full h-full object-cover object-center">
        <div class="absolute inset-0 bg-gradient-to-b from-forest-950/70 to-forest-950/90"></div>
    </div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-white">
        <nav class="text-xs text-white/60 mb-3 flex items-center gap-1.5">
            <a href="{{ route('home') }}" class="hover:text-white transition">Home</a><span>/</span><span class="text-white/90">Invest</span>
        </nav>
        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-4 max-w-3xl">Invest in the Heart of Northern Tanzania</h1>
        <p class="text-lg text-white/80 max-w-2xl leading-relaxed">
            Karatu is the gateway to Ngorongoro, Lake Manyara and Lake Eyasi, one of Tanzania's fastest-growing
            tourism corridors, with room to grow in hospitality, agriculture, culture and sport.
        </p>
        <a href="#opportunities" class="btn-primary inline-block mt-8 px-8 py-3">Explore opportunities</a>
    </div>
</section>

{{-- Why Karatu --}}
<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-forest-600 uppercase tracking-widest text-xs font-semibold mb-2">Why Karatu</p>
            <h2 class="text-3xl font-bold text-gray-900">A destination on the rise</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach([
                ['stat' => '600k+', 'label' => 'Annual visitors to the Ngorongoro area, passing through Karatu'],
                ['stat' => '3', 'label' => 'Major attractions on the doorstep: Ngorongoro, Manyara, Eyasi'],
                ['stat' => '365', 'label' => 'Days of highland climate ideal for farming, coffee and hospitality'],
            ] as $item)
                <div class="bg-forest-50 rounded-2xl p-8 text-center">
                    <div class="text-4xl font-extrabold text-forest-700 mb-2">{{ $item['stat'] }}</div>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $item['label'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Opportunities --}}
<section id="opportunities" class="py-16 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="text-forest-600 uppercase tracking-widest text-xs font-semibold mb-2">Opportunities</p>
            <h2 class="text-3xl font-bold text-gray-900">Where to invest</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach([
                ['title' => 'Hospitality & Lodges', 'desc' => 'Lodges, tented camps, boutique hotels and eco-retreats serving the Ngorongoro visitor flow.', 'icon' => 'M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6'],
                ['title' => 'Agriculture & Agri-tourism', 'desc' => 'Coffee estates, wheat and horticulture in Karatu\'s fertile highlands, plus farm-to-table tourism.', 'icon' => 'M12 2C7 7 7 13 12 22C17 13 17 7 12 2z'],
                ['title' => 'Tourism & Experiences', 'desc' => 'Tour operators, cultural tourism with the Iraqw, Hadzabe and Datoga, and adventure experiences.', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3'],
                ['title' => 'Sport & Community', 'desc' => 'Football academies, sports facilities and community projects linking Karatu to clubs abroad.', 'icon' => 'M12 2a10 10 0 100 20 10 10 0 000-20zM2 12h20M12 2a15 15 0 010 20M12 2a15 15 0 000 20'],
            ] as $opp)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-7 flex gap-5">
                    <div class="w-12 h-12 rounded-xl bg-forest-100 text-forest-700 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="{{ $opp['icon'] }}"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-1.5">{{ $opp['title'] }}</h3>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $opp['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-forest-900 rounded-3xl p-10 sm:p-14 text-center text-white">
            <h2 class="text-3xl font-bold mb-3">Let's build Karatu together</h2>
            <p class="text-forest-100 mb-8 max-w-xl mx-auto">Talk to us about investment, partnerships and land in the Karatu district. We'll connect you with the right people on the ground.</p>
            <a href="mailto:{{ setting('contact_email', 'info@visitkaratu.com') }}?subject=Investment enquiry" class="inline-block bg-white text-forest-900 font-semibold px-8 py-3 rounded-xl hover:bg-forest-50 transition">Contact the team</a>
        </div>
    </div>
</section>

@endsection
