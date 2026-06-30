{{-- Overview tab: full description --}}
<div class="prose prose-gray max-w-none text-gray-700 text-sm leading-relaxed">
    {!! nl2br(e($listing->full_description)) !!}
</div>

{{-- Quick include/exclude summary only when those tabs are NOT shown separately --}}
@php $tabs = array_keys($listing->visibleTabs()); @endphp
@if(! in_array('includes', $tabs) && $listing->includes->count() > 0)
    <div class="mt-8">
        <h4 class="font-bold text-gray-900 mb-4">What's Included</h4>
        <ul class="grid grid-cols-1 md:grid-cols-2 gap-2.5">
            @foreach($listing->includes as $item)
                <li class="flex items-start gap-2.5 text-sm text-gray-600">
                    <svg class="w-4 h-4 text-forest-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ $item->description }}
                </li>
            @endforeach
        </ul>
    </div>
@endif
