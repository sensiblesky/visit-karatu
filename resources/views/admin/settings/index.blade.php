@extends('layouts.admin')

@section('title', 'Site Settings')
@section('heading', 'Site Settings')

@section('content')
<div class="max-w-3xl">
    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
        @csrf @method('PUT')

        @php
            $groupLabels = [
                'branding' => 'Branding',
                'homepage' => 'Homepage Content',
                'contact'  => 'Contact Details',
                'footer'   => 'Footer',
                'social'   => 'Social Links',
            ];
        @endphp

        @foreach($groups as $group => $settings)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 border-b pb-3 mb-5">{{ $groupLabels[$group] ?? ucfirst($group) }}</h3>
                <div class="space-y-4">
                    @foreach($settings as $setting)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ $setting->label ?? $setting->key }}</label>
                            @if($setting->type === 'textarea')
                                <textarea name="settings[{{ $setting->key }}]" rows="3" class="form-input resize-y">{{ old('settings.' . $setting->key, $setting->value) }}</textarea>
                            @elseif($setting->type === 'select' && $setting->key === 'hero_media_type')
                                @php $current = old('settings.' . $setting->key, $setting->value); @endphp
                                <select name="settings[{{ $setting->key }}]" class="form-input">
                                    <option value="image" {{ $current === 'image' ? 'selected' : '' }}>Image</option>
                                    <option value="video" {{ $current === 'video' ? 'selected' : '' }}>Video</option>
                                </select>
                            @else
                                <input type="{{ in_array($setting->type, ['url', 'email']) ? $setting->type : 'text' }}"
                                       name="settings[{{ $setting->key }}]"
                                       value="{{ old('settings.' . $setting->key, $setting->value) }}"
                                       class="form-input">
                            @endif
                            <p class="text-xs text-gray-400 mt-1 font-mono">{{ $setting->key }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="sticky bottom-0 bg-gray-100 py-4">
            <button type="submit" class="bg-red-600 text-white font-bold px-8 py-3 rounded-xl hover:bg-red-700 transition">Save Settings</button>
        </div>
    </form>
</div>
@endsection
