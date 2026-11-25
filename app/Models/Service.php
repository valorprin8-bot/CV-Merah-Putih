<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = [
        'created_by',
        'title',
        'subtitle',
        'icon',
        'description',
        'highlights',
        'sort_order',
    ];

    protected $attributes = [
        'icon' => 'Car',
        'highlights' => '[]',
        'sort_order' => 0,
    ];

    protected function casts(): array
    {
        return [
            'highlights' => 'array',
            'sort_order' => 'integer',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function termsSections(): HasMany
    {
        return $this->hasMany(TermsSection::class, 'service_id')->orderBy('sort_order')->orderBy('id');
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }
}