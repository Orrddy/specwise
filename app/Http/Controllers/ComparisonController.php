<?php

namespace App\Http\Controllers;

use App\Models\Comparison;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ComparisonController extends Controller
{
    public function index(Request $request): View
    {
        $productIds = array_filter(explode(',', $request->get('products', '')));
        $products = collect();

        if (!empty($productIds)) {
            $products = Product::whereIn('id', $productIds)
                ->with(['category', 'prices.retailer', 'reviews'])
                ->get();

            // Increment view count if this is a saved comparison
            Comparison::where('product_ids', json_encode($productIds))->increment('view_count');
        }

        // Get spec keys shared across all products for table columns
        $specKeys = $products->flatMap(fn($p) => array_keys($p->specs ?? []))->unique()->values();

        $aiNarrative = null;
        if ($products->count() >= 2) {
            $deepSeek = new \App\Services\DeepSeekService();
            $summaryData = $deepSeek->getComparisonSummary($products->all());
            $aiNarrative = (object)[
                'content' => $summaryData
            ];
        }

        return view('pages.comparison', compact('products', 'specKeys', 'aiNarrative'));
    }

    public function save(Request $request)
    {
        $request->validate(['product_ids' => 'required|array|min:2|max:10']);

        $comparison = Comparison::updateOrCreate(
            ['user_id' => auth()->id(), 'product_ids' => json_encode(sort($request->product_ids))],
            ['is_public' => false, 'title' => $request->get('title', 'My Comparison')]
        );

        return back()->with('success', 'Comparison saved to your dashboard!');
    }
}
