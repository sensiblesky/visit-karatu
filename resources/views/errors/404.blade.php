@extends('layouts.app')

@section('title', 'Page not found')

@section('content')
<section class="relative min-h-[70vh] flex items-center">
    <div class="absolute inset-0">
        <img src="/images/placeholders/savanna.jpg" alt="" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-forest-950/85"></div>
    </div>
    <div class="relative z-10 max-w-xl mx-auto px-4 text-center text-white">
        <p class="text-7xl font-extrabold tracking-tight mb-2">404</p>
        <h1 class="text-2xl font-bold mb-3">This trail doesn't exist</h1>
        <p class="text-forest-100 mb-8">The page you're looking for may have moved or never existed. Let's get you back on the map.</p>

        <form action="{{ route('listings.index') }}" method="GET" class="flex gap-2 max-w-md mx-auto mb-6">
            <input type="search" name="q" placeholder="Search lodges, tours, attractions…"
                   class="flex-1 rounded-xl border-0 text-gray-900 px-4 py-3 text-sm focus:ring-2 focus:ring-forest-400">
            <button class="bg-white text-forest-900 font-semibold px-5 rounded-xl hover:bg-forest-50 transition">Search</button>
        </form>

        <div class="flex flex-wrap justify-center gap-x-6 gap-y-2 text-sm">
            <a href="{{ route('home') }}" class="text-forest-200 hover:text-white underline">Home</a>
            <a href="{{ route('things-to-do') }}" class="text-forest-200 hover:text-white underline">Things to Do</a>
            <a href="{{ route('news.index') }}" class="text-forest-200 hover:text-white underline">News</a>
            <a href="{{ route('listings.map') }}" class="text-forest-200 hover:text-white underline">Map</a>
        </div>
    </div>
</section>
@endsection
