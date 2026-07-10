<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use App\Models\SponsorApplication;
use App\Mail\SponsorApplicationReceived;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SponsorPageController extends Controller
{
    public function index()
    {
        // Commercial/tourism sponsors, graded by level (Platinum → Gold → Silver).
        // Sports partners live on their own hub (/sports-sponsorships) to avoid
        // listing the same logos twice.
        $sponsors = Sponsor::active()->where('is_sports', false)->byLevel()->get();

        $labels = ['platinum' => 'Platinum Partners', 'gold' => 'Gold Sponsors', 'silver' => 'Silver Sponsors'];
        $grouped = $sponsors->groupBy(fn ($s) => $s->level ?: 'silver')
            ->sortBy(fn ($group, $level) => array_search($level, Sponsor::LEVELS) === false ? 99 : array_search($level, Sponsor::LEVELS));

        // Show the sports callout only when there are sports partners to point at.
        $hasSportsPartners = Sponsor::active()->sports()->exists();

        return view('pages.sponsors', compact('sponsors', 'grouped', 'labels', 'hasSportsPartners'));
    }

    public function apply(Request $request)
    {
        if ($request->filled('website_hp')) { // honeypot
            return back()->with('success', 'Thank you! We have received your interest and will be in touch.');
        }

        $data = $request->validate([
            'organisation' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'website_url' => 'nullable|url|max:255',
            'tier' => 'nullable|string|max:100',
            'message' => 'nullable|string|max:2000',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('sponsor-applications', 'public');
        }

        $application = SponsorApplication::create($data);

        // Notify the admin inbox (logged in dev; real mail once SMTP is configured).
        if ($to = setting('contact_email')) {
            Mail::to($to)->send(new SponsorApplicationReceived($application));
        }

        return back()->with('success', 'Thank you! Your sponsorship enquiry has been received — our team will be in touch shortly.');
    }
}
