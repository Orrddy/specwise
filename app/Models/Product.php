<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'name', 'slug', 'brand', 'model_number', 'category_id',
        'description', 'specs', 'images', 'image_url', 'is_active', 'view_count',
    ];

    protected $casts = [
        'specs'     => 'array',
        'images'    => 'array',
        'is_active' => 'boolean',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function prices(): HasMany
    {
        return $this->hasMany(Price::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function aiSummaries(): HasMany
    {
        return $this->hasMany(AiSummary::class);
    }

    public function getLowestPriceAttribute(): ?float
    {
        return $this->prices()->min('price');
    }
}
