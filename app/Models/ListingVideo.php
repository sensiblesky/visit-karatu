<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingVideo extends Model
{
    protected $fillable = ['listing_id', 'path', 'poster', 'sort_order'];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
