<div class="bg-white rounded-2xl shadow-sm border border-gray-100 divide-y divide-gray-100">

    {{-- Header --}}
    <div class="px-5 py-4 flex items-center justify-between">
        <span class="font-bold text-gray-900">Filters</span>
        @if(request()->hasAny(['location','price','amenities','search']))
            <a href="{{ request()->url() }}" class="text-xs text-forest-600 font-semibold hover:text-forest-800 transition">Clear all</a>
        @endif
    </div>

    {{-- Location --}}
    <div class="px-5 py-5">
        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Location</h3>
        <select name="location" onchange="document.getElementById('filter-form').submit()"
                class="w-full text-sm border border-gray-200 rounded-xl px-4 py-2.5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-forest-500 bg-white">
            <option value="">All Locations</option>
            @foreach($locations as $loc)
                <option value="{{ $loc->slug }}" {{ request('location') === $loc->slug ? 'selected' : '' }}>
                    {{ $loc->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Price --}}
    <div class="px-5 py-5">
        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Price Range</h3>
        <div class="space-y-2.5">
            @foreach(['' => 'Any price', '$' => 'Budget (under $50)', '$$' => 'Mid-range ($50–$150)', '$$$' => 'Luxury ($150+)'] as $key => $label)
                <label class="flex items-center gap-3 cursor-pointer group">
                    <div class="relative">
                        <input type="radio" name="price" value="{{ $key }}"
                               {{ request('price', '') === $key ? 'checked' : '' }}
                               class="sr-only peer"
                               onchange="document.getElementById('filter-form').submit()">
                        <div class="w-5 h-5 rounded-full border-2 border-gray-300 peer-checked:border-forest-600 peer-checked:bg-forest-600 transition flex items-center justify-center">
                            <div class="w-2 h-2 bg-white rounded-full hidden peer-checked:block"></div>
                        </div>
                    </div>
                    <span class="text-sm text-gray-600 group-hover:text-gray-900 transition">{{ $label }}</span>
                </label>
            @endforeach
        </div>
    </div>

    {{-- Accommodation Type --}}
    <div class="px-5 py-5">
        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Category</h3>
        <div class="space-y-2.5">
            @foreach($categories as $cat)
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="checkbox" name="category[]" value="{{ $cat->slug }}"
                           {{ in_array($cat->slug, (array) request('category', [])) ? 'checked' : '' }}
                           class="w-4 h-4 text-forest-600 border-gray-300 rounded focus:ring-forest-500">
                    <span class="text-sm text-gray-600 group-hover:text-gray-900 transition">{{ $cat->name }}</span>
                </label>
            @endforeach
        </div>
    </div>

    {{-- Amenities --}}
    <div class="px-5 py-5">
        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Amenities</h3>
        <div class="space-y-2.5">
            @foreach($amenities as $amenity)
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="checkbox" name="amenities[]" value="{{ $amenity->slug }}"
                           {{ in_array($amenity->slug, (array) request('amenities', [])) ? 'checked' : '' }}
                           class="w-4 h-4 text-forest-600 border-gray-300 rounded focus:ring-forest-500">
                    <span class="text-sm text-gray-600 group-hover:text-gray-900 transition">{{ $amenity->name }}</span>
                </label>
            @endforeach
        </div>
        <button type="submit" class="mt-4 w-full bg-forest-700 hover:bg-forest-800 text-white text-sm font-semibold py-2.5 rounded-xl transition">
            Apply Filters
        </button>
    </div>
</div>
