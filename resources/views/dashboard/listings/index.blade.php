@extends('layouts.dashboard')

@section('title', 'My Listings')
@section('heading', 'My Listings')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    @if($listings->isEmpty())
        <div class="p-16 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-5">
                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
            </div>
            <p class="text-lg font-semibold text-gray-700">You haven't created any listings yet.</p>
            <p class="text-sm text-gray-400 mt-1 mb-6">Create your first listing to start reaching travellers.</p>
            <a href="{{ route('dashboard.listings.create') }}" class="inline-flex items-center gap-2 bg-forest-700 text-white px-6 py-3 rounded-xl font-semibold hover:bg-forest-800 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Create Your First Listing
            </a>
        </div>
    @else
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 text-left">Listing</th>
                    <th class="px-6 py-3 text-left">Category</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Plan</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($listings as $listing)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-gray-900">{{ $listing->name }}</p>
                            <p class="text-gray-400 text-xs mt-0.5">{{ $listing->location->name }}</p>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $listing->category->name }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-bold
                                {{ $listing->status === 'published' ? 'bg-forest-100 text-forest-700' : ($listing->status === 'rejected' ? 'bg-red-100 text-red-700' : ($listing->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-600')) }}">
                                {{ ucfirst($listing->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-medium {{ $listing->plan_tier === 'premium' ? 'text-purple-700' : ($listing->plan_tier === 'featured' ? 'text-forest-700' : 'text-gray-500') }}">
                                {{ ucfirst($listing->plan_tier) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('dashboard.listings.edit', $listing) }}" class="text-forest-700 hover:underline text-xs font-medium">Edit</a>
                                @if($listing->status === 'published')
                                    <a href="{{ route('listings.show', $listing->slug) }}" target="_blank" class="text-gray-500 hover:underline text-xs">View</a>
                                @endif
                                <form method="POST" action="{{ route('dashboard.listings.destroy', $listing) }}"
                                      onsubmit="return confirm('Delete this listing? This cannot be undone.')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:underline text-xs">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $listings->links() }}
        </div>
    @endif
</div>
@endsection
