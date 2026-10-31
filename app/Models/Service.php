<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $primaryKey = 'service_id';

    protected $fillable = [
        'category_id',
        'title',
        'description',
        'price',
        'delivery_days',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(
            Category::class,
            'category_id',
            'category_id'
        );
    }

    public function freelancerProfile()
    {
        return $this->belongsTo(
            FreelancerProfile::class,
            'freelancer_profile_id',
            'freelancer_profile_id'
        );
    }
}