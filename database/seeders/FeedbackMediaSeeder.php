<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Listing;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

/**
 * Stakeholder feedback batch (feedback.md):
 *  - #1 Add new photos/videos to the Datoga Blacksmith & Hadzabe listings.
 *  - #6 Add "Sparrow" (Golden Sparrow Lounge) to Food & Dining.
 *  - #7 Add Five Chutneys as a popular Food & Dining listing.
 *  - #8 Update the Lilac Tanzania phone numbers to +255 752 150 050.
 */
class FeedbackMediaSeeder extends Seeder
{
    public function run(): void
    {
        $this->attachMedia();
        $this->seedFoodListings();
        $this->seedTourOperators();
        $this->updateLilacPhone();
    }

    /**
     * #1 — copy the new committed photos/videos onto the public disk and attach
     * them to the existing Datoga Blacksmith and Hadzabe listings.
     */
    private function attachMedia(): void
    {
        $sets = [
            'datoga-blacksmith-workshop' => 'datoga-blacksmith',
            'lake-eyasi-hadzabe-bushwalk' => 'hadzabe',
        ];

        $assetBase = database_path('seeders/assets');

        foreach ($sets as $slug => $dir) {
            $listing = Listing::where('slug', $slug)->first();
            if (! $listing) {
                continue;
            }

            $srcDir = "$assetBase/$dir";
            $publicDir = "listings/$dir";
            Storage::disk('public')->makeDirectory($publicDir);

            // Images
            $images = glob("$srcDir/*.jpg") ?: [];
            sort($images);
            foreach ($images as $file) {
                Storage::disk('public')->put("$publicDir/".basename($file), file_get_contents($file));
            }

            // (Re)build the image set so the new photos become the gallery/cover.
            $listing->images()->delete();
            $i = 0;
            foreach ($images as $file) {
                $path = "$publicDir/".basename($file);
                if (! Storage::disk('public')->exists($path)) {
                    continue;
                }
                $listing->images()->create([
                    'path' => $path,
                    'sort_order' => $i,
                    'is_cover' => $i === 0,
                ]);
                $i++;
            }

            // Videos
            $videos = glob("$srcDir/*.mp4") ?: [];
            sort($videos);
            foreach ($videos as $file) {
                Storage::disk('public')->put("$publicDir/".basename($file), file_get_contents($file));
            }

            $listing->videos()->delete();
            $j = 0;
            $poster = $images ? "$publicDir/".basename($images[0]) : null;
            foreach ($videos as $file) {
                $path = "$publicDir/".basename($file);
                if (! Storage::disk('public')->exists($path)) {
                    continue;
                }
                $listing->videos()->create([
                    'path' => $path,
                    'poster' => $poster,
                    'sort_order' => $j,
                ]);
                $j++;
            }
        }
    }

