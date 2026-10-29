<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientProfile extends Model
{
    // Only these fields can be filled from a form (protects against mass assignment)
    protected $fillable = [
        'industry',
        'bio',
        'current_job',
        'address',
        'availability_status',
    ];

    protected $casts = [
        'availability_status' => 'boolean',
    ];

    // Each client profile belongs to one user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}