<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyProfile extends Model
{
    use HasFactory;

    protected $table = 'company_profiles';

    protected $fillable = [
        'updated_by',
        'company_name',
        'tagline',
        'description',
        'address',
        'phone',
        'whatsapp',
        'email',
        'operating_hours',
        'vision',
        'missions',
        'maps_url',
        'logo_url',
        'hero_image_url',
        'about_image_url',
    ];

    protected $attributes = [
        'missions' => '[]',
        'logo_url' => '',
        'hero_image_url' => '/images/hero-garage.jpg',
        'about_image_url' => '/images/hero-garage.jpg',
    ];

    protected function casts(): array
    {
        return [
            'missions' => 'array',
        ];
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}