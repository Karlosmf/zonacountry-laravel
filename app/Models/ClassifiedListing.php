<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassifiedListing extends Model
{
    protected $fillable = [
        'wp_listing_id',
        'country_id',
        'title',
        'slug',
        'category_name',
        'price_label',
        'description',
        'features',
        'image_path',
        'whatsapp_contact',
        'is_featured',
        'status',
    ];

    protected $casts = [
        'features' => 'array',
        'is_featured' => 'boolean',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
