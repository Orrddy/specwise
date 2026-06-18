<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    public $timestamps = false;
    protected $fillable = ['product_id', 'source', 'external_id', 'title', 'body', 'rating', 'author', 'url', 'sentiment_score', 'pros', 'cons', 'scraped_at'];
    protected $casts = ['pros' => 'array', 'cons' => 'array', 'rating' => 'float', 'sentiment_score' => 'float', 'scraped_at' => 'datetime'];

    public function product(): BelongsTo { return $this->belongsTo(Product::class); }
}
