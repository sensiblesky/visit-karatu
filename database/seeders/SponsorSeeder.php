<?php

namespace Database\Seeders;

use App\Models\Sponsor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class SponsorSeeder extends Seeder
{
    public function run(): void
    {
        // Remove the earlier placeholder sponsors now that we have real partners.
        Sponsor::whereIn('name', [
            'Ngorongoro Conservation Authority', 'Tanzania Tourist Board',
            'Karatu District Council', 'Highland Coffee Co-op',
            'Safari Airlink', 'Eyasi Cultural Trust',
        ])->delete();

        // Real aimed partners. Source logos live in database/seeders/assets/sponsors
        // (committed) and are copied to the public disk so they survive re-seeds.
        $assetDir = database_path('seeders/assets/sponsors');
        Storage::disk('public')->makeDirectory('sponsors');

        $sponsors = [
            [
                'name' => 'FC Bavois', 'file' => 'fc-bavois.png', 'tier' => 'Football Partner',
                'website_url' => 'https://www.fcbavois.ch', 'level' => 'platinum', 'is_sports' => true,
                'summary' => 'Our founding football partner in Switzerland, carrying Karatu to European fans.',
                'body' => "FC Bavois is Visit Karatu's founding football partner. Based in the canton of Vaud, Switzerland, the club is the message vector that first brings Karatu to European audiences.\n\nThrough training visits, community projects and shared coaching, the partnership links grassroots football in Karatu with a European club, giving young Tanzanian players exposure and Karatu global visibility.",
            ],
            [
                'name' => 'Tanzania Football Federation', 'file' => 'tff.png', 'tier' => 'Federation Partner',
                'website_url' => 'https://www.tff.or.tz', 'level' => 'platinum', 'is_sports' => true,
                'summary' => 'The national governing body for football in Tanzania.',
                'body' => "The Tanzania Football Federation (TFF) is the national governing body for football in Tanzania. As a federation partner, TFF lends institutional support to Karatu's football development ambitions.",
            ],
            [
                'name' => 'Arusha Region Football Association', 'file' => 'arusha-rfa.png', 'tier' => 'Football Partner',
                'website_url' => null, 'level' => 'gold', 'is_sports' => true,
                'summary' => 'Regional football association for the Arusha Region, home to Karatu.',
                'body' => "The Arusha Region Football Association oversees football across the Arusha Region, which includes the Karatu district. It is a key regional partner in developing local talent.",
            ],
            [
                'name' => 'Hive-2-Bottle', 'file' => 'hive-2-bottle.png', 'tier' => 'Official Sponsor',
                'website_url' => null, 'level' => 'silver', 'is_sports' => false,
                'summary' => null, 'body' => null,
            ],
        ];

        foreach ($sponsors as $i => $data) {
            $path = 'sponsors/' . $data['file'];
            $source = $assetDir . '/' . $data['file'];
            if (is_file($source)) {
                Storage::disk('public')->put($path, file_get_contents($source));
            }

            Sponsor::updateOrCreate(
                ['name' => $data['name']],
                [
                    'logo_path' => $path,
                    'website_url' => $data['website_url'],
                    'tier' => $data['tier'],
                    'level' => $data['level'],
                    'is_sports' => $data['is_sports'],
                    'summary' => $data['summary'],
                    'body' => $data['body'],
                    'sort_order' => $i,
                    'is_active' => true,
                ]
            );
        }
    }
}
