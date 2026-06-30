<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingView extends Model
{
    public $timestamps = false;

    protected $fillable = ['listing_id', 'viewed_at', 'source'];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
