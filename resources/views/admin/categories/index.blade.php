@extends('layouts.admin')

@section('title', 'Categories')
@section('heading', 'Categories')

@section('actions')
    <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center gap-1.5 bg-red-600 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-red-700 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New Category
    </a>
@endsection

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
            <tr>
                <th class="px-6 py-3 text-left">Order</th>
                <th class="px-6 py-3 text-left">Category</th>
                <th class="px-6 py-3 text-left">Detail-page Tabs</th>
                <th class="px-6 py-3 text-left">Listings</th>
                <th class="px-6 py-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @foreach($categories as $category)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-gray-400 font-mono">{{ $category->sort_order }}</td>
                    <td class="px-6 py-4">
                        <p class="font-semibold text-gray-900">{{ $category->name }}</p>
                        <p class="text-gray-400 text-xs mt-0.5 font-mono">{{ $category->slug }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-1.5">
                            @foreach($category->resolvedTabs() as $tab)
                                <span class="text-xs bg-forest-50 text-forest-700 px-2 py-0.5 rounded-full capitalize">{{ $tab }}</span>
                            @endforeach
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $category->listings_count }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="text-forest-700 hover:underline text-xs font-medium">Edit</a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                                  onsubmit="return confirm('Delete this category?')">
                                @csrf @method('DELETE')
                                <button class="text-red-500 hover:underline text-xs" {{ $category->listings_count > 0 ? 'disabled title=Has-listings' : '' }}
                                        @class(['opacity-30 cursor-not-allowed' => $category->listings_count > 0])>Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<p class="text-xs text-gray-400 mt-4">Overview and Reviews tabs are always shown and can't be disabled. Toggle the rest per category when editing.</p>
@endsection
