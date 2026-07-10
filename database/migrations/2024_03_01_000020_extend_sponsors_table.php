<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sponsors', function (Blueprint $table) {
            // Grading: platinum / gold / silver (drives front-page placement).
            $table->string('level')->default('silver')->after('tier');
            // Sports-partnership fields (Visit Rwanda style hub + detail pages).
            $table->boolean('is_sports')->default(false)->after('level');
            $table->string('slug')->nullable()->unique()->after('name');
            $table->string('summary', 500)->nullable()->after('website_url');
            $table->longText('body')->nullable()->after('summary');
            $table->string('hero_image')->nullable()->after('logo_path');
        });
    }

    public function down(): void
    {
        Schema::table('sponsors', function (Blueprint $table) {
            $table->dropColumn(['level', 'is_sports', 'slug', 'summary', 'body', 'hero_image']);
        });
    }
};
