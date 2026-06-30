<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\Review;

class ListingController extends Controller
{
    public function index()
    {
        $pendingListings = Listing::where('status', 'pending')->with(['user', 'category'])->latest()->get();
        $pendingReviews = Review::where('status', 'pending')->with(['listing', 'user'])->latest()->get();

        return view('admin.index', compact('pendingListings', 'pendingReviews'));
    }

    public function approve(Listing $listing)
    {
        $listing->update(['status' => 'published', 'published_at' => now()]);
        return back()->with('success', "Listing \"{$listing->name}\" approved and published.");
    }

    public function reject(Listing $listing)
    {
        $listing->update(['status' => 'rejected']);
        return back()->with('success', "Listing \"{$listing->name}\" rejected.");
    }
}
