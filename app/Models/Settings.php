<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'handphone',
        'email',
        'logo',
        'favicon',
        'facebook',
        'twitter',
        'instagram',
        'youtube',
        'description',
        'sertifikat',
    ];
}
