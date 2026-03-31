<?php

namespace App\Http\Controllers;

use App\Models\Bakery;
use App\Services\OrderPlacementService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicMenuController extends Controller
{
    public function __construct(
        protected OrderPlacementService $orderPlacementService
    ) {
    }

    public function show(Bakery $bakery): View
    {
        return view('public.menu', [
            'bakery' => $bakery,
            'products' => $bakery->products()
                ->with('inventory')
                ->where('is_active', true)
                ->orderBy('category')
                ->orderBy('name')
                ->get(),
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
            ->route('menu.show', $bakery->qr_token)
            ->with('success', 'Pre-order sent. Your order number is '.$order->order_number.'.');
    }
}
