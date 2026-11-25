<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TermsSection extends Model
{
    use HasFactory;

    protected $table = 'terms_sections';

    protected $fillable = [
        'service_id',
        'updated_by',
        'title',
        'items',
        'sort_order',
    ];

    protected $attributes = [
        'items' => '[]',
        'sort_order' => 0,
    ];

    protected function casts(): array
    {
        return [
            'items' => 'array',
            'sort_order' => 'integer',
        ];
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }
}