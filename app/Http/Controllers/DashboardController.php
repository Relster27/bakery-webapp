<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $bakery = $this->currentBakery();
        $completedOrders = $bakery->orders()
            ->where('order_status', 'completed')
            ->get();

        $stats = [
            'products' => $bakery->products()->count(),
            'customers' => $bakery->customers()->count(),
            'orders_today' => $bakery->orders()->whereDate('ordered_at', today())->count(),
            'pending_orders' => $bakery->orders()->whereIn('order_status', ['pending', 'baking', 'ready'])->count(),
            'revenue_ledger' => $bakery->revenue_ledger,
            'active_discounts' => $bakery->discountRules()->where('is_active', true)->count(),
            'custom_cake_requests' => $bakery->customCakeRequests()
                ->whereDate('pickup_date', '>=', today()->toDateString())
                ->whereIn('status', ['requested', 'reviewed', 'confirmed'])
                ->count(),
        ];

        $transparency = [
            'gross_before_discount' => $completedOrders->sum(fn ($order) => $order->grossBeforeDiscount()),
            'discounts_given' => $completedOrders->sum('discount_total'),
            'customer_paid' => $completedOrders->sum('total_amount'),
            'platform_fees' => $completedOrders->sum('platform_fee'),
            'net_after_fees' => $completedOrders->sum(fn ($order) => $order->netAfterFees()),
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

        $upcomingPrep = $this->prepSnapshot(
            $bakery->orders()
                ->with('items.product')
                ->where('order_type', 'preorder')
                ->whereIn('order_status', ['pending', 'baking', 'ready'])
                ->whereDate('pickup_time', '>=', today()->toDateString())
                ->take(10)
                ->get()
        );

        return view('dashboard.index', [
            'bakery' => $bakery,
            'stats' => $stats,
            'transparency' => $transparency,
            'lowStockItems' => $lowStockItems,
            'recentOrders' => $recentOrders,
            'upcomingPrep' => $upcomingPrep,
        ]);
    }

    protected function prepSnapshot(Collection $orders): Collection
    {
        return $orders
            ->flatMap(fn ($order) => $order->items->map(fn ($item) => [
                'product' => $item->product?->name ?? 'Deleted product',
                'quantity' => $item->quantity,
            ]))
            ->groupBy('product')
            ->map(fn (Collection $items, string $product) => [
                'product' => $product,
                'quantity' => $items->sum('quantity'),
            ])
            ->sortByDesc('quantity')
            ->take(5)
            ->values();
    }
}
