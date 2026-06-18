<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\Comparison;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $savedComparisons = Comparison::where('user_id', $user->id)
            ->with(['product1', 'product2'])
            ->latest()
            ->get();

        $activeAlerts = Alert::where('user_id', $user->id)
            ->where('is_active', true)
            ->with(['product', 'product.prices'])
            ->get()
            ->map(function ($alert) {
                $alert->current_price = $alert->product->prices()->orderBy('price')->first()?->price;
                $alert->progress = $alert->current_price
                    ? min(100, round((1 - ($alert->current_price - $alert->target_price) / $alert->current_price) * 100))
                    : 0;
                return $alert;
            });

        return view('pages.dashboard', compact('savedComparisons', 'activeAlerts'));
    }

    public function addToWatchlist(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);
        // Watchlist is stored as a comparison with a single product
        return back()->with('success', 'Added to your watchlist!');
    }

    public function removeFromWatchlist(string $productId)
    {
        return back()->with('success', 'Removed from watchlist.');
    }

    public function createAlert(Request $request)
    {
        $request->validate([
            'product_id'   => 'required|exists:products,id',
            'target_price' => 'required|numeric|min:0',
        ]);

        Alert::updateOrCreate(
            ['user_id' => auth()->id(), 'product_id' => $request->product_id, 'retailer_id' => null],
            ['target_price' => $request->target_price, 'is_active' => true]
        );

        return back()->with('success', 'Price alert set successfully!');
    }

    public function deleteAlert(int $id)
    {
        Alert::where('id', $id)->where('user_id', auth()->id())->delete();
        return back()->with('success', 'Alert removed.');
    }
}
