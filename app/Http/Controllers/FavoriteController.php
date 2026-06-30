<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function toggle(Listing $listing)
    {
        $user = auth()->user();
        $user->favorites()->toggle($listing->id);

        return back()->with('success', 'Wishlist updated.');
    }
}
