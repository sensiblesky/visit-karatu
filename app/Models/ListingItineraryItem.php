<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingItineraryItem extends Model
{
    protected $fillable = ['listing_id', 'day_label', 'description', 'sort_order'];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
