<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Sponsor Name *</label>
        <input type="text" name="name" value="{{ old('name', $sponsor->name) }}" required class="form-input">
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Grade / Level *</label>
            <select name="level" class="form-input">
                @foreach(\App\Models\Sponsor::LEVELS as $lvl)
                    <option value="{{ $lvl }}" @selected(old('level', $sponsor->level ?? 'silver') === $lvl)>{{ ucfirst($lvl) }}</option>
                @endforeach
            </select>
            <p class="text-xs text-gray-400 mt-1">Only <strong>Platinum</strong> appears on the homepage &amp; key pages.</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order *</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $sponsor->sort_order) }}" min="0" required class="form-input">
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Tier / Role Label</label>
        <input type="text" name="tier" value="{{ old('tier', $sponsor->tier) }}" placeholder="e.g. Sleeve Sponsor, Federation Partner, Football Partner..." class="form-input">
        <p class="text-xs text-gray-400 mt-1">The descriptive label shown above the name (Visit-Rwanda style).</p>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Website URL</label>
        <input type="url" name="website_url" value="{{ old('website_url', $sponsor->website_url) }}" placeholder="https://..." class="form-input">
    </div>

    <div class="border-t border-gray-100 pt-5">
        <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-3">
            <input type="checkbox" name="is_sports" value="1" {{ old('is_sports', $sponsor->is_sports) ? 'checked' : '' }}
                   class="rounded text-forest-600 focus:ring-forest-500">
            Sports partner (show on the Sports Sponsorships page with a detail page)
        </label>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Summary <span class="text-gray-400 font-normal">(one line)</span></label>
                <input type="text" name="summary" value="{{ old('summary', $sponsor->summary) }}" maxlength="500" class="form-input">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">About the partnership <span class="text-gray-400 font-normal">(detail page body)</span></label>
                <textarea name="body" rows="6" class="form-input">{{ old('body', $sponsor->body) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Hero / feature image</label>
                @if($sponsor->hero_image_url)
                    <img src="{{ $sponsor->hero_image_url }}" alt="" class="mb-2 w-full h-32 object-cover rounded-xl">
                @endif
                <input type="file" name="hero_image" accept="image/*"
                       class="text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-forest-50 file:text-forest-700 hover:file:bg-forest-100">
            </div>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Logo</label>
        @if($sponsor->logo_path)
            <div class="mb-3 w-40 h-20 bg-gray-50 rounded-xl border border-gray-100 flex items-center justify-center overflow-hidden">
                <img loading="lazy" decoding="async" src="{{ Storage::url($sponsor->logo_path) }}" alt="{{ $sponsor->name }}" class="max-h-16 max-w-[150px] object-contain">
            </div>
        @endif
        <input type="file" name="logo" accept="image/*"
               class="text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-forest-50 file:text-forest-700 hover:file:bg-forest-100">
        <p class="text-xs text-gray-400 mt-2">PNG, JPG or SVG. Max 2MB. Transparent logos look best. {{ $sponsor->logo_path ? 'Leave empty to keep the current logo.' : '' }}</p>
    </div>

    <label class="flex items-center gap-2 text-sm text-gray-700">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $sponsor->is_active) ? 'checked' : '' }}
               class="rounded text-forest-600 focus:ring-forest-500">
        Active (show on homepage)
    </label>
</div>
