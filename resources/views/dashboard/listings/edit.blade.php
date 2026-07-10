@extends('layouts.dashboard')

@section('title', 'Edit Listing')
@section('heading', 'Edit: ' . $listing->name)

@section('content')
<div class="max-w-3xl space-y-6">

    {{-- Status notice --}}
    <div class="bg-{{ $listing->status === 'published' ? 'forest' : ($listing->status === 'rejected' ? 'red' : 'yellow') }}-50 border border-{{ $listing->status === 'published' ? 'forest' : ($listing->status === 'rejected' ? 'red' : 'yellow') }}-200 rounded-2xl px-5 py-3.5 text-sm flex items-center gap-2.5">
        <span class="font-semibold capitalize">{{ $listing->status }}</span>
        <span class="text-gray-500">Saving changes re-submits this listing for admin approval.</span>
    </div>

    <form method="POST" action="{{ route('dashboard.listings.update', $listing) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf @method('PUT')
        @include('dashboard.listings._form', ['listing' => $listing])
        <div class="flex gap-4">
            <button type="submit" class="bg-forest-700 text-white font-bold px-8 py-3 rounded-xl hover:bg-forest-800 transition">
                Save & Re-submit
            </button>
            <a href="{{ route('dashboard.listings.index') }}" class="px-8 py-3 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50 transition">
                Cancel
            </a>
        </div>
    </form>

    {{-- Current photos management (separate from main form: delete / set cover / drag reorder) --}}
    @if($listing->images->count() > 0)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6"
             x-data="imageManager('{{ route('dashboard.listings.images.reorder', $listing) }}')">
            <div class="border-b pb-3 mb-5">
                <h3 class="font-bold text-gray-800">Current Photos</h3>
                <p class="text-xs text-gray-400 mt-0.5">Drag to reorder. Set a cover or delete any image. Changes apply immediately.</p>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                @foreach($listing->images as $img)
                    <div class="relative group rounded-xl overflow-hidden border border-gray-100 cursor-move"
                         draggable="true"
                         data-id="{{ $img->id }}"
                         @dragstart="onDragStart($event, {{ $img->id }})"
                         @dragover.prevent
                         @drop="onDrop($event, {{ $img->id }})">
                        <img loading="lazy" decoding="async" src="{{ Storage::url($img->path) }}" alt="" class="h-32 w-full object-cover pointer-events-none">

                        @if($img->is_cover)
                            <span class="absolute top-2 left-2 bg-forest-700 text-white text-xs font-bold px-2 py-0.5 rounded-full">Cover</span>
                        @endif

                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2">
                            @unless($img->is_cover)
                                <form method="POST" action="{{ route('dashboard.listings.images.cover', [$listing, $img]) }}">
                                    @csrf
                                    <button class="bg-white text-forest-800 text-xs font-semibold px-3 py-1.5 rounded-lg hover:bg-forest-50">Set cover</button>
                                </form>
                            @endunless
                            <form method="POST" action="{{ route('dashboard.listings.images.delete', [$listing, $img]) }}"
                                  onsubmit="return confirm('Delete this image?')">
                                @csrf @method('DELETE')
                                <button class="bg-white text-red-600 text-xs font-semibold px-3 py-1.5 rounded-lg hover:bg-red-50">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function imageManager(reorderUrl) {
    return {
        dragId: null,
        onDragStart(e, id) { this.dragId = id; e.dataTransfer.effectAllowed = 'move'; },
        onDrop(e, targetId) {
            if (this.dragId === null || this.dragId === targetId) return;
            const container = e.currentTarget.parentElement;
            const nodes = Array.from(container.children);
            const dragNode = nodes.find(n => n.dataset.id == this.dragId);
            const targetNode = nodes.find(n => n.dataset.id == targetId);
            container.insertBefore(dragNode, targetNode);
            this.persist(container);
            this.dragId = null;
        },
        persist(container) {
            const order = Array.from(container.children).map(n => n.dataset.id);
            fetch(reorderUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                },
                body: JSON.stringify({ order }),
            });
        }
    }
}
</script>
@endpush
