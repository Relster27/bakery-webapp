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
        {{-- =============================== --}}
        {{-- LIVE MENU LIST --}}
        {{-- =============================== --}}
        <div class="card">
            <h2>Live Menu</h2>
            <p class="muted">Flash-sale rules apply automatically when their time window is active.</p>
            <div style="display: grid; gap: 0.9rem; margin-top: 1rem;">
                @foreach ($products as $product)
                    <article style="
                        display: grid;
                        grid-template-columns: auto 1fr;
                        gap: 1rem;
                        align-items: start;
                        padding: 1rem 1.05rem;
                        border-radius: 22px;
                        background: linear-gradient(180deg, rgba(255,255,255,0.96), rgba(249,243,236,0.92));
                        border: 1px solid rgba(176,146,121,0.16);
                    ">
                        {{-- Column 1: Image --}}
                        @if ($product->image_path)
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($product->image_path) }}"
                                 alt="{{ $product->name }}"
                                 style="width: 64px; height: 64px; object-fit: cover; border-radius: 14px; border: 1px solid rgba(176,146,121,0.16); display: block; flex-shrink: 0;">
                        @else
                            <div style="width: 64px; height: 64px; border-radius: 14px; background: rgba(183,103,58,0.08); display: flex; align-items: center; justify-content: center; font-size: 1.6rem;">🍞</div>
                        @endif

                        {{-- Column 2: All text info stacked --}}
                        <div style="min-width: 0; display: grid; gap: 0.5rem;">
                            <div>
                                <strong style="font-size: 1.04rem; word-break: break-word;">{{ $product->name }}</strong>
                                <p class="muted" style="margin: 0.1rem 0 0;">{{ $product->category }}</p>
                            </div>
                            <div style="display: flex; flex-wrap: wrap; gap: 0.75rem 1.25rem; align-items: center;">
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
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>

        {{-- =============================== --}}
        {{-- PRE-ORDER FORM --}}
        {{-- =============================== --}}
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
                        <input id="customer_email" name="customer_email" type="email" placeholder="contoh@email.com" value="{{ old('customer_email') }}">
                    </div>

                    <div>
                        <label for="customer_phone">Phone</label>
                        <input id="customer_phone" name="customer_phone" type="text" placeholder="08xx-xxxx-xxxx" value="{{ old('customer_phone') }}" required>
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
                    <div style="display: grid; gap: 0.9rem; margin-top: 1rem;">
                        @foreach ($products as $product)
                            <article style="
                                display: grid;
                                grid-template-columns: auto 1fr auto auto;
                                gap: 1rem;
                                align-items: center;
                                padding: 1rem 1.05rem;
                                border-radius: 22px;
                                background: linear-gradient(180deg, rgba(255,255,255,0.96), rgba(249,243,236,0.92));
                                border: 1px solid rgba(176,146,121,0.16);
                            ">
                                {{-- Column 1: Image --}}
                                @if ($product->image_path)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($product->image_path) }}"
                                         alt="{{ $product->name }}"
                                         style="width: 52px; height: 52px; object-fit: cover; border-radius: 12px; border: 1px solid rgba(176,146,121,0.16); display: block; flex-shrink: 0;">
                                @else
                                    <div style="width: 52px; height: 52px; border-radius: 12px; background: rgba(183,103,58,0.08); display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">🍞</div>
                                @endif

                                {{-- Column 2: Name + Category + Price --}}
                                <div style="min-width: 0;">
                                    <strong style="word-break: break-word; display: block;">{{ $product->name }}</strong>
                                    <p class="product-copy" style="margin: 0.1rem 0;">{{ $product->category }}</p>
                                    @if ($product->has_active_discount ?? false)
                                        <div class="price-stack">
                                            <span class="price-current">Rp {{ number_format((float) $product->effective_price, 0, ',', '.') }}</span>
                                            <span class="price-old">Rp {{ number_format((float) $product->original_price, 0, ',', '.') }}</span>
                                        </div>
                                    @else
                                        <span class="product-value">Rp {{ number_format((float) $product->price, 0, ',', '.') }}</span>
                                    @endif
                                </div>

                                {{-- Column 3: Availability --}}
                                <div class="product-meta" style="min-width: 60px;">
                                    <span class="product-label">Available</span>
                                    <span class="product-value">{{ $product->inventory?->quantity_on_hand ?? 0 }}</span>
                                </div>

                                {{-- Column 4: Quantity Input --}}
                                <div style="min-width: 90px;">
                                    <label for="public_quantity_{{ $product->id }}" class="product-label">Quantity</label>
                                    <input
                                        id="public_quantity_{{ $product->id }}"
                                        name="quantities[{{ $product->id }}]"
                                        type="number"
                                        min="0"
                                        max="{{ $product->inventory?->quantity_on_hand ?? 0 }}"
                                        value="{{ old('quantities.'.$product->id, 0) }}"
                                        style="width: 100%;"
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