    /**
     * #6 + #7 — Golden Sparrow Lounge and Five Chutneys as Food & Dining listings.
     */
    private function seedFoodListings(): void
    {
        $location = Location::where('slug', 'karatu-town')->first() ?? Location::first();
        if (! $location) {
            return;
        }

        $food = Category::updateOrCreate(
            ['slug' => 'food-dining'],
            [
                'name' => 'Food & Dining',
                'icon' => 'utensils',
                'description' => 'Cafés, restaurants, bars and dining venues around Karatu.',
                'tabs' => ['overview', 'reviews'],
                'sort_order' => (int) Category::max('sort_order') + 1,
            ]
        );

        $admin = User::where('email', 'admin@visitkaratu.com')->first()
            ?? User::where('role', 'admin')->first()
            ?? User::first();

        $listings = [
            [
                'slug' => 'golden-sparrow-lounge',
                'dir' => 'golden-sparrow',
                'name' => 'Golden Sparrow Lounge',
                'tier' => 'featured',
                'popular' => true,
                'phone' => '+255 768 050 535',
                'whatsapp' => '+255 768 050 535',
                'email' => null,
                'address' => 'Karatu, Arusha Region, Tanzania',
                'lat' => -3.3419, 'lng' => 35.7003,
                'tags' => ['Restaurant', 'Lounge', 'Bar', 'Live Music', 'Conference Hall'],
                'short' => 'A lively Karatu lounge and restaurant blending local and international dishes with good music, cocktails and 24/7 service.',
                'full' => "Golden Sparrow Lounge is one of Karatu's most popular spots to eat, drink and unwind. The kitchen blends local Tanzanian favourites with international dishes, all crafted from fresh, locally sourced ingredients, with plenty of vegetarian and vegan options and a great selection of fresh juices and drinks.\n\nBeyond the food, the Golden Sparrow is a full lounge experience: warm decor that reflects the local culture, good music, a friendly team and beverage service around the clock, plus a resident DJ and a conference hall for events and gatherings.\n\nConveniently located in Karatu, it's an easy and welcoming stop before or after a day exploring the Ngorongoro Crater, Lake Manyara and the surrounding highlands.",
            ],
            [
                'slug' => 'five-chutneys-karatu',
                'dir' => 'five-chutneys',
                'name' => 'Five Chutneys',
                'tier' => 'premium',
                'popular' => true,
                'phone' => '+255 683 131 444',
                'whatsapp' => '+255 683 131 444',
                'email' => 'fivechutneys@gmail.com',
                'address' => 'Njia Panda, Karatu, Tanzania (7 km to Ngorongoro Crater gate)',
                'lat' => -3.3370, 'lng' => 35.7440,
                'tags' => ['Indian', 'Vegetarian', 'Vegan Options', 'Gluten-Free', 'Street Food'],
                'short' => "Authentic Indian vegetarian street food near the Ngorongoro gate — 30+ vegan and gluten-free options, with everything made fresh in-house.",
                'full' => "Five Chutneys is a family-run vegetarian restaurant serving authentic Indian street food in Karatu, just 7 km from the Ngorongoro Crater gate at Njia Panda. Founded in 1995 by Jagat and Roshni Vyas, the restaurant grew out of a simple mission: to bring fresh, flavourful, high-quality vegetarian food to travellers and locals alike.\n\nEverything is entirely vegetarian, with 30+ vegan options and 17+ gluten-free choices, and the chutneys, paneer and mayonnaise are all made fresh in-house every day. The menu spans Indian street-food favourites — samosas, pav bhaji, chole bhaturey, dabeli and vadapav — alongside a full range of dosas, uttapam and idli, chaats, flatbreads, and drinks like masala chai, lassi and fresh milkshakes.\n\nAlready loved in Arusha as the city's #1 vegetarian restaurant, Five Chutneys is a perfect, wholesome stop for safari-goers passing through Karatu on the northern circuit.",
            ],
        ];

        $assetBase = database_path('seeders/assets');

        foreach ($listings as $data) {
            $srcDir = "$assetBase/{$data['dir']}";
            $publicDir = "listings/{$data['dir']}";
            Storage::disk('public')->makeDirectory($publicDir);

            $files = glob("$srcDir/*.jpg") ?: [];
            sort($files);
            foreach ($files as $file) {
                Storage::disk('public')->put("$publicDir/".basename($file), file_get_contents($file));
            }

            $listing = Listing::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'user_id' => $admin?->id,
                    'category_id' => $food->id,
                    'location_id' => $location->id,
                    'name' => $data['name'],
                    'short_description' => $data['short'],
                    'full_description' => $data['full'],
                    'status' => 'published',
                    'plan_tier' => $data['tier'],
                    'is_popular' => $data['popular'],
                    'address_text' => $data['address'],
                    'latitude' => $data['lat'],
                    'longitude' => $data['lng'],
                    'phone' => $data['phone'],
                    'whatsapp_number' => $data['whatsapp'],
                    'email' => $data['email'],
                    'tags' => $data['tags'],
                    'published_at' => now(),
                ]
            );

