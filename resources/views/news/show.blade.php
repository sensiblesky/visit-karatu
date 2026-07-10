@extends('layouts.app')

@section('title', $post->title)
@section('meta_description', $post->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($post->body), 155))
@section('og_type', 'article')
@if($post->cover_image_url)
    @section('og_image', $post->cover_image_url)
@endif

@push('head')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'NewsArticle',
    'headline' => $post->title,
    'image' => $post->cover_image_url ? [$post->cover_image_url] : [],
    'datePublished' => optional($post->published_at)->toIso8601String(),
    'author' => ['@type' => 'Organization', 'name' => setting('site_name', 'Visit Karatu')],
    'publisher' => ['@type' => 'Organization', 'name' => setting('site_name', 'Visit Karatu')],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('home')],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'News', 'item' => route('news.index')],
        ['@type' => 'ListItem', 'position' => 3, 'name' => $post->title, 'item' => route('news.show', $post)],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush

@section('content')

@php
    $shareUrl = urlencode(url()->current());
    $shareText = urlencode($post->title);
@endphp

<article class="bg-white">
    {{-- Hero --}}
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pt-10">
        <nav class="text-xs text-gray-400 mb-4 flex items-center gap-1.5">
            <a href="{{ route('home') }}" class="hover:text-forest-600 transition">Home</a>
            <span>/</span>
            <a href="{{ route('news.index') }}" class="hover:text-forest-600 transition">News</a>
        </nav>

        @if($post->is_breaking)
            <span class="inline-flex items-center gap-1.5 bg-red-600 text-white text-[11px] font-bold uppercase tracking-wide px-3 py-1 rounded-full mb-4">
                <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span> Breaking
            </span>
        @endif

        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 leading-tight mb-4">{{ $post->title }}</h1>
        <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-gray-500 mb-6">
            <span>{{ optional($post->published_at)->format('l, d F Y') ?? $post->created_at->format('l, d F Y') }}</span>
            <span>·</span>
            <span>{{ $post->reading_time }} min read</span>
            @if($post->author)<span>·</span><span>By {{ $post->author->name }}</span>@endif
        </div>
    </div>

    @if($post->cover_image_url)
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
            <img src="{{ $post->cover_image_url }}" alt="{{ $post->title }}" class="w-full rounded-3xl object-cover max-h-[28rem]">
        </div>
    @endif

    {{-- Body --}}
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pb-4">
        @if($post->excerpt)
            <p class="text-lg text-gray-600 leading-relaxed font-medium mb-6">{{ $post->excerpt }}</p>
        @endif
        <div class="prose prose-forest max-w-none text-gray-800 leading-relaxed space-y-4">
            {!! nl2br(e($post->body)) !!}
        </div>

        {{-- Social share (redirects back to this site) --}}
        <div class="mt-10 pt-6 border-t border-gray-100">
            <p class="text-xs font-semibold uppercase tracking-wide text-gray-400 mb-3">Share this story</p>
            <div class="flex flex-wrap gap-2">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#1877F2] text-white text-sm font-medium hover:opacity-90 transition">Facebook</a>
                <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareText }}" target="_blank" rel="noopener"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-black text-white text-sm font-medium hover:opacity-90 transition">X</a>
                <a href="https://api.whatsapp.com/send?text={{ $shareText }}%20{{ $shareUrl }}" target="_blank" rel="noopener"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#25D366] text-white text-sm font-medium hover:opacity-90 transition">WhatsApp</a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}" target="_blank" rel="noopener"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#0A66C2] text-white text-sm font-medium hover:opacity-90 transition">LinkedIn</a>
            </div>
        </div>
    </div>
</article>

@if($related->isNotEmpty())
    <div class="bg-gray-50 border-t border-gray-100 mt-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h2 class="text-lg font-bold text-gray-900 mb-6">More news</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                @foreach($related as $r)
                    <a href="{{ route('news.show', $r) }}" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition group">
                        <div class="h-36 bg-forest-100 overflow-hidden">
                            @if($r->cover_image_url)<img loading="lazy" src="{{ $r->cover_image_url }}" alt="" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">@endif
                        </div>
                        <div class="p-4">
                            <p class="text-xs text-gray-400 mb-1">{{ optional($r->published_at)->format('d M Y') }}</p>
                            <h3 class="text-sm font-semibold text-gray-900 line-clamp-2 group-hover:text-forest-700 transition">{{ $r->title }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endif

@endsection
