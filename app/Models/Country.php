<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'sector',
    ];

    public function classifiedListings(): HasMany
    {
        return $this->hasMany(ClassifiedListing::class);
    }

    public function vecinalClaims(): HasMany
    {
        return $this->hasMany(VecinalClaim::class);
    }
}
