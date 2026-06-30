{{-- Excludes tab --}}
@if($listing->excludes->isEmpty())
    <p class="text-gray-400 text-sm text-center py-8">No information available.</p>
@else
    <ul class="grid grid-cols-1 md:grid-cols-2 gap-3">
        @foreach($listing->excludes as $item)
            <li class="flex items-center gap-3 p-4 bg-red-50 rounded-xl text-sm text-red-900 border border-red-100">
                <svg class="w-5 h-5 text-red-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                {{ $item->description }}
            </li>
        @endforeach
    </ul>
@endif
