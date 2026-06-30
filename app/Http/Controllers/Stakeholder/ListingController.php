<?php

namespace App\Http\Controllers\Stakeholder;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\Category;
use App\Models\Listing;
use App\Models\ListingImage;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ListingController extends Controller
{
    public function index()
    {
        $listings = auth()->user()->listings()->with(['category', 'location'])->latest()->paginate(20);
        return view('dashboard.listings.index', compact('listings'));
    }

    public function create()
    {
        return view('dashboard.listings.create', [
            'listing' => null,
            'categories' => Category::orderBy('sort_order')->get(),
            'locations' => Location::all(),
            'amenities' => Amenity::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateListing($request);

        $data['user_id'] = auth()->id();
        $data['slug'] = Str::slug($data['name']) . '-' . Str::random(6);
        $data['status'] = 'pending';

        $listing = Listing::create($this->listingColumns($data));

        $listing->amenities()->sync($request->input('amenities', []));
        $this->syncItinerary($listing, $request);
        $this->syncIncludeExcludes($listing, $request);
        $this->storeImages($listing, $request);

        return redirect()->route('dashboard.listings.index')->with('success', 'Listing submitted for review.');
    }

    public function edit(Listing $listing)
    {
        $this->authorize('update', $listing);

        return view('dashboard.listings.edit', [
            'listing' => $listing->load(['amenities', 'images', 'itineraryItems', 'includes', 'excludes']),
            'categories' => Category::orderBy('sort_order')->get(),
            'locations' => Location::all(),
            'amenities' => Amenity::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Listing $listing)
    {
        $this->authorize('update', $listing);

        $data = $this->validateListing($request);
        $data['status'] = 'pending'; // re-submit for approval on edit

        $listing->update($this->listingColumns($data));

        $listing->amenities()->sync($request->input('amenities', []));
        $this->syncItinerary($listing, $request);
        $this->syncIncludeExcludes($listing, $request);
        $this->storeImages($listing, $request);

        return redirect()->route('dashboard.listings.edit', $listing)
            ->with('success', 'Listing updated and re-submitted for review.');
    }

    public function destroy(Listing $listing)
    {
        $this->authorize('delete', $listing);

        foreach ($listing->images as $image) {
            Storage::disk('public')->delete($image->path);
        }
        $listing->delete();

        return redirect()->route('dashboard.listings.index')->with('success', 'Listing deleted.');
    }

    public function show(Listing $listing)
    {
        $this->authorize('view', $listing);
        return redirect()->route('listings.show', $listing->slug);
    }

    // ---- Image management endpoints ----

    public function deleteImage(Listing $listing, ListingImage $image)
    {
        $this->authorize('update', $listing);
        abort_unless($image->listing_id === $listing->id, 404);

        $wasCover = $image->is_cover;
        Storage::disk('public')->delete($image->path);
        $image->delete();

        // Promote another image to cover if we removed the cover.
        if ($wasCover && $first = $listing->images()->orderBy('sort_order')->first()) {
            $first->update(['is_cover' => true]);
        }

        return back()->with('success', 'Image removed.');
    }

    public function setCoverImage(Listing $listing, ListingImage $image)
    {
        $this->authorize('update', $listing);
        abort_unless($image->listing_id === $listing->id, 404);

        $listing->images()->update(['is_cover' => false]);
        $image->update(['is_cover' => true]);

        return back()->with('success', 'Cover image updated.');
    }

    public function reorderImages(Request $request, Listing $listing)
    {
        $this->authorize('update', $listing);

        $order = $request->input('order', []); // array of image ids in new order
        foreach ($order as $position => $imageId) {
            $listing->images()->where('id', $imageId)->update(['sort_order' => $position]);
        }

        return response()->json(['status' => 'ok']);
    }

    // ---- Helpers ----

    private function validateListing(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'short_description' => 'required|string|max:500',
            'full_description' => 'required|string',
            'price_amount' => 'nullable|numeric|min:0',
            'price_unit' => 'nullable|string|max:100',
            'address_text' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'whatsapp_number' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
            'images' => 'nullable|array',
            'images.*' => 'image|max:4096',
            // Repeatable content
            'itinerary' => 'nullable|array',
            'itinerary.*.day_label' => 'nullable|string|max:50',
            'itinerary.*.description' => 'nullable|string|max:2000',
            'includes' => 'nullable|array',
            'includes.*' => 'nullable|string|max:255',
            'excludes' => 'nullable|array',
            'excludes.*' => 'nullable|string|max:255',
        ]);
    }

    /** Only the columns that belong on the listings table. */
    private function listingColumns(array $data): array
    {
        return collect($data)->only([
            'user_id', 'category_id', 'location_id', 'name', 'slug',
            'short_description', 'full_description', 'price_amount', 'price_unit',
            'address_text', 'phone', 'whatsapp_number', 'email', 'status',
        ])->all();
    }

    private function syncItinerary(Listing $listing, Request $request): void
    {
        $listing->itineraryItems()->delete();

        foreach ($request->input('itinerary', []) as $i => $item) {
            if (empty($item['day_label']) && empty($item['description'])) {
                continue;
            }
            $listing->itineraryItems()->create([
                'day_label' => $item['day_label'] ?? 'Day ' . ($i + 1),
                'description' => $item['description'] ?? '',
                'sort_order' => $i,
            ]);
        }
    }

    private function syncIncludeExcludes(Listing $listing, Request $request): void
    {
        $listing->includeExcludes()->delete();

        foreach (array_filter($request->input('includes', [])) as $desc) {
            $listing->includeExcludes()->create(['type' => 'include', 'description' => $desc]);
        }
        foreach (array_filter($request->input('excludes', [])) as $desc) {
            $listing->includeExcludes()->create(['type' => 'exclude', 'description' => $desc]);
        }
    }

    private function storeImages(Listing $listing, Request $request): void
    {
        if (! $request->hasFile('images')) {
            return;
        }

        $startOrder = $listing->images()->max('sort_order') + 1;
        $hasCover = $listing->images()->where('is_cover', true)->exists();

        foreach ($request->file('images') as $i => $image) {
            $path = $image->store('listings', 'public');
            $listing->images()->create([
                'path' => $path,
                'sort_order' => $startOrder + $i,
                'is_cover' => ! $hasCover && $i === 0,
            ]);
        }
    }
}
