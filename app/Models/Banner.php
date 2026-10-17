<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Banner extends Model
{
    protected $fillable = [
        'sponsor_id',
        'ad_zone_id',
        'title',
        'headline',
        'subheadline',
        'image_path',
        'target_url',
        'color_theme',
        'starts_at',
        'ends_at',
        'impressions_count',
        'clicks_count',
        'is_active',
    ];

    protected $casts = [
        'starts_at' => 'date',
        'ends_at' => 'date',
        'is_active' => 'boolean',
    ];

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class);
    }

    public function adZone(): BelongsTo
    {
        return $this->belongsTo(AdZone::class);
    }

    public function getCtrAttribute(): float
    {
        if ($this->impressions_count <= 0) {
            return 0.0;
        }

        return round(($this->clicks_count / $this->impressions_count) * 100, 2);
    }

    public function getDaysRemainingAttribute(): int
    {
        if (! $this->ends_at) {
            return 30;
        }

        return (int) Carbon::today()->diffInDays($this->ends_at, false);
    }

    public function getIsExpiringSoonAttribute(): bool
    {
        $days = $this->days_remaining;

        return $days >= 0 && $days <= 7;
    }
}
