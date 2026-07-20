@extends('layouts.app')

@section('title', 'Hotel Partnership — Grow with Karatu')
@section('meta_description', 'A neutral, non-exclusive invitation for hotels and accommodation providers in and around Karatu to partner with Visit Karatu on destination promotion, visitor referrals, events and community initiatives.')

@section('content')

{{-- Hero --}}
<section class="relative overflow-hidden min-h-[420px] flex items-center bg-forest-950">
    <div class="absolute inset-0">
        <img src="{{ setting('hotel_partnership_hero_image', asset('images/placeholders/lodge.jpg')) }}" alt="Hotels and accommodation in Karatu" class="w-full h-full object-cover object-center opacity-40">
        <div class="absolute inset-0 bg-gradient-to-b from-forest-950/80 to-forest-950/95"></div>
    </div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-white w-full">
        <nav class="text-xs text-white/60 mb-3 flex items-center gap-1.5">
            <a href="{{ route('home') }}" class="hover:text-white transition">Home</a><span>/</span><span class="text-white/90">Hotel Partnership</span>
        </nav>
        <p class="text-forest-300 uppercase tracking-widest text-xs font-semibold mb-3">Hotel Partnership</p>
        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-4 max-w-3xl">Grow with Karatu</h1>
        <p class="text-lg text-white/80 max-w-2xl leading-relaxed">
            A shared platform for hospitality, destination visibility and community opportunity &mdash;
            open to hotels and accommodation providers of every size in and around Karatu.
        </p>
        <div class="mt-8 flex flex-wrap items-center gap-4">
            <a href="#get-in-touch" class="btn-primary inline-block px-8 py-3">Start a conversation</a>
            <div class="flex items-center gap-3 text-sm text-white/70">
                <img src="{{ asset('storage/sponsors/fc-bavois.png') }}" alt="FC Bavois" class="h-10 w-10 object-contain bg-white/95 rounded-lg p-1">
                <span>Premium Sports Partner<br><span class="text-white/90 font-semibold">FC Bavois &mdash; Switzerland</span></span>
            </div>
        </div>
    </div>
</section>

{{-- Neutral invitation --}}
<section class="bg-forest-50 border-b border-forest-100">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <p class="text-xs font-bold uppercase tracking-widest text-forest-700 mb-1">A neutral, non-exclusive invitation</p>
        <p class="text-gray-700">
            Visit Karatu invites hospitality partners to collaborate on destination promotion, visitor referrals, events,
            local experiences and responsible community initiatives. The programme is open to different types and sizes of
            hotels and does not give preference to any single establishment.
        </p>
    </div>
</section>

{{-- Why join --}}
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-3">Why join?</h2>
            <p class="text-gray-600">Coordinated promotion that helps participating hotels reach relevant audiences while
                contributing to the positive development and international profile of Karatu.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                ['n' => '1', 'title' => 'Destination Visibility', 'text' => 'Approved hotel information and offers featured through suitable Visit Karatu channels and campaigns.'],
                ['n' => '2', 'title' => 'Visitor Connections', 'text' => 'Potential referrals from travellers, sports groups, delegations, partners and media contacts.'],
                ['n' => '3', 'title' => 'Collaborative Experiences', 'text' => 'Combine accommodation with culture, tourism, sport and responsible local experiences.'],
                ['n' => '4', 'title' => 'Community Positioning', 'text' => 'Support transparent local and youth initiatives matched to the hotel’s capacity.'],
            ] as $item)
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 hover:shadow-md transition">
                    <div class="w-10 h-10 rounded-full bg-forest-600 text-white font-bold flex items-center justify-center mb-4">{{ $item['n'] }}</div>
                    <h3 class="font-bold text-gray-900 mb-2">{{ $item['title'] }}</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $item['text'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Participation options --}}
<section class="py-16 bg-gray-50 border-y border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-end justify-between gap-3 mb-10">
            <h2 class="text-3xl font-bold text-gray-900">Choose how you participate</h2>
            <span class="text-forest-700 text-sm font-semibold italic">Flexible participation</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-5">
            @foreach([
                ['title' => 'Promotional Partner', 'text' => 'Share approved content, destination offers and booking contacts for relevant Visit Karatu communications.'],
                ['title' => 'Hospitality Partner', 'text' => 'Provide agreed accommodation, meeting space, catering or guest services for specific activities or delegations.'],
                ['title' => 'Event Partner', 'text' => 'Support selected sports, cultural, networking or community events and launches.'],
                ['title' => 'Community Partner', 'text' => 'Contribute services, equipment, experiences or funding to a clearly defined local or youth-focused activity.'],
                ['title' => 'Strategic Partner', 'text' => 'Develop a broader annual collaboration with a documented activity plan, benefits, responsibilities and review schedule.'],
            ] as $opt)
                <div class="bg-white rounded-2xl p-6 border-l-4 border-forest-600 shadow-sm">
                    <h3 class="font-bold text-gray-900 mb-2">{{ $opt['title'] }}</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $opt['text'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Collaboration framework --}}
