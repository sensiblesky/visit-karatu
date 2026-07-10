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
        ];

        foreach ($posts as $data) {
            Post::updateOrCreate(
                ['title' => $data['title']],
                array_merge($data, ['author_id' => $authorId, 'reviewed_by' => $data['status'] === 'published' ? $authorId : null]),
            );
        }
    }
}
