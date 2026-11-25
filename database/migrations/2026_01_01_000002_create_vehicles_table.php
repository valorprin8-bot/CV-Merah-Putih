<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('name', 150);
            $table->string('category', 80);
            $table->enum('transmission', ['Matic', 'Manual'])->default('Matic');
            $table->unsignedTinyInteger('seats')->default(7);
            $table->unsignedSmallInteger('year');
            $table->string('fuel', 50)->default('Bensin');
            $table->string('engine', 100)->default('1.5L');
            $table->unsignedInteger('price_per_day');
            $table->enum('status', ['tersedia', 'disewa'])->default('tersedia');
            $table->string('image_url', 500);
            $table->text('description')->nullable();
            $table->json('features');
            $table->boolean('featured')->default(false);
            $table->timestamps();

            $table->index(['status', 'featured'], 'idx_vehicles_status_featured');
            $table->index('transmission', 'idx_vehicles_transmission');
            $table->index('category', 'idx_vehicles_category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};