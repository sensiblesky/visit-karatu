<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /** Current news feed (published, within the 30-day window). */
    public function index(Request $request)
    {
        $breaking = Post::breaking()->latestFirst()->limit(5)->get();

        $posts = Post::current()->articles()
            ->with('author')
            ->latestFirst()
            ->paginate(9)
            ->withQueryString();

        return view('news.index', compact('posts', 'breaking'));
    }

    /** Searchable archive of older / archived news. */
    public function archive(Request $request)
    {
        $q = trim((string) $request->get('q'));

        $posts = Post::archived()->articles()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('title', 'like', "%{$q}%")
                        ->orWhere('excerpt', 'like', "%{$q}%")
                        ->orWhere('body', 'like', "%{$q}%");
                });
            })
            ->latestFirst()
            ->paginate(12)
            ->withQueryString();

        return view('news.archive', compact('posts', 'q'));
    }

    public function show(Post $post)
    {
        abort_unless($post->status === 'published', 404);

        $post->increment('views');

        $related = Post::published()->articles()
            ->where('id', '!=', $post->id)
            ->latestFirst()
            ->limit(3)
            ->get();

        return view('news.show', compact('post', 'related'));
    }

    /** YouTube-hosted videos + pinned live event. */
    public function videos()
    {
        $live = Post::published()->videos()->where('is_live', true)->latestFirst()->first();

        $videos = Post::published()->videos()
            ->when($live, fn ($q) => $q->where('id', '!=', $live->id))
            ->latestFirst()
            ->paginate(12);

        return view('news.videos', compact('videos', 'live'));
    }
}
