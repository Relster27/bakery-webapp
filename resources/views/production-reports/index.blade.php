@extends('layouts.app')

@section('content')
    <section class="card stack">
        <div>
            <span class="eyebrow" style="color: var(--text);">Daily Prep</span>
            <h1>Production Reports</h1>
            <p class="muted">See what must be prepared for a selected pickup date, including pre-order items and custom cake requests.</p>
        </div>

        <form action="{{ route('production-reports.index') }}" method="GET" class="filter-bar">
            <div>
                <label for="date">Pickup Date</label>
                <input id="date" name="date" type="date" value="{{ $date }}">
            </div>

            <div class="actions">
                <button class="button-inline" type="submit">Build Report</button>
                <a class="button-inline button-secondary" href="{{ route('production-reports.export', ['date' => $date]) }}">Export CSV</a>
            </div>
        </form>
    </section>

    <section class="grid grid-2" style="margin-top: 1rem;">
        <div class="card stack">
            <div>
                <h2>Bakery Product Prep</h2>
                <p class="muted">Aggregated quantities from pre-orders scheduled for this date.</p>
            </div>

            @if ($productPrep->isEmpty())
                <p class="muted">No preorder production items are scheduled for this date.</p>
            @else
                <div class="report-list">
                    @foreach ($productPrep as $row)
                        <article class="report-row">
                            <div class="product-main">
                                <strong>{{ $row['product'] }}</strong>
                                <p class="product-copy">Prepare for pickup day</p>
                            </div>

                            <div class="product-meta">
                                <span class="product-label">Quantity</span>
                                <span class="product-value">{{ $row['quantity'] }}</span>
                            </div>

                            <div class="product-meta">
                                <span class="product-label">Source</span>
                                <span class="badge">PREORDER</span>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="card stack">
            <div>
                <h2>Custom Cake Queue</h2>
                <p class="muted">Guided cake requests waiting for review or production planning.</p>
            </div>

            @if ($customCakes->isEmpty())
                <p class="muted">No custom cake requests scheduled for this date.</p>
            @else
                <div class="report-list">
                    @foreach ($customCakes as $cake)
                        <article class="report-row-wide">
                            <div class="product-main">
                                <strong>{{ $cake->customer_name }}</strong>
                                <p class="product-copy">{{ $cake->occasion ?: 'Custom cake request' }}</p>
                            </div>

                            <div class="product-meta">
                                <span class="product-label">Flavor</span>
                                <span class="product-value">{{ $cake->sponge }} / {{ $cake->filling }}</span>
                            </div>

                            <div class="product-meta">
                                <span class="product-label">Finish</span>
                                <span class="product-value">{{ $cake->frosting }} / {{ $cake->decoration }}</span>
                            </div>

                            <div class="product-meta">
                                <span class="product-label">Servings</span>
                                <span class="product-value">{{ $cake->servings }}</span>
                            </div>

                            <div class="product-meta">
                                <span class="product-label">Status</span>
                                <span class="badge">{{ strtoupper($cake->status) }}</span>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <section class="card" style="margin-top: 1rem;">
        <h2>Scheduled Pre-orders</h2>
        @if ($orders->isEmpty())
            <p class="muted">No pre-orders are queued for this date.</p>
        @else
            <div class="order-list">
                @foreach ($orders as $order)
                    <article class="order-row">
                        <div class="product-main">
                            <strong>{{ $order->order_number }}</strong>
                            <p class="product-copy">{{ $order->customer?->name ?? 'Walk-in customer' }}</p>
                        </div>

                        <div class="product-meta">
                            <span class="product-label">Pickup</span>
                            <span class="product-value">{{ $order->pickup_time?->format('H:i') ?? '-' }}</span>
                        </div>

                        <div class="product-meta">
                            <span class="product-label">Status</span>
                            <span class="badge">{{ strtoupper($order->order_status) }}</span>
                        </div>

                        <div class="product-meta">
                            <span class="product-label">Items</span>
                            <span class="product-value">{{ $order->items->sum('quantity') }}</span>
                        </div>

                        <div class="row-actions">
                            <a href="{{ route('orders.show', $order) }}">Open order</a>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
@endsection
