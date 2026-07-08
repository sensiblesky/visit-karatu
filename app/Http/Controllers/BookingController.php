<?php

namespace App\Http\Controllers;

use App\Mail\BookingReceived;
use App\Models\Booking;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

        $booking = Booking::create($data);

        if ($to = $listing->email ?: optional($listing->user)->email ?: setting('contact_email')) {
            Mail::to($to)->send(new BookingReceived($booking));
        }

        return back()->with('success', 'Booking request submitted! The operator will confirm your availability shortly.');
    }
}
