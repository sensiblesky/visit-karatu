<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Branding
            ['key' => 'site_name', 'value' => 'VisitKaratu', 'group' => 'branding', 'type' => 'text', 'label' => 'Site Name'],
            ['key' => 'site_tagline', 'value' => 'Discover. Experience. Karatu.', 'group' => 'branding', 'type' => 'text', 'label' => 'Tagline'],

            // Homepage hero
            ['key' => 'hero_badge', 'value' => "Tanzania's Hidden Gem", 'group' => 'homepage', 'type' => 'text', 'label' => 'Hero Badge Text'],
            ['key' => 'hero_title', 'value' => "Discover the Heart of Northern Tanzania", 'group' => 'homepage', 'type' => 'text', 'label' => 'Hero Title'],
            ['key' => 'hero_subtitle', 'value' => 'Karatu is your gateway to Ngorongoro, Lake Manyara, Lake Eyasi and unforgettable cultural experiences.', 'group' => 'homepage', 'type' => 'textarea', 'label' => 'Hero Subtitle'],
            ['key' => 'hero_media_type', 'value' => 'image', 'group' => 'homepage', 'type' => 'select', 'label' => 'Hero Background Type (image or video)'],
            ['key' => 'hero_image', 'value' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=1800&q=85&auto=format&fit=crop', 'group' => 'homepage', 'type' => 'url', 'label' => 'Hero Background Image URL (also used as video poster)'],
            ['key' => 'hero_video', 'value' => '', 'group' => 'homepage', 'type' => 'url', 'label' => 'Hero Background Video URL (MP4, used when type = video)'],
            ['key' => 'hero_search_placeholder', 'value' => 'Search for lodges, tours, activities...', 'group' => 'homepage', 'type' => 'text', 'label' => 'Hero Search Placeholder'],

            // CTA banner
            ['key' => 'cta_title', 'value' => 'Own a Business in Karatu?', 'group' => 'homepage', 'type' => 'text', 'label' => 'CTA Title'],
            ['key' => 'cta_subtitle', 'value' => 'Join hundreds of lodges, tour operators, and experience providers already reaching thousands of travellers planning their northern Tanzania adventure.', 'group' => 'homepage', 'type' => 'textarea', 'label' => 'CTA Subtitle'],

            // Contact
            ['key' => 'contact_address', 'value' => 'Karatu Town, Arusha Region, Tanzania', 'group' => 'contact', 'type' => 'text', 'label' => 'Address'],
            ['key' => 'contact_email', 'value' => 'info@visitkaratu.com', 'group' => 'contact', 'type' => 'email', 'label' => 'Email'],
            ['key' => 'contact_phone', 'value' => '+255 27 253 4000', 'group' => 'contact', 'type' => 'text', 'label' => 'Phone'],

            // Footer
            ['key' => 'footer_about', 'value' => 'Your gateway to Ngorongoro Crater, Lake Eyasi, Lake Manyara, and the heart of northern Tanzania.', 'group' => 'footer', 'type' => 'textarea', 'label' => 'Footer About Text'],

            // Social
            ['key' => 'social_facebook', 'value' => 'https://facebook.com', 'group' => 'social', 'type' => 'url', 'label' => 'Facebook URL'],
            ['key' => 'social_instagram', 'value' => 'https://instagram.com', 'group' => 'social', 'type' => 'url', 'label' => 'Instagram URL'],
            ['key' => 'social_linkedin', 'value' => 'https://linkedin.com', 'group' => 'social', 'type' => 'url', 'label' => 'LinkedIn URL'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
