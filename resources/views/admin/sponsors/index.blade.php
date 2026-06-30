@extends('layouts.admin')

@section('title', 'Sponsors')
@section('heading', 'Sponsors & Partners')

@section('actions')
    <a href="{{ route('admin.sponsors.create') }}" class="inline-flex items-center gap-1.5 bg-red-600 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-red-700 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New Sponsor
    </a>
@endsection

@section('content')
@if($sponsors->isEmpty())
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center text-gray-400">
        No sponsors yet. Add your first partner.
    </div>
@else
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 text-left">Order</th>
                    <th class="px-6 py-3 text-left">Logo</th>
                    <th class="px-6 py-3 text-left">Sponsor</th>
                    <th class="px-6 py-3 text-left">Tier</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($sponsors as $sponsor)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-gray-400 font-mono">{{ $sponsor->sort_order }}</td>
                        <td class="px-6 py-4">
                            <div class="w-24 h-12 bg-gray-50 rounded-lg border border-gray-100 flex items-center justify-center overflow-hidden">
                                @if($sponsor->logo_path)
                                    <img loading="lazy" decoding="async" src="{{ Storage::url($sponsor->logo_path) }}" alt="{{ $sponsor->name }}" class="max-h-10 max-w-[88px] object-contain">
                                @else
                                    <span class="text-xs text-gray-300">No logo</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-semibold text-gray-900">{{ $sponsor->name }}</p>
                            @if($sponsor->website_url)
                                <a href="{{ $sponsor->website_url }}" target="_blank" class="text-xs text-forest-700 hover:underline">{{ $sponsor->website_url }}</a>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $sponsor->tier ?: '—' }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-bold {{ $sponsor->is_active ? 'bg-forest-100 text-forest-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $sponsor->is_active ? 'Active' : 'Hidden' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.sponsors.edit', $sponsor) }}" class="text-forest-700 hover:underline text-xs font-medium">Edit</a>
                                <form method="POST" action="{{ route('admin.sponsors.destroy', $sponsor) }}" onsubmit="return confirm('Remove this sponsor?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:underline text-xs">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <p class="text-xs text-gray-400 mt-4">Active sponsors appear in the “Our Partners” strip on the homepage, ordered by the Order column.</p>
@endif
@endsection
