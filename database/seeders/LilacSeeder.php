<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Listing;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class LilacSeeder extends Seeder
{
    public function run(): void
    {
        $location = Location::where('slug', 'karatu-town')->first();
        if (! $location) {
            return;
        }

        // A "Food & Dining" category for the cafés, restaurants and venues that
        // don't fit the existing lodge/tour/sport/attraction/culture set.
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
        $lodges = Category::where('slug', 'lodges-hotels')->first();

        // A stakeholder account that owns the Lilac Tanzania listings.
        $owner = User::updateOrCreate(
            ['email' => 'lilac@visitkaratu.com'],
            [
                'name' => 'Lilac Tanzania',
                'password' => Hash::make('password'),
                'role' => 'stakeholder',
            ]
        );

        // Contact details shared across the Lilac Tanzania portfolio (from the
        // lilactanzania.com contact page).
        $email = 'info@lilactanzania.com';
        $address = 'PO Box 388, Karatu, Tanzania';
        $mainPhone = '+255 752 150 050';   // also the main WhatsApp

        $listings = [
            [
                'slug' => 'lilac-oasis', 'dir' => 'lilac-oasis',
                'name' => 'Lilac Oasis',
                'category_id' => $food->id, 'tier' => 'premium', 'popular' => true,
                'phone' => '+255 758 013 044',
                'lat' => -3.3455, 'lng' => 35.7760,
                'tags' => ['Bar', 'BBQ', 'Swimming Pool', 'Events', 'Dining'],
                'short' => 'A vibrant bar, BBQ and dining retreat with a swimming pool, meeting spaces and cultural experiences, on the main road just before Karatu.',
                'full' => "Located along the main road just before Karatu when coming from Arusha, Lilac Oasis is a vibrant retreat designed for travelers, locals, and groups seeking a blend of comfort, culture, and culinary excellence. Our space offers a stylish bar, formal dining, delicious BBQ cuisine, versatile meeting spaces, and a refreshing swimming pool, now open and ready to enjoy.\n\nBeyond great food and relaxation, Lilac Oasis is a hub for cultural experiences, where guests can connect with local traditions, music, and storytelling. Whether you're unwinding with a handcrafted cocktail, savoring a memorable meal, hosting a gathering, or taking a refreshing dip in the pool, Lilac Oasis provides a sophisticated yet welcoming atmosphere.\n\nPerfectly positioned in Tanzania's Northern Safari Circuit, Lilac Oasis is a must-visit destination for those looking to relax, celebrate, and experience authentic hospitality on their journey.",
            ],
            [
                'slug' => 'lilac-cafe', 'dir' => 'lilac-cafe',
                'name' => 'Lilac Café',
                'category_id' => $food->id, 'tier' => 'basic', 'popular' => false,
                'phone' => '+255 746 822 243',
                'lat' => -3.3418, 'lng' => 35.7935,
                'tags' => ['Café', 'Coffee', 'Free Wi-Fi', 'Pizza', 'Juice'],
                'short' => "Karatu's cozy spot on the main road near Exim Bank for locally grown coffee, fresh juice, pizza and local dishes, with free Wi-Fi.",
                'full' => "Conveniently located on Karatu's main road near Exim Bank, Lilac Café is a welcoming space for travelers, locals, and remote workers looking for great food, a relaxed atmosphere, and a place to connect. Whether you're starting your day with a cup of locally grown Karatu coffee, stopping in for a freshly made juice, or enjoying a meal, we offer a comfortable and inviting setting.\n\nOur menu features delicious pizzas, hearty soups, and flavorful local dishes, all prepared with fresh ingredients. Need a spot to work or unwind? Our café offers free Wi-Fi, making it a great place to catch up on emails, meet with friends, or simply take a break.\n\nWhether you're grabbing a quick lunch, sipping on fresh juice, or settling in with a warm cup of coffee, Lilac Café is the perfect place to relax, refuel, and enjoy Karatu's welcoming hospitality.",
            ],
            [
                'slug' => 'lilac-hideaway', 'dir' => 'lilac-hideaway',
                'name' => 'Lilac Hideaway',
                'category_id' => $lodges?->id ?? $food->id, 'tier' => 'featured', 'popular' => true,
                'phone' => $mainPhone,
                'lat' => -3.3520, 'lng' => 35.7880,
                'tags' => ['Boutique Hotel', 'Restaurant', 'Safari Stay'],
                'short' => 'An intimate boutique hotel on the outskirts of Karatu with four thoughtfully designed rooms and a cozy restaurant.',
                'full' => "Nestled on the outskirts of Karatu, Lilac Hideaway is an intimate boutique hotel with just four thoughtfully designed rooms and a cozy restaurant. Surrounded by nature, it offers a peaceful retreat with beautiful views, perfect for travelers seeking comfort and charm.\n\nWhether you're unwinding after a safari or looking for a quiet getaway, Lilac Hideaway provides warm hospitality, delicious dining, and a serene atmosphere.",
            ],
            [
                'slug' => 'lilac-elevate-inn', 'dir' => 'lilac-elevate',
                'name' => 'Lilac Elevate Inn',
                'category_id' => $lodges?->id ?? $food->id, 'tier' => 'basic', 'popular' => false,
                'phone' => $mainPhone,
                'lat' => -3.3401, 'lng' => 35.7902,
                'tags' => ['Hotel', 'Restaurant', 'Bar'],
                'short' => 'Centrally located, affordable hotel in Karatu with well-appointed rooms, a restaurant and bar, for tourists and business travelers.',
                'full' => "Centrally located in Karatu, Lilac Elevate Inn offers affordable comfort and convenience for both tourists and business travelers. As part of the Lilac Tanzania portfolio, this inviting hotel provides well-appointed rooms, warm hospitality, and easy access to the town's attractions, making it an excellent choice for those exploring Tanzania's Northern Safari Circuit or passing through for work.\n\nGuests can also enjoy delicious meals and refreshing drinks at the hotel's restaurant and bar, making it a relaxing stopover after a day of adventure or business. Whether you're here for safari, work, or a stopover, Lilac Elevate Inn is your ideal home away from home in Karatu.",
            ],
            [
                'slug' => 'lilac-restaurant-fame', 'dir' => 'lilac-restaurant-fame',
                'name' => 'Lilac Restaurant @ FAME Hospital',
                'category_id' => $food->id, 'tier' => 'basic', 'popular' => false,
                'phone' => $mainPhone,
                'lat' => -3.3389, 'lng' => 35.7841,
                'tags' => ['Restaurant', 'Healthy Meals', 'FAME Hospital'],
                'short' => 'Fresh, wholesome meals for patients, visitors and medical staff, located within FAME Hospital in Karatu.',
                'full' => "As the first in the Lilac Tanzania portfolio, Lilac Restaurant at FAME Hospital was created with a mission to provide fresh, wholesome meals to those seeking care, their loved ones, and the dedicated medical staff at FAME Hospital. We understand the importance of nutritious, well-balanced meals in supporting recovery, well-being, and overall health.\n\nLocated within FAME Hospital, our restaurant offers a calm and welcoming atmosphere, where patients, visitors, and healthcare professionals can enjoy comforting, carefully prepared dishes made from fresh, locally sourced ingredients. Whether you're a patient regaining strength, a family member supporting a loved one, or a hardworking medical professional in need of a nourishing meal, we are here to serve you with warm hospitality and quality food.\n\nAt Lilac Restaurant at FAME, we believe that good food plays a crucial role in healing and well-being. We are proud to support FAME Hospital's commitment to providing accessible, high-quality healthcare in the region.",
            ],
            [
                'slug' => 'dungu-by-lilac', 'dir' => 'dungu-by-lilac',
                'name' => 'Dungu by Lilac',
                'category_id' => $food->id, 'tier' => 'featured', 'popular' => true,
                'phone' => $mainPhone,
                'lat' => -3.3430, 'lng' => 35.7915,
                'tags' => ['Mobile Bar', 'Catering', 'Events', 'BBQ', 'Cocktails'],
                'short' => 'A one-of-a-kind mobile party truck with a full bar and BBQ, bringing drinks, cocktails and food to events across Tanzania.',
                'full' => "Dungu by Lilac is a one-of-a-kind mobile party truck bringing the Lilac experience to private gatherings, public events, and festivals, wherever you are. Fully equipped with a professional bar and BBQ setup, Dungu serves refreshing drinks, handcrafted cocktails, and delicious snacks, making it the perfect addition to celebrations, corporate events, festivals, and outdoor parties. Whether you're hosting an intimate gathering or a lively crowd, we bring the fun, flavor, and festive vibes straight to you.\n\nDungu has already been a standout feature at major events such as Kili Fair, one of East Africa's largest tourism and travel trade fairs. There, we provided ice-cold drinks, expertly mixed cocktails, and mouthwatering BBQ bites to thousands of visitors, creating an atmosphere of fun and hospitality that perfectly embodies the Lilac spirit.\n\nLooking for a unique catering solution for your next event? Dungu is available for private parties, weddings, business functions, concerts, and more. Get in touch to book Dungu for your next event and enjoy exceptional service, great drinks, and memorable moments.",
            ],
        ];

        $assetBase = database_path('seeders/assets/lilac');

        foreach ($listings as $data) {
            // Copy the committed gallery onto the public disk.
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
                    'user_id' => $owner->id,
                    'category_id' => $data['category_id'],
                    'location_id' => $location->id,
                    'name' => $data['name'],
                    'short_description' => $data['short'],
                    'full_description' => $data['full'],
                    'status' => 'published',
                    'plan_tier' => $data['tier'],
                    'is_popular' => $data['popular'],
                    'address_text' => $address,
                    'latitude' => $data['lat'],
                    'longitude' => $data['lng'],
                    'phone' => $data['phone'],
                    'whatsapp_number' => $mainPhone,
                    'email' => $email,
                    'tags' => $data['tags'],
                    'published_at' => now(),
                ]
            );

            // (Re)build the image set from the copied files.
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
}
