{{-- Amenities tab --}}
@if($listing->amenities->isEmpty())
    <p class="text-gray-400 text-sm text-center py-8">No amenities listed.</p>
@else
    <ul class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
        @foreach($listing->amenities as $amenity)
            <li class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl text-sm text-gray-700 border border-gray-100">
                <svg class="w-5 h-5 text-forest-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                {{ $amenity->name }}
            </li>
        @endforeach
    </ul>
@endif
