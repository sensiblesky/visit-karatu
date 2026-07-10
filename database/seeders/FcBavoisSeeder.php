<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Event;
use App\Models\Listing;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class FcBavoisSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::where('slug', 'sport-clubs')->first();
        $location = Location::where('slug', 'karatu-town')->first();
        $owner = User::where('role', 'stakeholder')->first() ?? User::where('role', 'admin')->first();

        if (! $category || ! $location || ! $owner) {
            return;
        }

        // Copy the committed visit photos onto the public disk.
        $assetDir = database_path('seeders/assets/fc-bavois');
        Storage::disk('public')->makeDirectory('listings/fc-bavois');

        $gallery = [
            'cover.jpg'      => ['cover' => true],
            'g1-pitch.jpg'   => [],
            'g2-vehicles.jpg' => [],
            'g3-safari.jpg'  => [],
            'g4-pool.jpg'    => [],
            'g5-gate.jpg'    => [],
            'g6-community.jpg' => [],
            'g7-lodge.jpg'   => [],
            'g8-poster.jpg'  => [],
        ];

        foreach ($gallery as $file => $meta) {
            $source = "$assetDir/$file";
            if (is_file($source)) {
                Storage::disk('public')->put("listings/fc-bavois/$file", file_get_contents($source));
            }
        }

        $short = 'FC Bavois, a Swiss football club, brought its first team to Karatu for a training camp and community football project.';
        $full = "FC Bavois embarked on a unique adventure: supporting the development of football in Tanzania, the home country of their assistant coach Renatus Boniface Njihole.\n\n".
            "The first team travelled to Karatu for a training camp, combining professional preparation with a genuine human and sporting project, training sessions, friendly matches, and time shared with local clubs and young players.\n\n".
            "Between sessions the squad explored the region: game drives into the Ngorongoro Conservation Area, visits to highland lodges, and moments with the local community. It is a partnership that puts Karatu on the map as a destination for sports tourism and football development.";

        $listing = Listing::updateOrCreate(
            ['slug' => 'fc-bavois-tanzania'],
            [
                'user_id' => $owner->id,
                'category_id' => $category->id,
                'location_id' => $location->id,
                'name' => 'FC Bavois in Tanzania: Football & Community Project',
                'short_description' => $short,
                'full_description' => $full,
                'price_amount' => null,
                'price_unit' => null,
                'status' => 'published',
                'plan_tier' => 'featured',
                'is_popular' => true,
                'address_text' => 'Karatu, Arusha Region, Tanzania',
                'latitude' => -3.3402,
                'longitude' => 35.7912,
                'email' => 'info@fcbavois.ch',
                'whatsapp_number' => null,
                'tags' => ['Football', 'Training Camp', 'Community Project'],
                'published_at' => now()->subDays(5),
            ]
        );

        // (Re)build the image set.
        $listing->images()->delete();
        $i = 0;
        foreach ($gallery as $file => $meta) {
            if (! Storage::disk('public')->exists("listings/fc-bavois/$file")) {
                continue;
            }
            $listing->images()->create([
                'path' => "listings/fc-bavois/$file",
                'sort_order' => $i++,
                'is_cover' => $meta['cover'] ?? false,
            ]);
        }

        // A matching event on the Events page ("latest event" in the sports scene).
        Event::updateOrCreate(
            ['title' => 'FC Bavois Training Camp in Karatu'],
            [
                'description' => 'Swiss club FC Bavois brought its first team to Karatu for a training camp and community football project, training sessions and friendly matches with local clubs, alongside safaris in the Ngorongoro highlands.',
                'location_id' => $location->id,
                'starts_at' => now()->subDays(6)->setTime(9, 0),
                'ends_at' => now()->subDays(1)->setTime(17, 0),
                'cover_image' => 'listings/fc-bavois/cover.jpg',
            ]
        );
    }
}
