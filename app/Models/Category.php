<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'category_id';

    public function services()
    {
        return $this->hasMany(
            Service::class,
            'category_id',
            'category_id'
        );
    }
}