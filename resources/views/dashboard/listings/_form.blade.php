{{-- Validation errors --}}
@if($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-sm text-red-700">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5">
    <h3 class="font-bold text-gray-800 border-b pb-3">Basic Information</h3>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Listing Name *</label>
        <input type="text" name="name" value="{{ old('name', $listing?->name) }}" required
               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-forest-500">
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
            <select name="category_id" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-forest-500">
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $listing?->category_id) == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Location *</label>
            <select name="location_id" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-forest-500">
                @foreach($locations as $loc)
                    <option value="{{ $loc->id }}" {{ old('location_id', $listing?->location_id) == $loc->id ? 'selected' : '' }}>
                        {{ $loc->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Short Description * (shown on cards)</label>
        <input type="text" name="short_description" value="{{ old('short_description', $listing?->short_description) }}" required maxlength="500"
               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-forest-500">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Full Description *</label>
        <textarea name="full_description" rows="6" required
                  class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-forest-500 resize-y">{{ old('full_description', $listing?->full_description) }}</textarea>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Price (USD)</label>
            <input type="number" name="price_amount" value="{{ old('price_amount', $listing?->price_amount) }}" min="0" step="0.01"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-forest-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Price Unit</label>
            <input type="text" name="price_unit" value="{{ old('price_unit', $listing?->price_unit) }}" placeholder="per night, per person..."
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-forest-500">
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5">
    <h3 class="font-bold text-gray-800 border-b pb-3">Contact & Location</h3>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
        <input type="text" name="address_text" value="{{ old('address_text', $listing?->address_text) }}"
               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-forest-500">
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
            <input type="text" name="phone" value="{{ old('phone', $listing?->phone) }}"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-forest-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp</label>
            <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $listing?->whatsapp_number) }}"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-forest-500">
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Business Email</label>
        <input type="email" name="email" value="{{ old('email', $listing?->email) }}"
               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-forest-500">
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <h3 class="font-bold text-gray-800 border-b pb-3 mb-5">Amenities</h3>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
        @foreach($amenities as $amenity)
            <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}"
                       {{ in_array($amenity->id, old('amenities', $listing?->amenities->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}
                       class="text-forest-600 rounded">
                {{ $amenity->name }}
            </label>
        @endforeach
    </div>
</div>

{{-- Itinerary (repeatable) --}}
@php
    $itineraryOld = old('itinerary', $listing
        ? $listing->itineraryItems->map(fn($i) => ['day_label' => $i->day_label, 'description' => $i->description])->values()->all()
        : []);
@endphp
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6"
     x-data="{ items: {{ Js::from($itineraryOld ?: [['day_label' => 'Day 01', 'description' => '']]) }} }">
    <div class="flex items-center justify-between border-b pb-3 mb-5">
        <div>
            <h3 class="font-bold text-gray-800">Itinerary</h3>
            <p class="text-xs text-gray-400 mt-0.5">Used for tour / multi-day attraction listings. Leave empty if not applicable.</p>
        </div>
        <button type="button" @click="items.push({ day_label: 'Day ' + String(items.length + 1).padStart(2, '0'), description: '' })"
                class="text-sm font-semibold text-forest-700 hover:text-forest-900 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add day
        </button>
    </div>
    <div class="space-y-3">
        <template x-for="(item, index) in items" :key="index">
            <div class="flex gap-3 items-start">
                <input type="text" :name="`itinerary[${index}][day_label]`" x-model="item.day_label"
                       placeholder="Day 01" class="form-input w-28 shrink-0">
                <textarea :name="`itinerary[${index}][description]`" x-model="item.description" rows="2"
                          placeholder="What happens on this day..." class="form-input resize-y flex-1"></textarea>
                <button type="button" @click="items.splice(index, 1)"
                        class="mt-2 text-gray-300 hover:text-red-500 transition shrink-0" title="Remove">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </div>
        </template>
        <p x-show="items.length === 0" class="text-sm text-gray-400">No itinerary items.</p>
    </div>
</div>

{{-- Includes / Excludes (repeatable) --}}
@php
    $includesOld = old('includes', $listing ? $listing->includes->pluck('description')->all() : []);
    $excludesOld = old('excludes', $listing ? $listing->excludes->pluck('description')->all() : []);
@endphp
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    {{-- Includes --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6"
         x-data="{ rows: {{ Js::from($includesOld ?: ['']) }} }">
        <div class="flex items-center justify-between border-b pb-3 mb-5">
            <h3 class="font-bold text-gray-800">What's Included</h3>
            <button type="button" @click="rows.push('')" class="text-sm font-semibold text-forest-700 hover:text-forest-900">+ Add</button>
        </div>
        <div class="space-y-2">
            <template x-for="(row, index) in rows" :key="index">
                <div class="flex gap-2 items-center">
                    <input type="text" :name="`includes[${index}]`" x-model="rows[index]"
                           placeholder="e.g. All meals" class="form-input flex-1">
                    <button type="button" @click="rows.splice(index, 1)" class="text-gray-300 hover:text-red-500 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </template>
        </div>
    </div>

    {{-- Excludes --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6"
         x-data="{ rows: {{ Js::from($excludesOld ?: ['']) }} }">
        <div class="flex items-center justify-between border-b pb-3 mb-5">
            <h3 class="font-bold text-gray-800">Not Included</h3>
            <button type="button" @click="rows.push('')" class="text-sm font-semibold text-forest-700 hover:text-forest-900">+ Add</button>
        </div>
        <div class="space-y-2">
            <template x-for="(row, index) in rows" :key="index">
                <div class="flex gap-2 items-center">
                    <input type="text" :name="`excludes[${index}]`" x-model="rows[index]"
                           placeholder="e.g. Park entry fees" class="form-input flex-1">
                    <button type="button" @click="rows.splice(index, 1)" class="text-gray-300 hover:text-red-500 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </template>
        </div>
    </div>
</div>

{{-- Photos: upload new (inside main form) --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <h3 class="font-bold text-gray-800 border-b pb-3 mb-5">Add Photos</h3>
    <input type="file" name="images[]" multiple accept="image/*"
           class="text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-forest-50 file:text-forest-700 hover:file:bg-forest-100">
    <p class="text-xs text-gray-400 mt-2">Upload one or more images (max 4MB each). On a new listing the first image becomes the cover.</p>
    @if($listing)
        <p class="text-xs text-gray-400 mt-1">Manage existing photos in the “Current Photos” panel below.</p>
    @endif
</div>
