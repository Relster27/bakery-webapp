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
        ]);

        return redirect()
            ->route('menu.show', $bakery->public_slug)
            ->with('success', 'Pre-order sent. Your order number is '.$order->order_number.'.');
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
            'pickup_date' => ['required', 'date', 'after_or_equal:today'],
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

        $bakery->customCakeRequests()->create($validated);

        return redirect()
            ->route('menu.custom-cake.show', $bakery->public_slug)
            ->with('success', 'Custom cake request sent. The bakery can now review your design details.');
    }
}
