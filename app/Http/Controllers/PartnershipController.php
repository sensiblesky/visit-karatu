<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;

class PartnershipController extends Controller
{
    /** Visit-Rwanda-style Sports Sponsorships hub. */
    public function sportsIndex()
    {
        $partners = Sponsor::active()->sports()->byLevel()->get();

        return view('pages.sports-sponsorships', compact('partners'));
    }

    /** Per-partner detail page. */
    public function show(Sponsor $sponsor)
    {
        abort_unless($sponsor->is_active, 404);

        $others = Sponsor::active()->sports()
            ->where('id', '!=', $sponsor->id)
            ->byLevel()->limit(4)->get();

        return view('pages.partner-show', compact('sponsor', 'others'));
    }

    public function invest()
    {
        return view('pages.invest');
    }
}
