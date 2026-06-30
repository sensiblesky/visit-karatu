<?php

use App\Models\Setting;

if (! function_exists('setting')) {
    /**
     * Fetch a site setting value by key, with an optional default.
     */
    function setting(string $key, ?string $default = null): ?string
    {
        return Setting::get($key, $default);
    }
}
