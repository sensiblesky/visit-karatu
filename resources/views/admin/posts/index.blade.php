@extends('layouts.admin')

@section('title', 'News & Media')
@section('heading', 'News & Media')

@section('actions')
    <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center gap-1.5 bg-red-600 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-red-700 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New Post
    </a>
@endsection

@section('content')

{{-- Status filter tabs --}}
@php
    $tabs = ['' => 'All', 'pending_review' => 'Pending review', 'draft' => 'Drafts', 'published' => 'Published', 'archived' => 'Archived'];
@endphp
<div class="flex flex-wrap gap-2 mb-6">
    @foreach($tabs as $key => $label)
        <a href="{{ route('admin.posts.index', array_filter(['status' => $key])) }}"
           class="px-3.5 py-1.5 rounded-full text-xs font-semibold transition {{ $status === $key ? 'bg-gray-900 text-white' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
            {{ $label }}
            @if($key && ($counts[$key] ?? 0) > 0)<span class="ml-1 opacity-70">{{ $counts[$key] }}</span>@endif
        </a>
    @endforeach
</div>

@if($posts->isEmpty())
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center text-gray-400">
        No posts here yet.
    </div>
@else
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3 text-left">Title</th>
                    <th class="px-6 py-3 text-left">Type</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Author</th>
                    <th class="px-6 py-3 text-left">Date</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($posts as $post)
                    @php
                        $statusStyles = [
                            'draft' => 'bg-gray-100 text-gray-600',
                            'pending_review' => 'bg-yellow-100 text-yellow-800',
                            'published' => 'bg-forest-100 text-forest-700',
                            'archived' => 'bg-gray-100 text-gray-400',
                        ][$post->status] ?? 'bg-gray-100 text-gray-600';
                    @endphp
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-gray-900 flex items-center gap-2">
                                {{ $post->title }}
                                @if($post->is_breaking)<span class="text-[10px] font-bold uppercase bg-red-100 text-red-600 px-1.5 py-0.5 rounded">Breaking</span>@endif
                            </p>
                        </td>
                        <td class="px-6 py-4 text-gray-500 capitalize">{{ $post->type }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-bold {{ $statusStyles }}">{{ str_replace('_', ' ', $post->status) }}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ $post->author?->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-gray-400">{{ optional($post->published_at)->format('d M Y') ?? $post->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($post->status === 'pending_review')
                                    <form method="POST" action="{{ route('admin.posts.approve', $post) }}">
                                        @csrf<button class="text-forest-700 hover:underline text-xs font-semibold">Approve</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.posts.reject', $post) }}">
                                        @csrf<button class="text-yellow-700 hover:underline text-xs">Reject</button>
                                    </form>
                                @endif
                                <a href="{{ route('admin.posts.edit', $post) }}" class="text-gray-600 hover:underline text-xs font-medium">Edit</a>
                                @if($post->status === 'published')
                                    <form method="POST" action="{{ route('admin.posts.archive', $post) }}">
                                        @csrf<button class="text-gray-500 hover:underline text-xs">Archive</button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" onsubmit="return confirm('Delete this post?')">
                                    @csrf @method('DELETE')<button class="text-red-500 hover:underline text-xs">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $posts->links() }}</div>
    <p class="text-xs text-gray-400 mt-4">Editorial flow: authors submit for review → an editor/auditor approves before anything goes live. Published stories auto-move to the public archive after {{ \App\Models\Post::ARCHIVE_AFTER_DAYS }} days.</p>
@endif
@endsection
