<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('excerpt', 500)->nullable();
            $table->longText('body')->nullable();
            $table->string('cover_image')->nullable();

            // 'article' = news story, 'video' = YouTube-hosted clip
            $table->string('type')->default('article');
            $table->string('youtube_url')->nullable();
            $table->boolean('is_live')->default(false); // live-event stream flag (video)

            // Breaking-news / highlight ticker on the homepage
            $table->boolean('is_breaking')->default(false);

            // Editorial workflow: draft -> pending_review -> published -> archived
            $table->string('status')->default('draft');
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOn();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOn();
            $table->text('review_note')->nullable();

            $table->timestamp('published_at')->nullable();
            $table->timestamp('archived_at')->nullable();
            $table->unsignedBigInteger('views')->default(0);
            $table->timestamps();

            $table->index(['status', 'published_at']);
            $table->index(['type', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
