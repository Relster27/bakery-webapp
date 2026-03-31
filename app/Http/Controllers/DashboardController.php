<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $bakery = $this->currentBakery();

        $stats = [
            'products' => $bakery->products()->count(),
            'customers' => $bakery->customers()->count(),
            'orders_today' => $bakery->orders()->whereDate('ordered_at', today())->count(),
            'pending_orders' => $bakery->orders()->whereIn('order_status', ['pending', 'baking', 'ready'])->count(),
            'revenue_ledger' => $bakery->revenue_ledger,
        ];

        $lowStockItems = $bakery->inventories()
            ->with('product')
            ->whereColumn('quantity_on_hand', '<=', 'reorder_level')
            ->orderBy('quantity_on_hand')
            ->get();

        $recentOrders = $bakery->orders()
            ->with('customer')
            ->latest('ordered_at')
            ->take(5)
            ->get();

        return view('dashboard.index', [
            'bakery' => $bakery,
            'stats' => $stats,
            'lowStockItems' => $lowStockItems,
            'recentOrders' => $recentOrders,
        ]);
    }
}
