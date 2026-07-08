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
            ['name' => 'FC Bavois', 'file' => 'fc-bavois.png', 'tier' => 'Football Partner', 'website_url' => 'https://www.fcbavois.ch'],
            ['name' => 'Tanzania Football Federation', 'file' => 'tff.png', 'tier' => 'Federation Partner', 'website_url' => 'https://www.tff.or.tz'],
            ['name' => 'Arusha Region Football Association', 'file' => 'arusha-rfa.png', 'tier' => 'Football Partner', 'website_url' => null],
            ['name' => 'Hive-2-Bottle', 'file' => 'hive-2-bottle.png', 'tier' => 'Official Sponsor', 'website_url' => null],
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
                    'sort_order' => $i,
                    'is_active' => true,
                ]
            );
        }
    }
}
