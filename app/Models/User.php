<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'role',
        'is_active',
        'email_verified_at',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $attributes = [
        'role' => 'admin',
        'is_active' => true,
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function companyProfiles(): HasMany
    {
        return $this->hasMany(CompanyProfile::class, 'updated_by');
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class, 'created_by');
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class, 'created_by');
    }

    public function termsSections(): HasMany
    {
        return $this->hasMany(TermsSection::class, 'updated_by');
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'admin_id');
    }
}