            $listing->images()->delete();
            $i = 0;
            foreach ($files as $file) {
                $path = "$publicDir/".basename($file);
                if (! Storage::disk('public')->exists($path)) {
                    continue;
                }
                $listing->images()->create([
                    'path' => $path,
                    'sort_order' => $i,
                    'is_cover' => $i === 0,
                ]);
                $i++;
            }
        }
    }

    /**
     * Narina Trogon Safaris — a locally-owned Tanzanian tour operator
     * (narinatrogonsafarisltd.co.tz), added as a Tour Operators listing.
     */
    private function seedTourOperators(): void
    {
        $location = Location::where('slug', 'karatu-town')->first() ?? Location::first();
        if (! $location) {
            return;
        }

        $tours = Category::where('slug', 'tour-operators')->first();
        if (! $tours) {
            return;
        }

        $admin = User::where('email', 'admin@visitkaratu.com')->first()
            ?? User::where('role', 'admin')->first()
            ?? User::first();

        $phone = '+255 784 398 083';   // Tanzania office / WhatsApp
        $full = "Narina Trogon Safaris is a locally owned Tanzanian safari operator specialising in tailor-made safaris across Tanzania, Kenya, Uganda and the beaches of Zanzibar. The company is named after the Narina Trogon, the beautiful bird that lives on the slopes of Mount Meru near the founder's family home.\n\nFounded by Casmir Shija, an experienced guide with over 20 years in the industry who previously worked with andBeyond and Thomson Safaris and holds a degree in tourism management, Narina Trogon offers a genuinely founder-led, personal safari experience. Casmir and his trained team bring extensive knowledge of the bush, keen eyesight and warm hospitality to every trip.\n\nThey run road and air safaris across the Northern, Southern and Western circuits, including Serengeti and Ngorongoro Crater for the Great Migration and diverse wildlife, plus Kilimanjaro climbing, walking safaris, night game drives, hot-air balloon safaris, bird watching, cultural tours and Zanzibar beach escapes. Popular options include 5, 7 and 15-day Tanzania itineraries, all fully tailor-made. By booking direct and cutting out the middlemen, they keep safaris affordable while supporting local communities and sustainable tourism.\n\nWebsite: narinatrogonsafarisltd.co.tz\nInstagram: @narinatrogonsafarisltd\nTikTok: @narina.trogon.saf";

        $dir = 'narina-trogon';
        $publicDir = "listings/$dir";
        $srcDir = database_path("seeders/assets/$dir");
        Storage::disk('public')->makeDirectory($publicDir);

        $files = glob("$srcDir/*.jpg") ?: [];
        sort($files);
        foreach ($files as $file) {
            Storage::disk('public')->put("$publicDir/".basename($file), file_get_contents($file));
        }

        $listing = Listing::updateOrCreate(
            ['slug' => 'narina-trogon-safaris'],
            [
                'user_id' => $admin?->id,
                'category_id' => $tours->id,
                'location_id' => $location->id,
                'name' => 'Narina Trogon Safaris',
                'short_description' => 'Locally owned, founder-led safari operator offering tailor-made Tanzania, Kenya, Uganda and Zanzibar trips, plus Kilimanjaro climbs.',
                'full_description' => $full,
                'status' => 'published',
                'plan_tier' => 'featured',
                'is_popular' => true,
                'address_text' => 'P.O. Box, Usa River, Arusha, Tanzania',
                'latitude' => -3.3690,
                'longitude' => 36.8340,
                'phone' => $phone,
                'whatsapp_number' => $phone,
                'email' => 'info@narinatrogonsafarisltd.co.tz',
                'tags' => ['Safari', 'Tailor-Made', 'Kilimanjaro', 'Serengeti', 'Ngorongoro', 'Zanzibar', 'Bird Watching'],
                'published_at' => now(),
            ]
        );

        $listing->images()->delete();
        $i = 0;
        foreach ($files as $file) {
            $path = "$publicDir/".basename($file);
            if (! Storage::disk('public')->exists($path)) {
                continue;
            }
            $listing->images()->create([
                'path' => $path,
                'sort_order' => $i,
                'is_cover' => $i === 0,
            ]);
            $i++;
        }
    }

    /**
     * #8 — the Lilac Tanzania portfolio's main contact number.
     */
    private function updateLilacPhone(): void
    {
        $number = '+255 752 150 050';

        Listing::where('slug', 'like', 'lilac-%')
            ->orWhere('slug', 'dungu-by-lilac')
            ->update([
                'phone' => $number,
                'whatsapp_number' => $number,
            ]);
    }
}
