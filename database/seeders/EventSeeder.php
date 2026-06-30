<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Location;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $locations = Location::all()->keyBy('slug');

        $events = [
            [
                'title' => 'Karatu Cultural Festival',
                'description' => 'A three-day celebration of Iraqw, Datoga and Hadzabe culture with traditional music, dance, food stalls and craft markets in the heart of Karatu town.',
                'location' => 'karatu-town',
                'starts_at' => now()->addDays(12)->setTime(10, 0),
                'ends_at' => now()->addDays(14)->setTime(18, 0),
                'cover_image' => '/images/placeholders/culture.jpg',
            ],
            [
                'title' => 'Ngorongoro Highlands Coffee Harvest',
                'description' => 'Join local estates for the annual coffee harvest — pick, pulp and roast your own beans, then taste the highland brew straight from the source.',
                'location' => 'karatu-town',
                'starts_at' => now()->addDays(20)->setTime(8, 0),
                'ends_at' => now()->addDays(20)->setTime(13, 0),
                'cover_image' => '/images/placeholders/event-coffee.jpg',
            ],
            [
                'title' => 'Lake Eyasi Hadzabe Heritage Day',
                'description' => 'Spend a day with the Hadzabe community learning traditional hunting, fire-making and gathering skills, followed by storytelling around the fire.',
                'location' => 'lake-eyasi-area',
                'starts_at' => now()->addDays(28)->setTime(6, 30),
                'ends_at' => now()->addDays(28)->setTime(15, 0),
                'cover_image' => '/images/placeholders/event-hadzabe.jpg',
            ],
            [
                'title' => 'Karatu Farmers & Crafts Market',
                'description' => 'The weekly market returns with fresh highland produce, honey, spices, hand-carved woodwork and Maasai beadwork. Free entry, family friendly.',
                'location' => 'karatu-town',
                'starts_at' => now()->addDays(5)->setTime(9, 0),
                'ends_at' => now()->addDays(5)->setTime(16, 0),
                'cover_image' => '/images/placeholders/crafts.jpg',
            ],
            [
                'title' => 'Lake Manyara Birding Weekend',
                'description' => 'A guided two-day birding weekend around Lake Manyara, spotting flamingos, pelicans and over 400 recorded species with expert local guides.',
                'location' => 'lake-manyara-area',
                'starts_at' => now()->addDays(34)->setTime(7, 0),
                'ends_at' => now()->addDays(35)->setTime(17, 0),
                'cover_image' => '/images/placeholders/event-birding.jpg',
            ],
            [
                'title' => 'Crater Rim Trail Run',
                'description' => 'A community 10K and 21K trail run along the forested Ngorongoro crater rim. All abilities welcome — register at the Karatu sports club.',
                'location' => 'near-crater-gate',
                'starts_at' => now()->addDays(45)->setTime(6, 0),
                'ends_at' => now()->addDays(45)->setTime(11, 0),
                'cover_image' => '/images/placeholders/event-trail.jpg',
            ],
            [
                'title' => 'Taste of Karatu Food Fair',
                'description' => 'Local lodges and restaurants showcase farm-to-table Tanzanian cuisine, live cooking demos and live music in a one-day food fair.',
                'location' => 'karatu-town',
                'starts_at' => now()->addDays(52)->setTime(11, 0),
                'ends_at' => now()->addDays(52)->setTime(21, 0),
                'cover_image' => '/images/placeholders/event-food.jpg',
            ],
        ];

        foreach ($events as $data) {
            Event::updateOrCreate(
                ['title' => $data['title']],
                [
                    'description' => $data['description'],
                    'location_id' => $locations[$data['location']]->id ?? null,
                    'starts_at' => $data['starts_at'],
                    'ends_at' => $data['ends_at'],
                    'cover_image' => $data['cover_image'],
                ]
            );
        }
    }
}
