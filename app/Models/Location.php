<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['name', 'slug', 'latitude', 'longitude'];

    public function listings()
    {
        return $this->hasMany(Listing::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