<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <h2 class="text-3xl font-bold text-gray-900 mb-3">The collaboration framework</h2>
            <p class="text-gray-600">A practical split of contributions. Specific benefits and contributions are confirmed in
                writing before any activity is activated.</p>
        </div>
        <div class="overflow-x-auto rounded-2xl border border-gray-200 shadow-sm">
            <table class="w-full text-left border-collapse min-w-[640px]">
                <thead>
                    <tr class="bg-forest-700 text-white text-sm">
                        <th class="px-5 py-3 font-semibold">Area</th>
                        <th class="px-5 py-3 font-semibold">Hotel contribution</th>
                        <th class="px-5 py-3 font-semibold">Visit Karatu contribution</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700 divide-y divide-gray-100">
                    @foreach([
                        ['Destination promotion', 'Provide verified hotel information, offers and approved images.', 'Feature participating hotels through suitable destination channels and campaigns.'],
                        ['Visitor referrals', 'Offer clear booking contacts, availability terms and agreed guest benefits.', 'Direct relevant enquiries, without guaranteeing booking volume.'],
                        ['Events & hospitality', 'Host or support agreed meetings, delegations, sports groups or community events.', 'Coordinate opportunities, schedules and communication with stakeholders.'],
                        ['Local experiences', 'Recommend local services, culture and responsible visitor activities.', 'Connect hotel offers with destination stories and approved local experiences.'],
                        ['Community support', 'Select suitable in-kind, service or financial support where possible.', 'Document the agreed purpose and provide proportionate impact reporting.'],
                    ] as $row)
                        <tr class="hover:bg-forest-50/40 transition">
                            <td class="px-5 py-4 font-semibold text-gray-900 whitespace-nowrap">{{ $row[0] }}</td>
                            <td class="px-5 py-4">{{ $row[1] }}</td>
                            <td class="px-5 py-4">{{ $row[2] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Clear. Fair. Practical. --}}
        <div class="mt-8 bg-forest-50 border border-forest-100 rounded-2xl p-6">
            <p class="text-xs font-bold uppercase tracking-widest text-forest-700 mb-1">Clear. Fair. Practical.</p>
            <p class="text-sm text-gray-700 leading-relaxed">
                Participation is voluntary, transparent and non-exclusive. Every activity, contribution, benefit and use of
                hotel branding is agreed in writing before activation. No exclusivity, booking volume, media reach or
                commercial return is implied unless expressly stated in a signed agreement.
            </p>
        </div>
    </div>
</section>

{{-- How it works --}}
<section class="py-16 bg-gray-50 border-y border-gray-100">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">How it works</h2>
        <ol class="space-y-4">
            @foreach([
                'Confirm the selected participation option and your authorised contact people.',
                'Agree the activities, timing, deliverables, brand use and any financial or in-kind contribution.',
                'Approve all public use of hotel names, logos, images, prices and offers before publication.',
                'Review progress at agreed intervals and record completed activities and practical outcomes.',
                'Either party can end or revise the collaboration under the terms of the final agreement.',
            ] as $i => $step)
                <li class="flex gap-4 bg-white rounded-2xl p-5 border border-gray-100">
                    <span class="shrink-0 w-8 h-8 rounded-full bg-forest-600 text-white text-sm font-bold flex items-center justify-center">{{ $i + 1 }}</span>
                    <p class="text-gray-700 leading-relaxed">{{ $step }}</p>
                </li>
            @endforeach
        </ol>
    </div>
</section>

{{-- Get in touch --}}
<section id="get-in-touch" class="relative py-20 overflow-hidden bg-forest-900 text-white">
    <div class="max-w-3xl mx-auto text-center px-4">
        <p class="text-forest-300 uppercase tracking-widest text-xs font-semibold mb-3">Let’s start with one practical activity</p>
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Arrange a short introductory meeting</h2>
        <p class="text-forest-100 mb-8 max-w-xl mx-auto leading-relaxed">
            We’d like to understand your hotel’s priorities and identify one practical first activity. After the meeting,
            a simple partnership note can define the option, contributions, benefits, schedule, contacts and approval process.
        </p>
        <div class="inline-block bg-white/10 border border-white/15 rounded-2xl px-8 py-6 text-left">
            <p class="text-xs uppercase tracking-widest text-forest-300 mb-1">Visit Karatu Project &mdash; Karatu, Tanzania</p>
            <p class="text-xl font-bold mb-3">Renatus Njohole</p>
            <div class="space-y-1.5 text-forest-100">
                <a href="mailto:renatusnjohole@hotmail.com" class="flex items-center gap-2 hover:text-white transition">
                    <svg class="w-4 h-4 text-forest-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    renatusnjohole@hotmail.com
                </a>
                <a href="tel:+41788791360" class="flex items-center gap-2 hover:text-white transition">
                    <svg class="w-4 h-4 text-forest-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    +41 78 879 13 60
                </a>
            </div>
        </div>
        <p class="text-forest-300 text-xs mt-6 tracking-widest uppercase">Sports &nbsp;|&nbsp; Tourism &nbsp;|&nbsp; Community</p>
    </div>
</section>

@endsection
