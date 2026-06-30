<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Category Name *</label>
        <input type="text" name="name" value="{{ old('name', $category->name) }}" required class="form-input">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
        <textarea name="description" rows="2" class="form-input resize-y">{{ old('description', $category->description) }}</textarea>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Icon identifier</label>
            <input type="text" name="icon" value="{{ old('icon', $category->icon) }}" placeholder="bed, compass, camera..." class="form-input">
            <p class="text-xs text-gray-400 mt-1">Optional reference label for the homepage icon row.</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order *</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" min="0" required class="form-input">
        </div>
    </div>

    @if($category->exists)
        <label class="flex items-center gap-2 text-sm text-gray-600">
            <input type="checkbox" name="regenerate_slug" value="1" class="rounded text-forest-600 focus:ring-forest-500">
            Regenerate URL slug from name (current: <span class="font-mono text-gray-500">{{ $category->slug }}</span>)
        </label>
    @endif
</div>

{{-- Tab visibility --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <h3 class="font-bold text-gray-800 border-b pb-3 mb-2">Detail-page Tabs</h3>
    <p class="text-xs text-gray-400 mb-5">Choose which sections appear on the listing detail page for this category. A tab still hides itself automatically if a listing has no data for it.</p>

    @php $current = $category->tabs ?? $category->resolvedTabs(); @endphp
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        @foreach($availableTabs as $key => $def)
            <label class="flex items-center gap-3 p-3 rounded-xl border {{ ($def['always'] ?? false) ? 'bg-gray-50 border-gray-100' : 'border-gray-200 hover:border-forest-300 cursor-pointer' }}">
                <input type="checkbox"
                       name="tabs[]"
                       value="{{ $key }}"
                       {{ in_array($key, old('tabs', $current)) || ($def['always'] ?? false) ? 'checked' : '' }}
                       {{ ($def['always'] ?? false) ? 'disabled' : '' }}
                       class="rounded text-forest-600 focus:ring-forest-500">
                <div>
                    <span class="text-sm font-medium text-gray-800">{{ $def['label'] }}</span>
                    @if($def['always'] ?? false)
                        <span class="text-xs text-gray-400 ml-1">(always on)</span>
                    @elseif($def['needs'] ?? null)
                        <span class="block text-xs text-gray-400">shows only when the listing has {{ $def['needs'] === 'itineraryItems' ? 'itinerary' : $def['needs'] }} data</span>
                    @endif
                </div>
            </label>
        @endforeach
    </div>
</div>
