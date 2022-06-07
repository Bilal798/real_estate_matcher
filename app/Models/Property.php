<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    /**
     * Description: Relation between property and property fields.
     */
    public function propertyFields(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(PropertyItem::class, 'propertyId', 'id');
    }

    /**
     * Description: Get all the search profiles related to the current property type.
     */
    public function potentialProfiles(): \Illuminate\Database\Eloquent\Collection|array
    {
        return SearchProfile::with('searchFields')->where('propertyType', $this->propertyType)->get();
    }
}
