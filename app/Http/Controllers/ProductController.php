<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function show(string $slug): View
    {
        $product = Product::where('slug', $slug)
            ->with(['category', 'reviews', 'prices.retailer'])
            ->firstOrFail();

        // Track view for trending algorithm
        $product->increment('view_count');

        $lowestPrice = $product->prices()->orderBy('price')->first();
        $priceHistory = $product->prices()
            ->orderByDesc('scraped_at')
            ->limit(180)
            ->get()
            ->groupBy(fn($p) => $p->scraped_at->format('Y-m-d'))
            ->map(fn($group) => $group->min('price'));

        $deepSeek = new \App\Services\DeepSeekService();
        $summaryData = $deepSeek->getReviewSummary($product);
        $reviewSummary = (object)[
            'content' => $summaryData
        ];

        return view('pages.product', compact('product', 'lowestPrice', 'priceHistory', 'reviewSummary'));
    }

    public function search(Request $request): View
    {
        $query = $request->get('q', '');
        $brand = $request->get('brand');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');
        $category = $request->get('category');

        $products = Product::query()
            ->where('is_active', true)
            ->when($query, fn($q) => $q->where(function($sub) use ($query) {
                $sub->where('name', 'like', "%{$query}%")
                    ->orWhere('brand', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            }))
            ->when($brand, fn($q) => $q->where('brand', $brand))
            ->when($category, fn($q) => $q->whereHas('category', fn($c) => $c->where('slug', $category)))
            ->with(['category', 'prices'])
            ->paginate(20);

        $categories = Category::orderBy('name')->get();
        $brands = Product::distinct()->orderBy('brand')->pluck('brand');

        return view('pages.search', compact('products', 'query', 'categories', 'brands'));
    }
}
