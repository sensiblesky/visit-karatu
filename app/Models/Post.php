<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Post extends Model
{
    /** Days a published article stays on the "current" news feed before auto-archiving. */
    public const ARCHIVE_AFTER_DAYS = 30;

    protected $fillable = [
        'title', 'slug', 'excerpt', 'body', 'cover_image',
        'type', 'youtube_url', 'is_live', 'is_breaking',
        'status', 'author_id', 'reviewed_by', 'review_note',
        'published_at', 'archived_at', 'views',
    ];

    protected $casts = [
        'is_live' => 'boolean',
        'is_breaking' => 'boolean',
        'published_at' => 'datetime',
        'archived_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function (Post $post) {
            if (empty($post->slug) && $post->title) {
                $base = Str::slug($post->title);
                $slug = $base;
                $i = 1;
                while (static::where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
                    $slug = $base.'-'.$i++;
                }
                $post->slug = $slug;
            }
        });
    }

    /* ---------------- Scopes ---------------- */

    /** Publicly visible: published and past its publish time. */
    public function scopePublished(Builder $q): Builder
    {
        return $q->where('status', 'published')
            ->where(function ($q) {
                $q->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
    }

    /** Live (non-archived) news — published within the archive window. */
    public function scopeCurrent(Builder $q): Builder
    {
        return $q->published()
            ->where('status', '!=', 'archived')
            ->where(function ($q) {
                $q->whereNull('published_at')
                    ->orWhere('published_at', '>=', now()->subDays(self::ARCHIVE_AFTER_DAYS));
            });
    }

    /** Older than the archive window, or explicitly archived. */
    public function scopeArchived(Builder $q): Builder
    {
        return $q->where(function ($q) {
            $q->where('status', 'archived')
                ->orWhere(function ($q) {
                    $q->where('status', 'published')
                        ->where('published_at', '<', now()->subDays(self::ARCHIVE_AFTER_DAYS));
                });
        });
    }

    public function scopeArticles(Builder $q): Builder
    {
        return $q->where('type', 'article');
    }

    public function scopeVideos(Builder $q): Builder
    {
        return $q->where('type', 'video');
    }

    public function scopeBreaking(Builder $q): Builder
    {
        return $q->published()->where('is_breaking', true)
            ->where('type', 'article')
            ->where(function ($q) {
                $q->whereNull('published_at')
                    ->orWhere('published_at', '>=', now()->subDays(self::ARCHIVE_AFTER_DAYS));
            });
    }

    public function scopeLatestFirst(Builder $q): Builder
    {
        return $q->orderByDesc('published_at')->orderByDesc('created_at');
    }

    /* ---------------- Accessors ---------------- */

    public function getCoverImageUrlAttribute(): ?string
    {
        if (! $this->cover_image) {
            return $this->youtube_thumbnail;
        }
        if (str_starts_with($this->cover_image, 'http') || str_starts_with($this->cover_image, '/')) {
            return $this->cover_image;
        }
        return Storage::url($this->cover_image);
    }

    public function getYoutubeIdAttribute(): ?string
    {
        if (! $this->youtube_url) {
            return null;
        }
        if (preg_match('~(?:youtu\.be/|youtube\.com/(?:watch\?v=|embed/|live/|shorts/))([\w-]{11})~', $this->youtube_url, $m)) {
            return $m[1];
        }
        return null;
    }

    public function getYoutubeThumbnailAttribute(): ?string
    {
        return $this->youtube_id ? "https://i.ytimg.com/vi/{$this->youtube_id}/hqdefault.jpg" : null;
    }

    public function getIsArchivedAttribute(): bool
    {
        return $this->status === 'archived'
            || ($this->status === 'published' && $this->published_at && $this->published_at->lt(now()->subDays(self::ARCHIVE_AFTER_DAYS)));
    }

    public function getReadingTimeAttribute(): int
    {
        return max(1, (int) ceil(str_word_count(strip_tags((string) $this->body)) / 200));
    }

    /* ---------------- Relations ---------------- */

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
