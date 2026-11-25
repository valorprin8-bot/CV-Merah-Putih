<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vehicle extends Model
{
    use HasFactory;

    protected $table = 'vehicles';

    protected $fillable = [
        'created_by',
        'name',
        'category',
        'transmission',
        'seats',
        'year',
        'fuel',
        'engine',
        'price_per_day',
        'status',
        'image_url',
        'description',
        'features',
        'featured',
    ];

    protected $attributes = [
        'transmission' => 'Matic',
        'seats' => 7,
        'fuel' => 'Bensin',
        'engine' => '1.5L',
        'status' => 'tersedia',
        'description' => '',
        'features' => '[]',
        'featured' => false,
    ];

    protected function casts(): array
    {
        return [
            'seats' => 'integer',
            'year' => 'integer',
            'price_per_day' => 'integer',
            'features' => 'array',
            'featured' => 'boolean',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeTersedia(Builder $query): Builder
    {
        return $query->where('status', 'tersedia');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('featured', true);
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format((int) $this->price_per_day, 0, ',', '.');
    }
}