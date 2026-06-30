<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Lodges & Hotels', 'slug' => 'lodges-hotels', 'icon' => 'bed', 'description' => 'Accommodation options in and around Karatu', 'tabs' => ['overview', 'amenities', 'reviews'], 'sort_order' => 1],
            ['name' => 'Tour Operators', 'slug' => 'tour-operators', 'icon' => 'compass', 'description' => 'Safari and tour operators based in Karatu', 'tabs' => ['overview', 'itinerary', 'includes', 'excludes', 'reviews'], 'sort_order' => 2],
            ['name' => 'Sport Clubs', 'slug' => 'sport-clubs', 'icon' => 'trophy', 'description' => 'Sports and recreational activities', 'tabs' => ['overview', 'amenities', 'reviews'], 'sort_order' => 3],
            ['name' => 'Attractions', 'slug' => 'attractions', 'icon' => 'camera', 'description' => 'Natural and cultural attractions near Karatu', 'tabs' => ['overview', 'itinerary', 'reviews'], 'sort_order' => 4],
            ['name' => 'Culture & Crafts', 'slug' => 'culture-crafts', 'icon' => 'palette', 'description' => 'Local culture, crafts, and artisan markets', 'tabs' => ['overview', 'reviews'], 'sort_order' => 5],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
