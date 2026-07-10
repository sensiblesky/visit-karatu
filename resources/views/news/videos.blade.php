@extends('layouts.app')

@section('title', 'Videos & Live')
@section('meta_description', "Watch Karatu highlights, matches and events. Streamed from YouTube.")

@section('content')

<div class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <nav class="text-xs text-gray-400 mb-2 flex items-center gap-1.5">
            <a href="{{ route('home') }}" class="hover:text-forest-600 transition">Home</a>
            <span>/</span>
            <span class="text-gray-600">Videos</span>
        </nav>
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Videos &amp; Live</h1>
                <p class="text-sm text-gray-500 mt-1">Highlights and events from Karatu, streamed from YouTube</p>
            </div>
            @if($live)
                <a href="#live" class="inline-flex items-center gap-2 bg-red-600 text-white text-sm font-semibold px-4 py-2.5 rounded-xl hover:bg-red-700 transition">
                    <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span> Live now
                </a>
            @endif
        </div>
    </div>
</div>

<div class="bg-gray-50 min-h-[60vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        @if($live && $live->youtube_id)
            <section id="live" class="mb-12">
                <div class="flex items-center gap-2 mb-4">
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wide text-red-600">
                        <span class="w-2 h-2 rounded-full bg-red-600 animate-pulse"></span> Live event
                    </span>
                </div>
                <div class="rounded-3xl overflow-hidden shadow-lg bg-black aspect-video">
                    <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $live->youtube_id }}?autoplay=0"
                            title="{{ $live->title }}" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <h2 class="text-xl font-bold text-gray-900 mt-4">{{ $live->title }}</h2>
                @if($live->excerpt)<p class="text-gray-600 mt-1">{{ $live->excerpt }}</p>@endif
            </section>
        @endif

        @if($videos->isEmpty() && ! $live)
            <div class="bg-white rounded-3xl p-20 text-center shadow-sm border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">No videos yet</h3>
                <p class="text-gray-400 text-sm">New clips and streams will appear here.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($videos as $video)
                    <a href="https://youtu.be/{{ $video->youtube_id }}" target="_blank" rel="noopener"
                       class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition group">
                        <div class="relative aspect-video bg-black overflow-hidden">
                            @if($video->cover_image_url)
                                <img loading="lazy" src="{{ $video->cover_image_url }}" alt="{{ $video->title }}" class="w-full h-full object-cover opacity-90 group-hover:opacity-100 transition">
                            @endif
                            <span class="absolute inset-0 flex items-center justify-center">
                                <span class="w-14 h-14 rounded-full bg-black/60 flex items-center justify-center group-hover:bg-red-600 transition">
                                    <svg class="w-6 h-6 text-white ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </span>
                            </span>
                        </div>
                        <div class="p-4">
                            <h3 class="text-sm font-semibold text-gray-900 line-clamp-2 group-hover:text-forest-700 transition">{{ $video->title }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-10">{{ $videos->links() }}</div>
        @endif
    </div>
</div>

@endsection
