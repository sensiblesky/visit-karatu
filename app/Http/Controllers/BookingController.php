<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Listing;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request, Listing $listing)
    {
        $data = $request->validate([
            'guest_name' => 'required|string|max:255',
            'adults' => 'required|integer|min:1|max:20',
            'children' => 'nullable|integer|min:0|max:20',
            'booking_date' => 'required|date|after:today',
        ]);

        $data['listing_id'] = $listing->id;
        $data['user_id'] = auth()->id();
        $data['children'] = $data['children'] ?? 0;
        $data['amount'] = $listing->price_amount * ($data['adults'] + ($data['children'] * 0.5));
        $data['status'] = 'pending';

        Booking::create($data);

        return back()->with('success', 'Booking request submitted! The operator will confirm your availability shortly.');
    }
}
