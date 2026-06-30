{{-- Itinerary tab: timeline --}}
@if($listing->itineraryItems->isEmpty())
    <p class="text-gray-400 text-sm text-center py-8">No itinerary available.</p>
@else
    <div class="space-y-4 relative">
        <div class="absolute left-7 top-0 bottom-0 w-px bg-forest-100"></div>
        @foreach($listing->itineraryItems as $item)
            <div class="flex gap-5 relative">
                <div class="w-14 h-14 rounded-2xl bg-forest-700 text-white text-xs font-bold flex items-center justify-center shrink-0 shadow-sm z-10 text-center leading-tight px-1">
                    {{ $item->day_label }}
                </div>
                <div class="flex-1 bg-gray-50 rounded-2xl p-5 text-sm text-gray-700 leading-relaxed border border-gray-100">
                    {{ $item->description }}
                </div>
            </div>
        @endforeach
    </div>
@endif
