@extends('layouts.app')

@section('title', 'Access denied')

@section('content')
<section class="min-h-[70vh] flex items-center bg-gray-50">
    <div class="max-w-xl mx-auto px-4 text-center">
        <p class="text-7xl font-extrabold tracking-tight text-forest-800 mb-2">403</p>
        <h1 class="text-2xl font-bold text-gray-900 mb-3">You don't have access to this page</h1>
        <p class="text-gray-500 mb-8">{{ $exception?->getMessage() ?: 'This area is restricted.' }}</p>
        <a href="{{ route('home') }}" class="btn-primary px-8 py-3 inline-block">Back to home</a>
    </div>
</section>
@endsection
