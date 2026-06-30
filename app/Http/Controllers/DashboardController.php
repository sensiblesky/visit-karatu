<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Enquiry;
use App\Models\ListingView;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $listingIds = $user->listings()->pluck('id');

        $now = now();
        $currentStart = $now->copy()->subDays(30);
        $previousStart = $now->copy()->subDays(60);
        $previousEnd = $now->copy()->subDays(30);

        $profileViewsCurrent = ListingView::whereIn('listing_id', $listingIds)->where('viewed_at', '>=', $currentStart)->count();
        $profileViewsPrevious = ListingView::whereIn('listing_id', $listingIds)->whereBetween('viewed_at', [$previousStart, $previousEnd])->count();

        $bookingsCurrent = Booking::whereIn('listing_id', $listingIds)->where('created_at', '>=', $currentStart)->count();
        $bookingsPrevious = Booking::whereIn('listing_id', $listingIds)->whereBetween('created_at', [$previousStart, $previousEnd])->count();

        $enquiriesCurrent = Enquiry::whereIn('listing_id', $listingIds)->where('created_at', '>=', $currentStart)->count();
        $enquiriesPrevious = Enquiry::whereIn('listing_id', $listingIds)->whereBetween('created_at', [$previousStart, $previousEnd])->count();

        $stats = [
            'profile_views' => ['value' => $profileViewsCurrent, 'delta' => $this->delta($profileViewsCurrent, $profileViewsPrevious)],
            'search_views' => ['value' => $profileViewsCurrent, 'delta' => $this->delta($profileViewsCurrent, $profileViewsPrevious)],
            'bookings' => ['value' => $bookingsCurrent, 'delta' => $this->delta($bookingsCurrent, $bookingsPrevious)],
            'enquiries' => ['value' => $enquiriesCurrent, 'delta' => $this->delta($enquiriesCurrent, $enquiriesPrevious)],
        ];

        // Bookings per day for chart (last 30 days). Group in PHP so this stays
        // database-agnostic (SQLite/MySQL date functions differ).
        $bookingsChart = Booking::whereIn('listing_id', $listingIds)
            ->where('created_at', '>=', $currentStart)
            ->get(['created_at'])
            ->groupBy(fn ($booking) => $booking->created_at->format('Y-m-d'))
            ->map->count();

        // Fill in zeros for missing days
        $chartData = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartData[$date] = $bookingsChart[$date] ?? 0;
        }

        // Source breakdown donut chart
        $sourceCounts = ListingView::whereIn('listing_id', $listingIds)
            ->where('viewed_at', '>=', $currentStart)
            ->selectRaw('source, count(*) as count')
            ->groupBy('source')
            ->pluck('count', 'source');

        $recentBookings = Booking::whereIn('listing_id', $listingIds)
            ->with('listing')
            ->latest()
            ->limit(10)
            ->get();

        return view('dashboard.index', compact('stats', 'chartData', 'sourceCounts', 'recentBookings'));
    }

    public function bookings()
    {
        $bookings = Booking::whereIn('listing_id', auth()->user()->listings()->pluck('id'))
            ->with('listing')
            ->latest()
            ->paginate(20);

        return view('dashboard.bookings', compact('bookings'));
    }

    public function analytics()
    {
        return view('dashboard.analytics');
    }

    public function reviews()
    {
        $reviews = \App\Models\Review::whereIn('listing_id', auth()->user()->listings()->pluck('id'))
            ->with(['listing', 'user'])
            ->latest()
            ->paginate(20);

        return view('dashboard.reviews', compact('reviews'));
    }

    public function messages()
    {
        $enquiries = Enquiry::whereIn('listing_id', auth()->user()->listings()->pluck('id'))
            ->with(['listing', 'user'])
            ->latest()
            ->paginate(20);

        return view('dashboard.messages', compact('enquiries'));
    }

    private function delta(int $current, int $previous): string
    {
        if ($previous === 0) return $current > 0 ? '+100%' : '0%';
        $pct = round((($current - $previous) / $previous) * 100);
        return ($pct >= 0 ? '+' : '') . $pct . '%';
    }
}
