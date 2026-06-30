<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'icon', 'description', 'tabs', 'sort_order'];

    protected $casts = [
        'tabs' => 'array',
    ];

    public function listings()
    {
        return $this->hasMany(Listing::class);
    }

    /**
     * The ordered list of tab keys this category exposes, falling back to the
     * config defaults when the admin hasn't set an explicit list. 'overview'
     * and 'reviews' (the `always` tabs) are guaranteed to be present.
     *
     * @return array<int, string>
     */
    public function resolvedTabs(): array
    {
        $available = array_keys(config('listing_tabs.tabs'));

        $tabs = $this->tabs;
        if (empty($tabs)) {
            $defaults = config('listing_tabs.defaults');
            $tabs = $defaults[$this->slug] ?? $defaults['default'];
        }

        // Keep only known tab keys, in their configured order, then force-include
        // any "always" tabs the admin may have left out.
        $tabs = array_values(array_intersect($tabs, $available));

        foreach (config('listing_tabs.tabs') as $key => $def) {
            if (($def['always'] ?? false) && ! in_array($key, $tabs, true)) {
                // Overview first, Reviews last; otherwise append.
                $key === 'overview' ? array_unshift($tabs, $key) : $tabs[] = $key;
            }
        }

        return array_values(array_unique($tabs));
    }

    /**
     * Tab keys the admin is allowed to toggle (everything except `always` tabs).
     *
     * @return array<int, string>
     */
    public static function togglableTabs(): array
    {
        return collect(config('listing_tabs.tabs'))
            ->reject(fn ($def) => $def['always'] ?? false)
            ->keys()
            ->all();
    }
}
