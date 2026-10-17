<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdZone extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'dimensions_label',
        'description',
    ];

    public function banners(): HasMany
    {
        return $this->hasMany(Banner::class);
    }
}
