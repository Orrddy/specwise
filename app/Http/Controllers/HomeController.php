<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comparison;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $categories = Category::orderBy('name')->get();

        // Featured: most viewed comparison
        $featuredComparison = Comparison::where('is_public', true)
            ->orderByDesc('view_count')
            ->first();

        // Trending: next 2 most viewed comparisons (excluding featured)
        $trendingComparisons = Comparison::where('is_public', true)
            ->when($featuredComparison, fn($q) => $q->where('id', '!=', $featuredComparison->id))
            ->orderByDesc('view_count')
            ->limit(2)
            ->get();

        return view('pages.home', compact('categories', 'featuredComparison', 'trendingComparisons'));
    }
}
