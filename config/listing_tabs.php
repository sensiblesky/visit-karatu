<?php

/*
|--------------------------------------------------------------------------
| Listing detail-page tab catalog
|--------------------------------------------------------------------------
|
| This is the catalog of tab TYPES the application knows how to render on the
| listing detail page. Each entry needs a matching partial in
| resources/views/listings/tabs/{key}.blade.php.
|
| WHICH of these tabs a given category actually shows is admin-editable and
| stored on the `categories.tabs` JSON column (see Category::resolvedTabs()).
| This config only declares what is *available* and its default label — the
| structural catalog is developer-owned because each tab needs render code,
| while the per-category on/off + ordering is content and lives in the DB.
|
| `always` tabs cannot be switched off by the admin (Overview / Reviews are the
| spine of every listing). `needs` names the relation that must be non-empty for
| the tab to appear, so an enabled-but-empty tab still hides itself gracefully.
|
*/

return [
    'tabs' => [
        'overview' => [
            'label'  => 'Overview',
            'always' => true,
            'needs'  => null,
        ],
        'amenities' => [
            'label'  => 'Amenities',
            'always' => false,
            'needs'  => 'amenities',
        ],
        'itinerary' => [
            'label'  => 'Itinerary',
            'always' => false,
            'needs'  => 'itineraryItems',
        ],
        'includes' => [
            'label'  => 'Includes',
            'always' => false,
            'needs'  => 'includes',
        ],
        'excludes' => [
            'label'  => 'Excludes',
            'always' => false,
            'needs'  => 'excludes',
        ],
        'reviews' => [
            'label'  => 'Reviews',
            'always' => true,
            'needs'  => null,
        ],
    ],

    /*
    | Sensible defaults applied when a category has no explicit `tabs` value.
    | Keyed by category slug; anything not listed falls back to 'default'.
    */
    'defaults' => [
        'default'        => ['overview', 'reviews'],
        'lodges-hotels'  => ['overview', 'amenities', 'reviews'],
        'tour-operators' => ['overview', 'itinerary', 'includes', 'excludes', 'reviews'],
        'attractions'    => ['overview', 'itinerary', 'reviews'],
        'sport-clubs'    => ['overview', 'reviews'],
        'culture-crafts' => ['overview', 'reviews'],
    ],
];
