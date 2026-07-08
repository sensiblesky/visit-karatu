<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Listing;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = [];

        // Static pages
        foreach ([
            ['loc' => route('home'), 'freq' => 'daily', 'pri' => '1.0'],
            ['loc' => route('listings.index'), 'freq' => 'daily', 'pri' => '0.9'],
            ['loc' => route('listings.map'), 'freq' => 'weekly', 'pri' => '0.6'],
            ['loc' => route('events.index'), 'freq' => 'weekly', 'pri' => '0.7'],
            ['loc' => route('sponsors.index'), 'freq' => 'monthly', 'pri' => '0.5'],
            ['loc' => route('about'), 'freq' => 'monthly', 'pri' => '0.5'],
            ['loc' => route('district-council'), 'freq' => 'monthly', 'pri' => '0.4'],
        ] as $u) {
            $urls[] = $u;
        }

        foreach (Category::orderBy('sort_order')->get() as $cat) {
            $urls[] = ['loc' => route('listings.category', $cat->slug), 'freq' => 'weekly', 'pri' => '0.7'];
        }

        foreach (Listing::published()->latest('updated_at')->get() as $listing) {
            $urls[] = [
                'loc' => route('listings.show', $listing->slug),
                'lastmod' => $listing->updated_at->toAtomString(),
                'freq' => 'weekly',
                'pri' => '0.8',
            ];
        }

        $xml = view('sitemap', compact('urls'))->render();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
