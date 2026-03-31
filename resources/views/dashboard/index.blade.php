@extends('layouts.app')

@section('content')
    <section class="hero">
        <div class="hero-grid">
            <div>
                <span class="eyebrow">Owner Dashboard</span>
                <h1>{{ $bakery->shop_name }}</h1>
                <p class="muted">A single control room for menu changes, stock visibility, daily revenue, and live order handling.</p>
                <div class="actions">
                    <a class="button-inline" href="{{ route('orders.create') }}">Create Order</a>
                    <a class="button-inline button-secondary" href="{{ route('products.create') }}">Add Product</a>
                </div>
            </div>

            <div class="hero-aside">
                <span class="eyebrow">Customer Ordering Link</span>
                <p><a href="{{ route('menu.show', $bakery->qr_token) }}" target="_blank">{{ route('menu.show', $bakery->qr_token) }}</a></p>
                <p class="muted">Use this exact public URL as the destination for your QR code at the counter or on printed packaging.</p>
            </div>
        </div>
    </section>

    <section class="grid grid-4">
        <div class="stat">
            <small>Total Products</small>
            <h2>{{ $stats['products'] }}</h2>
        </div>
        <div class="stat">
            <small>Registered Customers</small>
            <h2>{{ $stats['customers'] }}</h2>
        </div>
        <div class="stat">
            <small>Orders Today</small>
            <h2>{{ $stats['orders_today'] }}</h2>
        </div>
        <div class="stat">
            <small>Revenue Ledger</small>
            <h2>Rp {{ number_format((float) $stats['revenue_ledger'], 0, ',', '.') }}</h2>
        </div>
    </section>

    <section class="grid grid-2" style="margin-top: 1rem;">
        <div class="card">
            <h2>Low Stock Watch</h2>
            @if ($lowStockItems->isEmpty())
                <p class="muted">No product is below its reorder level right now.</p>
            @else
                <table>
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th>Stock</th>
                        <th>Reorder Level</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($lowStockItems as $inventory)
                        <tr>
                            <td>{{ $inventory->product?->name }}</td>
                            <td>{{ $inventory->quantity_on_hand }}</td>
                            <td>{{ $inventory->reorder_level }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <div class="card">
            <h2>Recent Orders</h2>
            @if ($recentOrders->isEmpty())
                <p class="muted">No orders yet. Start from the Orders page.</p>
            @else
                <table>
                    <thead>
                    <tr>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($recentOrders as $order)
                        <tr>
                            <td>
                                <a href="{{ route('orders.show', $order) }}">{{ $order->order_number }}</a><br>
                                <span class="muted">{{ $order->customer?->name ?? 'Walk-in customer' }}</span>
                            </td>
                            <td><span class="badge">{{ strtoupper($order->order_status) }}</span></td>
                            <td>Rp {{ number_format((float) $order->total_amount, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </section>
@endsection
