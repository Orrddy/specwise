<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function show(string $slug, Request $request): View
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $brand = $request->get('brand');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');
        $sort = $request->get('sort', 'popular');

        $products = Product::where('category_id', $category->id)
            ->where('is_active', true)
            ->when($brand, fn($q) => $q->where('brand', $brand))
            ->with(['prices'])
            ->orderByDesc('view_count')
            ->paginate(24);

        $brands = Product::where('category_id', $category->id)->distinct()->pluck('brand');
        $breadcrumbs = $this->getBreadcrumbs($category);

        return view('pages.category', compact('category', 'products', 'brands', 'breadcrumbs'));
    }

    private function getBreadcrumbs(Category $category): array
    {
        $crumbs = [['name' => $category->name, 'url' => route('categories.show', $category->slug)]];
        if ($category->parent) {
            array_unshift($crumbs, ['name' => $category->parent->name, 'url' => route('categories.show', $category->parent->slug)]);
        }
        array_unshift($crumbs, ['name' => 'Home', 'url' => route('home')]);
        return $crumbs;
    }
}
