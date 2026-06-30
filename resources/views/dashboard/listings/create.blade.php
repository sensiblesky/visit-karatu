@extends('layouts.dashboard')

@section('title', 'Create Listing')
@section('heading', 'Create New Listing')

@section('content')
<div class="max-w-3xl">
    <form method="POST" action="{{ route('dashboard.listings.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @include('dashboard.listings._form', ['listing' => null])
        <div class="flex gap-4">
            <button type="submit" class="bg-forest-700 text-white font-bold px-8 py-3 rounded-xl hover:bg-forest-800 transition">
                Submit for Review
            </button>
            <a href="{{ route('dashboard.listings.index') }}" class="px-8 py-3 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50 transition">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
