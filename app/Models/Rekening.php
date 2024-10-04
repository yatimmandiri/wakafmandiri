<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rekening extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'number',
        'bank',
        'provider',
        'group',
        'token',
        'icon',
        'status',
        'recomendation',
    ];
}
