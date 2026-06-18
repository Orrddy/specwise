<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Categories
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('parent_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->json('spec_schema')->nullable();
            $table->string('icon')->nullable()->default('category');
            $table->timestamps();
        });

        // Retailers
        Schema::create('retailers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('base_url');
            $table->string('logo_url')->nullable();
            $table->char('country', 2)->default('US');
            $table->float('trust_score')->default(1.0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Products
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('brand')->nullable()->index();
            $table->string('model_number')->nullable();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->text('description')->nullable();
            $table->json('specs')->default('{}');
            $table->json('images')->default('[]');
            $table->text('image_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('view_count')->default(0);
            $table->timestamps();
            $table->index(['category_id', 'is_active']);
        });

        // Prices
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('retailer_id')->constrained()->cascadeOnDelete();
            $table->decimal('price', 12, 2);
            $table->char('currency', 3)->default('USD');
            $table->text('url');
            $table->boolean('in_stock')->default(true);
            $table->timestamp('scraped_at')->useCurrent();
            $table->index(['product_id', 'retailer_id']);
            $table->index('scraped_at');
        });

        // Reviews
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('source');
            $table->string('external_id')->nullable();
            $table->string('title')->nullable();
            $table->text('body');
            $table->float('rating')->nullable();
            $table->string('author')->nullable();
            $table->text('url')->nullable();
            $table->float('sentiment_score')->nullable();
            $table->json('pros')->default('[]');
            $table->json('cons')->default('[]');
            $table->timestamp('scraped_at')->useCurrent();
            $table->unique(['source', 'external_id']);
            $table->index('product_id');
        });

        // Comparisons
        Schema::create('comparisons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->json('product_ids');
            $table->string('title')->nullable();
            $table->boolean('is_public')->default(false);
            $table->string('share_token')->unique()->nullable();
            $table->unsignedBigInteger('view_count')->default(0);
            $table->text('ai_summary')->nullable();
            $table->string('tagline')->nullable();
            $table->string('category_name')->nullable();
            $table->timestamps();
            $table->index('user_id');
        });

        // Alerts
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('retailer_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('target_price', 12, 2);
            $table->char('currency', 3)->default('USD');
            $table->boolean('is_active')->default(true);
            $table->timestamp('triggered_at')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'product_id', 'retailer_id']);
            $table->index(['product_id', 'is_active']);
        });

        // AI Summaries (DeepSeek response cache)
        Schema::create('ai_summaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type');
            $table->string('input_hash')->unique();
            $table->json('content');
            $table->string('model')->default('deepseek-chat');
            $table->unsignedInteger('tokens_used')->nullable();
            $table->decimal('cost_usd', 10, 6)->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            $table->index('type');
            $table->index('expires_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_summaries');
        Schema::dropIfExists('alerts');
        Schema::dropIfExists('comparisons');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('prices');
        Schema::dropIfExists('products');
        Schema::dropIfExists('retailers');
        Schema::dropIfExists('categories');
    }
};
