<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AnalyticsController extends Controller
{
    public function index(Request $request): View
    {
        [$from, $to] = $this->dateRange($request);
        $orders = $this->filteredOrders($from, $to);

        return view('analytics.index', [
            'from' => $from->toDateString(),
            'to' => $to->toDateString(),
            'summary' => $this->buildSummary($orders),
            'hourlySales' => $this->buildHourlySales($orders),
            'topProducts' => $this->buildTopProducts($orders),
            'statusBreakdown' => $orders->groupBy('order_status')->map->count()->sortDesc(),
            'orders' => $orders->take(20),
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        [$from, $to] = $this->dateRange($request);
        $orders = $this->filteredOrders($from, $to);
        $filename = 'sales-analytics-'.$from->format('Ymd').'-'.$to->format('Ymd').'.csv';

        return response()->streamDownload(function () use ($orders) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Order Number', 'Ordered At', 'Type', 'Status', 'Customer', 'Gross Before Discount', 'Discount Given', 'Customer Paid', 'Platform Fee', 'Net After Fee']);

            foreach ($orders as $order) {
                fputcsv($handle, [
                    $order->order_number,
                    $order->ordered_at?->format('Y-m-d H:i:s'),
                    $order->order_type,
                    $order->order_status,
                    $order->customer?->name ?? 'Walk-in customer',
                    number_format($order->grossBeforeDiscount(), 2, '.', ''),
                    number_format((float) $order->discount_total, 2, '.', ''),
                    number_format((float) $order->total_amount, 2, '.', ''),
                    number_format((float) $order->platform_fee, 2, '.', ''),
                    number_format($order->netAfterFees(), 2, '.', ''),
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    protected function dateRange(Request $request): array
    {
        $from = Carbon::parse($request->input('from', now()->subDays(6)->toDateString()))->startOfDay();
        $to = Carbon::parse($request->input('to', now()->toDateString()))->endOfDay();

        if ($from->gt($to)) {
            [$from, $to] = [$to->copy()->startOfDay(), $from->copy()->endOfDay()];
        }

        return [$from, $to];
    }

    protected function filteredOrders(Carbon $from, Carbon $to): Collection
    {
        return $this->currentBakery()->orders()
            ->with(['customer', 'items.product'])
            ->whereBetween('ordered_at', [$from, $to])
            ->latest('ordered_at')
            ->get();
    }

    protected function buildSummary(Collection $orders): array
    {
        $completedOrders = $orders->where('order_status', 'completed');
        $grossBeforeDiscount = $completedOrders->sum(fn ($order) => $order->grossBeforeDiscount());
        $discountsGiven = $completedOrders->sum('discount_total');
        $customerPaid = $completedOrders->sum('total_amount');
        $platformFees = $completedOrders->sum('platform_fee');

        return [
            'completed_orders' => $completedOrders->count(),
            'gross_before_discount' => $grossBeforeDiscount,
            'discounts_given' => $discountsGiven,
            'customer_paid' => $customerPaid,
            'platform_fees' => $platformFees,
            'net_after_fees' => $customerPaid - $platformFees,
        ];
    }

    protected function buildHourlySales(Collection $orders): Collection
    {
        return $orders
            ->where('order_status', 'completed')
            ->groupBy(fn ($order) => $order->ordered_at?->format('H:00') ?? 'Unknown')
            ->map(fn (Collection $group) => [
                'orders' => $group->count(),
                'sales' => $group->sum('total_amount'),
                'net' => $group->sum(fn ($order) => $order->netAfterFees()),
            ])
            ->sortKeys();
    }

    protected function buildTopProducts(Collection $orders): Collection
    {
        return $orders
            ->where('order_status', 'completed')
            ->flatMap(function ($order) {
                return $order->items->map(fn ($item) => [
                    'product' => $item->product?->name ?? 'Deleted product',
                    'quantity' => $item->quantity,
                    'sales' => (float) $item->subtotal_item,
                ]);
            })
            ->groupBy('product')
            ->map(fn (Collection $items, string $product) => [
                'product' => $product,
                'quantity' => $items->sum('quantity'),
                'sales' => $items->sum('sales'),
            ])
            ->sortByDesc('sales')
            ->take(8)
            ->values();
    }
}
