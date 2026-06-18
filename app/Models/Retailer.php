<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Retailer extends Model
{
    protected $fillable = ['name', 'base_url', 'logo_url', 'country', 'trust_score', 'is_active'];
    protected $casts = ['trust_score' => 'float', 'is_active' => 'boolean'];

    public function prices(): HasMany { return $this->hasMany(Price::class); }
}
