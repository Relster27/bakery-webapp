<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderPlacementService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(
        protected OrderPlacementService $orderPlacementService
    ) {
    }

    public function index(): View
    {
        $orders = $this->currentBakery()->orders()
            ->with(['customer', 'items'])
            ->latest('ordered_at')
            ->get();

        return view('orders.index', [
            'orders' => $orders,
        ]);
    }

    public function create(): View
    {
        $bakery = $this->currentBakery();

        return view('orders.create', [
            'customers' => $bakery->customers()->orderBy('name')->get(),
            'products' => $bakery->products()
                ->with('inventory')
                ->where('is_active', true)
                ->orderBy('category')
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'order_type' => ['required', 'in:counter,preorder'],
            'customer_id' => ['nullable', 'integer'],
            'customer_name' => ['nullable', 'string', 'max:255'],
            'customer_email' => ['nullable', 'email', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:50'],
            'pickup_time' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
            'quantities' => ['required', 'array'],
        ]);

        if (
            $validated['order_type'] === 'preorder'
            && empty($validated['customer_id'])
            && (empty($validated['customer_name']) || empty($validated['customer_phone']))
        ) {
            return back()
                ->withErrors([
                    'customer_name' => 'Pre-orders need an existing customer or a new customer name and phone number.',
                ])
                ->withInput();
        }

        $order = $this->orderPlacementService->place($this->currentBakery(), $validated);

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Order created and inventory updated.');
    }

    public function show(Order $order): View
    {
        abort_unless($order->bakery_id === $this->currentBakery()->id, 404);

        return view('orders.show', [
            'order' => $order->load(['customer', 'items.product']),
        ]);
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        abort_unless($order->bakery_id === $this->currentBakery()->id, 404);

        $validated = $request->validate([
            'status' => ['required', 'in:baking,ready,completed'],
        ]);

        $this->orderPlacementService->updateStatus($order, $validated['status']);

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Order status updated.');
    }

    public function expire(Order $order): RedirectResponse
    {
        abort_unless($order->bakery_id === $this->currentBakery()->id, 404);

        $this->orderPlacementService->expire($order);

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Order expired and stock returned.');
    }
}
