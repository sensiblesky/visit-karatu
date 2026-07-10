<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        // Honeypot — bots fill hidden fields.
        if ($request->filled('company')) {
            return back()->with('success', 'Thanks for subscribing!');
        }

        $data = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        NewsletterSubscriber::updateOrCreate(
            ['email' => strtolower($data['email'])],
            ['is_active' => true, 'unsubscribed_at' => null],
        );

        return back()->with('success', 'Thanks for subscribing — look out for Karatu news in your inbox.');
    }
}
