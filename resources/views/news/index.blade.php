@extends('layouts.app')

@section('title', 'News & Highlights')
@section('meta_description', "The latest news, headlines and highlights from Karatu: tourism, football, culture and community.")

@section('content')

{{-- Page header --}}
<div class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <nav class="text-xs text-gray-400 mb-2 flex items-center gap-1.5">
            <a href="{{ route('home') }}" class="hover:text-forest-600 transition">Home</a>
            <span>/</span>
            <span class="text-gray-600">News</span>
        </nav>
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">News &amp; Highlights</h1>
                <p class="text-sm text-gray-500 mt-1">What's happening across Karatu, updated regularly</p>
            </div>
            <a href="{{ route('news.archive') }}" class="text-sm font-semibold text-forest-700 hover:text-forest-900 flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                Search the archive
            </a>
        </div>
    </div>
</div>

<div class="bg-gray-50 min-h-[60vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Breaking / highlight strip --}}
        @if($breaking->isNotEmpty())
            <div class="mb-8 flex flex-wrap items-center gap-3 bg-red-50 border border-red-100 rounded-2xl px-5 py-3">
                <span class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wide text-red-600">
                    <span class="w-2 h-2 rounded-full bg-red-600 animate-pulse"></span> Breaking
                </span>
                <a href="{{ route('news.show', $breaking->first()) }}" class="text-sm font-semibold text-red-800 hover:underline">
                    {{ $breaking->first()->title }}
                </a>
            </div>
        @endif

        @if($posts->isEmpty())
            <div class="bg-white rounded-3xl p-20 text-center shadow-sm border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">No news yet</h3>
                <p class="text-gray-400 text-sm">Check back soon. New stories are posted regularly.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($posts as $post)
                    <a href="{{ route('news.show', $post) }}"
                       class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300 group flex flex-col">
                        <div class="relative h-48 overflow-hidden bg-forest-100">
                            @if($post->cover_image_url)
                                <img loading="lazy" decoding="async" src="{{ $post->cover_image_url }}" alt="{{ $post->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @endif
                            @if($post->is_breaking)
                                <span class="absolute top-3 left-3 bg-red-600 text-white text-[10px] font-bold uppercase tracking-wide px-2.5 py-1 rounded-full">Breaking</span>
                            @endif
                        </div>
                        <div class="p-5 flex flex-col flex-1">
                            <p class="text-xs text-forest-600 font-semibold mb-1.5">
                                {{ optional($post->published_at)->format('D, d M Y') ?? $post->created_at->format('D, d M Y') }}
                                · {{ $post->reading_time }} min read
                            </p>
                            <h2 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-forest-700 transition leading-snug line-clamp-2">{{ $post->title }}</h2>
                            <p class="text-sm text-gray-600 line-clamp-3 leading-relaxed">{{ $post->excerpt }}</p>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-10">{{ $posts->links() }}</div>
        @endif
    </div>
</div>

@endsection
