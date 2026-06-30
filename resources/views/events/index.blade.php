@extends('layouts.app')

@section('title', 'Events in Karatu')
@section('meta_description', "What's happening in and around Karatu — festivals, markets, and cultural events.")

@section('content')

{{-- Page header --}}
<div class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <nav class="text-xs text-gray-400 mb-2 flex items-center gap-1.5">
            <a href="{{ route('home') }}" class="hover:text-forest-600 transition">Home</a>
            <span>/</span>
            <span class="text-gray-600">Events</span>
        </nav>
        <h1 class="text-2xl font-bold text-gray-900">Events in Karatu</h1>
        <p class="text-sm text-gray-500 mt-1">Festivals, markets and cultural happenings in and around Karatu</p>
    </div>
</div>

<div class="bg-gray-50 min-h-[60vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @if($events->isEmpty())
            <div class="bg-white rounded-3xl p-20 text-center shadow-sm border border-gray-100">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-5">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">No upcoming events</h3>
                <p class="text-gray-400 text-sm">Check back soon — new events are added regularly.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($events as $event)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300 group flex flex-col">
                        <div class="relative h-48 overflow-hidden bg-forest-100">
                            <img src="{{ $event->cover_image_url ?? 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=600&q=80' }}"
                                 alt="{{ $event->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            {{-- Date chip --}}
                            <div class="absolute top-3 left-3 bg-white rounded-xl shadow-sm px-3 py-2 text-center leading-none">
                                <div class="text-lg font-extrabold text-forest-700">{{ $event->starts_at->format('d') }}</div>
                                <div class="text-[10px] font-semibold text-gray-500 uppercase tracking-wide">{{ $event->starts_at->format('M') }}</div>
                            </div>
                        </div>
                        <div class="p-5 flex flex-col flex-1">
                            <p class="text-xs text-forest-600 font-semibold mb-1.5 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $event->starts_at->format('D, d M Y · H:i') }}@if($event->ends_at) – {{ $event->ends_at->format('H:i') }}@endif
                            </p>
                            <h2 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-forest-700 transition leading-snug">{{ $event->title }}</h2>
                            @if($event->location)
                                <p class="text-sm text-gray-500 flex items-center gap-1.5 mb-3">
                                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $event->location->name }}
                                </p>
                            @endif
                            <p class="text-sm text-gray-600 line-clamp-3 leading-relaxed">{{ $event->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-8">{{ $events->links() }}</div>
        @endif
    </div>
</div>
@endsection
