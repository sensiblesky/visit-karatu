<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\Category;
use App\Models\Listing;
use App\Models\ListingView;
use App\Models\Location;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function index(Request $request)
    {
        $query = Listing::published()
            ->with(['category', 'location', 'coverImage', 'amenities'])
            ->withAvg('approvedReviews', 'rating')
            ->withCount('approvedReviews');

        $this->applyFilters($query, $request);

        $listings = $query->paginate(12)->withQueryString();

        return view('listings.index', [
            'listings' => $listings,
            'categories' => Category::orderBy('sort_order')->get(),
            'locations' => Location::all(),
            'amenities' => Amenity::orderBy('name')->get(),
            'currentCategory' => null,
        ]);
    }

    public function byCategory(string $slug, Request $request)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $query = Listing::published()
            ->where('category_id', $category->id)
            ->with(['category', 'location', 'coverImage', 'amenities'])
            ->withAvg('approvedReviews', 'rating')
            ->withCount('approvedReviews');

        $this->applyFilters($query, $request);

        $listings = $query->paginate(12)->withQueryString();

        return view('listings.index', [
            'listings' => $listings,
            'categories' => Category::orderBy('sort_order')->get(),
            'locations' => Location::all(),
            'amenities' => Amenity::orderBy('name')->get(),
            'currentCategory' => $category,
        ]);
    }

    public function show(string $slug)
    {
        $listing = Listing::published()
            ->where('slug', $slug)
            ->with([
                'category', 'location', 'images', 'amenities',
                'itineraryItems', 'includes', 'excludes',
                'approvedReviews.user',
            ])
            ->withAvg('approvedReviews', 'rating')
            ->withCount('approvedReviews')
            ->firstOrFail();

        // Detect source from referrer
        $source = 'direct';
        $referrer = request()->headers->get('referer', '');
        if (str_contains($referrer, 'google') || str_contains($referrer, 'bing')) {
            $source = 'organic_search';
        } elseif ($referrer && !str_contains($referrer, request()->getHost())) {
            $source = 'referral';
        }

        ListingView::create([
            'listing_id' => $listing->id,
            'viewed_at' => now(),
            'source' => $source,
        ]);

        $isFavorited = auth()->check()
            ? $listing->favorites()->where('user_id', auth()->id())->exists()
            : false;

        // "You might also like" — other published listings in the same category,
        // falling back to the same location if the category is thin.
        $related = Listing::published()
            ->where('id', '!=', $listing->id)
            ->where(function ($q) use ($listing) {
                $q->where('category_id', $listing->category_id)
                  ->orWhere('location_id', $listing->location_id);
            })
            ->with(['category', 'location', 'coverImage'])
            ->withAvg('approvedReviews', 'rating')
            ->withCount('approvedReviews')
            ->orderByRaw('category_id = ? desc', [$listing->category_id])
            ->featuredFirst()
            ->limit(4)
            ->get();

        return view('listings.show', compact('listing', 'isFavorited', 'related'));
    }

    private function applyFilters($query, Request $request): void
    {
        if ($request->filled('location')) {
            $query->whereHas('location', fn($q) => $q->where('slug', $request->location));
        }

        if ($request->filled('amenities')) {
            foreach ($request->amenities as $amenitySlug) {
                $query->whereHas('amenities', fn($q) => $q->where('slug', $amenitySlug));
            }
        }

        if ($request->filled('price')) {
            match ($request->price) {
                '$' => $query->where('price_amount', '<', 50),
                '$$' => $query->whereBetween('price_amount', [50, 150]),
                '$$$' => $query->where('price_amount', '>', 150),
                default => null,
            };
        }

        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $query->where(fn($q) => $q->where('name', 'like', $search)->orWhere('short_description', 'like', $search));
        }

        match ($request->get('sort', 'recommended')) {
            'price_asc' => $query->orderBy('price_amount'),
            'price_desc' => $query->orderByDesc('price_amount'),
            'rating' => $query->orderByDesc('approved_reviews_avg_rating'),
            default => $query->featuredFirst()->orderByDesc('is_popular'),
        };
    }
}
