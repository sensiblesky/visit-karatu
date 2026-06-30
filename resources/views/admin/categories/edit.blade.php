@extends('layouts.admin')

@section('title', 'Edit Category')
@section('heading', 'Edit: ' . $category->name)

@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="space-y-6">
        @csrf @method('PUT')
        @include('admin.categories._form')
        <div class="flex gap-4">
            <button type="submit" class="bg-red-600 text-white font-bold px-8 py-3 rounded-xl hover:bg-red-700 transition">Save Changes</button>
            <a href="{{ route('admin.categories.index') }}" class="px-8 py-3 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50 transition">Cancel</a>
        </div>
    </form>
</div>
@endsection
