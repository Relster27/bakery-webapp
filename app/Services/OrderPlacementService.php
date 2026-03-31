<?php

namespace App\Services;

use App\Models\Bakery;
use App\Models\Customer;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OrderPlacementService
{
    public function place(Bakery $bakery, array $data): Order
    {
        return DB::transaction(function () use ($bakery, $data) {
            $items = $this->resolveItems($bakery, $data['quantities'] ?? []);
            $customer = $this->resolveCustomer($bakery, $data);
            $totalAmount = collect($items)->sum(fn (array $item) => $item['subtotal_item']);
            $orderType = $data['order_type'] ?? 'preorder';
            $pickupTime = ! empty($data['pickup_time']) ? Carbon::parse($data['pickup_time']) : null;
            $initialStatus = $orderType === 'counter' ? 'completed' : 'pending';

            $order = Order::create([
                'bakery_id' => $bakery->id,
                'customer_id' => $customer?->id,
                'order_number' => $this->makeOrderNumber(),
                'order_type' => $orderType,
                'order_status' => $initialStatus,
                'total_amount' => $totalAmount,
                'platform_fee' => round($totalAmount * 0.03, 2),
                'notes' => $data['notes'] ?? null,
                'pickup_time' => $pickupTime,
                'expires_at' => $orderType === 'preorder'
                    ? ($pickupTime ? $pickupTime->copy()->addHours(2) : now()->addDay())
                    : null,
                'fulfilled_at' => $orderType === 'counter' ? now() : null,
                'ordered_at' => now(),
            ]);

            foreach ($items as $item) {
                $order->items()->create(Arr::except($item, ['inventory']));
                $item['inventory']->decrement('quantity_on_hand', $item['quantity']);
            }

            if ($orderType === 'counter') {
                $bakery->increment('revenue_ledger', $order->total_amount);
            }

            return $order->load(['customer', 'items.product']);
        });
    }

    public function updateStatus(Order $order, string $status): Order
    {
        return DB::transaction(function () use ($order, $status) {
            if (in_array($order->order_status, ['expired', 'cancelled'], true)) {
                throw ValidationException::withMessages([
                    'status' => 'Expired or cancelled orders cannot be changed.',
                ]);
            }

            if ($order->order_status === 'completed') {
                throw ValidationException::withMessages([
                    'status' => 'Completed orders are already finished.',
                ]);
            }

            $order->order_status = $status;

            if ($status === 'completed') {
                $order->fulfilled_at = now();
                $order->bakery()->increment('revenue_ledger', $order->total_amount);
            }

            $order->save();

            return $order->fresh(['customer', 'items.product']);
        });
    }

    public function expire(Order $order): Order
    {
        return DB::transaction(function () use ($order) {
            if (! $order->isPreorder()) {
                throw ValidationException::withMessages([
                    'order' => 'Only pre-orders can be expired.',
                ]);
            }

            if ($order->stock_restored_at) {
                throw ValidationException::withMessages([
                    'order' => 'This order stock has already been restored.',
                ]);
            }

            if ($order->order_status === 'completed') {
                throw ValidationException::withMessages([
                    'order' => 'Completed orders cannot be expired.',
                ]);
            }

            $order->loadMissing('items');

            foreach ($order->items as $item) {
                $inventory = Inventory::query()
                    ->where('bakery_id', $order->bakery_id)
                    ->where('product_id', $item->product_id)
                    ->lockForUpdate()
                    ->first();

                if ($inventory) {
                    $inventory->increment('quantity_on_hand', $item->quantity);
                }
            }

            $order->update([
                'order_status' => 'expired',
                'stock_restored_at' => now(),
            ]);

            return $order->fresh(['customer', 'items.product']);
        });
    }

    protected function resolveCustomer(Bakery $bakery, array $data): ?Customer
    {
        if (! empty($data['customer_id'])) {
            return $bakery->customers()
                ->whereKey($data['customer_id'])
                ->first();
        }

        $name = trim((string) ($data['customer_name'] ?? ''));
        $email = trim((string) ($data['customer_email'] ?? ''));
        $phone = trim((string) ($data['customer_phone'] ?? ''));

        if ($name === '' && $email === '' && $phone === '') {
            return null;
        }

        if ($email !== '') {
            return Customer::query()->updateOrCreate(
                [
                    'bakery_id' => $bakery->id,
                    'email' => $email,
                ],
                [
                    'name' => $name !== '' ? $name : $email,
                    'phone' => $phone !== '' ? $phone : null,
                ]
            );
        }

        if ($phone !== '') {
            return Customer::query()->updateOrCreate(
                [
                    'bakery_id' => $bakery->id,
                    'phone' => $phone,
                ],
                [
                    'name' => $name !== '' ? $name : $phone,
                    'email' => $email !== '' ? $email : null,
                ]
            );
        }

        return Customer::create([
            'bakery_id' => $bakery->id,
            'name' => $name,
            'email' => $email !== '' ? $email : null,
            'phone' => $phone !== '' ? $phone : null,
        ]);
    }

    protected function resolveItems(Bakery $bakery, array $quantities): array
    {
        $selected = collect($quantities)
            ->map(fn ($value, $key) => ['product_id' => (int) $key, 'quantity' => (int) $value])
            ->filter(fn (array $item) => $item['quantity'] > 0)
            ->values();

        if ($selected->isEmpty()) {
            throw ValidationException::withMessages([
                'quantities' => 'Choose at least one product with quantity more than zero.',
            ]);
        }

        $products = Product::query()
            ->with('inventory')
            ->where('bakery_id', $bakery->id)
            ->whereIn('id', $selected->pluck('product_id'))
            ->where('is_active', true)
            ->get()
            ->keyBy('id');

        $items = [];

        foreach ($selected as $selectedItem) {
            $product = $products->get($selectedItem['product_id']);
            $inventory = $product?->inventory;

            if (! $product || ! $inventory) {
                throw ValidationException::withMessages([
                    'quantities' => 'One of the selected products is no longer available.',
                ]);
            }

            if ($inventory->quantity_on_hand < $selectedItem['quantity']) {
                throw ValidationException::withMessages([
                    'quantities' => $product->name.' does not have enough stock.',
                ]);
            }

            $items[] = [
                'product_id' => $product->id,
                'quantity' => $selectedItem['quantity'],
                'unit_price' => $product->price,
                'subtotal_item' => $product->price * $selectedItem['quantity'],
                'inventory' => $inventory,
            ];
        }

        return $items;
    }

    protected function makeOrderNumber(): string
    {
        do {
            $number = 'ORD-'.now()->format('Ymd').'-'.Str::upper(Str::random(5));
        } while (Order::query()->where('order_number', $number)->exists());

        return $number;
    }
}
