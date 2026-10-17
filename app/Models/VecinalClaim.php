<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VecinalClaim extends Model
{
    protected $fillable = [
        'country_id',
        'neighbor_name',
        'neighbor_phone',
        'claim_type',
        'description',
        'status',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
