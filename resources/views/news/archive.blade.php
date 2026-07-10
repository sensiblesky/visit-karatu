@extends('layouts.app')

@section('title', 'News Archive')
@section('meta_description', "Search past news and headlines from Karatu.")

@section('content')

<div class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <nav class="text-xs text-gray-400 mb-2 flex items-center gap-1.5">
            <a href="{{ route('home') }}" class="hover:text-forest-600 transition">Home</a>
            <span>/</span>
            <a href="{{ route('news.index') }}" class="hover:text-forest-600 transition">News</a>
            <span>/</span>
            <span class="text-gray-600">Archive</span>
        </nav>
        <h1 class="text-2xl font-bold text-gray-900">News Archive</h1>
        <p class="text-sm text-gray-500 mt-1">Stories older than {{ \App\Models\Post::ARCHIVE_AFTER_DAYS }} days. Search headlines below.</p>

        <form method="GET" action="{{ route('news.archive') }}" class="mt-5 flex gap-2 max-w-xl">
            <div class="relative flex-1">
                <svg class="w-5 h-5 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="search" name="q" value="{{ $q }}" placeholder="Search old news…"
                       class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:border-forest-500 focus:ring-forest-500 text-sm">
            </div>
            <button class="btn-primary px-6">Search</button>
        </form>
    </div>
</div>

<div class="bg-gray-50 min-h-[60vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @if($posts->isEmpty())
            <div class="bg-white rounded-3xl p-20 text-center shadow-sm border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Nothing found</h3>
                <p class="text-gray-400 text-sm">{{ $q ? "No archived stories match “{$q}”." : 'The archive is empty for now.' }}</p>
            </div>
        @else
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 divide-y divide-gray-100">
                @foreach($posts as $post)
                    <a href="{{ route('news.show', $post) }}" class="flex items-center gap-4 p-5 hover:bg-gray-50 transition group">
                        <div class="w-24 h-16 rounded-xl overflow-hidden bg-forest-100 shrink-0">
                            @if($post->cover_image_url)
                                <img loading="lazy" src="{{ $post->cover_image_url }}" alt="" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-gray-400 mb-0.5">{{ optional($post->published_at)->format('d M Y') ?? $post->created_at->format('d M Y') }}</p>
                            <h2 class="text-base font-semibold text-gray-900 group-hover:text-forest-700 transition truncate">{{ $post->title }}</h2>
                            <p class="text-sm text-gray-500 line-clamp-1">{{ $post->excerpt }}</p>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-10">{{ $posts->links() }}</div>
        @endif
    </div>
</div>

@endsection
