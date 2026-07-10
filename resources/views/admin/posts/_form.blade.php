@php $isEdit = $post->exists; @endphp

@if($errors->any())
    <div class="mb-6 bg-red-50 border border-red-100 text-red-700 text-sm rounded-xl p-4">
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ $isEdit ? route('admin.posts.update', $post) : route('admin.posts.store') }}"
      enctype="multipart/form-data" x-data="{ type: '{{ old('type', $post->type ?? 'article') }}' }" class="space-y-6">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main column --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Title</label>
                    <input type="text" name="title" value="{{ old('title', $post->title) }}" required
                           class="w-full rounded-xl border-gray-200 focus:border-forest-500 focus:ring-forest-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Excerpt <span class="text-gray-400 font-normal">(short summary / headline preview)</span></label>
                    <textarea name="excerpt" rows="2" maxlength="500"
                              class="w-full rounded-xl border-gray-200 focus:border-forest-500 focus:ring-forest-500 text-sm">{{ old('excerpt', $post->excerpt) }}</textarea>
                </div>

                <div x-show="type === 'video'" x-cloak>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">YouTube URL</label>
                    <input type="url" name="youtube_url" value="{{ old('youtube_url', $post->youtube_url) }}" placeholder="https://youtu.be/…"
                           class="w-full rounded-xl border-gray-200 focus:border-forest-500 focus:ring-forest-500 text-sm">
                    <label class="inline-flex items-center gap-2 mt-3 text-sm text-gray-700">
                        <input type="checkbox" name="is_live" value="1" @checked(old('is_live', $post->is_live)) class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                        Pin as the live event (shown at the top of the Videos page)
                    </label>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Body</label>
                    <textarea name="body" rows="14"
                              class="w-full rounded-xl border-gray-200 focus:border-forest-500 focus:ring-forest-500 text-sm leading-relaxed">{{ old('body', $post->body) }}</textarea>
                    <p class="text-xs text-gray-400 mt-1">Plain text with line breaks. Paragraph spacing is preserved on the public page.</p>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Type</label>
                    <select name="type" x-model="type" class="w-full rounded-xl border-gray-200 focus:border-forest-500 focus:ring-forest-500 text-sm">
                        <option value="article">Article (news)</option>
                        <option value="video">Video (YouTube)</option>
                    </select>
                </div>
                <label class="flex items-center gap-2 text-sm text-gray-700">
                    <input type="checkbox" name="is_breaking" value="1" @checked(old('is_breaking', $post->is_breaking)) class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                    Breaking / highlight (front-page ticker)
                </label>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Publish date <span class="text-gray-400 font-normal">(optional)</span></label>
                    <input type="datetime-local" name="published_at"
                           value="{{ old('published_at', optional($post->published_at)->format('Y-m-d\TH:i')) }}"
                           class="w-full rounded-xl border-gray-200 focus:border-forest-500 focus:ring-forest-500 text-sm">
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Cover image</label>
                @if($post->cover_image_url)
                    <img src="{{ $post->cover_image_url }}" alt="" class="w-full h-32 object-cover rounded-xl mb-3">
                @endif
                <input type="file" name="cover" accept="image/*" class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-forest-50 file:text-forest-700 file:text-sm file:font-medium">
                <p class="text-xs text-gray-400 mt-2">Videos use the YouTube thumbnail automatically if no cover is set.</p>
            </div>

            {{-- Workflow actions --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-2">
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-400 mb-2">Save as</p>
                <button type="submit" name="action" value="save" class="w-full text-sm font-semibold px-4 py-2.5 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50 transition">Save draft</button>
                <button type="submit" name="action" value="submit" class="w-full text-sm font-semibold px-4 py-2.5 rounded-xl bg-yellow-100 text-yellow-800 hover:bg-yellow-200 transition">Submit for review</button>
                <button type="submit" name="action" value="publish" class="w-full text-sm font-semibold px-4 py-2.5 rounded-xl bg-forest-700 text-white hover:bg-forest-800 transition">Publish now</button>
                @if($isEdit)
                    <a href="{{ route('admin.posts.index') }}" class="block text-center text-xs text-gray-400 hover:text-gray-600 pt-2">Cancel</a>
                @endif
            </div>
        </div>
    </div>
</form>
