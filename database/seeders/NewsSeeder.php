<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::where('email', 'admin@visitkaratu.com')->first();
        $authorId = $author?->id;

        $posts = [
            [
                'title' => 'Tanzania defeat Senegal to top CECAFA pre-CHAN tournament',
                'excerpt' => 'The national team lifted the trophy after a commanding run, with Karatu-linked talent in the squad.',
                'body' => "Tanzania sealed top spot at the CECAFA pre-CHAN tournament with a decisive win over Senegal.\n\nThe result is a boost for football development across the country, including grassroots programmes in the Karatu district that feed talent into the regional and national pipeline.",
                'type' => 'article', 'status' => 'published', 'is_breaking' => true,
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => 'FC Bavois community project returns to Karatu this season',
                'excerpt' => 'Our Swiss football partner is back with coaching clinics and a friendly match programme.',
                'body' => "FC Bavois, Visit Karatu's founding football partner, is returning for another season of community football in Karatu.\n\nThe visit includes coaching clinics for young players, a series of friendly matches, and community projects designed to strengthen the link between Karatu and European football.",
                'type' => 'article', 'status' => 'published', 'is_breaking' => true,
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'New coffee-tour trail opens in the Karatu highlands',
                'excerpt' => 'Visitors can now walk a guided farm-to-cup trail through the district\'s celebrated coffee estates.',
                'body' => "A new guided coffee trail has opened across several estates in the Karatu highlands, letting visitors follow the journey from cherry to cup.\n\nThe trail is part of a broader push to grow agri-tourism in the district.",
                'type' => 'article', 'status' => 'published', 'is_breaking' => false,
                'published_at' => now()->subDays(8),
            ],
            [
                'title' => 'Looking back: Karatu\'s first cultural festival',
                'excerpt' => 'An archive look at the festival that brought Iraqw, Datoga and Hadzabe communities together.',
                'body' => "Two years ago, Karatu hosted its first cultural festival, a celebration of the Iraqw, Datoga and Hadzabe communities.\n\nThis archived story revisits that milestone event.",
                'type' => 'article', 'status' => 'published', 'is_breaking' => false,
                'published_at' => now()->subDays(70), // older than the 30-day window → archive
            ],
            [
                'title' => 'DRAFT: Upcoming Gulio market schedule',
                'excerpt' => 'Pending editorial review before publishing.',
                'body' => "Draft copy for the upcoming Gulio (mnada) market schedule. Awaiting an editor's review.",
                'type' => 'article', 'status' => 'pending_review', 'is_breaking' => false,
                'published_at' => null,
            ],
            [
                'title' => 'Karatu Highlights: matchday reel',
                'excerpt' => 'Watch the best moments from the latest community match.',
                'body' => null,
                'type' => 'video', 'status' => 'published', 'is_breaking' => false,
                'youtube_url' => 'https://www.youtube.com/watch?v=aqz-KE-bpKQ',
                'published_at' => now()->subDays(2),
            ],

            [
                'title' => 'Ngorongoro visitor numbers climb as high season begins',
                'excerpt' => 'Conservation authorities report a busy start to the season, with most travellers passing through Karatu town on the way to the crater.',
                'body' => "The Ngorongoro Conservation Area has seen a steady rise in visitor arrivals over the past month as the dry-season rush gets under way.\n\nMost travellers heading for the crater rim pass through Karatu, the last major town before the gate, and local lodges, tour operators and restaurants say bookings are strong for the coming weeks.\n\n\"We start seeing the numbers pick up from June, and this year has been busier than last,\" said one Karatu-based guide. \"It is good for the whole town, not just the parks.\"\n\nOperators are urging visitors to book game drives and accommodation early, as the most popular lodges fill quickly during peak weeks.",
                'type' => 'article', 'status' => 'published', 'is_breaking' => false,
                'cover_image' => '/images/placeholders/wildlife.jpg',
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Karatu FC book place in regional cup semi-final',
                'excerpt' => 'A late goal sent the district side through to the last four of the Arusha regional competition.',
                'body' => "Karatu FC edged into the semi-finals of the Arusha regional cup after a hard-fought win in front of a lively home crowd.\n\nThe only goal of the match came late in the second half, sparking celebrations among supporters who had packed the local ground. The result is one of the club's best runs in the competition in recent years.\n\nCoaches credited the district's growing youth football programmes, including community clinics run with visiting partners, for deepening the pool of local talent.\n\nThe semi-final is expected to be played later this month, with a venue to be confirmed by organisers.",
                'type' => 'article', 'status' => 'published', 'is_breaking' => true,
                'cover_image' => '/images/placeholders/sport.jpg',
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => 'Karatu coffee cooperative recognised for quality at regional cupping',
                'excerpt' => 'Highland estates around the district scored highly at a recent tasting, boosting hopes for the growing coffee-tourism trade.',
                'body' => "A cooperative of smallholder coffee farmers from the Karatu highlands has been recognised for the quality of its beans at a regional cupping session.\n\nThe district's cool climate and volcanic soils have long produced sought-after arabica, and growers hope the recognition will help open new markets and draw more visitors to farm tours.\n\nSeveral estates now welcome travellers for guided walks that follow the process from cherry to cup, part of a wider effort to grow agri-tourism alongside the safari trade.\n\n\"When people taste the coffee where it is grown, they remember Karatu,\" said one cooperative member.",
                'type' => 'article', 'status' => 'published', 'is_breaking' => false,
                'cover_image' => '/images/placeholders/event-coffee.jpg',
                'published_at' => now()->subDays(6),
            ],
            [
                'title' => 'Council begins upgrades on the Karatu to Ngorongoro gate road',
                'excerpt' => 'Karatu District Council has started maintenance work aimed at easing travel for residents and visitors alike.',
                'body' => "Karatu District Council has begun a round of road maintenance on sections of the route linking the town to the Ngorongoro gate.\n\nThe work is intended to smooth one of the busiest tourism corridors in northern Tanzania, used daily by safari vehicles, freight and local traffic. Officials say improved roads support both residents and the visitor economy.\n\nDrivers are advised to expect short delays at active work sites and to follow signage from crews. The council said the upgrades form part of its ongoing investment in infrastructure across the district.",
                'type' => 'article', 'status' => 'published', 'is_breaking' => false,
                'cover_image' => '/images/placeholders/savanna.jpg',
                'published_at' => now()->subDays(9),
            ],
            [
                'title' => 'Hadzabe cultural tours expand with new community guiding roles',
                'excerpt' => 'A community-led tourism programme near Lake Eyasi is training more young guides to share Hadzabe and Datoga traditions.',
                'body' => "A community tourism initiative near Lake Eyasi is expanding, creating new guiding roles for young people from the Hadzabe and Datoga communities.\n\nVisitors on the dawn bushwalks learn traditional hunting and gathering skills, while Datoga blacksmiths demonstrate metalwork techniques passed down over generations. Organisers say keeping the experience community-led ensures more of the income stays local.\n\nThe programme has become one of the most requested day trips from Karatu, and the new roles are intended to spread the benefits to more households while protecting the cultural heritage at its heart.",
                'type' => 'article', 'status' => 'published', 'is_breaking' => false,
                'cover_image' => '/images/placeholders/event-hadzabe.jpg',
                'published_at' => now()->subDays(12),
            ],
            [
                'title' => 'Flamingos return in force to Lake Eyasi as birding season peaks',
                'excerpt' => 'Birdwatchers are being drawn to the soda lake as large flocks gather along the shallows.',
                'body' => "Large flocks of flamingos have gathered along the shallows of Lake Eyasi, marking the peak of the birding season on the edge of the Karatu district.\n\nThe seasonal spectacle draws photographers and birdwatchers, who combine it with visits to nearby cultural sites and the Ngorongoro highlands. Guides report strong interest from visitors keen to see the birds at their most numerous.\n\nEarly mornings offer the best viewing, with calm water and soft light along the lake edge.",
                'type' => 'article', 'status' => 'published', 'is_breaking' => false,
                'cover_image' => '/images/placeholders/event-birding.jpg',
                'published_at' => now()->subDays(16),
            ],
            [
                'title' => 'New guesthouses open in Karatu town ahead of busy months',
                'excerpt' => 'Several small, locally owned lodgings have opened as the district prepares for a strong high season.',
                'body' => "A handful of small, locally owned guesthouses have opened in and around Karatu town as operators prepare for the busy travel months.\n\nThe new lodgings add to a growing range of places to stay, from budget rooms to farm lodges with views over the coffee estates. Business owners say demand has been rising as more travellers use Karatu as a base for exploring Ngorongoro, Lake Manyara and Lake Eyasi.\n\nThe district's tourism directory continues to add listings, making it easier for visitors to compare options and contact hosts directly.",
                'type' => 'article', 'status' => 'published', 'is_breaking' => false,
                'cover_image' => '/images/placeholders/lodge.jpg',
                'published_at' => now()->subDays(21),
            ],
            [
                'title' => 'Sunrise over the highlands: a short film from Karatu',
                'excerpt' => 'A short montage of early mornings across the Karatu highlands and the road to the crater.',
                'body' => null,
                'type' => 'video', 'status' => 'published', 'is_breaking' => false,
                'youtube_url' => 'https://www.youtube.com/watch?v=1La4QzGeaaQ',
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Looking back: Karatu marks World Tourism Day with community clean-up',
                'excerpt' => 'An archive look at the volunteer clean-up and market day that brought the town together last year.',
                'body' => "Last year, residents, students and local businesses joined a community clean-up across Karatu town to mark World Tourism Day.\n\nThe day combined tidying of public spaces with a lively gulio market and cultural performances, underlining the link between a welcoming town and a healthy visitor economy.\n\nThis archived story revisits the event and the volunteers who made it happen.",
                'type' => 'article', 'status' => 'published', 'is_breaking' => false,
                'cover_image' => '/images/placeholders/culture.jpg',
                'published_at' => now()->subDays(52), // older than the 30-day window → archive
            ],
        ];

        foreach ($posts as $data) {
            Post::updateOrCreate(
                ['title' => $data['title']],
                array_merge($data, ['author_id' => $authorId, 'reviewed_by' => $data['status'] === 'published' ? $authorId : null]),
            );
        }
    }
}
