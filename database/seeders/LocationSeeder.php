<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            ['name' => 'Karatu Town', 'slug' => 'karatu-town', 'latitude' => -3.3428, 'longitude' => 35.7864],
            ['name' => 'Near Crater Gate', 'slug' => 'near-crater-gate', 'latitude' => -3.2333, 'longitude' => 35.5000],
            ['name' => 'Lake Eyasi Area', 'slug' => 'lake-eyasi-area', 'latitude' => -3.6833, 'longitude' => 35.0167],
            ['name' => 'Lake Manyara Area', 'slug' => 'lake-manyara-area', 'latitude' => -3.5000, 'longitude' => 35.8333],
        ];

        foreach ($locations as $location) {
            Location::updateOrCreate(['slug' => $location['slug']], $location);
        }
    }
}
