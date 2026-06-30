<?php

namespace Database\Seeders;

use App\Models\Amenity;
use Illuminate\Database\Seeder;

class AmenitySeeder extends Seeder
{
    public function run(): void
    {
        $amenities = [
            ['name' => 'Wi-Fi', 'slug' => 'wifi'],
            ['name' => 'Pool', 'slug' => 'pool'],
            ['name' => 'Restaurant', 'slug' => 'restaurant'],
            ['name' => 'Parking', 'slug' => 'parking'],
            ['name' => 'Airport Transfer', 'slug' => 'airport-transfer'],
            ['name' => 'Spa', 'slug' => 'spa'],
        ];

        foreach ($amenities as $amenity) {
            Amenity::updateOrCreate(['slug' => $amenity['slug']], $amenity);
        }
    }
}
