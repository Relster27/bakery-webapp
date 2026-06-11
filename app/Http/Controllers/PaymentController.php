<?php

namespace App\Http\Controllers;

use App\Models\Bakery;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function show(Bakery $bakery, string $orderNumber): View
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('bakery_id', $bakery->id)
            ->firstOrFail();

        // If the order is already paid or cancelled, maybe redirect?
        // But for simulation, we'll just show it if it's payment_pending
        if ($order->order_status !== 'payment_pending') {
            return redirect()->route('menu.show', $bakery->public_slug)
                ->with('success', 'Order is already processed.');
        }

        // Generate dynamic dummy VA (e.g. 900-12345-00014)
        $virtualAccount = '900-12345-' . str_pad($order->id, 5, '0', STR_PAD_LEFT);

        return view('public.payment', [
            'bakery'         => $bakery,
            'order'          => $order,
            'virtualAccount' => $virtualAccount,
            'bankName'           => $bakery->bank_name,
            'bankAccountNumber'  => $bakery->bank_account_number,
            'bankAccountName'    => $bakery->bank_account_name,
        ]);
    }

    public function process(Request $request, Bakery $bakery, string $orderNumber): RedirectResponse
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('bakery_id', $bakery->id)
            ->firstOrFail();

        if ($order->order_status === 'payment_pending') {
            $order->update([
                'order_status' => 'pending', // Set to pending so it appears in the admin dashboard
            ]);
        }

        $route = $order->order_type === 'custom_cake' 
            ? 'menu.custom-cake.show' 
            : 'menu.show';

        return redirect()->route($route, $bakery->public_slug)
            ->with('success', 'Payment successful! Your order ('.$order->order_number.') has been sent to the bakery.');
    }
}
