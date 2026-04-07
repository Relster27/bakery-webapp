@extends('layouts.app')

@section('content')
    <section class="hero">
        <div class="hero-grid">
            <div>
                <span class="eyebrow">Live Bakery Menu</span>
                <h1>{{ $bakery->shop_name }}</h1>
                <p class="muted">Browse the current menu, check live stock, and place a pickup order without calling the shop.</p>
            </div>

            <div class="hero-aside">
                <span class="eyebrow">Visit</span>
                @if ($bakery->address)
                    <p><strong>Address:</strong> {{ $bakery->address }}</p>
                @endif
                @if ($bakery->phone)
                    <p><strong>Phone:</strong> {{ $bakery->phone }}</p>
                @endif
                @if ($bakery->email)
                    <p><strong>Email:</strong> {{ $bakery->email }}</p>
                @endif
                <p><a href="{{ route('menu.custom-cake.show', $bakery->public_slug) }}">Need a custom cake instead?</a></p>
            </div>
        </div>
    </section>

    <section class="grid grid-2">
        <div class="card">
            <h2>Live Menu</h2>
            <p class="muted">Flash-sale rules apply automatically when their time window is active.</p>
            <div class="product-list" style="margin-top: 1rem;">
                @foreach ($products as $product)
                    <article class="product-row">
                        <div class="product-main">
                            <strong>{{ $product->name }}</strong><br>
                            <span class="muted">{{ $product->category }}</span>
                        </div>
                        <div class="product-meta">
                            <span class="product-label">Price</span>
                            @if ($product->has_active_discount ?? false)
                                <div class="price-stack">
                                    <span class="price-current">Rp {{ number_format((float) $product->effective_price, 0, ',', '.') }}</span>
                                    <span class="price-old">Rp {{ number_format((float) $product->original_price, 0, ',', '.') }}</span>
                                    <span class="discount-note">{{ $product->discount_name }}</span>
                                </div>
                            @else
                                <span class="product-value">Rp {{ number_format((float) $product->price, 0, ',', '.') }}</span>
                            @endif
                        </div>
                        <div class="product-meta">
                            <span class="product-label">Stock</span>
                            <span class="product-value">{{ $product->inventory?->quantity_on_hand ?? 0 }}</span>
                        </div>
                        <div class="product-meta">
                            <span class="product-label">Status</span>
                            <span class="badge {{ ($product->inventory?->quantity_on_hand ?? 0) > 0 ? '' : 'badge-muted' }}">
                                {{ ($product->inventory?->quantity_on_hand ?? 0) > 0 ? 'AVAILABLE' : 'OUT OF STOCK' }}
                            </span>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>

        <div class="card stack">
            <div>
                <h2>Place a Pre-order</h2>
                <p class="muted">Enter customer details, choose pickup time, then fill only the quantities you want.</p>
                <p class="helper-text">Planning a celebration cake? <a href="{{ route('menu.custom-cake.show', $bakery->public_slug) }}">Use the custom cake configurator</a>. {{ $cakeRequestCount }} guided request(s) already scheduled.</p>
            </div>

            <form action="{{ route('menu.order.store', $bakery->public_slug) }}" method="POST" class="stack">
                @csrf

                <div class="form-grid">
                    <div>
                        <label for="customer_name">Name</label>
                        <input id="customer_name" name="customer_name" type="text" value="{{ old('customer_name') }}" required>
                    </div>

                    <div>
                        <label for="customer_email">Email</label>
                        <input id="customer_email" name="customer_email" type="email" value="{{ old('customer_email') }}">
                    </div>

                    <div>
                        <label for="customer_phone">Phone</label>
                        <input id="customer_phone" name="customer_phone" type="text" value="{{ old('customer_phone') }}" required>
                    </div>
                </div>

                <div>
                    <label for="pickup_time">Pickup Time</label>
                    <input id="pickup_time" name="pickup_time" type="datetime-local" value="{{ old('pickup_time') }}" required>
                </div>

                <div>
                    <label for="notes">Notes</label>
                    <textarea id="notes" name="notes">{{ old('notes') }}</textarea>
                </div>

                <div class="card subcard">
                    <h3>Choose Products</h3>
                    <div class="selector-list">
                        @foreach ($products as $product)
                            <article class="selector-row">
                                <div class="product-main">
                                    <strong>{{ $product->name }}</strong>
                                    <p class="product-copy">{{ $product->category }}</p>
                                </div>
                                <div class="product-meta">
                                    <span class="product-label">Price</span>
                                    @if ($product->has_active_discount ?? false)
                                        <div class="price-stack">
                                            <span class="price-current">Rp {{ number_format((float) $product->effective_price, 0, ',', '.') }}</span>
                                            <span class="price-old">Rp {{ number_format((float) $product->original_price, 0, ',', '.') }}</span>
                                        </div>
                                    @else
                                        <span class="product-value">Rp {{ number_format((float) $product->price, 0, ',', '.') }}</span>
                                    @endif
                                </div>
                                <div class="product-meta">
                                    <span class="product-label">Available</span>
                                    <span class="product-value">{{ $product->inventory?->quantity_on_hand ?? 0 }}</span>
                                </div>
                                <div class="selector-quantity">
                                    <label for="public_quantity_{{ $product->id }}">Quantity</label>
                                    <input
                                        id="public_quantity_{{ $product->id }}"
                                        name="quantities[{{ $product->id }}]"
                                        type="number"
                                        min="0"
                                        max="{{ $product->inventory?->quantity_on_hand ?? 0 }}"
                                        value="{{ old('quantities.'.$product->id, 0) }}"
                                    >
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>

                <button class="button" type="submit">Send Pre-order</button>
            </form>
        </div>
    </section>
@endsection
