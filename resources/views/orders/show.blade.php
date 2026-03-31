@extends('layouts.app')

@section('content')
    <section class="hero">
        <h1>{{ $order->order_number }}</h1>
        <p class="muted">
            {{ strtoupper($order->order_type) }} order for {{ $order->customer?->name ?? 'Walk-in customer' }}
        </p>
        <div class="actions">
            <span class="badge">{{ strtoupper($order->order_status) }}</span>
            <span class="badge">Rp {{ number_format((float) $order->total_amount, 0, ',', '.') }}</span>
        </div>
    </section>

    <section class="grid grid-2">
        <div class="card stack">
            <h2>Order Summary</h2>
            <p><strong>Type:</strong> {{ strtoupper($order->order_type) }}</p>
            <p><strong>Status:</strong> {{ strtoupper($order->order_status) }}</p>
            <p><strong>Customer:</strong> {{ $order->customer?->name ?? 'Walk-in customer' }}</p>
            <p><strong>Ordered At:</strong> {{ $order->ordered_at?->format('d M Y H:i') }}</p>
            <p><strong>Pickup Time:</strong> {{ $order->pickup_time?->format('d M Y H:i') ?? '-' }}</p>
            <p><strong>Expires At:</strong> {{ $order->expires_at?->format('d M Y H:i') ?? '-' }}</p>
            <p><strong>Platform Fee:</strong> Rp {{ number_format((float) $order->platform_fee, 0, ',', '.') }}</p>
            <p><strong>Notes:</strong> {{ $order->notes ?: '-' }}</p>
        </div>

        <div class="card stack">
            <h2>Status Actions</h2>
            <p class="muted">Use these buttons to move pre-orders through the bakery workflow.</p>

            @if (! in_array($order->order_status, ['completed', 'expired'], true))
                <div class="actions">
                    <form action="{{ route('orders.status.update', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="baking">
                        <button class="button-inline" type="submit">Mark Baking</button>
                    </form>

                    <form action="{{ route('orders.status.update', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="ready">
                        <button class="button-inline" type="submit">Mark Ready</button>
                    </form>

                    <form action="{{ route('orders.status.update', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="completed">
                        <button class="button-inline" type="submit">Mark Completed</button>
                    </form>

                    @if ($order->order_type === 'preorder')
                        <form action="{{ route('orders.expire', $order) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button class="button-inline button-secondary" type="submit">Expire & Return Stock</button>
                        </form>
                    @endif
                </div>
            @else
                <p class="muted">This order is already finished, so no more status changes are available.</p>
            @endif
        </div>
    </section>

    <section class="card" style="margin-top: 1rem;">
        <h2>Ordered Items</h2>
        <table>
            <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->product?->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rp {{ number_format((float) $item->unit_price, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format((float) $item->subtotal_item, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
@endsection
