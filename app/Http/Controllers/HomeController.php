<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Listing;
use App\Models\Location;
use App\Models\Sponsor;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('sort_order')->get();

        $locations = Location::all();

        $sponsors = Sponsor::active()->ordered()->get();

        $featured = Listing::published()
            ->with(['category', 'location', 'coverImage'])
            ->withAvg('approvedReviews', 'rating')
            ->withCount('approvedReviews')
            ->where(function ($q) {
                $q->where('is_popular', true)->orWhere('plan_tier', '!=', 'basic');
            })
            ->featuredFirst()
            ->orderByDesc('is_popular')
            ->limit(8)
            ->get();

        return view('home', compact('categories', 'locations', 'featured', 'sponsors'));
    }
}
