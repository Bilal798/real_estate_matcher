<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchProfile extends Model
{
    use HasFactory;

    protected $casts = [
        'returnActual' => 'array'
    ];

    public function searchFields()
    {
        return $this->hasOne(SearchProfileItem::class, 'searchProfileId', 'id');
    }
}
