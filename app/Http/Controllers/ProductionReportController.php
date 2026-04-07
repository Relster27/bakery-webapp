<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProductionReportController extends Controller
{
    public function index(Request $request): View
    {
        $date = Carbon::parse($request->input('date', now()->toDateString()));
        [$orders, $customCakes] = $this->productionData($date);

        return view('production-reports.index', [
            'date' => $date->toDateString(),
            'productPrep' => $this->aggregateProductPrep($orders),
            'orders' => $orders,
            'customCakes' => $customCakes,
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $date = Carbon::parse($request->input('date', now()->toDateString()));
        [$orders, $customCakes] = $this->productionData($date);
        $productPrep = $this->aggregateProductPrep($orders);

        return response()->streamDownload(function () use ($date, $productPrep, $customCakes) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Production report for '.$date->toDateString()]);
            fputcsv($handle, []);
            fputcsv($handle, ['Bakery product', 'Total quantity']);

            foreach ($productPrep as $row) {
                fputcsv($handle, [$row['product'], $row['quantity']]);
            }

            fputcsv($handle, []);
            fputcsv($handle, ['Custom cake customer', 'Pickup date', 'Servings', 'Style', 'Flavor summary', 'Status']);

            foreach ($customCakes as $requestRow) {
                fputcsv($handle, [
                    $requestRow->customer_name,
                    $requestRow->pickup_date?->format('Y-m-d'),
                    $requestRow->servings,
                    $requestRow->size.' / '.$requestRow->decoration,
                    $requestRow->sponge.' + '.$requestRow->filling.' + '.$requestRow->frosting,
                    $requestRow->status,
                ]);
            }

            fclose($handle);
        }, 'production-report-'.$date->format('Ymd').'.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    protected function productionData(Carbon $date): array
    {
        $bakery = $this->currentBakery();

        $orders = $bakery->orders()
            ->with(['items.product', 'customer'])
            ->where('order_type', 'preorder')
            ->whereDate('pickup_time', $date->toDateString())
            ->whereIn('order_status', ['pending', 'baking', 'ready'])
            ->orderBy('pickup_time')
            ->get();

        $customCakes = $bakery->customCakeRequests()
            ->whereDate('pickup_date', $date->toDateString())
            ->whereIn('status', ['requested', 'reviewed', 'confirmed'])
            ->orderBy('pickup_date')
            ->get();

        return [$orders, $customCakes];
    }

    protected function aggregateProductPrep(Collection $orders): Collection
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
            ->values();
    }
}
