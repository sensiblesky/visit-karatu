<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Sponsor extends Model
{
    /** Grading levels, highest first. Platinum shows on the front page + key pages. */
    public const LEVELS = ['platinum', 'gold', 'silver'];

    protected $fillable = [
        'name', 'slug', 'logo_path', 'hero_image', 'website_url',
        'summary', 'body', 'tier', 'level', 'is_sports', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_sports' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (Sponsor $s) {
            if (empty($s->slug) && $s->name) {
                $base = Str::slug($s->name);
                $slug = $base;
                $i = 1;
                while (static::where('slug', $slug)->where('id', '!=', $s->id)->exists()) {
                    $slug = $base.'-'.$i++;
                }
                $s->slug = $slug;
            }
        });
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /** Highest-grade sponsors first (platinum → gold → silver), then sort order. */
    public function scopeByLevel(Builder $query): Builder
    {
        return $query->orderByRaw("FIELD(level,'platinum','gold','silver')")
            ->orderBy('sort_order')->orderBy('name');
    }

    public function scopePlatinum(Builder $query): Builder
    {
        return $query->where('level', 'platinum');
    }

    public function scopeSports(Builder $query): Builder
    {
        return $query->where('is_sports', true);
    }

    public function getLogoUrlAttribute(): ?string
    {
        return $this->fileUrl($this->logo_path);
    }

    public function getHeroImageUrlAttribute(): ?string
    {
        return $this->fileUrl($this->hero_image);
    }

    private function fileUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }
        if (str_starts_with($path, 'http') || str_starts_with($path, '/')) {
            return $path;
        }
        return Storage::url($path);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
