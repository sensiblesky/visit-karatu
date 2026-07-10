@extends('layouts.app')

@section('title', 'Terms of Use')
@section('meta_description', 'The terms governing your use of the Visit Karatu website.')

@section('content')
<div class="bg-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <nav class="text-xs text-gray-400 mb-3 flex items-center gap-1.5">
            <a href="{{ route('home') }}" class="hover:text-forest-600 transition">Home</a><span>/</span><span class="text-gray-600">Terms of Use</span>
        </nav>
        <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Terms of Use</h1>
        <p class="text-sm text-gray-400 mb-8">Last updated {{ now()->format('F Y') }}</p>

        <div class="prose max-w-none text-gray-700 leading-relaxed space-y-5">
            <p>By using {{ setting('site_name', 'Visit Karatu') }} ({{ url('/') }}) you agree to these terms.</p>

            <h2 class="text-xl font-bold text-gray-900">About this site</h2>
            <p>{{ setting('site_name', 'Visit Karatu') }} is a directory and information platform for the Karatu district. Listings for lodges, tours, attractions and businesses are provided for information; we are not the operator of those businesses and do not guarantee availability, pricing or the accuracy of third-party details.</p>

            <h2 class="text-xl font-bold text-gray-900">Bookings &amp; enquiries</h2>
            <p>Enquiries submitted through the site are forwarded to the relevant business. Any booking, payment, cancellation or refund is a matter between you and that business, subject to their own terms.</p>

            <h2 class="text-xl font-bold text-gray-900">User-submitted content</h2>
            <p>Reviews and other content you submit must be truthful and lawful. We moderate submissions and may edit or remove content at our discretion.</p>

            <h2 class="text-xl font-bold text-gray-900">Intellectual property</h2>
            <p>Site content and branding are owned by {{ setting('site_name', 'Visit Karatu') }} or its partners and may not be reused without permission.</p>

            <h2 class="text-xl font-bold text-gray-900">Contact</h2>
            <p>Questions about these terms? Email <a href="mailto:{{ setting('contact_email', 'info@visitkaratu.com') }}" class="text-forest-700 underline">{{ setting('contact_email', 'info@visitkaratu.com') }}</a>.</p>
        </div>
    </div>
</div>
@endsection
