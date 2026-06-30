<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'location_id', 'name', 'slug',
        'short_description', 'full_description', 'price_amount', 'price_unit',
        'status', 'plan_tier', 'is_popular', 'latitude', 'longitude',
        'address_text', 'phone', 'whatsapp_number', 'email', 'tags', 'published_at',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_popular' => 'boolean',
        'published_at' => 'datetime',
        'price_amount' => 'decimal:2',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function scopeFeaturedFirst(Builder $query): Builder
    {
        return $query->orderByRaw("CASE plan_tier WHEN 'premium' THEN 0 WHEN 'featured' THEN 1 ELSE 2 END");
    }

    /**
     * Tab keys to actually render on this listing's detail page: the category's
     * enabled tabs, minus any data-driven tab whose backing relation is empty.
     * Returns [key => label] preserving order.
     *
     * @return array<string, string>
     */
    public function visibleTabs(): array
    {
        $catalog = config('listing_tabs.tabs');
        $result = [];

        foreach ($this->category->resolvedTabs() as $key) {
            $def = $catalog[$key] ?? null;
            if (! $def) {
                continue;
            }

            // Data-driven tabs hide themselves when their relation is empty,
            // unless they are "always" tabs (Overview/Reviews stay).
            if (! ($def['always'] ?? false) && ! empty($def['needs'])) {
                $relation = $def['needs'];
                if ($this->{$relation}->isEmpty()) {
                    continue;
                }
            }

            $result[$key] = $def['label'];
        }

        return $result;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function images()
    {
        return $this->hasMany(ListingImage::class)->orderBy('sort_order');
    }

    public function coverImage()
    {
        return $this->hasOne(ListingImage::class)->where('is_cover', true);
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'listing_amenity');
    }

    public function itineraryItems()
    {
        return $this->hasMany(ListingItineraryItem::class)->orderBy('sort_order');
    }

    public function includeExcludes()
    {
        return $this->hasMany(ListingIncludeExclude::class);
    }

    public function includes()
    {
        return $this->hasMany(ListingIncludeExclude::class)->where('type', 'include');
    }

    public function excludes()
    {
        return $this->hasMany(ListingIncludeExclude::class)->where('type', 'exclude');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(Review::class)->where('status', 'approved');
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function enquiries()
    {
        return $this->hasMany(Enquiry::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function views()
    {
        return $this->hasMany(ListingView::class);
    }
}
