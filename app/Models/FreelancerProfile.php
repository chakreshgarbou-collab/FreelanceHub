<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FreelancerProfile extends Model
{
    // Only these fields can be filled from a form (protects against mass assignment)
    protected $fillable = [
        'professional_title',
        'bio',
        'skills',
        'location',
        'hourly_rate',
        'availability_status',
    ];

    protected $casts = [
        'hourly_rate' => 'decimal:2',
        'availability_status' => 'boolean',
    ];

    // Each freelancer profile belongs to one user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function services()
    {
        return $this->hasMany(
            Service::class,
            'freelancer_profile_id',
            'freelancer_profile_id'
        );
    }
}
