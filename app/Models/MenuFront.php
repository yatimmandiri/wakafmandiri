<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuFront extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
        'link',
        'parent',
    ];

    protected function childs()
    {
        return $this->hasMany(Menu::class, 'parent', 'id');
    }
}
