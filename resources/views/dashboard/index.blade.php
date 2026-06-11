@extends('layouts.app')

@section('content')
    <section class="hero">
        <div class="hero-grid">
            <div>
                <span class="eyebrow">Owner Dashboard</span>
                <h1>{{ $bakery->shop_name }}</h1>
                <div class="actions" style="margin-top: 0.85rem; flex-wrap: wrap; gap: 0.65rem;">
                    {{-- Chocolate Brown --}}
                    <a href="{{ route('orders.create') }}" style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.7rem 1.4rem; border-radius: 999px; background: #7B3F00; color: #fff7ef; font-weight: 700; font-size: 0.97rem; text-decoration: none; box-shadow: 0 6px 18px rgba(123,63,0,0.35); transition: transform 0.15s, box-shadow 0.15s;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 10px 24px rgba(123,63,0,0.48)'" onmouseout="this.style.transform='';this.style.boxShadow='0 6px 18px rgba(123,63,0,0.35)'">
                        ＋ Create Order
                    </a>
                    {{-- Copper Brown --}}
                    <a href="{{ route('products.create') }}" style="display: inline-flex; align-items: center; padding: 0.7rem 1.4rem; border-radius: 999px; background: #96400E; color: #fff7ef; font-weight: 700; font-size: 0.97rem; text-decoration: none; box-shadow: 0 6px 18px rgba(150,64,14,0.32); transition: transform 0.15s, box-shadow 0.15s;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 10px 24px rgba(150,64,14,0.45)'" onmouseout="this.style.transform='';this.style.boxShadow='0 6px 18px rgba(150,64,14,0.32)'">
                        Add Product
                    </a>
                    {{-- Coffee Brown --}}
                    <a href="{{ route('discounts.index') }}" style="display: inline-flex; align-items: center; padding: 0.7rem 1.4rem; border-radius: 999px; background: #4A2C17; color: #fff7ef; font-weight: 700; font-size: 0.97rem; text-decoration: none; box-shadow: 0 6px 18px rgba(74,44,23,0.35); transition: transform 0.15s, box-shadow 0.15s;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 10px 24px rgba(74,44,23,0.48)'" onmouseout="this.style.transform='';this.style.boxShadow='0 6px 18px rgba(74,44,23,0.35)'">
                        Flash Sale Rules
                    </a>
                    {{-- Brown Sugar --}}
                    <a href="{{ route('analytics.index') }}" style="display: inline-flex; align-items: center; padding: 0.7rem 1.4rem; border-radius: 999px; background: #B5743A; color: #fff7ef; font-weight: 700; font-size: 0.97rem; text-decoration: none; box-shadow: 0 6px 18px rgba(181,116,58,0.32); transition: transform 0.15s, box-shadow 0.15s;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 10px 24px rgba(181,116,58,0.45)'" onmouseout="this.style.transform='';this.style.boxShadow='0 6px 18px rgba(181,116,58,0.32)'">
                        Sales Analytics
                    </a>
                </div>
            </div>

            <div class="hero-aside">
                <span class="eyebrow">Public Ordering Link</span>
                <p><a href="{{ route('menu.show', $bakery->public_slug) }}" target="_blank">{{ route('menu.show', $bakery->public_slug) }}</a></p>
                <p class="muted">Share this public URL directly with customers so they can browse the menu and place a pickup order.</p>
            </div>
        </div>
    </section>

    <section class="dashboard-stats">
        <div class="stat dashboard-stat">
            <small>Total Products</small>
            <div class="dashboard-stat-value">{{ $stats['products'] }}</div>
        </div>
        <div class="stat dashboard-stat">
            <small>Registered Customers</small>
            <div class="dashboard-stat-value">{{ $stats['customers'] }}</div>
        </div>
        <div class="stat dashboard-stat">
            <small>Orders Today</small>
            <div class="dashboard-stat-value">{{ $stats['orders_today'] }}</div>
        </div>
        <div class="stat dashboard-stat">
            <small>Revenue Ledger</small>
            <div class="dashboard-stat-value dashboard-stat-value-money">Rp {{ number_format((float) $stats['revenue_ledger'], 0, ',', '.') }}</div>
        </div>
        <div class="stat dashboard-stat">
            <small>Active Discounts</small>
            <div class="dashboard-stat-value">{{ $stats['active_discounts'] }}</div>
        </div>
        <div class="stat dashboard-stat">
            <small>Custom Cake Requests</small>
            <div class="dashboard-stat-value">{{ $stats['custom_cake_requests'] }}</div>
        </div>
    </section>

    <section class="card stack" style="margin-top: 1rem;">
        <div>
            <h2>Revenue & Fee Transparency</h2>
            <p class="muted">This section separates gross value, discount givebacks, customer payments, and the 3% platform fee already calculated on each transaction.</p>
        </div>

        <div class="metric-grid">
            <div class="metric-card">
                <h3>Gross Before Discount</h3>
                <strong>Rp {{ number_format((float) $transparency['gross_before_discount'], 0, ',', '.') }}</strong>
            </div>
            <div class="metric-card">
                <h3>Discounts Given</h3>
                <strong>Rp {{ number_format((float) $transparency['discounts_given'], 0, ',', '.') }}</strong>
            </div>
            <div class="metric-card">
                <h3>Customer Paid</h3>
                <strong>Rp {{ number_format((float) $transparency['customer_paid'], 0, ',', '.') }}</strong>
            </div>
            <div class="metric-card">
                <h3>Platform Fees</h3>
                <strong>Rp {{ number_format((float) $transparency['platform_fees'], 0, ',', '.') }}</strong>
            </div>
            <div class="metric-card">
                <h3>Net After Fees</h3>
                <strong>Rp {{ number_format((float) $transparency['net_after_fees'], 0, ',', '.') }}</strong>
            </div>
        </div>
    </section>

    <section class="grid grid-2 dashboard-panels">
        <div class="card dashboard-panel">
            <div class="dashboard-panel-head">
                <div>
                    <h2>Low Stock Watch</h2>
                    <p class="muted">Products that need attention before they run too low.</p>
                </div>
            </div>

            @if ($lowStockItems->isEmpty())
                <p class="muted">No product is below its reorder level right now.</p>
            @else
                <div class="dashboard-list">
                    @foreach ($lowStockItems as $inventory)
                        <article class="dashboard-row">
                            <div class="dashboard-main" style="display: flex; gap: 1rem; align-items: flex-start;">
                                @if ($inventory->product?->image_path)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($inventory->product->image_path) }}"
                                         alt="{{ $inventory->product->name }}"
                                         style="width: 48px; height: 48px; object-fit: cover; border-radius: 12px; border: 1px solid rgba(176,146,121,0.16); flex-shrink: 0; display: block;">
                                @endif
                                <div style="min-width: 0;">
                                    <strong>{{ $inventory->product?->name }}</strong>
                                    <p class="product-copy">{{ $inventory->product?->category }}</p>
                                    <div class="dashboard-details">
                                        <div class="dashboard-detail">
                                            <span class="product-label">Stock</span>
                                            <span class="product-value">{{ $inventory->quantity_on_hand }}</span>
                                        </div>
                                        <div class="dashboard-detail">
                                            <span class="product-label">Reorder Level</span>
                                            <span class="product-value">{{ $inventory->reorder_level }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="dashboard-action">
                                <a class="dashboard-link" href="{{ route('inventories.index') }}">Manage stock</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="card dashboard-panel">
            <div class="dashboard-panel-head">
                <div>
                    <h2>Recent Orders</h2>
                    <p class="muted">Latest order activity with status and totals at a glance.</p>
                </div>
            </div>

            @if ($recentOrders->isEmpty())
                <p class="muted">No orders yet. Start from the Orders page.</p>
            @else
                <div class="dashboard-list">
                    @foreach ($recentOrders as $order)
                        @php
                            $rowClass = '';
                            if ($order->order_status === 'payment_pending') $rowClass = 'dashboard-row-yellow';
                            elseif (in_array($order->order_status, ['pending', 'baking'])) $rowClass = 'dashboard-row-red';
                            elseif (in_array($order->order_status, ['ready', 'completed'])) $rowClass = 'dashboard-row-green';
                        @endphp
                        <article class="dashboard-row {{ $rowClass }}">
                            <div class="dashboard-main">
                                <strong>{{ $order->order_number }}</strong>
                                <p class="product-copy">{{ $order->customer?->name ?? 'Walk-in customer' }}</p>
                                <div class="dashboard-details">
                                    <div class="dashboard-detail">
                                        <span class="product-label">Type</span>
                                        <span class="product-value">{{ strtoupper($order->order_type) }}</span>
                                    </div>
                                    <div class="dashboard-detail">
                                        <span class="product-label">Status</span>
                                        <span class="badge">{{ strtoupper($order->order_status) }}</span>
                                    </div>
                                    <div class="dashboard-detail">
                                        <span class="product-label">Total</span>
                                        <span class="product-value">Rp {{ number_format((float) $order->total_amount, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="dashboard-action">
                                <a class="dashboard-link" href="{{ route('orders.show', $order) }}">Open order</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <section class="card" style="margin-top: 1rem;">
        <div class="dashboard-panel-head">
            <div>
                <h2>Upcoming Production Snapshot</h2>
                <p class="muted">Top items queued in active pre-orders. Use the full report for date-based production planning.</p>
            </div>
            <div class="actions">
                <a class="button-inline button-secondary" href="{{ route('production-reports.index') }}">Open Production Report</a>
            </div>
        </div>

        @if ($upcomingPrep->isEmpty())
            <p class="muted">No active pre-orders are currently waiting for production.</p>
        @else
            <div class="report-list" style="margin-top: 1rem;">
                @foreach ($upcomingPrep as $prep)
                    <article class="report-row">
                        <div class="product-main">
                            <strong>{{ $prep['product'] }}</strong>
                            <p class="product-copy">Upcoming preorder demand</p>
                        </div>

                        <div class="product-meta">
                            <span class="product-label">Quantity</span>
                            <span class="product-value">{{ $prep['quantity'] }}</span>
                        </div>

                        <div class="product-meta">
                            <span class="product-label">Workflow</span>
                            <span class="badge">PREP</span>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
@endsection
