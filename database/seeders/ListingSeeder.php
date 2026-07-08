<?php

namespace Database\Seeders;

use App\Models\Amenity;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Enquiry;
use App\Models\Listing;
use App\Models\ListingIncludeExclude;
use App\Models\ListingItineraryItem;
use App\Models\ListingView;
use App\Models\Location;
use App\Models\Review;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ListingSeeder extends Seeder
{
    public function run(): void
    {
        // Create demo users
        $admin = User::updateOrCreate(
            ['email' => 'admin@visitkaratu.com'],
            ['name' => 'Admin', 'password' => Hash::make('password'), 'role' => 'admin', 'email_verified_at' => now()]
        );

        $stakeholder1 = User::updateOrCreate(
            ['email' => 'acacia@visitkaratu.com'],
            ['name' => 'Acacia Farm Lodge', 'password' => Hash::make('password'), 'role' => 'stakeholder', 'email_verified_at' => now(), 'phone' => '+255 27 253 4600']
        );

        $stakeholder2 = User::updateOrCreate(
            ['email' => 'safari@visitkaratu.com'],
            ['name' => 'Ngorongoro Safari Tours', 'password' => Hash::make('password'), 'role' => 'stakeholder', 'email_verified_at' => now(), 'phone' => '+255 27 253 4700']
        );

        $visitor = User::updateOrCreate(
            ['email' => 'visitor@visitkaratu.com'],
            ['name' => 'Jane Visitor', 'password' => Hash::make('password'), 'role' => 'visitor', 'email_verified_at' => now()]
        );

        $categories = Category::all()->keyBy('slug');
        $locations = Location::all()->keyBy('slug');
        $amenities = Amenity::all()->keyBy('slug');

        $listingsData = [
            [
                'user_id' => $stakeholder1->id,
                'category_id' => $categories['lodges-hotels']->id,
                'location_id' => $locations['karatu-town']->id,
                'name' => 'Acacia Farm Lodge',
                'slug' => 'acacia-farm-lodge',
                'short_description' => 'A tranquil farm lodge nestled in the lush highlands of Karatu, gateway to the Ngorongoro Crater.',
                'full_description' => "Acacia Farm Lodge is set on a working farm in the heart of the Karatu highlands, offering a serene escape with sweeping views of coffee and wheat plantations. The lodge features 20 elegant thatched cottages with en-suite facilities, a swimming pool, and a farm-to-table restaurant serving fresh organic produce.\n\nGuests can explore the farm on guided walks, visit local Iraqw villages, or use the lodge as a comfortable base for crater tours and Lake Manyara day trips. Evening sundowners on the terrace with views across the Ngorongoro highlands are a highlight.",
                'price_amount' => 185.00,
                'price_unit' => 'per night',
                'status' => 'published',
                'plan_tier' => 'premium',
                'is_popular' => true,
                'latitude' => -3.3428,
                'longitude' => 35.7864,
                'address_text' => 'Off the Arusha–Ngorongoro Road, Karatu',
                'phone' => '+255 27 253 4600',
                'whatsapp_number' => '+255 27 253 4600',
                'email' => 'reservations@acaciafarmlodge.com',
                'tags' => ['Full Day Activity', 'All Year Round', 'Family Friendly'],
                'published_at' => now()->subDays(90),
                'amenities' => ['wifi', 'pool', 'restaurant', 'parking', 'airport-transfer', 'spa'],
                'includes' => ['All meals (full board)', 'Airport transfers', 'Guided farm walks', 'Evening campfire'],
                'excludes' => ['Park entry fees', 'Alcoholic beverages', 'Laundry services', 'Tips & gratuities'],
                'itinerary' => [
                    ['day_label' => 'Day 01', 'description' => 'Arrival and check-in. Afternoon guided walk through coffee and wheat plantations. Sundowner drinks on the main terrace.', 'sort_order' => 1],
                    ['day_label' => 'Day 02', 'description' => 'Optional early morning Ngorongoro Crater safari (park fees extra). Afternoon visit to a nearby Iraqw cultural village. Dinner under the stars.', 'sort_order' => 2],
                    ['day_label' => 'Day 03', 'description' => 'Full day Lake Manyara National Park visit. Return for a farewell dinner at the farm restaurant.', 'sort_order' => 3],
                ],
            ],
            [
                'user_id' => $stakeholder2->id,
                'category_id' => $categories['tour-operators']->id,
                'location_id' => $locations['near-crater-gate']->id,
                'name' => 'Ngorongoro Crater Full Day Tour',
                'slug' => 'ngorongoro-crater-full-day-tour',
                'short_description' => 'A full-day descent into the world\'s largest intact volcanic caldera, home to over 25,000 animals.',
                'full_description' => "Experience the 8th Wonder of the World on this full-day guided safari into the Ngorongoro Crater. Descend 600 metres into the caldera floor and encounter the Big Five — lion, elephant, buffalo, leopard, and rhino — along with wildebeest, zebra, hippo, and flamingos on the soda lake.\n\nYour expert Swahili/English speaking guide will share knowledge of the crater's unique ecosystem and the Maasai community who live alongside wildlife on the crater rim. Lunch is served at the picnic site on the crater floor with views across the caldera.",
                'price_amount' => 120.00,
                'price_unit' => 'per person',
                'status' => 'published',
                'plan_tier' => 'featured',
                'is_popular' => true,
                'latitude' => -3.2333,
                'longitude' => 35.5000,
                'address_text' => 'Ngorongoro Conservation Area Gate, near Lodoare',
                'phone' => '+255 27 253 4700',
                'whatsapp_number' => '+255 27 253 4700',
                'email' => 'bookings@ngorosafaritours.com',
                'tags' => ['Full Day Tour', 'All Year Round', 'Pick-up Available'],
                'published_at' => now()->subDays(60),
                'amenities' => ['parking', 'airport-transfer'],
                'includes' => ['4WD safari vehicle', 'Professional guide (English/Swahili)', 'Crater descent fees', 'Packed lunch and drinking water', 'Hotel pick-up and drop-off (Karatu area)'],
                'excludes' => ['Ngorongoro Conservation Area entrance fee ($60/person)', 'Alcoholic beverages', 'Gratuities for guide and driver'],
                'itinerary' => [
                    ['day_label' => 'Day 01', 'description' => '06:30 Pick-up from your accommodation. 07:30 Arrive at crater rim for sunrise views. 08:00 Descend into the caldera. Morning game drive (Big Five spotting). 13:00 Picnic lunch on crater floor. 14:00 Continue game drive. 16:00 Ascend to rim. 17:30 Return to Karatu hotels.', 'sort_order' => 1],
                ],
            ],
            [
                'user_id' => $stakeholder1->id,
                'category_id' => $categories['attractions']->id,
                'location_id' => $locations['lake-eyasi-area']->id,
                'name' => 'Lake Eyasi Hadzabe Bushwalk',
                'slug' => 'lake-eyasi-hadzabe-bushwalk',
                'short_description' => 'Spend a morning with the Hadzabe tribe — one of the last remaining hunter-gatherer peoples in Africa.',
                'full_description' => "Join one of East Africa's most unique cultural experiences: a dawn bushwalk with the Hadzabe, one of the last remaining hunter-gatherer tribes in Africa. Live like they have for 10,000 years — tracking game on foot, gathering wild berries, and learning to use traditional bow and arrow.\n\nAfternoon: visit the Datoga blacksmiths on the shores of Lake Eyasi and watch them craft iron jewellery and arrowheads using techniques unchanged for centuries. Flamingos feed in the shallows as you explore the lake edge.",
                'price_amount' => 75.00,
                'price_unit' => 'per person',
                'status' => 'published',
                'plan_tier' => 'featured',
                'is_popular' => true,
                'latitude' => -3.6833,
                'longitude' => 35.0167,
                'address_text' => 'Lake Eyasi, south of Karatu',
                'phone' => '+255 27 253 4600',
                'whatsapp_number' => '+255 27 253 4600',
                'email' => 'reservations@acaciafarmlodge.com',
                'tags' => ['Full Day Tour', 'All Year Round', 'Cultural Experience'],
                'published_at' => now()->subDays(45),
                'amenities' => ['parking', 'airport-transfer'],
                'includes' => ['Transport from Karatu', 'Local guide and translator', 'Hadzabe village visit permit', 'Datoga blacksmith visit', 'Picnic lunch'],
                'excludes' => ['Gratuities (discretionary)', 'Personal purchases from artisans'],
                'itinerary' => [
                    ['day_label' => 'Day 01', 'description' => '05:00 Depart Karatu hotels. 06:30 Arrive at Hadzabe camp for dawn hunt. 09:00 Return to camp — traditional meal preparation. 11:00 Drive to Lake Eyasi shore for Datoga blacksmith visit. 13:00 Picnic lunch on the lake. 15:00 Return to Karatu.', 'sort_order' => 1],
                ],
            ],
            [
                'user_id' => $stakeholder2->id,
                'category_id' => $categories['lodges-hotels']->id,
                'location_id' => $locations['karatu-town']->id,
                'name' => 'Karatu Simba Lodge',
                'slug' => 'karatu-simba-lodge',
                'short_description' => 'Budget-friendly lodge in Karatu town, perfect for travellers passing through to the crater.',
                'full_description' => "Karatu Simba Lodge offers clean, comfortable rooms at affordable prices right in Karatu town. The lodge has 30 en-suite rooms, a restaurant serving local and international food, and a garden bar. It's the ideal base for budget-conscious travellers exploring the Ngorongoro area.",
                'price_amount' => 65.00,
                'price_unit' => 'per night',
                'status' => 'published',
                'plan_tier' => 'basic',
                'is_popular' => false,
                'latitude' => -3.3500,
                'longitude' => 35.7900,
                'address_text' => 'Main Road, Karatu Town',
                'phone' => '+255 27 253 4800',
                'whatsapp_number' => '+255 27 253 4800',
                'email' => 'info@karatusimbalodge.com',
                'tags' => ['Budget Friendly', 'Town Centre', 'All Year Round'],
                'published_at' => now()->subDays(30),
                'amenities' => ['wifi', 'restaurant', 'parking'],
                'includes' => ['Breakfast', 'Free Wi-Fi', 'Parking'],
                'excludes' => ['Lunch and dinner', 'Airport transfers', 'Safari activities'],
                'itinerary' => [],
            ],
            [
                'user_id' => $stakeholder1->id,
                'category_id' => $categories['culture-crafts']->id,
                'location_id' => $locations['karatu-town']->id,
                'name' => 'Karatu Cultural Crafts Market',
                'slug' => 'karatu-cultural-crafts-market',
                'short_description' => 'Browse and buy authentic Tanzanian crafts, Maasai jewellery, and local produce at Karatu\'s vibrant market.',
                'full_description' => "Karatu's weekly crafts market brings together artisans from across the Ngorongoro highlands. Find hand-carved wooden animals, Maasai beaded jewellery, Iraqw pottery, and locally grown coffee, honey, and spices. Guided market tours available, pairing a visit with a traditional cooking demonstration.",
                'price_amount' => 15.00,
                'price_unit' => 'per person',
                'status' => 'published',
                'plan_tier' => 'basic',
                'is_popular' => false,
                'latitude' => -3.3420,
                'longitude' => 35.7870,
                'address_text' => 'Town Square, Karatu',
                'phone' => '+255 27 253 4600',
                'whatsapp_number' => '+255 27 253 4600',
                'email' => 'reservations@acaciafarmlodge.com',
                'tags' => ['Half Day', 'Every Saturday', 'Family Friendly'],
                'published_at' => now()->subDays(20),
                'amenities' => ['parking'],
                'includes' => ['Guided tour of the market', 'Cooking demonstration', 'Tasting of local produce'],
                'excludes' => ['Personal purchases', 'Transport to/from market'],
                'itinerary' => [],
            ],
        ];

        foreach ($listingsData as $data) {
            $amenityKeys = $data['amenities'] ?? [];
            $includes = $data['includes'] ?? [];
            $excludes = $data['excludes'] ?? [];
            $itinerary = $data['itinerary'] ?? [];

            unset($data['amenities'], $data['includes'], $data['excludes'], $data['itinerary']);

            $listing = Listing::updateOrCreate(['slug' => $data['slug']], $data);

            // Amenities (filter by slug — Eloquent Collection::only() matches by id, not key)
            $amenityIds = $amenities->whereIn('slug', $amenityKeys)->pluck('id');
            $listing->amenities()->sync($amenityIds);

            // Includes/Excludes
            $listing->includeExcludes()->delete();
            foreach ($includes as $desc) {
                $listing->includeExcludes()->create(['type' => 'include', 'description' => $desc]);
            }
            foreach ($excludes as $desc) {
                $listing->includeExcludes()->create(['type' => 'exclude', 'description' => $desc]);
            }

            // Itinerary
            $listing->itineraryItems()->delete();
            foreach ($itinerary as $item) {
                $listing->itineraryItems()->create($item);
            }
        }

        // --- Additional bulk listings so every category is populated and the
        //     directory has enough entries to paginate. ---
        $owners = [$stakeholder1->id, $stakeholder2->id];
        $locationIds = $locations->pluck('id')->all();
        $amenityPool = $amenities->pluck('slug')->all();

        $bulk = [
            // Lodges & Hotels
            ['cat' => 'lodges-hotels', 'name' => 'Crater Highlands Tented Camp', 'price' => 140, 'unit' => 'per night', 'desc' => 'Luxury tented camp on the Ngorongoro highlands with panoramic crater-rim views.'],
            ['cat' => 'lodges-hotels', 'name' => 'Bougainvillea Safari Lodge', 'price' => 110, 'unit' => 'per night', 'desc' => 'Garden lodge with a pool and spa, a 10-minute drive from Karatu town centre.'],
            ['cat' => 'lodges-hotels', 'name' => 'Eyasi Sunset Camp', 'price' => 80, 'unit' => 'per night', 'desc' => 'Rustic eco-camp on the shores of Lake Eyasi, perfect for cultural-tour travellers.'],
            // Tour Operators
            ['cat' => 'tour-operators', 'name' => 'Lake Manyara Day Safari', 'price' => 95, 'unit' => 'per person', 'desc' => 'Half-day game drive through Lake Manyara National Park, famous for tree-climbing lions.'],
            ['cat' => 'tour-operators', 'name' => 'Karatu Coffee Plantation Tour', 'price' => 35, 'unit' => 'per person', 'desc' => 'Walk a working coffee farm from bean to cup, with a tasting of fresh highland brew.'],
            ['cat' => 'tour-operators', 'name' => 'Ngorongoro Rim Cycling Adventure', 'price' => 60, 'unit' => 'per person', 'desc' => 'Guided mountain-bike ride along the forested crater rim with sweeping highland views.'],
            // Attractions
            ['cat' => 'attractions', 'name' => 'Elephant Cave & Waterfall Walk', 'price' => 25, 'unit' => 'per person', 'desc' => 'A guided forest hike to the elephant caves and a hidden seasonal waterfall.'],
            ['cat' => 'attractions', 'name' => 'Lake Eyasi Birding Point', 'price' => 20, 'unit' => 'entry fee', 'desc' => 'Flamingos, pelicans and dozens of migratory species on the soda-lake shoreline.'],
            // Sport Clubs
            ['cat' => 'sport-clubs', 'name' => 'Karatu Highlands Golf & Country Club', 'price' => 40, 'unit' => 'per person', 'desc' => 'Nine-hole highland course and clubhouse open to visitors and members alike.'],
            ['cat' => 'sport-clubs', 'name' => 'Ngorongoro Trail Runners Club', 'price' => 15, 'unit' => 'per person', 'desc' => 'Weekly guided trail runs through coffee estates and the crater-rim forest.'],
            ['cat' => 'sport-clubs', 'name' => 'Eyasi Watersports Centre', 'price' => 30, 'unit' => 'per person', 'desc' => 'Kayaking and stand-up paddleboarding sessions on calm Lake Eyasi waters.'],
            // Culture & Crafts
            ['cat' => 'culture-crafts', 'name' => 'Iraqw Traditional Homestead Visit', 'price' => 22, 'unit' => 'per person', 'desc' => 'Step inside a traditional Iraqw underground home and learn local farming customs.'],
            ['cat' => 'culture-crafts', 'name' => 'Datoga Blacksmith Workshop', 'price' => 18, 'unit' => 'per person', 'desc' => 'Watch Datoga artisans forge jewellery and arrowheads using centuries-old techniques.'],
            ['cat' => 'culture-crafts', 'name' => 'Karatu Beadwork & Basketry Studio', 'price' => 15, 'unit' => 'per person', 'desc' => 'Hands-on beadwork and basket-weaving class led by local women artisans.'],
        ];

        foreach ($bulk as $i => $b) {
            $loc = $locations->firstWhere('id', $locationIds[$i % count($locationIds)]);
            $listing = Listing::updateOrCreate(
                ['slug' => Str::slug($b['name'])],
                [
                    'user_id' => $owners[$i % count($owners)],
                    'category_id' => $categories[$b['cat']]->id,
                    'location_id' => $locationIds[$i % count($locationIds)],
                    'name' => $b['name'],
                    'short_description' => $b['desc'],
                    'full_description' => $b['desc'] . "\n\nThis is a sample listing seeded for demonstration. Contact the operator for full details, availability and current pricing.",
                    'price_amount' => $b['price'],
                    'price_unit' => $b['unit'],
                    'latitude' => $loc ? round($loc->latitude + (mt_rand(-200, 200) / 10000), 6) : null,
                    'longitude' => $loc ? round($loc->longitude + (mt_rand(-200, 200) / 10000), 6) : null,
                    'status' => 'published',
                    'plan_tier' => $i % 4 === 0 ? 'featured' : 'basic',
                    'is_popular' => $i % 5 === 0,
                    'phone' => '+255 74 885 9172',
                    'whatsapp_number' => '+255 74 885 9172',
                    'email' => 'info@visitkaratu.com',
                    'published_at' => now()->subDays(rand(1, 40)),
                ]
            );

            // Give each a couple of random amenities
            $randomAmenities = collect($amenityPool)->shuffle()->take(rand(2, 4))->all();
            $listing->amenities()->sync($amenities->whereIn('slug', $randomAmenities)->pluck('id'));
        }

        // Seed reviews
        $publishedListings = Listing::where('status', 'published')->get();
        $reviewTexts = [
            ['rating' => 5, 'comment' => 'Absolutely incredible experience. The staff were so welcoming and the views were breathtaking. Will definitely return!'],
            ['rating' => 5, 'comment' => 'Best safari guide we\'ve ever had. He knew exactly where to find the lions and rhinos. Worth every penny.'],
            ['rating' => 4, 'comment' => 'Great location and comfortable rooms. The food was fresh and delicious. Only minor gripe was slow Wi-Fi.'],
            ['rating' => 5, 'comment' => 'The Hadzabe experience was life-changing. Nothing like it anywhere else in Africa. Book it!'],
            ['rating' => 4, 'comment' => 'Good value for money. Clean rooms, friendly staff. Perfect base for a crater day trip.'],
        ];

        foreach ($publishedListings as $i => $listing) {
            $reviewData = $reviewTexts[$i % count($reviewTexts)];
            Review::updateOrCreate(
                ['listing_id' => $listing->id, 'user_id' => $visitor->id],
                ['rating' => $reviewData['rating'], 'comment' => $reviewData['comment'], 'status' => 'approved']
            );
        }

        // Seed listing views (last 60 days)
        $sources = ['direct', 'organic_search', 'referral', 'other'];
        $sourceWeights = [40, 35, 15, 10];
        foreach ($publishedListings as $listing) {
            $viewCount = rand(80, 300);
            for ($i = 0; $i < $viewCount; $i++) {
                $rand = rand(1, 100);
                $cumulative = 0;
                $source = 'direct';
                foreach ($sources as $j => $s) {
                    $cumulative += $sourceWeights[$j];
                    if ($rand <= $cumulative) {
                        $source = $s;
                        break;
                    }
                }
                ListingView::create([
                    'listing_id' => $listing->id,
                    'viewed_at' => now()->subDays(rand(0, 60))->subHours(rand(0, 23)),
                    'source' => $source,
                ]);
            }
        }

        // Seed bookings
        foreach ($publishedListings->take(3) as $listing) {
            for ($i = 0; $i < 5; $i++) {
                Booking::create([
                    'listing_id' => $listing->id,
                    'user_id' => $visitor->id,
                    'guest_name' => fake()->name(),
                    'adults' => rand(1, 4),
                    'children' => rand(0, 2),
                    'booking_date' => now()->addDays(rand(1, 60)),
                    'amount' => $listing->price_amount * rand(1, 3),
                    'status' => fake()->randomElement(['pending', 'confirmed', 'confirmed']),
                ]);
            }
        }

        // Seed enquiries
        foreach ($publishedListings->take(3) as $listing) {
            Enquiry::create([
                'listing_id' => $listing->id,
                'user_id' => $visitor->id,
                'name' => 'Sarah Johnson',
                'email' => 'sarah@example.com',
                'phone' => '+1 555 0100',
                'message' => 'Hi, I\'m interested in booking for 2 adults and 1 child in early August. Do you have availability?',
                'status' => 'new',
            ]);
        }
    }
}
