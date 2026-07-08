@extends('layouts.admin')

@section('title', 'Sponsor Applications')
@section('heading', 'Sponsor Applications')

@section('content')
@if($applications->isEmpty())
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center text-gray-400">
        No sponsorship enquiries yet.
    </div>
@else
    <div class="space-y-4">
        @foreach($applications as $app)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div class="flex items-start gap-4 min-w-0">
                        @if($app->logo_path)
                            <div class="w-16 h-16 bg-gray-50 rounded-xl border border-gray-100 flex items-center justify-center shrink-0 overflow-hidden">
                                <img src="{{ Storage::url($app->logo_path) }}" alt="" class="max-h-14 max-w-14 object-contain">
                            </div>
                        @endif
                        <div class="min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-bold text-gray-900">{{ $app->organisation }}</span>
                                @if($app->tier)<span class="text-xs bg-forest-50 text-forest-700 px-2 py-0.5 rounded-full">{{ $app->tier }}</span>@endif
                                <span class="px-2 py-0.5 rounded-full text-xs font-bold
                                    {{ $app->status === 'approved' ? 'bg-forest-100 text-forest-700' : ($app->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                    {{ ucfirst($app->status) }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">{{ $app->contact_name }} ·
                                <a href="mailto:{{ $app->email }}" class="text-forest-700 hover:underline">{{ $app->email }}</a>
                                @if($app->phone) · {{ $app->phone }}@endif
                            </p>
                            @if($app->website_url)
                                <a href="{{ $app->website_url }}" target="_blank" class="text-xs text-forest-700 hover:underline">{{ $app->website_url }}</a>
                            @endif
                            @if($app->message)<p class="text-sm text-gray-600 mt-2">{{ $app->message }}</p>@endif
                            <p class="text-xs text-gray-400 mt-2">{{ $app->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        @if($app->status !== 'approved')
                            <form method="POST" action="{{ route('admin.sponsor_applications.approve', $app) }}">
                                @csrf
                                <button class="bg-forest-700 text-white text-xs font-bold px-3 py-2 rounded-lg hover:bg-forest-800 transition">Approve → add sponsor</button>
                            </form>
                        @endif
                        @if($app->status !== 'rejected')
                            <form method="POST" action="{{ route('admin.sponsor_applications.reject', $app) }}">
                                @csrf
                                <button class="bg-yellow-100 text-yellow-800 text-xs font-bold px-3 py-2 rounded-lg hover:bg-yellow-200 transition">Reject</button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('admin.sponsor_applications.destroy', $app) }}" onsubmit="return confirm('Delete this application?')">
                            @csrf @method('DELETE')
                            <button class="bg-red-100 text-red-700 text-xs font-bold px-3 py-2 rounded-lg hover:bg-red-200 transition">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-6">{{ $applications->links() }}</div>
@endif
@endsection
