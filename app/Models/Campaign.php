<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'excerpt',
        'description',
        'feature_image',
        'status',
        'categories_id',
    ];

    public function categories()
    {
        return $this->belongsTo(Category::class);
    }
}
