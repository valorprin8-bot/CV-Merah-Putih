<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('company_name', 150);
            $table->string('tagline', 255);
            $table->text('description');
            $table->string('address', 255);
            $table->string('phone', 50);
            $table->string('whatsapp', 30);
            $table->string('email', 160);
            $table->string('operating_hours', 180);
            $table->text('vision');
            $table->json('missions');
            $table->string('maps_url', 500);
            $table->string('logo_url', 500)->nullable();
            $table->string('hero_image_url', 500)->default('/images/hero-garage.jpg');
            $table->string('about_image_url', 500)->default('/images/hero-garage.jpg');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_profiles');
    }
};