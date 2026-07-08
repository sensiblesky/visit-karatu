@extends('layouts.app')

@section('title', 'Map of Karatu')
@section('meta_description', 'Explore lodges, tours and attractions across Karatu on an interactive map.')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
    <style>
        #karatu-map { height: calc(100vh - 8.5rem); min-height: 460px; }
        .leaflet-popup-content { margin: 0; }
        .leaflet-popup-content-wrapper { border-radius: 16px; overflow: hidden; padding: 0; }
        .leaflet-container { font-family: inherit; }
    </style>
@endpush

@section('content')
<div class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <nav class="text-xs text-gray-400 mb-1 flex items-center gap-1.5">
                <a href="{{ route('home') }}" class="hover:text-forest-600 transition">Home</a><span>/</span><span class="text-gray-600">Map</span>
            </nav>
            <h1 class="text-2xl font-bold text-gray-900">Explore Karatu on the Map</h1>
            <p class="text-sm text-gray-500 mt-0.5">{{ $markers->count() }} places to discover</p>
        </div>
        <a href="{{ route('listings.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-forest-700 border border-forest-200 hover:bg-forest-50 px-4 py-2.5 rounded-xl transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            List view
        </a>
    </div>
</div>

<div id="karatu-map" class="w-full bg-forest-50"></div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    const places = @json($markers);

    const map = L.map('karatu-map', { scrollWheelZoom: true }).setView([-3.3428, 35.7864], 10);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const pin = L.divIcon({
        className: 'vk-pin',
        html: '<div style="width:28px;height:28px;background:#1b5545;border:3px solid #fff;border-radius:50% 50% 50% 0;transform:rotate(-45deg);box-shadow:0 2px 6px rgba(0,0,0,.35)"></div>',
        iconSize: [28, 28],
        iconAnchor: [14, 28],
        popupAnchor: [0, -28],
    });

    const bounds = [];
    places.forEach(p => {
        const m = L.marker([p.lat, p.lng], { icon: pin }).addTo(map);
        bounds.push([p.lat, p.lng]);
        const priceHtml = p.price ? `<div style="color:#1b5545;font-weight:700;font-size:13px;margin-top:2px">${p.price}</div>` : '';
        m.bindPopup(`
            <a href="${p.url}" style="display:block;width:220px;text-decoration:none;color:#111">
                <img src="${p.image}" alt="" style="width:100%;height:110px;object-fit:cover" loading="lazy">
                <div style="padding:10px 12px">
                    <div style="font-size:11px;color:#236d59;font-weight:600">${p.category}</div>
                    <div style="font-weight:700;font-size:14px;line-height:1.3;margin-top:2px">${p.name}</div>
                    <div style="font-size:12px;color:#888;margin-top:2px">${p.location}</div>
                    ${priceHtml}
                </div>
            </a>
        `);
    });

    if (bounds.length) {
        map.fitBounds(bounds, { padding: [50, 50], maxZoom: 12 });
    }
</script>
@endpush
