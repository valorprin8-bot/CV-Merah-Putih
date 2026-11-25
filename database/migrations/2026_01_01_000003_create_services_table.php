<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('title', 160);
            $table->string('subtitle', 120);
            $table->string('icon', 60)->default('Car');
            $table->text('description');
            $table->json('highlights');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index('sort_order', 'idx_services_sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};