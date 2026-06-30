<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    protected $fillable = ['name', 'slug'];

    public function listings()
    {
        return $this->belongsToMany(Listing::class, 'listing_amenity');
    }
}
