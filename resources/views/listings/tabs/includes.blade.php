{{-- Includes tab --}}
@if($listing->includes->isEmpty())
    <p class="text-gray-400 text-sm text-center py-8">No information available.</p>
@else
    <ul class="grid grid-cols-1 md:grid-cols-2 gap-3">
        @foreach($listing->includes as $item)
            <li class="flex items-center gap-3 p-4 bg-forest-50 rounded-xl text-sm text-forest-900 border border-forest-100">
                <svg class="w-5 h-5 text-forest-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                {{ $item->description }}
            </li>
        @endforeach
    </ul>
@endif
