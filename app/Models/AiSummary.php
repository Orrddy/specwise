<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiSummary extends Model
{
    protected $table = 'ai_summaries';
    protected $fillable = ['product_id', 'type', 'input_hash', 'content', 'model', 'tokens_used', 'cost_usd', 'expires_at'];
    protected $casts = ['content' => 'array', 'cost_usd' => 'decimal:6', 'expires_at' => 'datetime'];

    public function product(): BelongsTo { return $this->belongsTo(Product::class); }
}
