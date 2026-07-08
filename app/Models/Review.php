<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['listing_id', 'user_id', 'author_name', 'author_email', 'rating', 'comment', 'status'];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Display name for the reviewer, whether a registered user or a guest. */
    public function getReviewerNameAttribute(): string
    {
        return $this->user?->name ?? $this->author_name ?? 'Guest';
    }
}
