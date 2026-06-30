<?php

namespace Database\Seeders;

use App\Models\Sponsor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SponsorSeeder extends Seeder
{
    public function run(): void
    {
        $sponsors = [
            ['name' => 'Ngorongoro Conservation Authority', 'tier' => 'Official Partner', 'bg' => '#1b5545', 'website_url' => 'https://example.com'],
            ['name' => 'Tanzania Tourist Board', 'tier' => 'Official Partner', 'bg' => '#236d59', 'website_url' => 'https://example.com'],
            ['name' => 'Karatu District Council', 'tier' => 'Gold Sponsor', 'bg' => '#318870', 'website_url' => 'https://example.com'],
            ['name' => 'Highland Coffee Co-op', 'tier' => 'Gold Sponsor', 'bg' => '#52a388', 'website_url' => 'https://example.com'],
            ['name' => 'Safari Airlink', 'tier' => 'Silver Sponsor', 'bg' => '#174538', 'website_url' => 'https://example.com'],
            ['name' => 'Eyasi Cultural Trust', 'tier' => 'Silver Sponsor', 'bg' => '#14392f', 'website_url' => 'https://example.com'],
        ];

        foreach ($sponsors as $i => $data) {
            $path = $this->makePlaceholderLogo($data['name'], $data['bg']);

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

    /**
     * Generate a simple, copyright-free SVG placeholder logo (initials on a
     * coloured rounded card) and store it on the public disk. Returns the path.
     */
    private function makePlaceholderLogo(string $name, string $bg): string
    {
        $initials = collect(explode(' ', $name))
            ->filter()
            ->take(2)
            ->map(fn ($w) => Str::upper(Str::substr($w, 0, 1)))
            ->implode('');

        $label = e($name);

        $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="320" height="160" viewBox="0 0 320 160" role="img" aria-label="{$label}">
  <rect width="320" height="160" rx="16" fill="{$bg}"/>
  <circle cx="60" cy="80" r="34" fill="#ffffff" fill-opacity="0.12"/>
  <text x="60" y="80" font-family="Arial, sans-serif" font-size="30" font-weight="700"
        fill="#ffffff" text-anchor="middle" dominant-baseline="central">{$initials}</text>
  <text x="110" y="68" font-family="Arial, sans-serif" font-size="15" font-weight="700" fill="#ffffff">SPONSOR</text>
  <text x="110" y="92" font-family="Arial, sans-serif" font-size="11" fill="#ffffff" fill-opacity="0.7">Placeholder logo</text>
</svg>
SVG;

        $path = 'sponsors/' . Str::slug($name) . '.svg';
        Storage::disk('public')->put($path, $svg);

        return $path;
    }
}
