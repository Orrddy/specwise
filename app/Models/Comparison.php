<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Comparison extends Model
{
    protected $fillable = ['user_id', 'product_ids', 'title', 'is_public', 'share_token', 'view_count', 'ai_summary', 'tagline', 'category_name'];
    protected $casts = ['product_ids' => 'array', 'is_public' => 'boolean'];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (Comparison $c) {
            $c->share_token = Str::random(12);
        });
    }

    public function user(): BelongsTo { return $this->belongsTo(\App\Models\User::class); }

    public function product1(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_ids->0');
    }

    public function product2(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_ids->1');
    }
}
