<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    use HasFactory;

    protected $table = 'articles';

    protected $fillable = [
        'admin_id',
        'title',
        'category',
        'excerpt',
        'content',
        'image_url',
        'published_at',
        'author',
        'status',
    ];

    protected $attributes = [
        'author' => 'Tim CV. Merah Putih',
        'status' => 'published',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'date',
        ];
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')->orderByDesc('published_at')->orderByDesc('id');
    }
}