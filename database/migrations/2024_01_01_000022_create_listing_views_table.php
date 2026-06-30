<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listing_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained()->cascadeOnDelete();
            $table->timestamp('viewed_at');
            $table->enum('source', ['direct', 'organic_search', 'referral', 'other'])->default('direct');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listing_views');
    }
};
