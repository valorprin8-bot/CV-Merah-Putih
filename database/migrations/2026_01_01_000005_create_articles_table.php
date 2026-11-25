<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('title', 200);
            $table->string('category', 80);
            $table->text('excerpt');
            $table->longText('content');
            $table->string('image_url', 500);
            $table->date('published_at');
            $table->string('author', 120)->default('Tim CV. Merah Putih');
            $table->enum('status', ['published', 'draft'])->default('published');
            $table->timestamps();

            $table->index(['status', 'published_at'], 'idx_articles_status_published');
            $table->index('category', 'idx_articles_category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};