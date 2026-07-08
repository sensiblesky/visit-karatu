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

{{-- Sponsor grid by tier --}}
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @forelse($grouped as $tier => $items)
            <div class="mb-12 last:mb-0">
                <div class="flex items-center gap-4 mb-6">
                    <h2 class="text-lg font-bold text-gray-900">{{ $tier }}</h2>
                    <div class="flex-1 h-px bg-gray-100"></div>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($items as $sponsor)
                        @php $tag = $sponsor->website_url ? 'a' : 'div'; @endphp
                        <{{ $tag }}
                            @if($sponsor->website_url) href="{{ $sponsor->website_url }}" target="_blank" rel="noopener nofollow" @endif
                            class="group bg-gray-50 hover:bg-white border border-gray-100 hover:border-forest-200 rounded-2xl p-6 flex flex-col items-center justify-center text-center transition hover:shadow-md">
                            <div class="h-20 flex items-center justify-center mb-3">
                                @if($sponsor->logo_path)
                                    <img src="{{ Storage::url($sponsor->logo_path) }}" alt="{{ $sponsor->name }}" class="max-h-20 max-w-full object-contain">
                                @else
                                    <span class="text-lg font-bold text-gray-300">{{ $sponsor->name }}</span>
                                @endif
                            </div>
                            <p class="text-sm font-semibold text-gray-800 group-hover:text-forest-700 transition">{{ $sponsor->name }}</p>
                        </{{ $tag }}>
                    @endforeach
                </div>
            </div>
        @empty
            <p class="text-center text-gray-400 py-10">No sponsors listed yet.</p>
        @endforelse
    </div>
</section>

{{-- Become a sponsor --}}
<section id="become-a-sponsor" class="py-16 bg-gray-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-start">
            <div>
                <p class="text-forest-600 text-sm font-semibold tracking-wide uppercase mb-2">Get involved</p>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Become a Sponsor</h2>
                <p class="text-gray-600 leading-relaxed mb-5">
                    Put your brand in front of thousands of travellers and locals discovering Karatu. Partner with us to
                    support sustainable tourism, cultural heritage and grassroots football — and gain visibility across
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
                        <option value="Official Partner" @selected(old('tier')==='Official Partner')>Official Partner</option>
                        <option value="Gold Sponsor" @selected(old('tier')==='Gold Sponsor')>Gold Sponsor</option>
                        <option value="Silver Sponsor" @selected(old('tier')==='Silver Sponsor')>Silver Sponsor</option>
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
