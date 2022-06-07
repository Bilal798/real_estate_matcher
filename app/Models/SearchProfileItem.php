<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchProfileItem extends Model
{
    use HasFactory;

    protected $casts = [
        'returnActual' => 'array',
        'price' => 'array',
        'area' => 'array',
        'yearOfConstruction' => 'array',
        'rooms' => 'array'
    ];
}
