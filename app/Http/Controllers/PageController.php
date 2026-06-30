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
}
