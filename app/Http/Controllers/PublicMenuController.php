<?php

namespace App\Http\Controllers;

use App\Models\Bakery;
use App\Services\OrderPlacementService;
use App\Services\PricingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicMenuController extends Controller
{
    public function __construct(
        protected OrderPlacementService $orderPlacementService,
        protected PricingService $pricingService
    ) {
    }

    public function show(Bakery $bakery): View
    {
        $products = $bakery->products()
            ->with('inventory')
            ->where('is_active', true)
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        return view('public.menu', [
            'bakery' => $bakery,
            'products' => $this->pricingService->decorateProducts($bakery, $products),
            'cakeRequestCount' => $bakery->customCakeRequests()
                ->whereDate('pickup_date', '>=', now()->toDateString())
                ->count(),
        ]);
    }

    public function store(Request $request, Bakery $bakery): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['nullable', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:50'],
            'pickup_time' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
            'quantities' => ['required', 'array'],
        ]);

        $order = $this->orderPlacementService->place($bakery, [
            ...$validated,
            'order_type' => 'preorder',
            'order_status' => 'payment_pending',
        ]);

        return redirect()
            ->route('menu.payment.show', ['bakery' => $bakery->public_slug, 'order' => $order->order_number]);
    }

    public function showCustomCake(Bakery $bakery): View
    {
        return view('public.custom-cake', [
            'bakery' => $bakery,
        ]);
    }

    public function storeCustomCake(Request $request, Bakery $bakery): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['nullable', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:50'],
            'pickup_date' => ['required', 'date', 'after_or_equal:tomorrow'],
            'occasion' => ['nullable', 'string', 'max:255'],
            'servings' => ['required', 'integer', 'min:6', 'max:200'],
            'size' => ['required', 'string', 'max:50'],
            'sponge' => ['required', 'string', 'max:50'],
            'filling' => ['required', 'string', 'max:50'],
            'frosting' => ['required', 'string', 'max:50'],
            'decoration' => ['required', 'string', 'max:100'],
            'inscription' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $customer = $this->orderPlacementService->resolveCustomer($bakery, $validated);

        $customNotes = "CUSTOM CAKE REQUEST\n";
        $customNotes .= "Occasion: {$validated['occasion']}\n";
        $customNotes .= "Size/Servings: {$validated['size']} (approx {$validated['servings']} servings)\n";
        $customNotes .= "Sponge: {$validated['sponge']}\n";
        $customNotes .= "Filling: {$validated['filling']}\n";
        $customNotes .= "Frosting: {$validated['frosting']}\n";
        $customNotes .= "Decoration: {$validated['decoration']}\n";
        $customNotes .= "Inscription: {$validated['inscription']}\n";
        if (!empty($validated['notes'])) {
            $customNotes .= "Extra Notes: {$validated['notes']}";
        }

        $pickupDate = \Illuminate\Support\Carbon::parse($validated['pickup_date']);

        $order = \App\Models\Order::create([
            'bakery_id' => $bakery->id,
            'customer_id' => $customer?->id,
            'order_number' => $this->orderPlacementService->makeOrderNumber(),
            'order_type' => 'custom_cake',
            'order_status' => 'payment_pending',
            'total_amount' => 200000,
            'discount_total' => 0,
            'platform_fee' => 200000 * 0.03,
            'notes' => $customNotes,
            'pickup_time' => $pickupDate,
            'expires_at' => $pickupDate->copy()->addHours(2),
            'ordered_at' => now(),
        ]);

        return redirect()
            ->route('menu.payment.show', ['bakery' => $bakery->public_slug, 'order' => $order->order_number]);
    }
}
