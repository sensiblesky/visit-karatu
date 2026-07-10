@extends('layouts.app')

@section('title', 'Privacy Policy')
@section('meta_description', 'How Visit Karatu collects, uses and protects your information, including cookies and translation.')

@section('content')
<div class="bg-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <nav class="text-xs text-gray-400 mb-3 flex items-center gap-1.5">
            <a href="{{ route('home') }}" class="hover:text-forest-600 transition">Home</a><span>/</span><span class="text-gray-600">Privacy Policy</span>
        </nav>
        <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Privacy Policy</h1>
        <p class="text-sm text-gray-400 mb-8">Last updated {{ now()->format('F Y') }}</p>

        <div class="prose max-w-none text-gray-700 leading-relaxed space-y-5">
            <p>This Privacy Policy explains how {{ setting('site_name', 'Visit Karatu') }} ("we", "us") handles information when you visit {{ url('/') }}.</p>

            <h2 class="text-xl font-bold text-gray-900">Information we collect</h2>
            <ul class="list-disc list-inside space-y-1">
                <li><strong>Information you provide:</strong> when you submit an enquiry, review, sponsorship interest or newsletter signup (e.g. name, email, message).</li>
                <li><strong>Usage data:</strong> basic, non-identifying information such as pages visited, collected to improve the site.</li>
                <li><strong>Cookies:</strong> small files used to remember preferences (see below).</li>
            </ul>

            <h2 class="text-xl font-bold text-gray-900">Cookies &amp; translation</h2>
            <p>We use essential cookies to run the site (e.g. session and security). We also use Google Translate to offer the site in Swahili, French and German; when you choose a language (or when your browser indicates a preferred one), a <code>googtrans</code> cookie is set so pages display in that language. Google may process page text to provide translations. You can decline non-essential cookies using the banner shown on your first visit, and clear cookies at any time in your browser.</p>

            <h2 class="text-xl font-bold text-gray-900">How we use information</h2>
            <p>To respond to your enquiries, publish reviews you submit (after moderation), send newsletters you opt into, and operate and improve the website. We do not sell your personal information.</p>

            <h2 class="text-xl font-bold text-gray-900">Your rights</h2>
            <p>You may request access to, correction of, or deletion of your personal information, and unsubscribe from the newsletter at any time. Contact us at <a href="mailto:{{ setting('contact_email', 'info@visitkaratu.com') }}" class="text-forest-700 underline">{{ setting('contact_email', 'info@visitkaratu.com') }}</a>.</p>

            <h2 class="text-xl font-bold text-gray-900">Contact</h2>
            <p>{{ setting('site_name', 'Visit Karatu') }}<br>{{ setting('contact_address', 'Karatu Town, Arusha Region, Tanzania') }}<br>{{ setting('contact_email', 'info@visitkaratu.com') }}</p>
        </div>
    </div>
</div>
@endsection
