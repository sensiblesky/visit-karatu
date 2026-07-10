<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');

        $posts = Post::with('author')
            ->when($status, fn ($q) => $q->where('status', $status))
            ->orderByRaw("FIELD(status,'pending_review','draft','published','archived')")
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        $counts = Post::selectRaw('status, count(*) as c')->groupBy('status')->pluck('c', 'status');

        return view('admin.posts.index', compact('posts', 'status', 'counts'));
    }

    public function create()
    {
        return view('admin.posts.create', ['post' => new Post(['type' => 'article', 'status' => 'draft'])]);
    }

    public function store(Request $request)
    {
        $data = $this->validatePost($request);
        $data['author_id'] = $request->user()->id;
        $data = $this->applyStatus($request, $data, new Post());

        if ($request->hasFile('cover')) {
            $data['cover_image'] = $request->file('cover')->store('news', 'public');
        }

        Post::create($data);

        return redirect()->route('admin.posts.index')->with('success', 'Post created.');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $this->validatePost($request);
        $data = $this->applyStatus($request, $data, $post);

        if ($request->hasFile('cover')) {
            if ($post->cover_image && ! str_starts_with($post->cover_image, 'http')) {
                Storage::disk('public')->delete($post->cover_image);
            }
            $data['cover_image'] = $request->file('cover')->store('news', 'public');
        }

        $post->update($data);

        return redirect()->route('admin.posts.index')->with('success', 'Post updated.');
    }

    /** Editor/Auditor sign-off: move a pending post to published. */
    public function approve(Request $request, Post $post)
    {
        $post->update([
            'status' => 'published',
            'reviewed_by' => $request->user()->id,
            'published_at' => $post->published_at ?? now(),
        ]);

        return back()->with('success', "“{$post->title}” approved and published.");
    }

    public function reject(Request $request, Post $post)
    {
        $post->update([
            'status' => 'draft',
            'reviewed_by' => $request->user()->id,
            'review_note' => $request->input('review_note'),
        ]);

        return back()->with('success', "“{$post->title}” sent back to the author.");
    }

    public function archive(Post $post)
    {
        $post->update(['status' => 'archived', 'archived_at' => now()]);
        return back()->with('success', "“{$post->title}” archived.");
    }

    public function destroy(Post $post)
    {
        if ($post->cover_image && ! str_starts_with($post->cover_image, 'http')) {
            Storage::disk('public')->delete($post->cover_image);
        }
        $post->delete();

        return back()->with('success', 'Post deleted.');
    }

    private function validatePost(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'body' => 'nullable|string',
            'type' => 'required|in:article,video',
            'youtube_url' => 'nullable|url|max:255|required_if:type,video',
            'is_live' => 'nullable|boolean',
            'is_breaking' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'cover' => 'nullable|image|max:4096',
        ]);
    }

    /**
     * Resolve the target status from the submitted action.
     * Authors "submit for review"; editors/auditors "publish" directly.
     */
    private function applyStatus(Request $request, array $data, Post $post): array
    {
        $data['is_live'] = $request->boolean('is_live');
        $data['is_breaking'] = $request->boolean('is_breaking');

        $action = $request->input('action', 'save');

        $data['status'] = match ($action) {
            'submit'  => 'pending_review',
            'publish' => 'published',
            'archive' => 'archived',
            default   => $post->status ?: 'draft',
        };

        if ($data['status'] === 'published') {
            $data['reviewed_by'] = $request->user()->id;
            $data['published_at'] = $data['published_at'] ?? $post->published_at ?? now();
        }

        return $data;
    }
}
