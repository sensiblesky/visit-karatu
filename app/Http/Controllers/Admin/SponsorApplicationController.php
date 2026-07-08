<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use App\Models\SponsorApplication;

class SponsorApplicationController extends Controller
{
    public function index()
    {
        $applications = SponsorApplication::latest()->paginate(20);
        return view('admin.sponsor_applications.index', compact('applications'));
    }

    public function approve(SponsorApplication $application)
    {
        Sponsor::create([
            'name' => $application->organisation,
            'logo_path' => $application->logo_path, // may be null; admin can upload later
            'website_url' => $application->website_url,
            'tier' => $application->tier ?: 'Partner',
            'sort_order' => (Sponsor::max('sort_order') ?? 0) + 1,
            'is_active' => false, // admin activates after adding a logo
        ]);

        $application->update(['status' => 'approved']);

        return back()->with('success', "Approved — '{$application->organisation}' added as a sponsor (hidden until you activate it in Sponsors).");
    }

    public function reject(SponsorApplication $application)
    {
        $application->update(['status' => 'rejected']);
        return back()->with('success', 'Application rejected.');
    }

    public function destroy(SponsorApplication $application)
    {
        $application->delete();
        return back()->with('success', 'Application deleted.');
    }
}
