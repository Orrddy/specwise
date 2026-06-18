<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comparison;
use App\Models\Price;
use App\Models\Product;
use App\Models\Retailer;
use App\Models\Review;
use Illuminate\Database\Seeder;

class SpecwiseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Categories ──────────────────────────────────────────────
        $smartphones = Category::create(['name' => 'Smartphones', 'slug' => 'smartphones', 'icon' => 'smartphone']);
        $laptops     = Category::create(['name' => 'Laptops', 'slug' => 'laptops', 'icon' => 'laptop_mac']);
        $headphones  = Category::create(['name' => 'Headphones', 'slug' => 'headphones', 'icon' => 'headphones']);
        Category::create(['name' => 'Cameras', 'slug' => 'cameras', 'icon' => 'photo_camera']);
        Category::create(['name' => 'Wearables', 'slug' => 'wearables', 'icon' => 'watch']);

        // ── Retailers ──────────────────────────────────────────────
        $amazon  = Retailer::create(['name' => 'Amazon',   'base_url' => 'https://amazon.com',  'country' => 'US', 'trust_score' => 0.95]);
        $bestbuy = Retailer::create(['name' => 'Best Buy', 'base_url' => 'https://bestbuy.com', 'country' => 'US', 'trust_score' => 0.92]);
        $walmart = Retailer::create(['name' => 'Walmart',  'base_url' => 'https://walmart.com', 'country' => 'US', 'trust_score' => 0.88]);

        // ── Products ──────────────────────────────────────────────
        $iphone = Product::create([
            'name' => 'Apple iPhone 15 Pro', 'slug' => 'apple-iphone-15-pro',
            'brand' => 'Apple', 'model_number' => 'MTVA3LL/A', 'category_id' => $smartphones->id,
            'description' => 'Apple\'s flagship iPhone with titanium design and A17 Pro chip.',
            'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAg2eRl0tdcYBe9p110vLaQgZJDjJRHSto3kYS_CVjnVf_BVBZoRGICvnTVuweIzXjSqGgx5_3VKDcnPYMe4dtqcy5ZCQWpHnAnzA0mT8gjG8S9L7-NkhwKgla27MvP_eAWR7K01RHSrv2RUq-vj2LC2KTzzDyM-IRn6eenIw5NW2nfaq3BUzGgLfnCXbBABiUmTmQSZDmVSg26fqVyQ5P1M1i-w0M41TlJ7CQvMkxLJEntV9veFPHoE49ZEsx2mNbJrWxA1eFdXjI',
            'specs' => ['display' => '6.1" Super Retina XDR', 'chip' => 'A17 Pro', 'ram_gb' => 8, 'storage_gb' => 256, 'battery_mah' => 3274, 'camera_mp' => 48, '5g' => true, 'weight_g' => 187],
            'is_active' => true, 'view_count' => 1240,
        ]);

        $samsung = Product::create([
            'name' => 'Samsung Galaxy S24 Ultra', 'slug' => 'samsung-galaxy-s24-ultra',
            'brand' => 'Samsung', 'model_number' => 'SM-S928BZKGEUB', 'category_id' => $smartphones->id,
            'description' => 'Samsung\'s most powerful Galaxy with built-in S Pen and 200MP camera.',
            'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCOmVTPQmQ023e6f-HLzg5d-M-8j9ty92OYBdWCtR1H3f3_F2L-dt2JlJWhgdQHpnD95-jTMLtQqXses6Ch2bePQIphbWgk8cW-L-stvhYLuu2x_nXk7JAE2Gg5JjMwqSYJo4PTkECUIKPcuNgLV54I711OTxf4Bdryw0vh_E66qve92u8PSKWXcA77KNLR34jng5AwEk67EkeU689CqJIqhZO6izK2EWgC-0sV4S_tWmlvJgdfMJOuuF6adcNjYUo5rBgsME2meQA',
            'specs' => ['display' => '6.8" QHD+ Dynamic AMOLED', 'chip' => 'Snapdragon 8 Gen 3', 'ram_gb' => 12, 'storage_gb' => 256, 'battery_mah' => 5000, 'camera_mp' => 200, '5g' => true, 'weight_g' => 232],
            'is_active' => true, 'view_count' => 1180,
        ]);

        $macbook = Product::create([
            'name' => 'Apple MacBook Air M3', 'slug' => 'apple-macbook-air-m3',
            'brand' => 'Apple', 'model_number' => 'MRXN3LL/A', 'category_id' => $laptops->id,
            'description' => 'Ultra-thin laptop powered by the M3 chip with up to 18 hours battery.',
            'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBfs_RSD_y3ID3M3IrDrSS52_d0p0xAMN9c5Zx7CKEsmoocx58GlhiZV9vBBmETgeKEO25YwAc1wSsoS0qCrI91c9ZASB44kAE4uF-C_o3C8EaSXtTV0l9EbjE7P-JnSBSPYOBLf5EmarZFUnd7pL88Opk8i8_VM0g_j52-H6jGGkbijgI1C8de-XC7mQeaHoudViTzhLO6OWduC2fUvxw-LuNFuu6ZrgK7QOGpTTfCe-iPdNn5UHu9DSV_JkqXuGcwFnRlujw_FX0',
            'specs' => ['display' => '13.6" Liquid Retina', 'chip' => 'Apple M3', 'ram_gb' => 8, 'storage_gb' => 256, 'battery_hours' => 18, 'weight_kg' => 1.24],
            'is_active' => true, 'view_count' => 980,
        ]);

        $dell = Product::create([
            'name' => 'Dell XPS 13', 'slug' => 'dell-xps-13',
            'brand' => 'Dell', 'model_number' => 'XPS9340-7870PLT', 'category_id' => $laptops->id,
            'description' => 'Dell\'s iconic compact ultrabook with InfinityEdge display.',
            'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCdFBwkEEog7QoWoe1ug3yphriPbNlR3Cfn5u0Xcr4ZcyyzN2wk11ZoBEDkVNrBjTdY4JKuGQ_d1JzqgtLiY-0-ArXmuLSng44AE99qFrfQVelCbq5LHTwTaEo6bW8GdUkoPKOyBqToYw2lgdOmBfliPfCtp7qizpMtrDesqmOTcS9txzGvNUneXg4723s3DOaBr5OMgqpHCooU3UO-srkE4gxQDSe6S_tfsF0cnx6pXm6BCZ0SEYWDxM_4TcONlUfOFmiaK-Q6bN8',
            'specs' => ['display' => '13.4" FHD+ InfinityEdge', 'chip' => 'Intel Core Ultra 7', 'ram_gb' => 16, 'storage_gb' => 512, 'battery_hours' => 12, 'weight_kg' => 1.17],
            'is_active' => true, 'view_count' => 760,
        ]);

        // ── Prices ─────────────────────────────────────────────────
        Price::create(['product_id' => $iphone->id, 'retailer_id' => $amazon->id,  'price' => 999.00,  'url' => 'https://amazon.com/dp/iphone15pro',   'in_stock' => true, 'scraped_at' => now()]);
        Price::create(['product_id' => $iphone->id, 'retailer_id' => $bestbuy->id, 'price' => 999.99,  'url' => 'https://bestbuy.com/iphone15pro',      'in_stock' => true, 'scraped_at' => now()]);
        Price::create(['product_id' => $samsung->id,'retailer_id' => $amazon->id,  'price' => 1199.00, 'url' => 'https://amazon.com/dp/s24ultra',       'in_stock' => true, 'scraped_at' => now()]);
        Price::create(['product_id' => $samsung->id,'retailer_id' => $walmart->id, 'price' => 1149.00, 'url' => 'https://walmart.com/s24ultra',         'in_stock' => true, 'scraped_at' => now()]);
        Price::create(['product_id' => $macbook->id,'retailer_id' => $amazon->id,  'price' => 1099.00, 'url' => 'https://amazon.com/dp/macbookairm3',   'in_stock' => true, 'scraped_at' => now()]);
        Price::create(['product_id' => $macbook->id,'retailer_id' => $bestbuy->id, 'price' => 1099.99, 'url' => 'https://bestbuy.com/macbookairm3',     'in_stock' => true, 'scraped_at' => now()]);
        Price::create(['product_id' => $dell->id,   'retailer_id' => $amazon->id,  'price' => 1249.00, 'url' => 'https://amazon.com/dp/dellxps13',      'in_stock' => true, 'scraped_at' => now()]);

        // ── Comparisons ────────────────────────────────────────────
        Comparison::create([
            'product_ids'   => [$iphone->id, $samsung->id],
            'title'         => 'iPhone 15 Pro vs Galaxy S24 Ultra',
            'is_public'     => true,
            'view_count'    => 4820,
            'category_name' => 'Smartphones',
            'tagline'       => 'Flagship camera battle: who wins in 2024?',
            'ai_summary'    => 'Both devices offer peak performance. iPhone wins on video quality and resale value, while S24 Ultra leads in display brightness, zoom capabilities, and productivity with the S Pen.',
        ]);

        Comparison::create([
            'product_ids'   => [$macbook->id, $dell->id],
            'title'         => 'MacBook Air M3 vs Dell XPS 13',
            'is_public'     => true,
            'view_count'    => 2310,
            'category_name' => 'Laptops',
            'tagline'       => 'Comparing battery life & thermals.',
        ]);

        // ── Reviews ─────────────────────────────────────────────────
        Review::create([
            'product_id' => $iphone->id, 'source' => 'amazon', 'external_id' => 'R1ABC123',
            'title' => 'Best iPhone yet', 'body' => 'The titanium design is premium and the camera is incredible. Battery could be better but overall amazing.',
            'rating' => 4.8, 'author' => 'TechEnthusiast', 'sentiment_score' => 0.85,
            'pros' => ['Great camera', 'Premium build', 'Fast performance'],
            'cons' => ['Battery life', 'Price'],
        ]);

        $this->command->info('✅ SpecWise database seeded successfully!');
        $this->command->info('   - 5 categories, 3 retailers, 4 products, 7 prices, 2 comparisons');
    }
}
