<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    protected $fillable = ['title', 'description', 'location_id', 'starts_at', 'ends_at', 'cover_image'];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    /**
     * Full URL for the cover image, supporting both externally hosted URLs
     * (dummy/seed data) and locally stored upload paths.
     */
    public function getCoverImageUrlAttribute(): ?string
    {
        if (! $this->cover_image) {
            return null;
        }

        // Absolute URL (external) or root-relative public path (seeded placeholders)
        if (str_starts_with($this->cover_image, 'http') || str_starts_with($this->cover_image, '/')) {
            return $this->cover_image;
        }

        // Otherwise a stored upload path on the public disk
        return Storage::url($this->cover_image);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
