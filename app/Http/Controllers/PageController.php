<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Listing;
use App\Models\Location;

class PageController extends Controller
{
    public function about()
    {
        $stats = [
            'listings' => Listing::published()->count(),
            'categories' => Category::count(),
            'locations' => Location::count(),
        ];

        $categories = Category::orderBy('sort_order')->get();

        return view('pages.about', compact('stats', 'categories'));
    }

    public function districtCouncil()
    {
        return view('pages.district-council');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function thingsToDo()
    {
        // Pull real attraction/experience listings to sit beneath the curated highlights.
        $listings = Listing::published()
            ->with(['category', 'location', 'coverImage'])
            ->whereHas('category', fn ($q) => $q->whereIn('slug', ['attractions', 'tour-operators', 'culture-crafts']))
            ->featuredFirst()
            ->limit(8)
            ->get();

        return view('pages.things-to-do', compact('listings'));
    }
}
