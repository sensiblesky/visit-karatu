<?php

namespace App\Http\Controllers;

use App\Mail\EnquiryReceived;
use App\Models\Enquiry;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EnquiryController extends Controller
{
    public function store(Request $request, Listing $listing)
    {
        // Honeypot
        if ($request->filled('company')) {
            return back()->with('success', 'Your enquiry has been sent. The operator will contact you shortly.');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'message' => 'required|string|max:2000',
        ]);

        $data['listing_id'] = $listing->id;
        $data['user_id'] = auth()->id();

        $enquiry = Enquiry::create($data);

        // Notify the operator (listing contact, owner, then site inbox as fallback).
        if ($to = $listing->email ?: optional($listing->user)->email ?: setting('contact_email')) {
            Mail::to($to)->send(new EnquiryReceived($enquiry));
        }

        return back()->with('success', 'Your enquiry has been sent. The operator will contact you shortly.');
    }
}
