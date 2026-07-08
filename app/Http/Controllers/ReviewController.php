<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Listing $listing)
    {
        // Honeypot: bots fill hidden fields; humans leave them empty.
        if ($request->filled('website')) {
            return back()->with('success', 'Thank you! Your review has been submitted for moderation.');
        }

        $data = $request->validate([
            'author_name' => 'required|string|max:255',
            'author_email' => 'nullable|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
        ]);

        Review::create([
            'listing_id' => $listing->id,
            'user_id' => auth()->id(),
            'author_name' => $data['author_name'],
            'author_email' => $data['author_email'] ?? null,
            'rating' => $data['rating'],
            'comment' => $data['comment'] ?? null,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Thank you! Your review has been submitted and will appear once approved.')
            ->withFragment('reviews');
    }
}
