<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    protected $fillable = [
        'wp_post_id',
        'category_id',
        'title',
        'slug',
        'excerpt',
        'content_html',
        'featured_image',
        'countries_tags',
        'whatsapp_copy',
        'instagram_copy',
        'seo_meta_title',
        'seo_meta_description',
        'generated_with_ai',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'countries_tags' => 'array',
        'generated_with_ai' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
