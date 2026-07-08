<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sponsor_applications', function (Blueprint $table) {
            $table->id();
            $table->string('organisation');
            $table->string('contact_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('website_url')->nullable();
            $table->string('tier')->nullable();       // preferred package
            $table->text('message')->nullable();
            $table->string('logo_path')->nullable();   // optional uploaded logo
            $table->enum('status', ['new', 'approved', 'rejected'])->default('new');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sponsor_applications');
    }
};
