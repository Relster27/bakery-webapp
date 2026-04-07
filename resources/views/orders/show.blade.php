@extends('layouts.app')

@section('content')
    <section class="hero">
        <div class="hero-grid">
            <div>
                <span class="eyebrow">Order Detail</span>
                <h1>{{ $order->order_number }}</h1>
                <p class="muted">
                    {{ strtoupper($order->order_type) }} order for {{ $order->customer?->name ?? 'Walk-in customer' }}
                </p>
                <div class="actions">
                    <span class="badge badge-hero">{{ strtoupper($order->order_status) }}</span>
                    <span class="badge badge-hero">Paid Rp {{ number_format((float) $order->total_amount, 0, ',', '.') }}</span>
                    @if ((float) $order->discount_total > 0)
                        <span class="badge badge-hero">Saved Rp {{ number_format((float) $order->discount_total, 0, ',', '.') }}</span>
                    @endif
                </div>
            </div>

            <div class="hero-aside">
                <span class="eyebrow">Quick Snapshot</span>
                <p><strong>Items:</strong> {{ $order->items->sum('quantity') }}</p>
                <p><strong>Gross Before Discount:</strong> Rp {{ number_format($order->grossBeforeDiscount(), 0, ',', '.') }}</p>
                <p><strong>Platform Fee:</strong> Rp {{ number_format((float) $order->platform_fee, 0, ',', '.') }}</p>
                <p><strong>Net After Fee:</strong> Rp {{ number_format($order->netAfterFees(), 0, ',', '.') }}</p>
                <p><strong>Pickup:</strong> {{ $order->pickup_time?->format('d M Y H:i') ?? 'Not scheduled' }}</p>
            </div>
        </div>
    </section>

    <section class="detail-grid">
        <div class="card stack">
            <h2>Order Summary</h2>
            <div class="summary-list">
                <div class="summary-row">
                    <div class="summary-key">Type</div>
                    <div class="summary-value">{{ strtoupper($order->order_type) }}</div>
                </div>
                <div class="summary-row">
                    <div class="summary-key">Status</div>
                    <div class="summary-value">{{ strtoupper($order->order_status) }}</div>
                </div>
                <div class="summary-row">
                    <div class="summary-key">Customer</div>
                    <div class="summary-value">{{ $order->customer?->name ?? 'Walk-in customer' }}</div>
                </div>
                <div class="summary-row">
                    <div class="summary-key">Ordered At</div>
                    <div class="summary-value">{{ $order->ordered_at?->format('d M Y H:i') }}</div>
                </div>
                <div class="summary-row">
                    <div class="summary-key">Pickup Time</div>
                    <div class="summary-value">{{ $order->pickup_time?->format('d M Y H:i') ?? '-' }}</div>
                </div>
                <div class="summary-row">
                    <div class="summary-key">Expires At</div>
                    <div class="summary-value">{{ $order->expires_at?->format('d M Y H:i') ?? '-' }}</div>
                </div>
                <div class="summary-row">
                    <div class="summary-key">Gross Before Discount</div>
                    <div class="summary-value">Rp {{ number_format($order->grossBeforeDiscount(), 0, ',', '.') }}</div>
                </div>
                <div class="summary-row">
                    <div class="summary-key">Discount Given</div>
                    <div class="summary-value">Rp {{ number_format((float) $order->discount_total, 0, ',', '.') }}</div>
                </div>
                <div class="summary-row">
                    <div class="summary-key">Customer Paid</div>
                    <div class="summary-value">Rp {{ number_format((float) $order->total_amount, 0, ',', '.') }}</div>
                </div>
                <div class="summary-row">
                    <div class="summary-key">Platform Fee</div>
                    <div class="summary-value">Rp {{ number_format((float) $order->platform_fee, 0, ',', '.') }}</div>
                </div>
                <div class="summary-row">
                    <div class="summary-key">Net After Fee</div>
                    <div class="summary-value">Rp {{ number_format($order->netAfterFees(), 0, ',', '.') }}</div>
                </div>
                <div class="summary-row">
                    <div class="summary-key">Notes</div>
                    <div class="summary-value">{{ $order->notes ?: '-' }}</div>
                </div>
            </div>
        </div>

        <aside class="card status-panel">
            <div>
                <h2>Status Actions</h2>
                <p class="muted">Use these controls to move the order through the bakery workflow.</p>
            </div>

            <div class="status-current">
                <h3>Current Status</h3>
                <div class="actions">
                    <span class="badge">{{ strtoupper($order->order_status) }}</span>
                    <span class="badge">{{ strtoupper($order->order_type) }}</span>
                </div>
            </div>

            @if (! in_array($order->order_status, ['completed', 'expired'], true))
                <div class="action-grid">
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
                <div class="surface-note">
                    This order is already finished, so no more status changes are available.
                </div>
            @endif
        </aside>
    </section>

    <section class="card" style="margin-top: 1rem;">
        <h2>Ordered Items</h2>
        @if ((float) $order->discount_total > 0)
            <p class="muted">This order used at least one active flash-sale rule when it was created.</p>
        @endif
        <div class="item-list">
            @foreach ($order->items as $item)
                <article class="item-row">
                    <div class="product-main">
                        <strong>{{ $item->product?->name }}</strong>
                        <p class="product-copy">{{ $item->product?->category ?? 'Bakery item' }}</p>
                    </div>

                    <div class="product-meta">
                        <span class="product-label">Quantity</span>
                        <span class="product-value">{{ $item->quantity }}</span>
                    </div>

                    <div class="product-meta">
                        <span class="product-label">Unit Price</span>
                        <span class="product-value">Rp {{ number_format((float) $item->unit_price, 0, ',', '.') }}</span>
                    </div>

                    <div class="item-highlight">
                        <div class="product-label">Subtotal</div>
                        <div class="product-value">Rp {{ number_format((float) $item->subtotal_item, 0, ',', '.') }}</div>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
@endsection
