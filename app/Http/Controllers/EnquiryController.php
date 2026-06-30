<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\Listing;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    public function store(Request $request, Listing $listing)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'message' => 'required|string|max:2000',
        ]);

        $data['listing_id'] = $listing->id;
        $data['user_id'] = auth()->id();

        Enquiry::create($data);

        return back()->with('success', 'Your enquiry has been sent. The operator will contact you shortly.');
    }
}
